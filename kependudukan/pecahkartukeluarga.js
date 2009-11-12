jQuery(document).ready(function(){
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
                $("#kk_id_lama").val(data.keluarga_id);
            }    
        });
    }); 
});