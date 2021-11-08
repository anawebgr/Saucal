<?php
/**
 * Modify Woocommerce myaccount to add saucal Tab
 *
 * @package  wp_saucal_gtompeas
 * @version  1.0.0
 */

function add_saucal_tompeas_endpoint()
{
    add_rewrite_endpoint('saucal_tompeas', EP_ROOT | EP_PAGES);
    flush_rewrite_rules();
}

add_action('init', 'add_saucal_tompeas_endpoint');

function saucal_tompeas_query_vars($vars)
{
    $vars[] = 'saucal_tompeas';
    return $vars;
}

add_filter('query_vars', 'saucal_tompeas_query_vars', 0);

function add_saucal_tompeas_link_my_account($items)
{
    $items['saucal_tompeas'] = 'Saucal';
    return $items;
}

add_filter('woocommerce_account_menu_items', 'add_saucal_tompeas_link_my_account');


add_action('woocommerce_account_saucal_tompeas_endpoint', 'saucal_tompeas1');

function saucal_tompeas1()
{
    $current_user = wp_get_current_user();

    $userinputsdata = get_user_meta($current_user->ID, 'userinputs');
    if (isset($userinputsdata[0]))
	$userinputsdataval = implode("\n", $userinputsdata[0]);
    else
	$userinputsdataval='';	
	

    echo '<h3>Saucal Test Tompeas</h3><p>Please Complete the Form Below </p>';
    echo '<p>Every Line  is a New Data Entry </p>';
  
    echo '  <form class="woocommerce-EditAccountForm edit-account" action="/my-account" method="post">
            <div class="clear"></div>
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
               <label for="userinputs">User data&nbsp;<span class="required">*</span></label>
               <textarea placeholder="Fill data one per line
               Data1
               Data2" id="userinputs"  id="userinputs" name="userinputs" rows="14" cols="50" >' . trim($userinputsdataval) . '</textarea>
	        </p>
	        <p>   <label for="apiusername">Api User Name&nbsp;<span class="required">*</span></label></p>
            <p>   <input name="apiusername" id="apiusername" value="ff" placeholder="Complete the user name for the api"</p>
            <p>   <label for="apiuserpwd">Api  User PassWord&nbsp;<span class="required">*</span></label></p>
            <p>   <input name="apiuserpwd" id="apiuserpwd" value="ff" placeholder="Complete the user pwd for the api"</p>
            <div class="clear"></div>
            <p>   <label for="cachetimesecs">Cache Expiration in secs &nbsp;<span class="required">*</span></label></p>
            <p>   <input name="cachetimesecs" id="cachetimesecs" value="60" placeholder="How many secs cache live"</p>
         

            <div class="clear"></div>
            <div>
               <button type="submit" class="woocommerce-Button button" name="save_saucal_userdata" value="Save User Data">Save User Data</button>
               <input type="hidden" name="action" value="save_saucal_userdata">
		       <input type="hidden" name="userid" value="' . $current_user->ID . '">
            </div>

    </form>
    <div class="clear"></div>
    <div><p>The Data from Api </p></div>

    ';
  the_widget( 'saucal_gtompeas_widget' );

	
}
add_action('wp', 'save_user_data_account_details');


function save_user_data_account_details()
{

    if (isset($_POST['action']) && $_POST['action'] == 'save_saucal_userdata') {

        $ag = explode("\n", $_POST['userinputs']);

        update_user_meta($_POST['userid'], 'userinputs', $ag);
        update_user_meta($_POST['userid'], 'apiusername', $_POST['apiusername']);
        update_user_meta($_POST['userid'], 'apiuserpwd', $_POST['apiuserpwd']);
        update_user_meta($_POST['userid'], 'cachetimesecs', $_POST['cachetimesecs']);
        delete_transient( 'xsaucal_tompeas'.$_POST['userid'] );
      //  set_transient('xsaucal_tompeas'.$_POST['userid'], $ag,$_POST['cachetimesecs'] ); 

      



      
        $_POST['action'] = '';

    }
	}