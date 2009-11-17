var keluarga_id = "0";
var kk = jQuery("#kk").jqGrid({ 
    url:'kependudukan/kartukeluarga.php?q=1&kec_id=0',
    datatype: "json",
    colNames:['id','No. Kartu Keluarga', 'No. Formulir', 'Alamat', 'RT', 'RW', 'Kelurahan'],
    colModel:[
            {name:'id',index:'id', width:2},
            {name:'kode_keluarga',index:'kode_keluarga', width:10, editable:true,
                edirules:{required: true}
            },
            {name:'no_formulir', index: 'no_formulir', width: 10, editable: true,                
                editrules: {required: true}
            },
            {name:'alamat', index:'alamat', width: 10, editable: true,
                
                editrules: {required: true}
            },
            {name:'rukun_tetangga', index: 'rukun_tetangga', width:5, editable:true,
               
                editrules: {required: true}
            },
            {name:'rukun_warga', index: 'rukun_warga', width:5, editable:true,
                
                editrules: {required: true}
            },
            {name:'kelurahan_id', index: 'kelurahan_id', width:10, editable:true,
                edittype: "select",
                editoptions:{
                    defaultValue: function() {
                        return "";
                    },
                    dataUrl: "master/kelurahan.php?q=2"
                },
                formoptions:{rowpos:6, label: "Kelurahan"},
                editrules: {required: true}
            }
    ],
    rowNum:10,
    rowList:[10,20,30],
    imgpath: gridimgpath,
    pager: jQuery('#kknav'),
    sortname: 'id',
    width: 700,
    height: 210,
    multiselect: false,
    viewrecords: true,
    sortorder: "desc",
    caption:"Daftar Keluarga",
    editurl: "kependudukan/kartukeluarga.php",
    onSelectRow: function(ids){
        if(null == ids)
        {
            ids = 0;
			keluarga_id = ids;
            if(kkdetail.getGridParam("records") > 0)
            {
                kkdetail.setGridParam({url: "kependudukan/penduduk.php?q=1&keluarga_id=" + ids, page: 1})
                    .trigger("reloadGrid");
            }
        }
        else
        {
			keluarga_id = ids;
            kkdetail.setGridParam({url: "kependudukan/penduduk.php?q=1&keluarga_id=" + ids, page: 1})
                .trigger("reloadGrid");
        }
    }
}).navGrid("#kknav",
    {view: true},
    {height: 210, width: 500, reloadAfterSubmit: true, jqModal: false, closeOnEscape:true}, // edit
    {height: 210, width: 500, reloadAfterSubmit: true, jqModal: false, closeOnEscape: true}, // add
    {reloadAfterSubmit: true, jqModal: false, closeOnEscape: true}, // delete
    {closeOnEscape: true}, // search
    {height: 210, width: 500, jqModal: false, closeOnEscape: true} //view
).navButtonAdd("#kknav",{caption:"Lap. KK",title:"Laporan Kartu keluarga",buttonimg:gridimgpath+'/find.gif',
    onClickButton:function(){
        $.ajax({
			url : "reports/pdf/lap2.php",
			type: "get",
			dataType: "html",
			data: {
				kk_id : kk.getGridParam("selrow")
			},
			cache : false,
			success: function(data, status){
				
			}
		});
    }
}); 

$("#report").click(function(event){
	$("#flash").html("");
	var id = kk.getGridParam("selrow");
	if(null == id){
		$("#flash").html("<p style=\"color: red;\">Pilih keluarga dulu </p>");
		event.preventDefault();
	} else {		
		$("#report").attr("href", "reports/pdf/lap2.php?kode=" + id);
		$("#report").attr("target", "_blank");
	}
});

$("#akta").click(function(event){
	$("#flash").html("");
	var id = kkdetail.getGridParam("selrow");
	if(null == id){
		$("#flash").html("<p style=\"color: red;\">Pilih Penduduk dulu </p>");
		event.preventDefault();
	} else {
		$("#akta").attr("href", "reports/pdf/lap3.php?penduduk_id=" + id);
		$("#akta").attr("target", "_blank");
	}
});

