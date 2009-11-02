jQuery(document).ready(function(){
    var formakte = $('#kelahiran').dialog({
	    bgiframe: true,
		autoOpen : false,
		height: 300,
		modal: true,
		buttons : {
            "Create" : function(){
                $(this).dialog('close');
			},
			Cancel : function() {
                $(this).dialog('close');
			}
		}
	});
	$("#tgl_lahir").datepicker({
	    dateFormat : "yy-mm-dd"
	});
	$('#akte_add').click(function() {
	    $("#kelahiran").dialog('open');
	}
});
