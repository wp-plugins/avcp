<?php
/*
* configure taxonomy custom fields
*/
$config = array(
   'id' => 'tax_meta_box_ditte_avcp',                         // meta box id, unique per meta box
   'title' => 'Campi Speciali AVCP ditte',                      // meta box title
   'pages' => array('ditte'),                    // taxonomy name, accept categories, post_tag and custom taxonomies
   'context' => 'normal',                           // where the meta box appear: normal (default), advanced, side; optional
   'fields' => array(),                             // list of meta fields (can be added by field arrays)
   'local_images' => false,                         // Use local or hosted images (meta box images for add/remove)
   'use_with_theme' => false                        //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
);
 
$my_taxmeta = new Tax_Meta_Class($config);

//checkbox field
$my_taxmeta->addCheckbox('avcp_is_ditta_estera',array('name'=> 'Ditta Estera? ', 'desc'=> '<p class="description">Spuntare questa casella se la ditta ha un codice fiscale identificativo estero</p>'));

//Finish Taxonomy Extra fields Deceleration
$my_taxmeta->Finish();

?>