var groupGrid = jQuery("#groups").jqGrid({
   url: "admin/groups.php?q=1",
   datatype: "json",
   colNames: ["Id", "Nama Group", "Kecamatan/Dinas"],
   colModel: [
      {name: "id", index: "id", width: 50},
      {name: "name", index : "name", width: 100, editable: true},
      {name: "kecamatan", index: "kecamatan", width: 200, editable: true, edittype: "select",
         editoptions: {
            defaultValue: function() {
               return "";
            },
            dataUrl : "admin/users.php?q=2"
         }
      }
   ],
   rowNum: 10,
   rowList: [10, 20, 30],
   imgpath: gridimgpath,
   pager: jQuery("#groupsnav"),
   sortname: "id",
   multiselect : false,
   onSelectRow : function(ids) {
        if(null == ids){
			ids = 0;
			if(usersGrid.getGridParam('records') > 0) {
			    usersGrid.setGridParam({url: "admin/users.php?q=1&group_id=" + ids, page: 1})
				.trigger("reloadGrid");
			}
		} else {
		    usersGrid.setGridParam({url: "admin/users.php?q=1&group_id=" + ids, page: 1})
			.trigger("reloadGrid");
		}
   },
   caption: "Daftar Group",
   editurl: "admin/groups.php"
}).navGrid("#groupsnav", {add:true, edit:true, del:true, search: false   
});

var usersGrid = jQuery("#users").jqGrid({
   master : groupGrid,
   url: "admin/users.php?q=1&group_id=0",
   datatype: "json",
   colNames: ["Id", "username", "password"],
   colModel: [
        {name: "id", index: "id", width: 50},
		{name: "username", index: "username", width:200, editable: true},
		{name: "password", index: "password", width: 200, editable: true, edittype: "password"}
   ],
   rowNum: 10,
   rowList: [10, 20,30],
   imgpath: gridimgpath,
   pager: jQuery("#usersnav"),
   sortname: "id",
   multiselect: false,
   caption: "Daftar Users",
   editurl: "admin/users.php"
}).navGrid("#usersnav",
    {add:true, edit:true, del:true, search: false},
	{ /** editing form **/
	    onclickSubmit :  function(re, data) {
            return {"group_id" : groupGrid.getGridParam('selrow') };
		}
	},
	{ /** add form **/
	    onclickSubmit : function(re, data) {
            return {"group_id" : groupGrid.getGridParam('selrow') };
		}
	}
);
