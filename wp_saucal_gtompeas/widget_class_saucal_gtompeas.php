<?php
/**
 * The widget creation that read user data and post them to endpoint
 *
 * @package  wp_saucal_gtompeas
 * @version  1.0.0
 */

require_once ABSPATH . 'wp-includes/class-wp-widget.php';

// Creating the widget
class saucal_gtompeas_widget extends WP_Widget
{

    public function __construct()
    {
        parent::__construct(

            // Base ID of your widget
            'saucal_gtompeas_widget',

            // Widget name will appear in UI
            __('Saucal Gtompeas Widget', 'wpb_widget_domain'),

            // Widget description
            array('description' => __('A widget for saucal php exercise', 'wpb_widget_domain'))
        );
    }

    public function posttoapi($auserparams, $username, $password)
    {

      
        $apiresults = wp_remote_post(
            'https://httpbin.org/post',
            array(

                'method' => 'POST',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.1',
                'body' => $auserparams,
                'sslverify' => 'false',
                'headers' => array(
                    'Authorization' => 'Basic ' . base64_encode($username . ':' . $password),
                ),

            )
        );

        return $apiresults;
    }
   
    // Creating widget front-end

    public function widget($args, $instance)
    {
		if (!empty($instance['title'])) {
        $title = apply_filters('widget_title', $instance['title']);
		}

        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

      

        $current_user = wp_get_current_user();

        if ($current_user->ID != 0) {
        
            $userinputs = get_user_meta($current_user->ID, 'userinputs');
            $apiusername = get_user_meta($current_user->ID, 'apiusername');
            $apiuserpwd = get_user_meta($current_user->ID, 'apiuserpwd');
            $cachetimesecs= get_user_meta($current_user->ID, 'cachetimesecs');
          
            if (isset($userinputs[0]))
			$auserinputs = $userinputs[0];
		    else
            $auserinputs='';

            if (false === ($value = get_transient('xsaucal_tompeas'.$current_user->ID))) {
                echo "Data from api".$value."-".$current_user->ID."<br>";



            $resultsfromapi = $this->posttoapi($auserinputs, $apiusername[0], $apiuserpwd[0]);
            $responsebody = wp_remote_retrieve_body($resultsfromapi);
            echo $reqdate = wp_remote_retrieve_header($resultsfromapi, 'date');

            $aresults = json_decode($responsebody, true);
            $amydata = $aresults['form'];
            $smydata = implode("<br>", $amydata);
            delete_transient( 'xsaucal_tompeas'.$current_user->ID );
            set_transient('xsaucal_tompeas'.$current_user->ID, $amydata,890 );
       
          

        }else
        {
            $amydata = get_transient('xsaucal_tompeas'.$current_user->ID);
            echo "<br>------------------Cached Data----------<br>";
            $smydata=implode("<br>",$amydata);
        }

   
        echo "<br>".$smydata;
        }
    }

    // Widget Backend
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('New title', 'wpb_widget_domain');
        }
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:');?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
<?php
}

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

   
}

// Register and load the widget
function wpb_load_widget()
{
    register_widget('saucal_gtompeas_widget');
}
add_action('widgets_init', 'wpb_load_widget');
