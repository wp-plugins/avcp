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
	echo '<h2>Validazione Dataset XML</h2><em>Tramite questa pagina puoi verificare se i tuoi dataset xml generati presentano problemi di validazione secondo le specifiche di avcp. Ricorda che questo test non garantisce, e anzi <b>ignora</b>, la completezza o veridicita\' delle informazioni inserite, o di dati omessi.<br/>In particolare, controllare di avere impostato per ogni gara le relative ditte aggiudicatarie.</em>';
	echo '<hr/><center>Per creare/aggiornare i dataset clicca su "AVCP -> Impostazioni >> Crea Dataset"</center><hr/>';
	check_annoimpostato();
    $terms = get_terms( 'annirif', array('hide_empty' => 0) );
	foreach ( $terms as $term ) {
		$xml = new DOMDocument(); 
		$xml->load(ABSPATH  . '/avcp/' . $term->name. '.xml');
		echo '<hr/><center><h3 style="margin-bottom: 0px;">Dataset Anno ' . $term->name . '</h3><small><a target="_blank" href="' . get_site_url()  . '/avcp/' . $term->name. '.xml">' . get_site_url()  . '/avcp/' . $term->name. '.xml</a></small></center>';
		if (!$xml->schemaValidate(ABSPATH  . '/wp-content/plugins/avcp/includes/datasetAppaltiL190.xsd')) {
			libxml_display_errors();
			echo '<br/><center><font style="background-color:red;color:white;padding:2px;border-radius:3px;font-weight:bold;font-family:verdana;">ERRORE VALIDAZIONE AVCP<br/>Risolvere i problemi riportati qui sopra, poi procedere con la rigenerazione dei dataset .xml!</font></center><br/>';
			check_software($term->name);
		} else {
			echo '<center><br/><font style="background-color:lime;padding:2px;border-radius:3px;font-weight:bold;font-family:verdana;">Validazione sintattica passata!</font></center>';
			check_software($term->name);
		}
	}
	echo '<br/><div class="clear"></div><hr><center>Puoi controllare online i dataset anche con il validatore gratuito offerto da <b><a href="https://avcp.centrosistema.it/validator">CentroSistema</a></b></center>';
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

function check_software($anno) {
query_posts( array( 'post_type' => 'avcp', 'annirif' => $anno, 'posts_per_page' => '-1') ); global $post;
	$erroredate = false;
	if ( have_posts() ) : while ( have_posts() ) : the_post();
			$datainizio = get_post_meta($post->ID, 'avcp_data_inizio', true);
			$datafine = get_post_meta($post->ID, 'avcp_data_fine', true);
			if ($datainizio == '' || $datafine == '' ) {
				$erroredate = true;
				$logerrori .= '[id <b>' . $post->ID . '</b> // ' . get_the_title() . '] -';
			}
	endwhile; else:
	endif;
	if ($erroredate == true) {
		echo '<center><font style="background-color:red;color:white;padding:2px;border-radius:3px;font-weight:bold;font-family:verdana;">ERRORE VALIDAZIONE SOFTWARE: data_inizio / data_fine<br/>' . $logerrori . '</font></center><br/>';
	} else {
		echo '<center><font style="background-color:lime;padding:2px;border-radius:3px;font-weight:bold;font-family:verdana;">Validazione software completata per i campi data_inizio e data_fine</font></center>';
	}
}

function check_annoimpostato() {
	query_posts( array( 'post_type' => 'avcp', 'posts_per_page' => '-1') ); global $post;
	$erroreanno = false;
	$ng = 0;
	if ( have_posts() ) : while ( have_posts() ) : the_post();
			$ng++;
			if(!( has_term( '2013', 'annirif' ) || has_term( '2014', 'annirif' ) )) {
				$erroreanno = true;
			}
	endwhile; else:
	endif;
	if ($erroreanno == true) {
		echo '<center><font style="background-color:red;color:white;padding:2px;border-radius:3px;font-weight:bold;font-family:verdana;">ATTENZIONE || E\' PRESENTE UNA O PIU\' GARE SENZA ANNO DI RIFERIMENTO!!</font></center><br/>';
	} else {
		echo '<center><font style="background-color:lime;padding:2px;border-radius:3px;font-weight:bold;font-family:verdana;">Tutte le ' . $ng . ' gare hanno un anno di riferimento e saranno incluse nel relativo dataset :)</font></center>';
	}
}

?>