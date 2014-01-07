<?php
add_action('template_redirect', 'avcp_job_cpt_template');
function avcp_job_cpt_template()
{
		global $wp, $wp_query;
		if (isset($wp->query_vars['post_type']) && $wp->query_vars['post_type'] == 'avcp') {
			if (have_posts()) {
				add_filter('the_content', 'avcp_job_cpt_template_filter');
			} else {
				$wp_query->is_404 = true;
			}
		}
}
function avcp_job_cpt_template_filter($content)
{
    global $wp_query;
    $jobID = $wp_query->post->ID;
	//echo get_post_meta(get_the_ID(), 'ammap_wysiwyg', true) . '<br/>';

	echo '<br/>';
	echo '<table>';
	echo '<tr><td>CIG:</td><td>' . get_post_meta(get_the_ID(), 'avcp_cig', true) . '</td></tr>';
	echo '<tr><td>Struttura proponente:</td><td>' . get_option('avcp_denominazione_ente') . '<br/>' . get_option('avcp_codicefiscale_ente') . '</td></tr>';
	echo '<tr><td>Oggetto del bando:</td><td>' . get_the_title(get_the_ID()) . '</td></tr>';
	echo '<tr><td>Procedura di scelta del contraente:</td><td>' .  get_post_meta(get_the_ID(), 'avcp_contraente', true) . '</td></tr>';
	echo '<tr><td>Importo di aggiudicazione:</td><td>' .  get_post_meta(get_the_ID(), 'avcp_aggiudicazione', true) . '</td></tr>';
	echo '<tr><td>Data di effettivo inizio:</td><td>' .  date("d F Y", strtotime(get_post_meta(get_the_ID(), 'avcp_data_inizio', true))) . '</td></tr>';
	echo '<tr><td>Data di ultimazione:</td><td>' .  date("d F Y", strtotime(get_post_meta(get_the_ID(), 'avcp_data_fine', true))) . '</td></tr>';
	echo '<tr><td>Importo delle somme liquidate:</td><td>' .  get_post_meta(get_the_ID(), 'avcp_somme_liquidate', true) . '</td></tr>';
	echo '<tr><td>Anno di riferimento:</td><td>';
	$get_avcp_dis_archivioanni = get_option('avcp_dis_archivioanni');
	if ($get_avcp_dis_archivioanni == '1') {
		echo strip_tags (
			get_the_term_list( $post->ID, 'annirif', '', ' - ', '' )
		);
	} else {
		echo get_the_term_list( $post->ID, 'annirif', '', ' - ', '' );
	}
	echo '</td></tr>';
	echo '</table>';
	echo '<h3>Elenco degli operatori invitati a presentare offerte</h3>';

	echo '<table>';	
	$terms = get_the_terms( $post->ID, 'ditte' );
	if ($terms) {
	  foreach($terms as $term) {
		$get_term = get_term_by('name', $term->name, 'ditte');
		$t_id = $get_term->term_id;
		$term_meta = get_option( "taxonomy_$t_id" );
		$term_return = esc_attr( $term_meta['avcp_codice_fiscale'] );
		echo '<tr>
			<td><a href="' . get_term_link( $get_term->term_id, 'ditte' ) . '" title="' . $term->name . '">' . $term->name . '</a></td>
			<td>' . $term_return . '</td>
			</tr>';
	  }
	}
	echo '</table>';
	
	echo '<h3>Aggiudicatari</h3>';
	echo '<table>';
	global $post;
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
				echo '<tr>
				<td><a href="' . get_term_link( $cterm->term_id, 'ditte' ) . '" title="' . $term->name . '">' . $term->name . '</a></td>
				<td>' . $term_return . '</td>
				</tr>';
			}
		}
	}	
	
	echo '</table>';
	
}
?>