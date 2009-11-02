jQuery("#kelurahan").jqGrid({
    url:'master/kelurahan.php?q=1&kecamatan_id=0',
    datatype: "json",
    colNames:['id','Lurah', 'Kelurahan'],
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
        }
    ],
    rowNum:5,
    rowList:[10,20,30],
    imgpath: gridimgpath,
    pager: jQuery('#kelurahannav'),
    sortname: 'id',
    width: 500,
    height: 200,
    multiselect: true,
    viewrecords: true,    
    sortorder: "asc",
    caption:"Daftar  Kelurahan",
    editurl: "master/kelurahan.php"
}).navGrid('#kelurahannav',
    {view: true},
    {
        height: 150,/* reloadAfterSubmit: true, */jqModal: false, closeOnEscape:true,
        onclickSubmit: function(ret, data){
            alert("ret :" + ret);
            alert("post data :" + data);
        }
    }, // edit
    {height: 150, /*reloadAfterSubmit: true, */jqModal: false, closeOnEscape: true}, // add
    {reloadAfterSubmit: true, jqModal: false, closeOnEscape: true}, // delete
    {closeOnEscape: true}, // search
    {height: 200, jqModal: false, closeOnEscape: true} //view
);   