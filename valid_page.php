<?php
add_action('admin_menu', 'avcp_valid_menu');
function avcp_valid_menu()
{
    add_submenu_page('edit.php?post_type=avcp', 'Validazione Dataset', 'Validazione Dataset', 'manage_options', 'avcp_v_dataset', 'avcp_v_dataset_load');
}

function avcp_v_dataset_load()
{
	echo '<div class="wrap">';
	screen_icon();
	echo '<h2>Validazione Dataset XML</h2><em>Tramite questa pagina puoi verificare se i tuoi dataset xml generati presentano problemi di validazione secondo le specifiche di avcp. Ricorda che questo test non garantisce la completezza o veridicita\' delle informazioni inserite, o di dati omessi.</em>';
    $terms = get_terms( 'annirif', array('hide_empty' => 0) );
	foreach ( $terms as $term ) {
		$xml = new DOMDocument(); 
		$xml->load(ABSPATH  . '/avcp/' . $term->name. '.xml');
		echo '<hr><h3>Dataset Anno ' . $term->name . ' >>> <a href="' . get_site_url()  . '/avcp/' . $term->name. '.xml">' . get_site_url()  . '/avcp/' . $term->name. '.xml</a></h3>';
		if (!$xml->schemaValidate(ABSPATH  . '/wp-content/plugins/avcp/includes/datasetAppaltiL190.xsd')) {
			libxml_display_errors();
			echo '<br/><font style="color:red;font-weight:bold;">Risolvere i problemi riportati qui sopra, poi procedere con la rigenerazione dei dataset .xml!</font>';
		} else {
			echo 'Valido!';
		}
	}
	echo '</div>';
}

function libxml_display_error($error) 
{ 
$return = "<br/>\n"; 
switch ($error->level) { 
case LIBXML_ERR_WARNING: 
$return .= "<b>Warning $error->code</b>: "; 
break; 
case LIBXML_ERR_ERROR: 
$return .= "<b>Error $error->code</b>: "; 
break; 
case LIBXML_ERR_FATAL: 
$return .= "<b>Fatal Error $error->code</b>: "; 
break; 
} 
$return .= trim($error->message); 
if ($error->file) { 
$return .= " in <b>$error->file</b>"; 
} 
$return .= " on line <b>$error->line</b>\n"; 

return $return; 
} 

function libxml_display_errors() { 
$errors = libxml_get_errors(); 
foreach ($errors as $error) { 
print libxml_display_error($error); 
} 
libxml_clear_errors(); 
} 
// Enable user error handling 
libxml_use_internal_errors(true);

?>