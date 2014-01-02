<?php/* Display a thankyou notice */add_action('admin_notices', 'avcp_admin_messages');function avcp_admin_messages() {	global $current_user ;        $user_id = $current_user->ID;	if ( is_admin() && !get_user_meta($user_id, 'avcp_upgrade_2ar') ) {		echo '<div class="error"><p>'; 		printf(__('AVCP | Per completare l\'aggiornamento alla versione 2.0 è necessario eseguire una breve convalida dei dati.		<br/>Per eseguire l\'aggiornamento <a href="%1$s">clicca qui</a>.'), '?avcp_upgrade_2ar=0');		echo "</p></div>";	}		if ( is_admin() && get_user_meta($user_id, 'avcp_upgrade_2ar') && !get_user_meta($user_id, 'avcp_upgrade_2date') ) {		echo '<div class="error"><p>'; 		printf(__('AVCP | AGGIORNAMENTO 2.0 COMPLETATO. Ecco i prossimi 2 passaggi:<br/>		1. Reimposta l\'anno per ogni gara<br/>		2. Reimposta la data di inizio e di fine per ogni gara (basta cliccarci sopra e selezionarla nuovamente, anche se mostra il dato nel vecchio formato)<br/><a href="%1$s">Clicca qui</a> per chiudere, dopo avere completato i 2 passaggi<br/><br/>Attenzione! E\' necessario rivedere anche gli importi inseriti nelle gare per assicurarsi che siano nel formato 12345678.00 (solo con il punto dei decimali)<br/><br/>Al termine, disattiva e riattiva il plugin :)'), '?avcp_upgrade_2date_ignore=0');		echo "</p></div>";	}		//if ( ! get_user_meta($user_id, 'avcp_thankyou_ignore_notice') ) {    //    echo '<div class="updated"><p>';     //    printf(__('Grazie per avere installato Amministrazione Trasparente!<br/>Per la gestione delle spese dai un\'occhiata a <a href="http://wordpress.org/plugins/amministrazione-aperta/" target="_blank">Amministrazione Aperta</a> | <a href="%1$s">Nascondi</a>'), '?avcp_thankyou_nag_ignore=0');    //    echo "</p></div>";	//}		//global $pagenow;	//if (( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) && ($_GET['post_type'] == 'at_gara')) {    //echo '<div class="error"><p>';      //   printf(__('Attenzione! Stai usando una versione beta di AVCP for Wordpress. Procedi a tuo rischio e pericolo'));     //   echo "</p></div>";    //}}add_action('admin_init', 'avcp_admin_messages_ignore');function avcp_admin_messages_ignore() {	global $current_user;        $user_id = $current_user->ID;        /* If user clicks to ignore the notice, add that to their user meta */        if ( isset($_GET['avcp_upgrade_2ar']) && '0' == $_GET['avcp_upgrade_2ar'] ) {			$terms = get_terms( 'annirif', array( 'fields' => 'ids', 'hide_empty' => false ) );			foreach ( $terms as $value ) {				wp_delete_term( $value, 'annirif' );			}			add_user_meta($user_id, 'avcp_upgrade_2ar', 'true', true);		}				if ( isset($_GET['avcp_upgrade_2date_ignore']) && '0' == $_GET['avcp_upgrade_2date_ignore'] ) {             add_user_meta($user_id, 'avcp_upgrade_2date', 'true', true);		}}?>