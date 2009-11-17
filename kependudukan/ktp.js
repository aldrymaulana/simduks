jQuery(document).ready(function(){
    $("#tgl_lahir").datepicker({
        dateFormat: "yy-mm-dd",
        onSelect: function(date, str){
            $("#tgl_lahir").val(date);
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
                $("#oper").val("upload");
                $("#photo").val("");
                if(data.umur < 17){
                    $("#save").attr("disabled", "disabled");
                    $("#flash").html("<p style='color:red;'>Umur belum mencukupi untuk membuat KTP</p>");
                } else{
                    $("#save").removeAttr("disabled");
                }
                
                if(data.photo.length > 0){
                    $("#upload_output").html(
                        "<img src=\"" + data.photo + "\/>"  
                    );
                }
            }
        });
    });
    
    function updateCoords(c)
    {
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#w').val(c.w);
        $('#h').val(c.h);
        
        if (parseInt(c.w) > 0)
        {
            var rx = 100 / c.w;
            var ry = 100 / c.h;

            jQuery('#preview').css({
                width: Math.round(rx * 500) + 'px',
                height: Math.round(ry * 370) + 'px',
                marginLeft: '-' + Math.round(rx * c.x) + 'px',
                marginTop: '-' + Math.round(ry * c.y) + 'px'
            });
        }
    };
    var url = "reports/pdf/lap3.php?penduduk_id=";
    var id = "";
    var form_ktp = $("#form_ktp").ajaxForm({
        beforeSubmit : function(a, f, o){
            $("#pdf").remove();
            o.dataType = "html";
        },
        success : function(data){
            $("#pdf").remove();
            $("#upload_output").html(data);
           
            id = $("#penduduk_id").val();
            var pdf = "<a id=\"pdf\" href=\"#\" name=\"pdf\">PDF</a>";
            $("#cancel").after(
                pdf
            );
            
            $("#flash").html(
                "<p style='color: green;'>Foto berhasil disimpan</p>"
            )
        }
    });
    
    $("#cancel").click(function(event){
        event.preventDefault();
        $("#form_ktp").resetForm();
        $("#flash").html("");
        $("#nik").attr("onfocus","this.value='';this.onfocus=null;");
    });   
    
    
    $("#pdf").click(function(event){
        $("#pdf").attr("href", url + id);
        $("#pdf").attr("target", "_blank");
    });
})