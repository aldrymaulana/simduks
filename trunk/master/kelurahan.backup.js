jQuery("#kelurahan").jqGrid({
    url:'master/kelurahan.php?q=1&kecamatan_id=0',
    datatype: "json",
    colNames:['id','Lurah', 'Kelurahan', 'Kecamatan'],
    colModel:[
        {name:'id',index:'id', width:2, editable: false,
            editoptions:{readonly:true, size:2}
        },           
        {name:'lurah', index: 'lurah', width: 10, editable: true,
            editoptions:{size: 20},
            formoptions:{rowpos:2, label: "Lurah"},
            editrules: {required: true}
        },
        {name:'kelurahan', index:'kelurahan', width: 10, editable: true,
            editoptions:{size: 30},
            formoptions:{rowpos: 3, label: "Kelurahan"},
            editrules: {required: true}
        },
        {name:'kecamatan', index:'kecamatan', width: 10, editable: true,
            edittype: "select",
            editoptions:{defaultValue: function(){
                    return jQuery("#nama_kecamatan").val();
                },
                dataUrl:"master/kecamatan.php?q=2"
            },
            formoptions:{rowpos: 4, label: "Kecamatan"},
            editrules: {required: true}
        }
    ],
    rowNum:10,
    rowList:[10,20,30],
    imgpath: gridimgpath,
    pager: jQuery('#kelurahannav'),
    sortname: 'id',
    width: 500,
    height: 230,
    multiselect: false,
    viewrecords: true,    
    sortorder: "desc",
    caption:"Daftar  Kelurahan",
    editurl: "master/kelurahan.php"
}).navGrid('#kelurahannav',
    {view: true},
    {
        height: 150, reloadAfterSubmit: true, jqModal: false, closeOnEscape:true,
        onclickSubmit: function(ret, data){
            alert("ret :" + ret);
            alert("post data :" + data);
        }
    }, // edit
    {height: 150, reloadAfterSubmit: true, jqModal: false, closeOnEscape: true}, // add
    {reloadAfterSubmit: true, jqModal: false, closeOnEscape: true}, // delete
    {closeOnEscape: true}, // search
    {height: 250, jqModal: false, closeOnEscape: true} //view
);   