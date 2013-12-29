<?php
/*
Plugin Name: AVCP XML
Plugin URI: http://www.marcomilesi.ml
Description: Generatore XML per l’AVCP (Autorità per la Vigilanza sui Contratti Pubblici di Lavori, Servizi e Forniture) // Art. 1 comma 32 Legge 190/2012.
Author: Marco Milesi
Version: 1.1.2
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

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Gare AVCP',
        'supports' => array( 'title', 'custom-fields', 'revisions' ),
        'taxonomies' => array( 'ditte' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 20,
        'menu_icon' => 'http://www.comunepantelleria.it/files/ext/ico_zip.gif',
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
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
        'query_var' => true
    );

    register_taxonomy( 'annirif', array('avcp'), $args );
}

add_action('save_post', 'save_at_gara_posts',10,2);
function save_at_gara_posts($post_id) {
	$get_avcp_autopublish = get_option('avcp_autopublish');
	if ($get_avcp_autopublish == '1') {
		$terms = wp_get_post_terms($post_id, 'annirif');
		$count = count($terms);
		if (!($count > 0 )){
			echo '<div class="error"><p>'; 
			printf(__('FATAL ERROR' . $verificafilecreati));
			echo "</p></div>";	
		}
		require_once(plugin_dir_path(__FILE__) . 'avcp_xml_generator.php');
		foreach ( $terms as $term ) {
			creafilexml ($term->name);
			$verificafilecreati = $term->name . ' - ' . $verificafilecreati;
		}
		echo '<div class="updated"><p>'; 
		printf(__('AVCP | Generazione dei file .xml completata => ' . $verificafilecreati));
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
	include(plugin_dir_path(__FILE__) . 'meta-box-class/metabox.php');
	require_once(plugin_dir_path(__FILE__) . 'avcp_metabox_generator.php');
	require_once(plugin_dir_path(__FILE__) . 'singlehack.php');
	require_once(plugin_dir_path(__FILE__) . 'avcp_xml_generator.php');
	//include(plugin_dir_path(__FILE__) . 'alerts.php');
	include(plugin_dir_path(__FILE__) . 'styledbackend.php');
	require_once(plugin_dir_path(__FILE__) . 'taxfilteringbackend.php');
	require_once(plugin_dir_path(__FILE__) . 'searchTaxonomy/searchTaxonomyGT.php');
	
	global $typenow;
	if ($typenow == 'avcp') {
		add_filter( 'manage_posts_custom_column', 'avcp_modify_post_table_row', 10, 2 );
		add_filter( 'manage_posts_custom_column', 'avcp_modify_post_table' );
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
?>