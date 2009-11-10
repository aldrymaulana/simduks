jQuery(document).ready(function(){
    $("#tgl_lahir").datepicker({
        dateFormat: "yy-mm-dd",
        onSelect: function(date, str){
            $("#tgl_lahir").val(date);
        }
    });
    
    $("#load_data").click(function(event){
        event.preventDefault();
        $.ajax({
            url: "kependudukan/penduduk.php",
            type: "get",
            data :{
                q:4,
                nik : $("#nik").val()
            },
            dataType: "json",
            cache : false,
            success: function(data, status){
                // TODO append to field..
            }
        });
    });
})