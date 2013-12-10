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
	echo 'Anno di Riferimento: ';
	$get_avcp_dis_archivioanni = get_option('avcp_dis_archivioanni');
	if ($get_avcp_dis_archivioanni == '1') {
		echo strip_tags (
			get_the_term_list( $post->ID, 'annirif', '', ' - ', '' )
		);
	} else {
		echo get_the_term_list( $post->ID, 'annirif', '', ' - ', '' );
	}
	echo '<br/>';
    echo 'CIG: <b>' . get_post_meta(get_the_ID(), 'avcp_cig', true) . '</b><br/>';
	echo 'Contraente: <b>' . get_post_meta(get_the_ID(), 'avcp_contraente', true) . '</b><br/>';
	echo 'Importo Aggiudicazione: <b>' . get_post_meta(get_the_ID(), 'avcp_aggiudicazione', true) . '</b><br/>';
	echo 'Somme liquidate: <b>' . get_post_meta(get_the_ID(), 'avcp_somme_liquidate', true) . '</b><br/>';
	echo 'Data di inizio: <b>' . date("Y-m-d", strtotime(get_post_meta(get_the_ID(), 'avcp_data_inizio', true))) . '</b><br/>';
	echo 'Data di ultimazione: <b>' . date("Y-m-d", strtotime(get_post_meta(get_the_ID(), 'avcp_data_fine', true))) . '</b><br/>';
	echo 'Ditte partecipanti: ';

	$get_avcp_dis_archivioditte = get_option('avcp_dis_archivioditte');
	if ($get_avcp_dis_archivioditte == '1') {
		echo strip_tags (
			get_the_term_list( $post->ID, 'ditte', '', ' - ', '' )
		);
	} else {
		echo get_the_term_list( $post->ID, 'ditte', '', ' - ', '' );
	}
}
?>