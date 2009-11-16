jQuery(document).ready(function(){
    $("#tanggal_pindah").datepicker({
	    dateFormat : "yy-mm-dd",
		onSelect : function(dateText, inst) {
			$("#tanggal_pindah").text(dateText);
		}
	});
    
    $("#load_data").click(function(event){
		$("#flash").html("");
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
                $("#nama").val(data.nama);
                $("#jenis_kelamin").val(data.jenis_kelamin);
                $("#gol_darah").val(data.gol_darah);
                $("#tmp_lahir").val(data.tempat_lahir);
                $("#tgl_lahir").val(data.tgl_lahir);
                $("#agama").val(data.agama);
                $("#status_pernikahan").val(data.status_nikah);
                $("#pekerjaan").val(data.pekerjaan);
                $("#kewarganegaraan").val(data.wni);
                $("#alamat").val(data.alamat.alamat);
                $("#rt").val(data.alamat.rt);
                $("#rw").val(data.alamat.rw);
                $("#desa").val(data.alamat.kelurahan);
                $("#kecamatan").val(data.alamat.kecamatan);
                $("#kodepos").val(data.alamat.kodepos);
                
                // penduduk id
                $("#penduduk_id").val(data.id);
                $("#kk_lama").val(data.kode_keluarga);
            }    
        });
    });
    
    $("#loadkk_baru").click(function(event){
        event.preventDefault();
        $.ajax({
            url : "kependudukan/penduduk.php",
            type: "get",
            data : {
                q : 5,
                kk_id : $("#no_kk_baru").val() 
            },
            dataType: "json",
            cache: false,
            success : function(data, status){
                $("#alamat_baru").val(data.alamat);
                $("#rt_baru").val(data.rt);
                $("#rw_baru").val(data.rw);
                $("#desa_baru").val(data.kelurahan);
                $("#kecamatan_baru").val(data.kecamatan);
                $("#kodepos_baru").val(data.kodepos);
                $("#kk_baru").val(data.kode_keluarga);
            }
        });
    });
    
    $("#save").click(function(event){
		$("#flash").html("");
        event.preventDefault();
        $.ajax({
            url : "kependudukan/penduduk.php",
            type: "post",
            data : {
                oper : "pindahalamat",
                penduduk_id : $("#penduduk_id").val(),
                tgl_pindah : $("#tanggal_pindah").val(),
                kk_id_lama : $("#kk_lama").val(),
                kk_id_baru : $("#kk_baru").val(),
                keterangan : $("#keterangan_pindah").val(),
				status_hub_kel_baru : $("#status_hub_keluarga").val()
            },
            dataType: "html",
            cache : false,
            success : function(data, status){
                
                $("#flash").html(data);
            }
        });
    });
	
	$.ajax({
		url: "kependudukan/penduduk.php",
		type: "get",
		dataType : "html",
		data : {
			q : 2,
			id : "status_hub_kel"
		},
		success : function(data, status){
			$("#lbl_status_hub_keluarga").after(data);
		}
	});
});
