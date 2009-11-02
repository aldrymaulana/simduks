jQuery("#kb").jqGrid({
    url:'master/kb.php?q=1',
    datatype: "json",
    colNames:['id','kb'],
    colModel:[
            {name:'id',index:'id', width:10, editable: false, editoptions:{readonly:true, size:5}},
            {name:'kb',index:'kb', width:30, editable:true, editoptions:{size:30}, formoptions:{rowpos:1, label: "Keluarga Berencana"}, edirules:{required: true}}
            
    ],
    rowNum:10,
    rowList:[10,20,30],
    imgpath: gridimgpath,
    pager: jQuery('#kbnav'),
    sortname: 'id',
    width: 500,
    height: "100%",
    multiselect: false,
    viewrecords: true,
    sortorder: "desc",
    caption:"Daftar Keluarga Berencana",
    editurl: "master/kb.php"
}).navGrid('#kbnav',
    {view: true},
    {height: 100, reloadAfterSubmit: false, jqModal: false, closeOnEscape:true}, // edit
    {height: 100, reloadAfterSubmit: false, jqModal: false, closeOnEscape: true}, // add
    {reloadAfterSubmit: false, jqModal: false, closeOnEscape: true}, // delete
    {closeOnEscape: true}, // search
    {height: 150, jqModal: false, closeOnEscape: true} //view
);   