jQuery("#vcol").click(function (){ jQuery("#kk").setColumns(); }); 
// kartu keluarga details ....
var kkdetail = jQuery("#kkdetail").jqGrid({
    master : kk,
    url:'kependudukan/penduduk.php?q=1&keluarga_id=0',
    datatype: "json",
    colNames:['id','NIK', 'Nama', 'Jenis Kelamin', 'Status Pernikahan', 'Status Hub. Keluarga','Ayah','Ibu',
              'Gol. Darah', 'Tempat Lahir','Tanggal Lahir','Agama', 'Pendidikan', 'Pekerjaan', 'Penghasilan','Warga Negara'
    ],
    colModel:[
            {name:'id',index:'id', width:2},
            {name:'nik',index:'nik', width:16},
            {name:'nama', index: 'nama', width: 10, editable: true},
            {name:'jenis_kelamin', index:'jenis_kelamin', width: 10, editable: true,
                edittype: "select",
                editoptions:{defaultValue: function(){
                        return "Perempuan";
                    },
                    dataUrl:"kependudukan/penduduk.php?q=2&id=jenis_kelamin"
                },
                
                editrules: {required: true}
            },
            {name:'status_nikah', index: 'status_nikah', width:10, editable:true,
                edittype: "select",
                editoptions:{
                    defaultValue: function() {
                        return "Tidak kawin";
                    },
                    dataUrl: "kependudukan/penduduk.php?q=2&id=status_nikah"
                }                
            },
            {name:'status_hub_kel', index: 'status_hub_kel', width:10, editable:true,
                edittype: "select",
                editoptions:{
                    defaultValue: function(){
                        return "Anak";
                    },
                    dataUrl: "kependudukan/penduduk.php?q=2&id=status_hub_kel"
                },
                
                editrules: {required: true}
            },
			{
				name: 'ayah', index: 'ayah', width: 20, editable: false
			},
			{
				name: 'ibu', index: 'ibu', width: 20, editable: false
			},
            {name:'gol_darah', index: 'gol_darah', width:10, editable:true,
                edittype: "select",
                editoptions:{
                    defaultValue: function(){
                        return "-";
                    },
                    dataUrl: "kependudukan/penduduk.php?q=2&id=gol_darah"
                },
              
                editrules: {required: true}
            },
            {name:'tmp_lahir', index: 'tmp_lahir', width:20, editable:true,               
                editoptions:{
                    size: 20,
                    defaultValue : function() {
                        return "Tulungagung";
                    }
                },
                
                editrules: {required: true}
            },
            {name:'tgl_lahir', index: 'tgl_lahir', width:10, editable:true,               
                editoptions:{
                    size: 10,
                    dataInit: function(el){
                        $(el).datepicker({dateFormat: 'yy-mm-dd'});
                    },
                    defaultValue: function() {
                        var currentTime = new Date();
                        var month = parseInt(currentTime.getMonth());
                        month = month <= 9 ? "0"+month : month;
                        var day = currentTime.getDate();
                        day = day <= 9 ? "0"+day : day;
                        var year = currentTime.getFullYear();
                        return year+"-"+month + "-"+day;
                    }
                },
               
                editrules: {required: true},
                sorttype:"date"
            },
            {name:'agama', index: 'agama', width:10, editable:true,
                edittype: "select",
                editoptions:{
                    defaultValue: function(){
                        return "Anak";
                    },
                    dataUrl: "kependudukan/penduduk.php?q=2&id=agama"
                },
                
                editrules: {required: true}
            },
            {name: "pendidikan", index: "pendidikan", width: 30, editable: true,
                edittype: "select",
                editoptions: {
                    defaultValue : function(){
                        return "Islam";
                    },
                    dataUrl: "kependudukan/penduduk.php?q=2&id=pendidikan"
                },
                editrules: {required: true}
            },
            {name: "pekerjaan", index: "pekerjaan", width: 30,editable: true,
                edittype: "select",
                editoptions: {
                    defaultValue : function(){
                        return "";
                    },
                    dataUrl : "kependudukan/penduduk.php?q=2&id=pekerjaan"
                }
            },
			{name: "penghasilan", index: "penghasilan", width: 30, editable: true,
				editoptions: {
					defaultValue : function(){
						return "0";
					}
				}			
			},
            {name: "warga", index: "warga", width: 10, editable: true,
                edittype: "select",
                editoptions: {
                    defaultValue : function() {
                        return "WNI";
                    },
                    dataUrl : "kependudukan/penduduk.php?q=2&id=warga_negara"
                }                
            }
    ],
    rowNum:10,
    rowList:[10,20,30],
    imgpath: gridimgpath,
    pager: jQuery('#kkdetailnav'),
    sortname: 'id',
    width: 900,
    height: 210,
    multiselect: false,
    viewrecords: true,
    sortorder: "desc",
    caption:"Daftar Keluarga Detail",
    editurl: "kependudukan/penduduk.php"
	
}).navGrid("#kkdetailnav",
    {view: true, edit: true, add: false},
    {
        onclickSubmit :  function(re, data) {
            return {"kk_id" : kk.getGridParam('selrow') };
		}
    }, // edit
    {
        onclickSubmit :  function(re, data) {
            return {"kk_id" : kk.getGridParam('selrow') };
		}
    }, // add
    {reloadAfterSubmit: true, jqModal: false, closeOnEscape: true}, // delete
    {closeOnEscape: true}, // search
    {height: 210, width: 500, jqModal: false, closeOnEscape: true} //view
).navButtonAdd("#kkdetailnav",{caption:"Reg. Kelahiran",title:"Register Penduduk baru",buttonimg:gridimgpath+'/find.gif',
    onClickButton:function(){
        alert("Register Data Kelahiran Ditampilkan");
    }
}); 
