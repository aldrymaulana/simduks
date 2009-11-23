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
                $("#saksi2_id").val(data.id);
                $("#nama_saksi2").val(data.nama);               
            }
        })
    });
    
    $("#save").click(function(event){
        event.preventDefault();
		$("#report").remove();
        $.ajax({
            url : "kependudukan/penduduk.php",
            type: "post",
            data : {
                oper : "pernikahan",
				no_pernikahan : $("#nomor_pernikahan").val(),
				pria : $("#pria_id").val(),
				wanita : $("#wanita_id").val(),
				tanggal_pernikahan : $("#tanggal_pernikahan").val(),
				penghulu : $("#penghulu").val(),
				kelurahan : $("#desa_baru").val(),
				kecamatan : $("#kecamatan_baru").val(),
				wali : $("#wali").val(),
				saksi1 : $("#saksi1").val(),
				saksi2 : $("#saksi2").val()
            },
            dataType: "json",
            cache : false,
            success : function(data, status){
                $("#id").val(data);
				var url = "<a href=\"#\" id=\"report\">Laporan</a>";
				$("#cancel").after(url);
            }
        });
    });
    
    $("#cancel").click(function(event){
        event.preventDefault();
        /// TODO reset all data form
    })
    
	$("#report").click(function(event){
		var id = $("#id").val();
		$("#report").attr("href", "reports/pdf/lap4.php?id=" + id );
		$("#report").attr("target", "_blank");
	});
	
	function show_desa(kecamatan_id)
    {
        $.ajax({
            url : "kependudukan/penduduk.php?q=7&kecamatan_id=" + kecamatan_id,
            type: "get",
            data: {},
            dataType: "html",
            success : function(data, status){
				$("#desa_baru").remove();
                $("#lbl_desa").after(data);
            }
        });
    }
	
    $.ajax({
        url: "kependudukan/penduduk.php?q=6",
        type: "get",
        data: {},
        dataType: "html",
        success: function(data, status) {           
            $("#li_penghulu").after(data);
			$("#kecamatan_baru").change(function(){                
                $("#kecamatan_baru option:selected").each(function(){
                    var id = $(this).val();
                    show_desa(id);                    
                });
            }).trigger('change');
        }
    });
	
})