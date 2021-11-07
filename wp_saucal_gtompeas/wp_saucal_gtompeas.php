<?php
/**
 * Plugin Name: Saucal Gtompeas Widget
 * Plugin URI: https://saucal.com
 * Description: Modify Woocommerce `My Account` tab,grab data from api and display them in a widget
 *
 * Author: George Tompeas
 * Author URI:  https://saucal.com
 * Version: 1.0
 */

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}



/* The code part that modify my account page
Create a new Tab "Saucal" with  Settings Form
 */

require_once 'modify_account_saucal_gtompeas.php';

/* The code part that create the widget
Get the user settings from Tab "Saucal"
post them to api and display the results
 */
require_once 'widget_class_saucal_gtompeas.php';
