<?php

add_action( 'admin_menu', 'register_avcp_wpgov_menu_page' );

function register_avcp_wpgov_menu_page(){
    if (is_plugin_active( 'amministrazione-trasparente/amministrazionetrasparente.php' )) { return; }
    add_menu_page('Impostazioni soluzioni WPGOV.IT', 'WPGov.it', 'manage_options', 'impostazioni-wpgov', 'avcp_wpgov_settings', 'dashicons-palmtree', 40);
}

function avcp_wpgov_settings () {
    
    $date1 = date('Y-m-d', time());
    $date2 = date('Y-m-d', strtotime(get_option('wpgov_ddate')) );
    if ( floor( (strtotime($date1)-strtotime($date2))/(60*60*24) ) > 6 ) {
        update_option('wpgov_ddate', $date1);
        include(plugin_dir_path(__FILE__) . 'dona.php');
    } else {
        include(plugin_dir_path(__FILE__) . 'dispatcher.php');
    }
}
?>
