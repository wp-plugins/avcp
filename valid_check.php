<?php
function avcp_valid_check() {
	// Enable user error handling 
	libxml_use_internal_errors(true);
	
	$terms = get_terms( 'annirif', array('hide_empty' => 0) );
	foreach ( $terms as $term ) {
		$xml = new DOMDocument(); 
		$xml->load(get_site_url()  . '/avcp/' . $term->name. '.xml');
		if (!$xml->schemaValidate(get_site_url()  . '/wp-content/plugins/avcp/includes/datasetAppaltiL190.xsd')) {
			$errori .= $term->name . ' ';
		}
	}
	if ($errori) {
		update_option('avcp_invalid', '1');
		echo '<div class="error"><p>AVCP | I seguenti file .xml presentano errori: ' . $errori . '</p><p><a href="' . admin_url() . 'edit.php?post_type=avcp&page=avcp_v_dataset">Clicca qui vedere i dettagli degli errori</a></div>';
	} else {
		update_option('avcp_invalid', '0');
	}
}
?>