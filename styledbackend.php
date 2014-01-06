<?php
function sfondo_avcp_trasparenza() {
		global $current_screen;
		if ($current_screen->post_type == 'avcp') {
			$css = '<style type="text/css">' . '#annirifdiv { background:yellow; } #error { border: 2px solid red; #right { border: 2px solid green;' . '</style>';
			echo $css;
			$javascript = '<script>
			document.getElementById("avcp_data_inizio").setAttribute("readonly", "true");
			document.getElementById("avcp_data_fine").setAttribute("readonly", "true");
			document.getElementById("avcp_aggiudicazione").setAttribute("onkeyup", "valid(this)");
			document.getElementById("avcp_aggiudicazione").setAttribute("onblur", "valid(this)");
			document.getElementById("avcp_somme_liquidate").setAttribute("onkeyup", "valid(this)");
			document.getElementById("avcp_somme_liquidate").setAttribute("onblur", "valid(this)");
			document.getElementById("avcp_cig").setAttribute("onkeyup", "validcig(this)");
			function valid(f) {
				f.value = f.value.replace(/[^.0-9-\s]/ig,\'\');
				$("#avcp_aggiudicazione").val.toFixed(2);
				$("#avcp_somme_liquidate").val.toFixed(2);
			} 
			function validcig(f) {
				f.value = f.value.replace(/[^A-Z0-9-\s]/ig,\'\');
				if(f.length != 10){
					$("#avcp_cig").addClass("error");
				} else {
					$("#avcp_cig").addClass("valid");
				}
			} 
			</script>';
			echo $javascript;
		}
}
add_action('admin_footer', 'sfondo_avcp_trasparenza');
?>