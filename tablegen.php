<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo plugin_dir_url(__FILE__).'includes/jquery.dataTables.min.js';?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo plugin_dir_url(__FILE__).'TableTools/js/TableTools.js'?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo plugin_dir_url(__FILE__).'TableTools/js/ZeroClipboard.js'?>"></script>

<?php
$get_avcp_tab_jqueryui = get_option('avcp_tab_jqueryui');
if ($get_avcp_tab_jqueryui == '1') {
	$t_jqueryui = 'true';
} else {
	$t_jqueryui = 'false';
}
?>
<style type="text/css" title="currentStyle">
			@import "<?php echo plugin_dir_url(__FILE__).'css/demo_page.css';?>";
			@import "<?php echo plugin_dir_url(__FILE__).'css/demo_table_jui.css';?>";
<?php if ($t_jqueryui == 'true') {
			echo '@import "' . plugin_dir_url(__FILE__). 'css/themeroller.css';
}?>
</style>
<script type="text/javascript" charset="utf-8">
$(document).ready( function () {
	var oTable = $('#avcp_table').dataTable( {
		"bScrollCollapse": true,
		"bJQueryUI": <? echo $t_jqueryui ?>,
		"bSort": true,
		//"sDom": '<"H"Tfr>T<"F"ip>lfrtip',
		//"sDom": 'T<"clear">lfrtip',
		"sDom": 'T<"clear"><"H"lfr>t<"F"ip>',
		"sPaginationType": "full_numbers",
		"oLanguage": {
			"sProcessing":   "Caricamento dati avcp...",
			"sLengthMenu":   "Visualizza _MENU_ voci",
			"sZeroRecords":  "Nessun risultato trovato.",
			"sInfo":         "Vista da _START_ a _END_ di _TOTAL_ voci",
			"sInfoEmpty":    "Vista da 0 a 0 di 0 voci",
			"sInfoFiltered": "(filtrati da _MAX_ voci totali)",
			"sInfoPostFix":  "",
			"sSearch":       "Cerca:",
			"sFirst":    "Inizio",
			"sPrevious": "Precedente",
			"sNext":     "Successivo",
			"sLast":     "Fine",
			"oPaginate": {
				"sFirst":    "Inizio",
				"sPrevious": "Precedente",
				"sNext":     "Successivo",
				"sLast":     "Fine",
			},
		},
		"oTableTools": {
			"sSwfPath": "<?php echo plugin_dir_url(__FILE__).'TableTools/swf/copy_csv_xls_pdf.swf'?>",
			"aButtons": [
				{
					"sExtends": "csv",
					"sButtonText": "CSV",
					"sFileName": "<?php echo get_bloginfo( 'name' );?>_amministrazioneaperta.csv"
				},
				{
					"sExtends": "xls",
					"sButtonText": "EXCEL",
					"sFileName": "<?php echo get_bloginfo( 'name' );?>_amministrazioneaperta.xls"
				},
				{
					"sExtends": "pdf",
					"sButtonText": "PDF",
					"sPdfOrientation": "landscape",
					"sPdfMessage": "<?php echo get_bloginfo( 'name' );?> - Amministrazione Aperta",
					"sFileName": "<?php echo get_bloginfo( 'name' );?>_amministrazioneaperta.pdf"
				}
			]
		}
	} );
	
	
} );

</script>

<!-- Qui inizia il codice per il rendering della tabella. Il parametro anno è passato dallo shortcode! -->

<table id="avcp_table" class="display">
    <thead>
        <tr>
            <th>Oggetto</th>
            <th>C.I.G.</th>
            <th>Importo aggiudicazione</th>
			<th>Partecipanti</th>
        </tr>
    </thead>
    <tbody>

	<!-- Avvio query -->
<?php if ($anno=="all") {
query_posts( array( 'post_type' => 'avcp', 'orderby' => date, 'order' => DESC, 'posts_per_page' => -1  ) );
echo '<h3>Elenco Bandi e appalti - Tutti gli Anni</h3>';
} else {
query_posts( array( 'post_type' => 'avcp', 'orderby' => date, 'order' => DESC, 'posts_per_page' => -1 , 'annirif' => $anno) );
echo '<h3>Elenco Bandi e appalti - Anno ' . $anno . '</h3>';
}
?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); global $post; ?>
<?php
$avcp_cig = get_post_meta($post->ID, 'avcp_cig', true);
$avcp_importo_aggiudicazione = get_post_meta($post->ID, 'avcp_aggiudicazione', true);
?>
        <tr>
            <td><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></td>
            <td><?php echo $avcp_cig; ?></td>
            <td><?php echo '€ ' . $avcp_importo_aggiudicazione; ?></td>
<td>
<?php
$get_avcp_dis_archivioditte = get_option('avcp_dis_archivioditte');
if ($get_avcp_dis_archivioditte == '1') {
	echo strip_tags (
		get_the_term_list( $post->ID, 'ditte', '', ' - ', '' )
	);
} else {
	echo get_the_term_list( $post->ID, 'ditte', '', ' - ', '' );
}
?></td>
        </tr>

<?php endwhile; else: ?>
 <p>Errore query.</p>
<?php endif; ?>
<?php wp_reset_query(); ?>
    </tbody>
</table>
<?php
echo '<div class="clear"></div>';
$get_avcp_showxml = get_option('avcp_showxml');
if ($get_avcp_showxml == '1') {
	echo '<div style="float:right;"><small><a href="' . get_site_url() . '/avcp" target="_blank" title="File .xml">Scarica i file annuali in formato .xml</a></small></div>';
}
$get_avcp_showlove = get_option('avcp_showlove');
if ($get_avcp_showlove == '1') {
	echo '<small>Tabella generata con il plugin <a href="http://wordpress.org/plugins/avcp/" target="_blank" title="AVCP Wordpress Plugin">AVCP XML per Wordpress</a></small>';
}
?>