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
			@import "<?php echo plugin_dir_url(__FILE__).'css/themeroller.css';?>";
</style>
<script type="text/javascript" charset="utf-8">


function fnFormatDetails ( oTable, nTr )
{
    var aData = oTable.fnGetData( nTr );
    var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
    sOut += '<tr><td>Procedura di scelta del contraente:</td><td>'+aData[7]+'</td></tr>';
    sOut += '<tr><td>Elenco degli operatori partecipanti:</td><td>'+aData[8]+'</td></tr>';
    sOut += '<tr><td>Elenco degli operatori aggiudicatari:</td><td>'+aData[9]+'</td></tr>';
    sOut += '</table>';
     
    return sOut;
}

$(document).ready( function () {
	//MULTIROW
	/*
     * Insert a 'details' column to the table
     */
    var nCloneTh = document.createElement( 'th' );
    var nCloneTd = document.createElement( 'td' );
    nCloneTd.innerHTML = '<img style="cursor:pointer;" src="<?php echo plugin_dir_url(__FILE__).'images/details_open.png';?>">';
    nCloneTd.className = "center";
     
    $('#avcp_table thead tr').each( function () {
        this.insertBefore( nCloneTh, this.childNodes[0] );
    } );
     
    $('#avcp_table tbody tr').each( function () {
        this.insertBefore(  nCloneTd.cloneNode( true ), this.childNodes[0] );
    } );
     
     
    /* Add event listener for opening and closing details
     * Note that the indicator for showing which row is open is not controlled by DataTables,
     * rather it is done here
     */
    $('#avcp_table tbody td img').live('click', function () {
        var nTr = $(this).parents('tr')[0];
        if ( oTable.fnIsOpen(nTr) )
        {
            /* This row is already open - close it */
            this.src = "<?php echo plugin_dir_url(__FILE__).'images/details_open.png';?>";
            oTable.fnClose( nTr );
        }
        else
        {
            /* Open this row */
            this.src = "<?php echo plugin_dir_url(__FILE__).'images/details_close.png';?>";
            oTable.fnOpen( nTr, fnFormatDetails(oTable, nTr), 'details' );
        }
    } );

	<?php
	$get_avcp_export = get_option('avcp_export');
	if ($get_avcp_export == '0') {
		$tabledom = 'T<"clear"><"H"lfr>t<"F"ip>';
	} else {
		$tabledom = '<"clear"><"H"lfr>t<"F"ip>';
	}
	?>
	//TABELLA
	var oTable = $('#avcp_table').dataTable( {
        "aaSorting": [[1, 'asc']], //multirow
		"bScrollCollapse": true,
		"bJQueryUI": <? echo $t_jqueryui ?>,
		//"bSort": true,
		"aoColumnDefs": [
						{ "bSortable": false, "aTargets": [ 0 ] },
                        { "bVisible": false, "aTargets": [ 7 ] },
                        { "bVisible": false, "aTargets": [ 8 ] },
						{ "bVisible": false, "aTargets": [ 9 ] },
                    ],
		"sDom": '<?php echo $tabledom; ?>',
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
                    "sExtends":    "copy",
                    "sButtonText": "Copia",
					"mColumns": [1, 2, 3, 4, 5, 6, 7, 8, 9]
                },
				{
                    "sExtends":    "print",
                    "sButtonText": "Stampa",
					"sInfo": "<h2>Modalità Stampa</h2>La tabella è pronta! Usa la funzione di stampa del tuo browser per completare",
					"mColumns": [1, 2, 3, 4, 5, 6, 7, 8, 9]
                },
				{
                    "sExtends":    "collection",
                    "sButtonText": "Esporta",
                    "aButtons":    [
						{
							"sExtends": "csv",
							"sButtonText": "CSV",
							"sFileName": "<?php echo get_bloginfo( 'name' );?>_gare.csv",
							"mColumns": [1, 2, 3, 4, 5, 6, 7, 8, 9]
						},
						{
							"sExtends": "xls",
							"sButtonText": "EXCEL",
							"sFileName": "<?php echo get_bloginfo( 'name' );?>_gare.xls",
							"mColumns": [1, 2, 3, 4, 5, 6, 7, 8, 9]
						},
						{
							"sExtends": "pdf",
							"sButtonText": "PDF",
							"sPdfOrientation": "landscape",
							"sPdfMessage": "<?php echo get_bloginfo( 'name' );?> - Bandi di Gara",
							"sFileName": "<?php echo get_bloginfo( 'name' );?>_gare.pdf",
							"mColumns": [1, 2, 3, 4, 5, 6, 7, 8, 9]
						}
					]
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
            <th>Importo agg.</th>
			<th>Importo liq.</th>
			<th>Data di inizio</th>
			<th>Data di fine</th>
			<th>Procedura di scelta</th>
			<th>Partecipanti</th>
			<th>Aggiudicatari</th>
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
			<td><?php echo '€ ' . get_post_meta(get_the_ID(), 'avcp_somme_liquidate', true); ?></td>
			<td>
			<?php
			$mesi = array(1=>'gennaio', 'febbraio', 'marzo', 'aprile',
                'maggio', 'giugno', 'luglio', 'agosto',
                'settembre', 'ottobre', 'novembre','dicembre');
	list($giorno,$mese,$anno) = explode(' ',date('j n Y',strtotime(get_post_meta(get_the_ID(), 'avcp_data_inizio', true))));
	echo $giorno . ' ' . $mesi[$mese] . ' ' . $anno;
			?>
			</td>
			<td>
			<?php
			list($giorno1,$mese1,$anno1) = explode(' ',date('j n Y',strtotime(get_post_meta(get_the_ID(), 'avcp_data_fine', true))));
			echo $giorno1 . ' ' . $mesi[$mese1] . ' ' . $anno1;
			?>
			</td>
			<td><?php echo get_post_meta(get_the_ID(), 'avcp_contraente', true); ?></td>
			<td>
			<?php
				$terms = get_the_terms( $post->ID, 'ditte' );
			if ($terms) {
			  foreach($terms as $term) {
				$get_term = get_term_by('name', $term->name, 'ditte');
				$t_id = $get_term->term_id;
				$term_meta = get_option( "taxonomy_$t_id" );
				$term_return = esc_attr( $term_meta['avcp_codice_fiscale'] );
				$stato_var = get_tax_meta($t_id,'avcp_is_ditta_estera');
				if (empty($stato_var)) {$is_estera = '<acronym title="Identificativo Fiscale Italiano">IT</acronym>';}else{$is_estera = '<acronym title="Identificativo Fiscale Estero">EE</acronym>';}
					$get_avcp_dis_archivioditte = get_option('avcp_dis_archivioditte');
					if ($get_avcp_dis_archivioditte == '1') {
						echo $term->name;
					} else {
						echo '<a href="' . get_term_link( $t_id, 'ditte' ) . '" title="' . $term->name . '">' . $term->name . '</a>';
					}
					echo' (' . $term_return . ' <b>' . $is_estera . '</b>)<br/>';
					}
				}
			?>
			</td>
			<td>
			<?php
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
			$stato_var = get_tax_meta($cat_id,'avcp_is_ditta_estera');
			if (empty($stato_var)) {$is_estera = '<acronym title="Identificativo Fiscale Italiano">IT</acronym>';}else{$is_estera = '<acronym title="Identificativo Fiscale Estero">EE</acronym>';}
			if ($checked) {
				$get_avcp_dis_archivioditte = get_option('avcp_dis_archivioditte');
					if ($get_avcp_dis_archivioditte != '1') {
						echo '<a href="' . get_term_link( $cterm->term_id, 'ditte' ) . '" title="' . $term->name . '">';
					}
					echo $term->name;
					if ($get_avcp_dis_archivioditte != '1') { echo '</a>'; }
				echo ' (' . $term_return . ' <b>' . $is_estera . '</b>)<br/>';
			}
		}
	}	?></td>
        </tr>

<?php endwhile; else: ?>
 <p>Nessuna gara trovata.</p>
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