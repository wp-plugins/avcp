<?php
/*
Plugin Name: AVCP XML
Plugin URI: http://www.marcomilesi.ml
Description: Generatore XML per l’AVCP (Autorità per la Vigilanza sui Contratti Pubblici di Lavori, Servizi e Forniture) // Art. 1 comma 32 Legge 190/2012.
Author: Marco Milesi
Version: 4
Author URI: http://www.marcomilesi.ml
*/

add_action( 'init', 'register_cpt_avcp' );

function register_cpt_avcp() {

    $labels = array( 
        'name' => _x( 'Gare', 'avcp' ),
        'singular_name' => _x( 'Gara', 'avcp' ),
        'add_new' => _x( 'Nuova Gara', 'avcp' ),
        'add_new_item' => _x( 'Nuova Gara', 'avcp' ),
        'edit_item' => _x( 'Modifica Gara', 'avcp' ),
        'new_item' => _x( 'Nuova Gara', 'avcp' ),
        'view_item' => _x( 'Vedi Gara', 'avcp' ),
        'search_items' => _x( 'Cerca Gara', 'avcp' ),
        'not_found' => _x( 'Nessuna voce trovata', 'avcp' ),
        'not_found_in_trash' => _x( 'Nessuna voce trovata', 'avcp' ),
        'parent_item_colon' => _x( 'Parent Gara:', 'avcp' ),
        'menu_name' => _x( 'AVCP', 'avcp' ),
    );
	
	$get_avcp_enable_editor = get_option('avcp_enable_editor');
	if ($get_avcp_enable_editor == '1') {
		$cp_support = array( 'title', 'custom-fields', 'editor', 'revisions' );
	} else {
		$cp_support = array( 'title', 'custom-fields', 'revisions' );
	}
	
	$get_avcp_abilita_ruoli = get_option('avcp_abilita_ruoli');
	if ($get_avcp_abilita_ruoli == '1') {
		$avcp_capability_type = 'gare_avcp';
		$avcp_map_meta_cap_var = 'true';
		$avcp_capabilities_array = array(
				'publish_posts' => 'pubblicare_gara_avcp',
				'edit_posts' => 'modificare_propri_gara_avcp',
				'edit_others_posts' => 'modificare_altri_gara_avcp',
				'delete_posts' => 'eliminare_propri_gara_avcp',
				'delete_others_posts' => 'modificare_altri_gara_avcp',
				'read_private_posts' => 'read_private_avcp',
				'edit_post' => 'modificare_gara_avcp',
				'delete_post' => 'eliminare_gara_avcp',
				'read_post' => 'leggere_gara_avcp',
				);
	} else {
		$avcp_capability_type = 'post';
		$avcp_map_meta_cap_var = 'false';
	}

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Gare AVCP',
        'supports' => $cp_support,
        'taxonomies' => array( 'ditte' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon'    => 'dashicons-portfolio',
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => $avcp_capability_type,
		'map_meta_cap' => $avcp_map_meta_cap_var
    );

    register_post_type( 'avcp', $args );
}

add_action( 'init', 'register_taxonomy_ditte' );

