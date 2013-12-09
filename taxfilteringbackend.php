<?php
//FILTRI
add_action( 'restrict_manage_posts', 'avcp_restrict_manage_posts' );
function avcp_restrict_manage_posts() {
    global $typenow;
    $taxonomy = 'ditte';
    if ($typenow == 'avcp') {
        $filters = array($taxonomy);
        foreach ($filters as $tax_slug) {
            $tax_obj = get_taxonomy($tax_slug);
            $tax_name = $tax_obj->labels->name;
            $terms = get_terms($tax_slug);
            echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
            echo "<option value=''>Tutte le ditte</option>";
            foreach ($terms as $term) { 
                $label = (isset($_GET[$tax_slug])) ? $_GET[$tax_slug] : ''; // Fix
                echo '<option value='. $term->slug, $label == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
            }
            echo "</select>";
        }
    }
	$taxonomy = 'annirif';
    if ($typenow == 'avcp') {
        $filters = array($taxonomy);
        foreach ($filters as $tax_slug) {
            $tax_obj = get_taxonomy($tax_slug);
            $tax_name = $tax_obj->labels->name;
            $terms = get_terms($tax_slug);
            echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
            echo "<option value=''>Tutti gli Anni di Riferimento</option>";
            foreach ($terms as $term) { 
                $label = (isset($_GET[$tax_slug])) ? $_GET[$tax_slug] : ''; // Fix
                echo '<option value='. $term->slug, $label == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
            }
            echo "</select>";
        }
    }
}
?>


<?php //HOOK PER LE COLONNE DELLA NUOVA VISUALIZZAZIONE AMMINISTRATORE
	
function avcp_modify_post_table( $column, $defaults ) {
	$column['avcp_CIG'] = 'CIG';
	return $column;
}
add_filter( 'manage_edit-avcp_columns', 'avcp_modify_post_table' );

function remove_post_columns($defaults) {
  unset($defaults['date']);
  return $defaults;
}
add_filter('manage_edit-avcp_columns', 'remove_post_columns');

function avcp_modify_post_table_row( $column_name, $post_id ) {
	$custom_fields = get_post_custom( $post_id );
 
	switch ($column_name) {
		case 'avcp_CIG' :
			echo $custom_fields['avcp_cig'][0];
			break;
 
		default:
	}
}
add_filter( 'manage_posts_custom_column', 'avcp_modify_post_table_row', 10, 2 );

function my_sortable_cake_column( $columns ) {  
	$column['avcp_CIG'] = 'CIG';
  
    return $columns;  
}
add_filter( 'manage_edit-cake_sortable_columns', 'my_sortable_cake_column' );

/*
 * ADMIN COLUMN - SORTING - MAKE HEADERS SORTABLE
 * https://gist.github.com/906872
 */
add_filter("manage_edit-avcp_sortable_columns", 'avcp_date_sort');
function avcp_date_sort($columns) {
	$column['avcp_CIG'] = 'CIG';
	return $column;
}
?>