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
                if(data.jenis_kelamin != "Perempuan"){
                    $("#flash").html("");
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
                } else {
                    $("#flash").html(
                        "<p style=\"color: red;\">" + data.nama + " adalah seorang Perempuan, untuk pecah kk harus penduduk laki-laki</p>"
                    );
                }
            }    
        });
    });
    
    $("#chk_alamat_baru").click(function(event){        
        if($("#chk_alamat_baru").attr("checked")){
            $("#fieldset_alamat_baru").attr("style", "display:block");
        } else {
            $("#fieldset_alamat_baru").attr("style", "display:none");
        }
    });
    
    function show_desa(kecamatan_id)
    {
        $.ajax({
            url : "kependudukan/penduduk.php?q=7&kecamatan_id=" + kecamatan_id,
            type: "get",
            data: {},
            dataType: "html",
            success : function(data, status){               
                $("#lbl_desa").after(data);
            }
        });
    }
    
    function show_kodepos(kecamatan_id){
        $.ajax({
            url : "kependudukan/penduduk.php",
            type: "get",
            data:{
                q : 8,
                kecamatan_id: kecamatan_id
            },
            dataType: "html",
            success: function(data, status){
                $("#kodepos_baru").val(data);
            }
        });
    }
    
    $.ajax({
        url: "kependudukan/penduduk.php?q=6",
        type: "get",
        data: {},
        dataType: "html",
        success: function(data, status) {           
            $("#rtrw").after(data);            
            $("#kecamatan_baru").change(function(){
                $("#desa_baru").remove();
                $("#kecamatan_baru option:selected").each(function(){
                    var id = $(this).val();
                    show_desa(id);
                    show_kodepos(id);
                });
            }).trigger('change');
        }
    });	
});