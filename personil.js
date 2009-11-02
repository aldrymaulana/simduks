var alamatGrid = jQuery("#alamat").jqGrid({
    url: "personil.php?q=1",
    datatype: "json",
    colNames: ['Id', 'Nama', 'Alamat'],
    colModel:[
        {name: "id", index:"id", width: 55},
        {name: "nama", index: "nama", width: 200, editable: true},
        {name: "alamat", index: "alamat", width: 300, editable: true}        
    ],
    rowNum: 8,
    rowList: [8, 16, 24, 32],
    imgpath : gridimgpath,
    pager : jQuery("#alamatnav"),
    sortname: "nama",
    multiselect : false,
    onSelectRow:function(ids){
        if(ids == null) {
			ids=0;
			if(jQuery("#personil").getGridParam('records') >0 )
			{
				jQuery("#personil").setGridParam({url:"personil_detail.php?q=1&alamat_id="+ids,page:1})
				.setCaption("Personil Detail: "+ids)
				.trigger('reloadGrid');
			}
		} else {
			jQuery("#personil").setGridParam({url:"personil_detail.php?q=1&alamat_id="+ids,page:1})
			.setCaption("Personil Detail: "+ids)
			.trigger('reloadGrid');			
		}
    },
    caption: "Alamat Personil",
    editurl: "personil.php"
})
.navGrid("#alamatnav", {add:true,edit:true, del:true, search: false
});

/********** Personil Detail **************/
var personilGrid = jQuery("#personil").jqGrid({
	master : alamatGrid,
    url: "personil_detail.php?q=1&alamat_id=0",
    datatype: "json",
    colNames: ['Id', 'Nama Personil'],
    colModel:[
        {name: "id", index:"id", width: 55},
        {name: "nama_personel", index: "nama_personel", width: 300, editable: true},            
    ],
    rowNum: 10,
    rowList: [10, 20, 30, 40],
    imgpath : gridimgpath,
    pager : jQuery("#personilnav"),
    sortname: "nama_personel",
    multiselect : false,
    caption: "Personil Detail",
    editurl: "personil_detail.php"
})
.navGrid("#personilnav",
	{
		add:true,edit:true, del:true, search: false
	},
    {	/** editing form ***/
        onclickSubmit: function(re, data){
            var alamat_id = alamatGrid.getGridParam('selrow');
            return {"alamat_id" : alamat_id};
        }
    },
    {	/** adding form ***/		
        onclickSubmit: function(re, data){
            var alamat_id = alamatGrid.getGridParam('selrow');
            return {'alamat_id' : alamat_id };
        }
    }
);