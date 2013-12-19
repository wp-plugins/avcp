<?php
function sfondo_avcp_trasparenza() {
	$get_avcp_dis_styledbackend = get_option('avcp_dis_styledbackend');
	if ($get_avcp_dis_styledbackend == '0') {
		global $current_screen;
		if ($current_screen->post_type == 'avcp') {
			$css = '<style type="text/css">' . '#annirifdiv { background:yellow; } #titlewrap {width: 70%;}' . '</style>';
			echo $css;
		}
	}
}
add_action('admin_footer', 'sfondo_avcp_trasparenza');
?>