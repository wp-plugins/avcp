<?php
function creafilexml ($anno) {
	$avcp_denominazione_ente = get_option('avcp_denominazione_ente');
	$XML_data_aggiornamento =  date("Y-m-d");
	$XML_data_completa_aggiornamento = date('d/m/y - H:i'); //Utile essenzialmente per i test
	$XML_anno_riferimento =  $anno;

	$XML_FILE .= '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	$XML_FILE .= '
	<legge190:pubblicazione xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:legge190="legge190_1_0" xsi:schemaLocation="legge190_1_0 datasetAppaltiL190.xsd">
	<metadata>
	<titolo>Pubblicazione 1 legge 190</titolo>
	<abstract>Pubblicazione 1 legge 190 anno 1 rif. 2013 - ' . $XML_data_completa_aggiornamento . ' - Wordpress Plugin AVCP XML di Marco Milesi</abstract>
	<dataPubbicazioneDataset>2013-06-12</dataPubbicazioneDataset>
	<entePubblicatore>' . $avcp_denominazione_ente . '</entePubblicatore>
	<dataUltimoAggiornamentoDataset>' . $XML_data_aggiornamento . '</dataUltimoAggiornamentoDataset>
	<annoRiferimento>' . $XML_anno_riferimento . '</annoRiferimento>
	<urlFile>' . site_url() . '/avcp/' . $anno . '.xml' . '</urlFile>
	<licenza>IODL</licenza>
	</metadata>
	<data>';

	query_posts( array( 'post_type' => 'avcp', 'annirif' => $anno) ); global $post;
	if ( have_posts() ) : while ( have_posts() ) : the_post();
	//Ottieni le variabili per la voce corrente
	$avcp_cig = get_post_meta($post->ID, 'avcp_cig', true);
	$avcp_codicefiscale_ente = get_option('avcp_codicefiscale_ente');
	$avcp_contraente = get_post_meta($post->ID, 'avcp_contraente', true);
	$avcp_importo_aggiudicazione = get_post_meta($post->ID, 'avcp_aggiudicazione', true);
	$avcp_somme_liquidate = get_post_meta($post->ID, 'avcp_somme_liquidate', true);
	$avcp_data_inizio = date("Y-m-d", strtotime(get_post_meta(get_the_ID(), 'avcp_data_inizio', true)));
	$avcp_data_ultimazione = date("Y-m-d", strtotime(get_post_meta(get_the_ID(), 'avcp_data_fine', true)));
	$XML_FILE .= '<lotto>
	<cig>' . $avcp_cig . '</cig>
	<strutturaProponente>
	<codiceFiscaleProp>' . $avcp_codicefiscale_ente . '</codiceFiscaleProp>
	<denominazione>' . $avcp_denominazione_ente . '</denominazione>
	</strutturaProponente>
	<oggetto>' . get_the_title() . '</oggetto>
	<sceltaContraente>' . $avcp_contraente . '</sceltaContraente>
	<partecipanti>';
	$queried_term = get_query_var($taxonomy);
	$terms = get_the_terms( $post->ID, 'ditte' );
	if ($terms) {
	  foreach($terms as $term) {
		$get_term = get_term_by('name', $term->name, 'ditte');
		$t_id = $get_term->term_id;
		$term_meta = get_option( "taxonomy_$t_id" );
		$term_return = esc_attr( $term_meta['avcp_codice_fiscale'] );
		$XML_FILE .= '<partecipante>
			<codiceFiscale>' . $term_return . '</codiceFiscale>
			<ragioneSociale>' . $term->name . '</ragioneSociale>
			</partecipante>';
	  }
	}
	$XML_FILE .= '</partecipanti>
	<aggiudicatari>';
	
	$dittepartecipanti = get_the_terms( $post->ID, 'ditte' );
	$cats = get_post_meta($post->ID,'avcp_aggiudicatari',true);
	if(is_array($dittepartecipanti)) {
		foreach ($dittepartecipanti as $term) {
			
			$cterm = get_term_by('name',$term->name,'ditte');
			$cat_id = $cterm->term_id; //Prende l'id del termine
			$term_meta = get_option( "taxonomy_$cat_id" );
			$term_return = esc_attr( $term_meta['avcp_codice_fiscale'] );
			$checked = (in_array($cat_id,(array)$cats)? ' checked="checked"': "");
			if ($checked) {
				$XML_FILE .= '<aggiudicatario>';
				$XML_FILE .= '<ragioneSociale>' . $term->name . '</ragioneSociale>';
				$XML_FILE .= '<codiceFiscale>' . $term_return . '</codiceFiscale>';
				$XML_FILE .= '</aggiudicatario>';
			}
		}
	}	
	
	$XML_FILE .= '</aggiudicatari>
	<importoAggiudicazione>' . $avcp_importo_aggiudicazione . '</importoAggiudicazione>
	<tempiCompletamento>
	<dataInizio>' . $avcp_data_inizio . '</dataInizio>
	<dataUltimazione>' . $avcp_data_ultimazione . '</dataUltimazione>
	</tempiCompletamento>
	<importoSommeLiquidate>' . $avcp_somme_liquidate . '</importoSommeLiquidate>
	</lotto>';
	endwhile; else:
	_e('Sorry, no posts matched your criteria.');
	endif;

	$XML_FILE .= '</data>
	</legge190:pubblicazione>';

	// Open or create a file (this does it in the same dir as the script)
	$XML_PATH = ABSPATH . 'avcp/' . $anno . '.xml';
	$my_file = fopen($XML_PATH, "w");

	// Write the string's contents into that file
	fwrite($my_file, $XML_FILE);

	// Close 'er up
	fclose($my_file);
}
?>