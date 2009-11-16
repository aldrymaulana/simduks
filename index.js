jQuery(document).ready(function(){
    /** calculate penduduk */
    $("#total_penduduk").html("");
    $("#pria").html("");
    $("#perempuan").html("");
    $.ajax({        
        url : "kependudukan/penduduk.php",
        type: "get",
        dataType : "json",
        cache : false,
        data : {
            q : 9
        },
        success: function(data, status){
            $("#total_penduduk").html(data.total_penduduk);
            $("#pria").html(data.pria);
            $("#perempuan").html(data.perempuan);
        }
    })
});