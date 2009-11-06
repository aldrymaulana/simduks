jQuery(document).ready(function(){
    $("#tgl_lahir").datepicker({
        dateFormat: "yy-mm-dd",
        onSelect: function(date, str){
            $("#tgl_lahir").val(date);
        }
    });   
})