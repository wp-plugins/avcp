<?php

function get_meta_values( $key = '', $type = 'avcp', $status = 'publish' ) {
    global $wpdb;
    if( empty( $key ) )
        return;
    $r = $wpdb->get_col( $wpdb->prepare( "
        SELECT pm.meta_value FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        WHERE pm.meta_key = '%s' 
        AND p.post_status = '%s' 
        AND p.post_type = '%s'
    ", $key, $status, $type ) );
    return $r;
}

/* =========== Settings Menu ============ */
add_action('admin_menu', 'avcp_setting_menu');
	add_action('admin_init', 'avcp_reg_settings');
if ( is_admin() ){ // admin actions
	
} else {
  // non-admin enqueues, actions, and filters
}

function avcp_reg_settings() {
	register_setting( 'avcp_options', 'avcp_version_number'); update_option( 'avcp_version_number', '2.0.1' );
	register_setting( 'avcp_options', 'avcp_denominazione_ente');
	register_setting( 'avcp_options', 'avcp_codicefiscale_ente');
	register_setting( 'avcp_options', 'avcp_autopublish');
	register_setting( 'avcp_options', 'avcp_dis_archivioditte');
	register_setting( 'avcp_options', 'avcp_dis_archivioanni');
	register_setting( 'avcp_options', 'avcp_dis_styledbackend');
	register_setting( 'avcp_options', 'avcp_tab_jqueryui');
	register_setting( 'avcp_options', 'avcp_showxml');
	register_setting( 'avcp_options', 'avcp_showlove');
}

function avcp_setting_menu()
{
    add_submenu_page('edit.php?post_type=avcp', 'Impostazioni', 'Impostazioni', 'manage_options', 'avcp_settings', 'avcp_settings_menu');
}

function avcp_settings_menu()
{
	if (!current_user_can('manage_options')) {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}
		
	if(isset($_POST['XMLgenBUTTON'])) {
		$terms = get_terms( 'annirif', array('hide_empty' => 0) );
		$count = count($terms);
			if ( $count > 0 ){
				foreach ( $terms as $term ) {
				  creafilexml ($term->name);
				  $verificafilecreati = $term->name . ' - ' . $verificafilecreati;
				  echo '<div class="updated"><p>'; 
				  printf(__('AVCP | Il seguente file .xml è stato creato correttamente: <b>' . $term->name . '</b>'));
				  echo "</p></div>";
				}
			} else {
				echo '<div class="error"><p>'; 
				printf(__('AVCP | Impossibile creare il file .xml!<br/>Controlla che sia presente qualche gara e che siano collegate al proprio "Anno di Riferimento"...'));
				echo "</p></div>";
			}
		}	
		
    if(isset($_POST['Submit'])) {
		$get_avcp_denominazione_ente = $_POST["avcp_denominazione_ente_n"];
        update_option( 'avcp_denominazione_ente', $get_avcp_denominazione_ente );
		$get_avcp_codicefiscale_ente = $_POST["avcp_codicefiscale_ente_n"];
        update_option( 'avcp_codicefiscale_ente', $get_avcp_codicefiscale_ente );
		if (isset($_POST['avcp_autopublish_n'])){
				update_option('avcp_autopublish', '1');
			} else {
				update_option('avcp_autopublish', '0');
		}
		if (isset($_POST['avcp_dis_archivioditte_n'])){
				update_option('avcp_dis_archivioditte', '0'); //Invertito
			} else {
				update_option('avcp_dis_archivioditte', '1');
		}
		if (isset($_POST['avcp_dis_archivioanni_n'])){
				update_option('avcp_dis_archivioanni', '0'); //Invertito
			} else {
				update_option('avcp_dis_archivioanni', '1');
		}
		if (isset($_POST['avcp_dis_styledbackend_n'])){
				update_option('avcp_dis_styledbackend', '0'); //Invertito
			} else {
				update_option('avcp_dis_styledbackend', '1');
		}
		if (isset($_POST['avcp_tab_jqueryui_n'])){
				update_option('avcp_tab_jqueryui', '1');
			} else {
				update_option('avcp_tab_jqueryui', '0');
		}
		if (isset($_POST['avcp_showxml_n'])){
				update_option('avcp_showxml', '1');
			} else {
				update_option('avcp_showxml', '0');
		}
		if (isset($_POST['avcp_showlove_n'])){
				update_option('avcp_showlove', '1');
			} else {
				update_option('avcp_showlove', '0');
		}
	}
	
	echo '<div class="wrap">';
	screen_icon();
	printf(
        '
<div style="float:right;">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="F2JK36SCXKTE2">
<input type="image" src="https://www.paypalobjects.com/it_IT/IT/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - Il metodo rapido, affidabile e innovativo per pagare e farsi pagare.">
<img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
</form>
</div>

<h2>AVCP XML v' . get_option('avcp_version_number') . ' <a href="http://wordpress.org/plugins/avcp/installation/" target="_blank" class="add-new-h2">Installazione</a><a href="http://marcomilesi.ml/supporto" target="_blank" class="add-new-h2">Forum di Supporto</a><a href="http://wordpress.org/plugins/avcp/changelog/" target="_blank" class="add-new-h2">CHANGELOG</a></h2>'
    );
	
	// SYSTEM CHECK
	echo '<form method="post" name="options" target="_self">';
	settings_fields('avcp_options');
	echo '<div id="welcome-panel" style="margin:10px;width:50%;float:left;" class="welcome-panel">
	<h3><span>Generazione file .xml</span></h3>
	I file .xml generati sono pubblicamente accessibili da: <b><a class="add-new-h2" href="' . get_site_url() . '/avcp' . '" target="_blank">' . get_site_url() . '/avcp' . '</a></b><br/>
	<center><p class="submit"><input type="submit" class="button-primary" name="XMLgenBUTTON" value="Genera XML" /><br/>Clicca qui per generare manualmente i file .xml (verranno creati i file divisi per anno prendendo come riferimento il campo "Anno di Riferimento" inserito nelle varie voci).<br/>Per <b>cancellare</b> i file, accedere via ftp!</p><p style="color:red;">Attenzione! Questa funzione non sostituisce la comunicazione obbligatoria dell\'url del file .xml ad AVCP, secondo le disposizioni normative vigenti.</p></center>';
	
	echo '</div>';
	echo '
	<div id="alert" style="margin:10px;width:40%;float:left;" class="welcome-panel">
        <h3><span>System Check-UP</span></h3>';

	$dir = ABSPATH . 'avcp';
	$file = $dir . '/index.php';
	echo '<br/>';
	$system_ok = true;
	if(is_dir($dir)) {
		echo 'Presenza cartella /avcp<font style="color:green;font-weight:bold;"> ==> OK</font>';
	} else {
		echo 'Presenza cartella /avcp<font style="color:red;font-weight:bold;"> ==> NON TROVATA</font>';
		$system_ok = false;
	}
	echo '<br/>';
	if (is_writeable($dir)) {
		echo 'Permessi scrittura cartella /avcp<font style="color:green;font-weight:bold;"> ==> OK</font>';
	} else {
		echo 'Permessi scrittura cartella /avcp<font style="color:red;font-weight:bold;"> ==> NON CORRISPONDENTI</font>';
		$system_ok = false;
	}
	echo '<br/>';

	if (file_exists($file)) {
		echo 'Presenza index.php /avcp<font style="color:green;font-weight:bold;"> ==> OK</font>';
	} else {
		echo 'Presenza index.php /avcp<font style="color:red;font-weight:bold;"> ==> NON TROVATO</font>';
		$system_ok = false;
	}
	echo '<br/>';
	
	$urlcheck = get_site_url() . '/avcp/index.php';

	$agent = "Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_8; pt-pt) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27";
 
     // initializes curl session
     $ch=curl_init();
 
     // sets the URL to fetch
     curl_setopt ($ch, CURLOPT_URL,$urlcheck );
 
     // sets the content of the User-Agent header
     curl_setopt($ch, CURLOPT_USERAGENT, $agent);
 
     // return the transfer as a string
     curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
 
     // disable output verbose information
     curl_setopt ($ch,CURLOPT_VERBOSE,false);
 
     // max number of seconds to allow cURL function to execute
     curl_setopt($ch, CURLOPT_TIMEOUT, 5);
 
     curl_exec($ch);
 
     // get HTTP response code
     $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
 
     curl_close($ch);
 
    if($httpcode==200) {
		echo 'Test Accesso pubblico /avcp<font style="color:green;font-weight:bold;"> ==> OK [200]</font>';
    } else if($httpcode==500) {
		echo 'Test Accesso pubblico /avcp<font style="color:red;font-weight:bold;"> ==> ERRORE 500 ISE</font>';
		$headers = get_headers($urlcheck);
		echo ' - ' . $headers[0];
		$system_ok = false;
	} else {
        echo 'Test Accesso pubblico /avcp<font style="color:red;font-weight:bold;"> ==> ERRORE ' . $httpcode . '</font>';
		$headers = get_headers($urlcheck);
		echo ' - ' . $headers[0];
		$system_ok = false;
	}


	echo '<h4>Esito:</h4>';
	if ($system_ok) {
		echo 'Nessun problema rilevato con il server. Molto bene!';
	} else {
		echo '
		<style>
		#alert {
		background: white url(' . plugin_dir_url(__FILE__) . 'includes/alert.jpg) no-repeat center;
		}
		</style>';
		echo 'Sono stati trovati alcuni problemi <b>critici</b>. Affinchè AVCP funzioni correttamente è necessario risolvere al più presto questi problemi. Consultare la documentazione del plugin per conoscere le cause più probabili di questo problema!';
	}	
	echo '</div>
	<div class="clear"></div>';
	
	//Qui inizia la sezione delle impostazioni
	
	echo '
	<div class="postbox-container" style="width: 100%">
        <div class="metabox-holder">

    <div class="postbox" id="second">
        <h3 class="hndle"><span>Impostazioni Ente</span></h3>
            <div class="inside">
			
	<table class="form-table"><tbody>';
	
	echo '<tr>';
	echo '<th><label>Denominazione Ente</label></th>';
	echo '<td><input type="text" name="avcp_denominazione_ente_n" value="'; echo get_option('avcp_denominazione_ente'); echo '" class="regular-text">';
	echo '<span class="description">Inserire la denominazione dell\'Ente # massimo 250 caratteri</span></td>';
	echo '</tr>';
	
	echo '<tr>';
	echo '<th><label>Codice Fiscale Ente</label></th>';
	echo '<td><input type="text" name="avcp_codicefiscale_ente_n" value="'; echo get_option('avcp_codicefiscale_ente'); echo '" class="regular-text">';
	echo '<span class="description">Inserire il codice fiscale/partita iva dell\'ente # 9 caratteri.</span></td>';
	echo '</tr>';
	
	echo '<tr>';
	echo '<th><label>.XML Automatico</label></th>';
	echo '<td><input type="checkbox" name="avcp_autopublish_n" ';
	$get_avcp_autopublish = get_option('avcp_autopublish');
		if ($get_avcp_autopublish == '1') {
			echo 'checked="checked" ';
		}
	echo '><span class="description">Spunta questa casella se vuoi generare aggiungere automaticamente le gare al corrispettivo file .xml (in base all\'anno di riferimento impostato).<br/><small>Attenzione! Con questa funzione ad ogni nuova pubblicazione viene ricreato solo file .xml relativo all\'anno di riferimento della gara. Per creare i file .xml relativi ad ogni anno di riferimento è comunque necessario cliccare sul pulsante di questa pagina, in alto.</small></span></td>';
	echo '</tr>';
	
	echo'</tbody></table>
	</div></div>';
	
	echo '
	<div class="postbox" id="second">
        <h3 class="hndle"><span>Impostazioni Tabella</span></h3>
            <div class="inside">
			
	<table class="form-table"><tbody>';
	
	echo '<tr>';
	echo '<th><label>JQuery UI</label></th>';
	echo '<td><input type="checkbox" name="avcp_tab_jqueryui_n" ';
	$get_avcp_tab_jqueryui = get_option('avcp_tab_jqueryui');
		if ($get_avcp_tab_jqueryui == '1') {
			echo 'checked="checked" ';
		}
	echo '><span class="description">Spunta questa casella se vuoi abilitare il tema jQueryUI Themeroller per la tabella</span></td>';
	echo '</tr>';
	
	echo '<tr>';
	echo '<th><label>Mostra Link XML</label></th>';
	echo '<td><input type="checkbox" name="avcp_showxml_n" ';
	$get_avcp_showxml = get_option('avcp_showxml');
		if ($get_avcp_showxml == '1') {
			echo 'checked="checked" ';
		}
	echo '><span class="description">Spunta questa casella se vuoi mostrare il collegamento alla pagina dei file .xml generati (vedi in alto)</span></td>';
	echo '</tr>';
	
	echo '<tr>';
	echo '<th><label>Mostra un po\' di Amore</label></th>';
	echo '<td><input type="checkbox" name="avcp_showlove_n" ';
	$get_avcp_showlove = get_option('avcp_showlove');
		if ($get_avcp_showlove == '1') {
			echo 'checked="checked" ';
		}
	echo '><span class="description">Spunta questa casella se vuoi mostrare il link al plugin sotto alla tabella generata</span></td>';
	echo '</tr>';

	echo '</tbody></table>
	</div></div>';
	
	echo '
	<div class="postbox" id="second">
        <h3 class="hndle"><span>Visualizzazioni archivio</span></h3>
            <div class="inside">
			
	<table class="form-table"><tbody>';
	
	echo '<tr>';
	echo '<th><label>Archivio Ditte</label></th>';
	echo '<td><input type="checkbox" name="avcp_dis_archivioditte_n" ';
	$get_avcp_dis_archivioditte = get_option('avcp_dis_archivioditte');
		if ($get_avcp_dis_archivioditte == '0') {
			echo 'checked="checked" ';
		}
	echo '><span class="description">Abilita i link con la visualizzazione archivio delle ditte con i bandi a cui la ditta ha partecipato</span></td>';
	echo '</tr>';
	
	echo '<tr>';
	echo '<th><label>Archivio Annuale</label></th>';
	echo '<td><input type="checkbox" name="avcp_dis_archivioanni_n" ';
	$get_avcp_dis_archivioanni = get_option('avcp_dis_archivioanni');
		if ($get_avcp_dis_archivioanni == '0') {
			echo 'checked="checked" ';
		}
	echo '><span class="description">Abilita i link con la visualizzazione archivio su base annuale dei bandi</span></td>';
	echo '</tr>';
	
	echo '</tbody></table>
	</div></div>';
	
	echo '
	<div class="postbox" id="second">
        <h3 class="hndle"><span>Altre Impostazioni</span></h3>
            <div class="inside">
			
	<table class="form-table"><tbody>';
	
	echo '<tr>';
	echo '<th><label>CSS Backend</label></th>';
	echo '<td><input type="checkbox" name="avcp_dis_styledbackend_n" ';
	$get_avcp_dis_styledbackend = get_option('avcp_dis_styledbackend');
		if ($get_avcp_dis_styledbackend == '0') {
			echo 'checked="checked" ';
		}
	echo '><span class="description">Abilita il caricamento di css aggiuntivo per le pagine di amministrazione AVCP</span></td>';
	echo '</tr>';
	
	echo '</tbody></table>
	</div></div>
	</div></div>
	<p class="submit"><input type="submit" class="button-primary" name="Submit" value="AGGIORNA IMPOSTAZIONI" /></p>';
    
    echo '</form>';
	
	//Qui finisce la sezione delle impostazione
	
	echo '<center><h3>Scopri gli altri plugin pensati per la Pubblica Amministrazione</h3>
	<hr/>
	<a href="http://wordpress.org/plugins/amministrazione-trasparente" target="_blank" title="Plugin Wordpress per la gestione della sezione AMMINISTRAZIONE TRASPARENTE prevista dal d.lgs 33/2013">
	<img src="' . plugin_dir_url(__FILE__) . 'includes/at.png"/></a>
	<hr/>
	<a href="http://wordpress.org/plugins/amministrazione-aperta/" target="_blank" title="Plugin Wordpress per la gestione di Spese, Contributi, Concessioni, Incarichi...">
	<img src="' . plugin_dir_url(__FILE__) . 'includes/aa.png"/></a>
	<hr/>
	Sviluppo e ideazione Wordpress a cura di <a href="http://marcomilesi.ml" target="_blank" title="www.marcomilesi.ml">Marco Milesi</a><br/><small>Per la preparazione di questo programma sono state impiegate diverse ore a titolo volontario. Se vuoi, puoi effettuare una piccola donazione utilizzando il link che trovi in alto a destra.<br/>Per qualsiasi informazione e per segnalare un problema è attivo il forum di supporto su <a href="http://marcomilesi.ml/supporto" target="_blank" title="www.marcomilesi.ml/supporto">www.marcomilesi.ml/supporto</a></small></center>
	</div>';

}
?>