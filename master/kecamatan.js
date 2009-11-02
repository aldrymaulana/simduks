var kecGrid = jQuery("#kecamatan").jqGrid({
    url: "master/kecamatan.php?q=1",
	datatype: "json",
	colNames: ['Id', 'Kode Wilayah', 'Camat', 'Kecamatan', 'Kodepos'],
	colModel: [
        {name: "id", index:"id", width: 55},
		{name: "kd_wilayah", index: "kd_wilayah", width: 100, editable: true},
		{name: "camat", index : "camat", width: 200, editable: true},
		{name: "nama_kecamatan", index: "nama_kecamatan", width: 200, editable: true},
		{name: "kodepos", index: "kodepos", width:100, editable:true}
	],
	rowNum : 10,
	rowList: [10, 20, 30, 40],
	imgpath :gridimgpath,
	pager: jQuery("#kecamatannav"),
	sortname: "id",
	multiselect: false,
	onSelectRow: function(ids){
       if(null == ids){
           ids = 0;
		   if(kelGrid.getGridParam("records") > 0){
		       kelGrid.setGridParam({url: "master/kelurahan.php?q=1&kecamatan_id="+ids, page: 1})
			   .trigger("reloadGrid");
		   }
	   } else {
          kelGrid.setGridParam({url: "master/kelurahan.php?q=1&kecamatan_id=" + ids, page:1})
		  .trigger("reloadGrid");
	   }
	},
	caption: "Daftar Kecamatan",
	editurl: "master/kecamatan.php"
}).navGrid("#kecamatannav", {add:true, edit:true,del:true, search:false});


var kelGrid = jQuery("#kelurahan").jqGrid({
    url: "master/kelurahan.php?q=1&kecamatan_id=0",
	datatype: "json",
	colNames :["Id", "Lurah", "Kelurahan"],
	colModel :[
        {name: "id", index:"id", width: 55},
		{name: "lurah", index:"lurah", width: 100, editable:true},
		{name: "nama_kelurahan", index: "nama_kelurahan", width: 200, editable: true}
	],
    rowNum : 10,
	rowLis : [10, 20, 30],
	imgpath: gridimgpath,
	pager: jQuery("#kelurahannav"),
	sortname: "id",
	multiselect: false,
	caption: "Daftar Kelurahan",
	editurl: "master/kelurahan.php"
}).navGrid("#kelurahannav", 
    {
	    add:true, edit:true, del:true, search:false,
	    cancelShowingAddForm : function() {
            return null == kecGrid.getGridParam('selrow') ? true : false;
		}
	},
	{ /** editing form **/
        onclickSubmit : function(re, data) {
            return {"kecamatan_id" : kecGrid.getGridParam('selrow')};
		}
	},
	{ /** adding form **/
        onclickSubmit : function(re, data) {
            return {"kecamatan_id" : kecGrid.getGridParam('selrow')};
		}
	}
);
