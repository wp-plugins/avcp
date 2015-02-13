<?php

add_action( 'admin_menu', 'register_avcp_wpgov_menu_page' );

function register_avcp_wpgov_menu_page(){
    if (is_plugin_active( 'amministrazione-trasparente/amministrazionetrasparente.php' )) { return; }
    add_menu_page('Impostazioni soluzioni WPGOV.IT', 'WPGov.it', 'manage_options', 'impostazioni-wpgov', 'avcp_wpgov_settings', 'dashicons-palmtree', 40);
}

function avcp_wpgov_settings () {
    include(plugin_dir_path(__FILE__) . 'dispatcher.php');
}
?>
