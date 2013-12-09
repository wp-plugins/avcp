<?php
function creafilexml ($anno) {
	$XML_ente_proponente = get_option('avcp_denominazione_ente');
	$XML_data_aggiornamento =  date("Y-m-d");
	$XML_data_completa_aggiornamento = date('d/m/y - h:m.s'); //Utile essenzialmente per i test
	$XML_anno_riferimento =  $anno;

	$XML_FILE .= '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	$XML_FILE .= '
	<legge190:pubblicazione xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:legge190="legge190_1_0" xsi:schemaLocation="legge190_1_0 datasetAppaltiL190.xsd">
	<metadata>
	<titolo>Pubblicazione 1 legge 190</titolo>
	<abstract>Pubblicazione 1 legge 190 anno 1 rif. 2013 - ' . $XML_data_completa_aggiornamento . ' - Wordpress Plugin AVCP XML di Marco Milesi</abstract>
	<dataPubbicazioneDataset>2013-06-12</dataPubbicazioneDataset>
	<entePubblicatore>' . $XML_ente_proponente . '</entePubblicatore>
	<dataUltimoAggiornamentoDataset>' . $XML_data_aggiornamento . '</dataUltimoAggiornamentoDataset>
	<annoRiferimento>' . $XML_anno_riferimento . '</annoRiferimento>
	<urlFile>' . site_url() . 'avcp.xml' . '</urlFile>
	<licenza>IODL</licenza>
	</metadata>
	<data>';

	query_posts( array( 'post_type' => 'avcp', 'annirif' => $anno) ); global $post;
	if ( have_posts() ) : while ( have_posts() ) : the_post();
	//Ottieni le variabili per la voce corrente
	$avcp_cig = get_post_meta($post->ID, 'avcp_cig', true);
	$avcp_codicefiscale_ente = get_option('avcp_codicefiscale_ente');
	$avcp_denominazione_ente = get_option('avcp_denominazione_ente');
	$avcp_contraente = get_post_meta($post->ID, 'avcp_contraente', true);
	$avcp_importo_aggiudicazione = get_post_meta($post->ID, 'avcp_aggiudicazione', true);
	$avcp_somme_liquidate = get_post_meta($post->ID, 'avcp_somme_liquidate', true);
	$avcp_data_inizio = date("Y-m-d", strtotime(get_post_meta(get_the_ID(), 'data_inizio', true)));
	$avcp_data_ultimazione = date("Y-m-d", strtotime(get_post_meta(get_the_ID(), 'data_fine', true)));
	$XML_FILE .= '<lotto>
	<cig>' . $avcp_cig . '</cig>
	<strutturaProponente>
	<codiceFiscaleProp>' . $avcp_codicefiscale_ente . '</codiceFiscaleProp>
	<denominazione>' . $avcp_denominazione_ente . '</denominazione>
	</strutturaProponente>
	<oggetto>' . get_the_title() . '</oggetto>
	<sceltaContraente>' . $avcp_contraente . '</sceltaContraente>
	<partecipanti>
	<partecipante>
	<codiceFiscale>XXXXXXXXXXX</codiceFiscale>
	<ragioneSociale>XXXXXXXXX</ragioneSociale>
	</partecipante>
	</partecipanti>
	<aggiudicatari>';
	$queried_term = get_query_var($taxonomy);
	$terms = get_terms('ditte', 'slug='.$queried_term);
	if ($terms) {
	  foreach($terms as $term) {
		$XML_FILE .= '<aggiudicatario>
			<codiceFiscale>XXXXXX</codiceFiscale>
			<ragioneSociale>' . $term->name . '</ragioneSociale>
			</aggiudicatario>';
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