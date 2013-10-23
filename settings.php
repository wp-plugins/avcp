<?php

/* =========== Settings Menu ============ */


if ( is_admin() ){ // admin actions
  add_action('admin_menu', 'atg_setting_menu');
  add_action('admin_init', 'atg_reg_settings');
} else {
  // non-admin enqueues, actions, and filters
}

function atg_reg_settings() {
	//register_setting( 'at_options_group', 'at_option_sblocca_tipologie', 'intval');
}

function atg_setting_menu()
{
    add_submenu_page('edit.php?post_type=at_gara', 'Impostazioni', 'Impostazioni', 'manage_options', 'atg_settings', 'atg_settings_menu');
}

function atg_settings_menu()
{
	if(isset($_POST['XMLgenBUTTON'])) {
		include(plugin_dir_path(__FILE__) . 'avcp_xml_generator.php');
		echo '<div class="updated"><p>'; 
        printf(__('AVCP | Il file .xml è stato generato correttamente!'));
        echo "</p></div>";
	}
	
	echo '<div class="wrap">';
	screen_icon();
	echo '<h2>AVCP XML WORDPRESS</h2>
	Questo plugin è stato realizzato per generare un file XML per l’AVCP (Autorità per la Vigilanza sui Contratti Pubblici di Lavori, Servizi e Forniture) conforme alle specifiche tecniche ai sensi dell’art. 1 comma 32 Legge n. 190/2012.';
	
	echo '<form method="post" name="options" target="_self">';
	settings_fields( 'at_option_group' );
	echo '<p class="submit"><input type="submit" class="button-primary" name="XMLgenBUTTON" value="Genera XML" />Clicca qui per generare manualmente il file .xml</p>';
	echo '</form>';
	
	echo '<h3>Impostazioni</h3>';
	
	echo '<h3>Informazioni</h3>
	Plugin Wordpress sviluppato da Marco Milesi in collaborazione con CentroSistema.<br/>
	Per richiedere supporto contattare milesimarco@outlook.com';
	echo '</div>';

}
?>