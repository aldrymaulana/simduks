jQuery(document).ready(function(){
    $("#tanggal_pernikahan").datepicker({
	    dateFormat : "yy-mm-dd",
		onSelect : function(dateText, inst) {
			$("#tanggal_pernikahan").text(dateText);
		}
	});
    
    $("#loadnik_pria").click(function(event){
        event.preventDefault();
        $.ajax({
            url : "kependudukan/penduduk.php",
            type: "get",
            data: {
                q : 4,
                nik : $("#nik_pria").val()
            },
            dataType : "json",
            cache : false,
            success : function(data, status){
                $("#pria_id").val(data.id);
                $("#nama_pria").val(data.nama);
                $("#nama_ayah_pria").val(data.ayah);
                $("#nama_ibu_pria").val(data.ibu);
            }
        })
    });
    
    $("#loadnik_wanita").click(function(event){
        event.preventDefault();
        $.ajax({
            url : "kependudukan/penduduk.php",
            type: "get",
            data: {
                q : 4,
                nik : $("#nik_wanita").val()
            },
            dataType : "json",
            cache : false,
            success : function(data, status){
                $("#wanita_id").val(data.id);
                $("#nama_wanita").val(data.nama);
                $("#nama_ayah_wanita").val(data.ayah);
                $("#nama_ibu_wanita").val(data.ibu);
            }
        })
    });
    
    $("#load_wali").click(function(event){
        event.preventDefault();
        $.ajax({
            url : "kependudukan/penduduk.php",
            type: "get",
            data: {
                q : 4,
                nik : $("#wali").val()
            },
            dataType : "json",
            cache : false,
            success : function(data, status){
                $("#wali_id").val(data.id);
                $("#nama_wali").val(data.nama);               
            }
        })
    });
    
    $("#load_saksi1").click(function(event){
        event.preventDefault();
        $.ajax({
            url : "kependudukan/penduduk.php",
            type: "get",
            data: {
                q : 4,
                nik : $("#saksi1").val()
            },
            dataType : "json",
            cache : false,
            success : function(data, status){
                $("#saksi1_id").val(data.id);
                $("#nama_saksi1").val(data.nama);               
            }
        })
    });
    
    $("#load_saksi2").click(function(event){
        event.preventDefault();
        $.ajax({
            url : "kependudukan/penduduk.php",
            type: "get",
            data: {
                q : 4,
                nik : $("#saksi2").val()
            },
            dataType : "json",
            cache : false,
            success : function(data, status){
                $("#saksi1_id").val(data.id);
                $("#nama_saksi2").val(data.nama);               
            }
        })
    });
    
    $("#save").click(function(event){
        event.preventDefault();
        $.ajax({
            url : "kependudukan/penduduk.php",
            type: "post",
            data : {
                oper : "pernikahan"
            },
            dataType: "json",
            cache : false,
            success : function(data, status){
                
            }
        });
    });
    
    $("#cancel").click(function(event){
        event.preventDefault();
        /// TODO reset all data form
    })
    
    $.ajax({
        url: "kependudukan/penduduk.php?q=6",
        type: "get",
        data: {},
        dataType: "html",
        success: function(data, status) {           
            $("#li_penghulu").after(data);    
        }
    });
})