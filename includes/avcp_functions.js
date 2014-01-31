document.getElementById("avcp_data_inizio").setAttribute("readonly", "true");
document.getElementById("avcp_data_fine").setAttribute("readonly", "true");
document.getElementById("avcp_cig").setAttribute("onkeyup", "validcig(this)");
	
    $("#clearinizio").click(function(e) {
        e.preventDefault();
        $("#avcp_data_inizio").val('');
    });
 $("#clearfine").click(function(e) {
        e.preventDefault();
        $("#avcp_data_fine").val('');
    });

function validcig(f) {
    f.value = f.value.replace(/[^A-Z0-9-\s]/ig,'');
    if(f.length != '10'){
		$('#avcp_cig').addClass('error');
    } else {
		$('#avcp_cig').addClass('valid');
    }
}

function formatImporto(value, len) {

    //    if (!/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(value) )value=0;
    decSeparator = '.';
    curSeparator = '';
    if (value == ""){
        return value;
    }
    value = formatImportoBack(value);
    if (isNaN(value)) {
        return("");
    }
    var tmp = value;

    if (decSeparator == ',') {
        var idx = tmp.indexOf('.');
        if (idx > 0) {
            tmp = tmp.substring(0, idx) + ',' + tmp.substring(idx + 1);
        }
    }
    var sgn = false;
    if (tmp.substring(0, 1) == '-') {
        sgn = true;
        tmp = tmp.substring(1);
    }
    var arr = tmp.split(decSeparator);

    var intPart = arr[0];
    var len = intPart.length;
    var rem = len % 3;

    var result = "";
    for (i = len - 3; i > 0; i -= 3)
        result = curSeparator + intPart.substr(i, 3) + result;
    result = intPart.substring(0, rem == 0 ? 3 : rem) + result;

    if (sgn)
        result = "-" + result;

    result += decSeparator;

    len = 0;
    if (arr.length > 1) {
        result += arr[1];
        len = arr[1].length;
    }

    for (i = len; i < 2; i++) {
        result += '0';
    }

    return result;

}

function formatImportoBack(value) {

    if (value == "")
        return value;

    value = value.replace(',', '.');
    return value;

}

function formattaimporto(id) {
    newval = formatImporto(jQuery("#" + id).val(), 15);
    jQuery("#" + id).val(newval);
}

jQuery(document).ready(function(){

    if (jQuery('#avcp_somme_liquidate').length > 0){
        jQuery('#avcp_somme_liquidate').change(function(){
            formattaimporto('avcp_somme_liquidate');
        });
    }

    if (jQuery('#avcp_aggiudicazione').length > 0){
        jQuery('#avcp_aggiudicazione').change(function(){
            formattaimporto('avcp_aggiudicazione');
        });
    }

})
/* Italian initialisation for the jQuery UI date picker plugin. */
/* Written by Antonello Pasella (antonello.pasella@gmail.com). */
(function( factory ) {
	if ( typeof define === "function" && define.amd ) {

		// AMD. Register as an anonymous module.
		define([ "../datepicker" ], factory );
	} else {

		// Browser globals
		factory( jQuery.datepicker );
	}
}(function( datepicker ) {
	datepicker.regional['it'] = {
		closeText: 'Chiudi',
		prevText: '&#x3C;Prec',
		nextText: 'Succ&#x3E;',
		currentText: 'Oggi',
		monthNames: ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno',
			'Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'],
		dayNames: ['Domenica','Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato'],
		dayNamesShort: ['Dom','Lun','Mar','Mer','Gio','Ven','Sab'],
		dayNamesMin: ['Do','Lu','Ma','Me','Gi','Ve','Sa'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	datepicker.setDefaults(datepicker.regional['it']);

	return datepicker.regional['it'];

}));