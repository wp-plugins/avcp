<?php
/*
Plugin Name: AVCP Xml
Plugin URI: http://www.marcomilesi.ml
Description: Generatore XML per l’AVCP (Autorità per la Vigilanza sui Contratti Pubblici di Lavori, Servizi e Forniture) // Art. 1 comma 32 Legge 190/2012.
Author: Marco Milesi
Version: alpha
Author URI: http://www.marcomilesi.ml
*/

add_action( 'init', 'register_cpt_at__gara' );

function register_cpt_at__gara() {

    $labels = array( 
        'name' => _x( 'Gare', 'at__gara' ),
        'singular_name' => _x( 'Gara', 'at__gara' ),
        'add_new' => _x( 'Nuova Gara', 'at__gara' ),
        'add_new_item' => _x( 'Nuova Gara', 'at__gara' ),
        'edit_item' => _x( 'Modifica Gara', 'at__gara' ),
        'new_item' => _x( 'Nuova Gara', 'at__gara' ),
        'view_item' => _x( 'Vedi Gara', 'at__gara' ),
        'search_items' => _x( 'Cerca Gara', 'at__gara' ),
        'not_found' => _x( 'Nessuna voce trovata', 'at__gara' ),
        'not_found_in_trash' => _x( 'Nessuna voce trovata', 'at__gara' ),
        'parent_item_colon' => _x( 'Parent Gara:', 'at__gara' ),
        'menu_name' => _x( 'Gare', 'at__gara' ),
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

    register_post_type( 'at_gara', $args );
}

add_action( 'init', 'register_taxonomy_at_ditta' );

function register_taxonomy_at_ditta() {

    $labels = array( 
        'name' => _x( 'Ditta', 'at_ditta' ),
        'singular_name' => _x( 'Ditte', 'at_ditta' ),
        'search_items' => _x( 'Cerca Ditta', 'at_ditta' ),
        'popular_items' => _x( 'Ditte più usate', 'at_ditta' ),
        'all_items' => _x( 'Tutte le ditte', 'at_ditta' ),
        'parent_item' => _x( 'Parent Ditte', 'at_ditta' ),
        'parent_item_colon' => _x( 'Parent Ditte:', 'at_ditta' ),
        'edit_item' => _x( 'Edit Ditte', 'at_ditta' ),
        'update_item' => _x( 'Update Ditte', 'at_ditta' ),
        'add_new_item' => _x( 'Add New Ditte', 'at_ditta' ),
        'new_item_name' => _x( 'New Ditte', 'at_ditta' ),
        'separate_items_with_commas' => _x( 'Separate ditta with commas', 'at_ditta' ),
        'add_or_remove_items' => _x( 'Add or remove ditta', 'at_ditta' ),
        'choose_from_most_used' => _x( 'Choose from the most used ditta', 'at_ditta' ),
        'menu_name' => _x( 'Ditte', 'at_ditta' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => false,
        'show_ui' => true,
        'show_tagcloud' => true,
        'show_admin_column' => true,
        'hierarchical' => true,

        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'at_ditta', array('at_gara'), $args );
}

include(plugin_dir_path(__FILE__) . 'avcp_create_taxonomy.php');
//include(plugin_dir_path(__FILE__) . 'avcp_metabox_generator.php');
include(plugin_dir_path(__FILE__) . 'settings.php');
?>
