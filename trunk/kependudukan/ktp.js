jQuery(document).ready(function(){
    var form_ktp = $("#ktpadd").dialog({
        bgiframe: true,
        autoOpen : false,
        height: 300,
        modal: true,
        buttons: {
            "Create" : function() {
                
            },
            Cancel : function() {
                $(this).dialog('close');
            }
        }
    });
    
    $("#ktp_create").click(function(){
        $("#ktpadd").dialog('open');
    });
    
    $("#ktpadd").dialog('open');
})