function register_taxonomy_ditte() {

    $labels = array( 
        'name' => _x( 'Ditta', 'ditte' ),
        'singular_name' => _x( 'Ditte', 'ditte' ),
        'search_items' => _x( 'Cerca Ditta', 'ditte' ),
        'popular_items' => _x( 'Ditte più usate', 'ditte' ),
        'all_items' => _x( 'Tutte le ditte', 'ditte' ),
        'parent_item' => _x( 'Parent Ditte', 'ditte' ),
        'parent_item_colon' => _x( 'Parent Ditte:', 'ditte' ),
        'edit_item' => _x( 'Edit Ditte', 'ditte' ),
        'update_item' => _x( 'Update Ditte', 'ditte' ),
        'add_new_item' => _x( 'Nuova Ditta', 'ditte' ),
        'new_item_name' => _x( 'Nuova Ditte', 'ditte' ),
        'separate_items_with_commas' => _x( 'Separate ditta with commas', 'ditte' ),
        'add_or_remove_items' => _x( 'Add or remove ditta', 'ditte' ),
        'choose_from_most_used' => _x( 'Choose from the most used ditta', 'ditte' ),
        'menu_name' => _x( 'Ditte', 'ditte' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => false,
        'show_ui' => true,
        'show_tagcloud' => false,
        'show_admin_column' => true,
        'hierarchical' => true,
        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'ditte', array('avcp'), $args );
}

add_action( 'init', 'register_taxonomy_annirif' );

function register_taxonomy_annirif() {

    $labels2 = array( 
        'name' => _x( 'Anno Riferimento', 'annirif' ),
        'singular_name' => _x( 'Anno Riferimento', 'annirif' ),
        'search_items' => _x( 'Cerca Anno', 'annirif' ),
        'popular_items' => _x( 'Anni più Usati', 'annirif' ),
        'all_items' => _x( 'Tutti gli anni', 'annirif' ),
        'parent_item' => _x( 'Parent Anni', 'annirif' ),
        'parent_item_colon' => _x( 'Parent Anno:', 'annirif' ),
        'edit_item' => _x( 'Modifica Anno', 'annirif' ),
        'update_item' => _x( 'Aggiorna Anno', 'annirif' ),
        'add_new_item' => _x( 'Nuovo Anno', 'annirif' ),
        'new_item_name' => _x( 'Nuovo Anno', 'annirif' ),
        'separate_items_with_commas' => _x( 'Separate anno with commas', 'annirif' ),
        'add_or_remove_items' => _x( 'Add or remove anno', 'annirif' ),
        'choose_from_most_used' => _x( 'Choose from the most used years', 'annirif' ),
        'menu_name' => _x( 'Anni', 'annirif' ),
    );

    $args = array( 
        'labels' => $labels2,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'show_admin_column' => true,
        'hierarchical' => true,
        'rewrite' => true,
		'capabilities' => array('manage_terms' => 'utentealieno','edit_terms'   => 'utentealieno','delete_terms' => 'utentealieno'),
        'query_var' => true
    );

    register_taxonomy( 'annirif', array('avcp'), $args );
	$termcheck = term_exists('2013', 'annirif');
	if ($termcheck == 0 || $termcheck == null) {
		wp_insert_term('2013', 'annirif');
	}
	$termcheck = term_exists('2014', 'annirif');
	if ($termcheck == 0 || $termcheck == null) {
		wp_insert_term('2014', 'annirif');
	}
}

add_action( 'init', 'register_taxonomy_areesettori' );

function register_taxonomy_areesettori() {

    $labels = array( 
        'name' => _x( 'Settori - Centri di costo', 'areesettori' ),
        'singular_name' => _x( 'Settore - Centro di costo', 'areesettori' ),
        'search_items' => _x( 'Cerca in Settori - Centri di costo', 'areesettori' ),
        'popular_items' => _x( 'Settori - Centri di costo Più usati', 'areesettori' ),
        'all_items' => _x( 'Tutti i Centri di costo', 'areesettori' ),
        'parent_item' => _x( 'Parent Settore - Centro di costo', 'areesettori' ),
        'parent_item_colon' => _x( 'Parent Settore - Centro di costo:', 'areesettori' ),
        'edit_item' => _x( 'Modifica Settore - Centro di costo', 'areesettori' ),
        'update_item' => _x( 'Aggiorna Settore - Centro di costo', 'areesettori' ),
        'add_new_item' => _x( 'Aggiungi Nuovo Settore - Centro di costo', 'areesettori' ),
        'new_item_name' => _x( 'Nuovo Settore - Centro di costo', 'areesettori' ),
        'separate_items_with_commas' => _x( 'Separate settori - centri di costo with commas', 'areesettori' ),
        'add_or_remove_items' => _x( 'Add or remove settori - centri di costo', 'areesettori' ),
        'choose_from_most_used' => _x( 'Choose from the most used settori - centri di costo', 'areesettori' ),
        'menu_name' => _x( 'Centri di costo', 'areesettori' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => false,
        'show_ui' => true,
        'show_tagcloud' => false,
        'show_admin_column' => true,
        'hierarchical' => true,

        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'areesettori', array('avcp'), $args );
}

add_action('save_post', 'save_at_gara_posts',10,2);
function save_at_gara_posts($post_id) {

	$post = get_post($post_id);
    // If this isn't a 'book' post, don't update it.
    $slug = 'avcp'; if ( $slug != $post->post_type ) { return; }
	
	$get_avcp_autopublish = get_option('avcp_autopublish');
	if ($get_avcp_autopublish == '1') {
		$terms = wp_get_post_terms($post_id, 'annirif');
		$count = count($terms);
		if (!($count > 0 )){
			echo '<div class="error"><p>'; 
			printf(__('AVCP | Errore: impossibile ricreare il file .xml: la gara inserita non ha ditte collegate' . $verificafilecreati));
			echo "</p></div>";	
		}
		require_once(plugin_dir_path(__FILE__) . 'avcp_xml_generator.php');
		foreach ( $terms as $term ) {
			creafilexml ($term->name);
			$verificafilecreati = $term->name . ' - ' . $verificafilecreati;
		}
		echo '<div class="updated"><p>'; 
		printf(__('AVCP | Generazione automatica del file .xml completata => ' . $verificafilecreati));
		echo "</p></div>";		
	}
}

/* =========== Cambio Titolo Custom Post =========== */
function avcp_default_title($title)
{
    $screen = get_current_screen();
    if ('avcp' == $screen->post_type) {
        $title = 'Inserire Oggetto della Gara';
    }
    return $title;
}
add_filter('enter_title_here', 'avcp_default_title');

function avcp_plugin() {
    $api_key = 'abt3ep7uq9b2jzohwmefm3y5koqcsxguqx0a';
    $auth    = 'mpu9auof5dh2btpmmn59a0pdqh4w4x95k';
    // Start of Metrics
    global $wpdb;
    $data = get_transient( 'presstrends_cache_data' );
    if ( !$data || $data == '' ) {
        $api_base = 'http://api.presstrends.io/index.php/api/pluginsites/update?auth=';
        $url      = $api_base . $auth . '&api=' . $api_key . '';
        $count_posts    = wp_count_posts();
        $count_pages    = wp_count_posts( 'page' );
        $comments_count = wp_count_comments();
        if ( function_exists( 'wp_get_theme' ) ) {
            $theme_data = wp_get_theme();
            $theme_name = urlencode( $theme_data->Name );
        } else {
            $theme_data = get_theme_data( get_stylesheet_directory() . '/style.css' );
            $theme_name = $theme_data['Name'];
        }
        $plugin_name = '&';
        foreach ( get_plugins() as $plugin_info ) {
            $plugin_name .= $plugin_info['Name'] . '&';
        }
        // CHANGE __FILE__ PATH IF LOCATED OUTSIDE MAIN PLUGIN FILE
        $plugin_data         = get_plugin_data( __FILE__ );
        $posts_with_comments = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_type='post' AND comment_count > 0" );
        $data                = array(
            'url'             => base64_encode(site_url()),
            'posts'           => $count_posts->publish,
            'pages'           => $count_pages->publish,
            'comments'        => $comments_count->total_comments,
            'approved'        => $comments_count->approved,
            'spam'            => $comments_count->spam,
            'pingbacks'       => $wpdb->get_var( "SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE comment_type = 'pingback'" ),
            'post_conversion' => ( $count_posts->publish > 0 && $posts_with_comments > 0 ) ? number_format( ( $posts_with_comments / $count_posts->publish ) * 100, 0, '.', '' ) : 0,
            'theme_version'   => $plugin_data['Version'],
            'theme_name'      => $theme_name,
            'site_name'       => str_replace( ' ', '', get_bloginfo( 'name' ) ),
            'plugins'         => count( get_option( 'active_plugins' ) ),
            'plugin'          => urlencode( $plugin_name ),
            'wpversion'       => get_bloginfo( 'version' ),
        );
        foreach ( $data as $k => $v ) {
            $url .= '&' . $k . '=' . $v . '';
        }
        wp_remote_get( $url );
        set_transient( 'presstrends_cache_data', $data, 60 * 60 * 24 );
        }
    }
// PressTrends WordPress Action
add_action('admin_init', 'avcp_plugin');

// Rimuove "Modifica Rapida" (per evitare di taggare gli anni ad cazzum)
add_filter( 'post_row_actions', 'avcp_remove_row_actions', 10, 1 );
function avcp_remove_row_actions( $actions )
{
    if( get_post_type() === 'avcp' )
        unset( $actions['inline hide-if-no-js'] );
    return $actions;
}

/* =========== PLUGINLNK ============ */
add_filter('plugin_action_links', 'avcp_plugin_action_links', 10, 2);

function avcp_plugin_action_links($links, $file) {
    static $this_plugin;

    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }

    if ($file == $this_plugin) {
        // The "page" query string value must be equal to the slug
        // of the Settings admin page we defined earlier, which in
        // this case equals "myplugin-settings".
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/edit.php?post_type=avcp&page=avcp_settings">Configura</a>';
        array_unshift($links, $settings_link);
    }

    return $links;
}

/**
 * Add meta links in Plugins table
 */
 
add_filter( 'plugin_row_meta', 'avcp_plugin_meta_links', 10, 2 );
function avcp_plugin_meta_links( $links, $file ) {

	$plugin = plugin_basename(__FILE__);
	
	// create link
	if ( $file == $plugin ) {
		return array_merge(
			$links,
			array( '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=F2JK36SCXKTE2">Donazione</a>' )
		);
	}
	return $links;
}

/* =========== SHORTCODE ============ */

function avcp_func($atts)
{
extract(shortcode_atts(array(
      'anno' => 'all',
   ), $atts));
ob_start();
include(plugin_dir_path(__FILE__) . 'tablegen.php');
$atshortcode = ob_get_clean();
return $atshortcode;
}
add_shortcode('avcp', 'avcp_func');

add_action( 'init', 'atg_caricamoduli' );
function atg_caricamoduli() {
	include(plugin_dir_path(__FILE__) . 'settings.php');
	include(plugin_dir_path(__FILE__) . 'avcp_create_taxonomy.php');
	require_once(plugin_dir_path(__FILE__) . 'meta-box-class/metabox.php');
	require_once(plugin_dir_path(__FILE__) . 'tax-meta-class/Tax-meta-class.php');
	require_once(plugin_dir_path(__FILE__) . 'avcp_taxonomy_fields.php');
	require_once(plugin_dir_path(__FILE__) . 'avcp_metabox_generator.php');
	require_once(plugin_dir_path(__FILE__) . 'avcp_index_generator.php');
	require_once(plugin_dir_path(__FILE__) . 'singlehack.php');
	require_once(plugin_dir_path(__FILE__) . 'avcp_xml_generator.php');
	include(plugin_dir_path(__FILE__) . 'alerts.php');
	include(plugin_dir_path(__FILE__) . 'styledbackend.php');
	require_once(plugin_dir_path(__FILE__) . 'taxfilteringbackend.php');
	require_once(plugin_dir_path(__FILE__) . 'searchTaxonomy/searchTaxonomyGT.php');
	
	//Include sistemi di validazione
	include(plugin_dir_path(__FILE__) . 'valid_check.php');
	include(plugin_dir_path(__FILE__) . 'valid_page.php');
	
	global $typenow;
	if ($typenow == 'avcp') {
		add_filter( 'manage_posts_custom_column', 'avcp_modify_post_table_row', 10, 2 );
		add_filter( 'manage_posts_custom_column', 'avcp_modify_post_table' );
	}
	
	$pluginversion = get_option('avcp_version_number');
	if ($pluginversion == '') {
		update_option( 'avcp_version_number', '4' );
	}
	if (version_compare($pluginversion, "3.1", "<")) { 
		avcp_activate();
		update_option( 'avcp_version_number', '3.1' );
	} else if (version_compare($pluginversion, "3.1.1", "<")) { 
		update_option( 'avcp_version_number', '3.1.1' );
	} else if (version_compare($pluginversion, "3.1.2", "<")) { 
		update_option( 'avcp_version_number', '3.1.2' );
	} else if (version_compare($pluginversion, "3.1.3", "<")) { 
		update_option( 'avcp_version_number', '3.1.3' );
	} else if (version_compare($pluginversion, "3.2", "<")) {
		query_posts( array( 'post_type' => 'avcp', 'posts_per_page' => '-1') ); global $post;
		if ( have_posts() ) : while ( have_posts() ) : the_post();
			$tip_contraente = get_post_meta($post->ID, 'avcp_contraente', true);
			if ($tip_contraente == '25-AFFIDAMENTO DIRETTO A SOCIETA') {
				update_post_meta($post->ID, 'avcp_contraente', '25-AFFIDAMENTO DIRETTO A SOCIETA&apos; RAGGRUPPATE/CONSORZIATE O CONTROLLATE NELLE CONCESSIONI DI LL.PP');
			} else if ($tip_contraente == '24-AFFIDAMENTO DIRETTO A SOCIETA') {
				update_post_meta($post->ID, 'avcp_contraente', '24-AFFIDAMENTO DIRETTO A SOCIETA&apos; IN HOUSE');
			}
		endwhile; else:
		endif;
		update_option( 'avcp_version_number', '3.2' );
		creafilexml ('2013');
		creafilexml ('2014');
	} else if (version_compare($pluginversion, "4", "<")) { 
		update_option( 'avcp_version_number', '4' );
	}
	
}

function avcp_activate() {
	$srcfile= ABSPATH . 'wp-content/plugins/avcp/includes/index.php.null';
	$dstfile= ABSPATH . 'avcp/index.php';
	mkdir(dirname($dstfile), 0755, true);
	copy($srcfile, $dstfile);
	chmod($dstfile, 0755);
}
register_activation_hook( __FILE__, 'avcp_activate' );

function avcp_deactivate() {
	unlink(ABSPATH . 'avcp/index.php');
}
register_deactivation_hook( __FILE__, 'avcp_deactivate' );

?>