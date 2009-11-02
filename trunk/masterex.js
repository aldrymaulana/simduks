var master = jQuery("#list10").jqGrid({
   	url:'server.php?q=2',
	datatype: "json",
   	colNames:['Inv No','Date', 'Client', 'Amount','Tax','Total','Notes'],
   	colModel:[
   		{name:'id',index:'id', width:55, editable: true},
   		{name:'invdate',index:'invdate', editable: true, width:90,
			editoptions:{
				size: 12,
				dataInit: function(el){
					$(el).datepicker({dateFormat:'yy-mm-dd'});
				},
				defaultValue:function(){
					var today = new Date();
					var month = parseInt(today.getMonth() + 1);
					month = month <= 9? "0" + month : month;
					var day = today.getDate();
					day = day <= 9 ? "0" + day : day;
					var year = today.getFullYear();
					return year + "-" + month + "-" + day;
				}
			},
			editrules: { required: true }
		},
   		{name:'name',index:'name', width:100, editable: true},
   		{name:'amount',index:'amount', width:80, align:"right", editable: true},
   		{name:'tax',index:'tax', width:80, align:"right", editable: true},		
   		{name:'total',index:'total', width:80,align:"right", editable: true},		
   		{name:'note',index:'note', width:150, sortable:false, editable: true}		
   	],
   	rowNum:10,
   	rowList:[10,20,30],
   	imgpath: gridimgpath,
   	pager: jQuery('#pager10'),
   	sortname: 'id',
    viewrecords: true,
    sortorder: "desc",
	multiselect: false,
	caption: "Invoice Header",
	onSelectRow: function(ids) {
		if(ids == null) {
			ids=0;
			if(jQuery("#list10_d").getGridParam('records') >0 )
			{
				jQuery("#list10_d").setGridParam({url:"subgrid.php?q=1&id="+ids,page:1})
				.setCaption("Invoice Detail: "+ids)
				.trigger('reloadGrid');
			}
		} else {
			jQuery("#list10_d").setGridParam({url:"subgrid.php?q=1&id="+ids,page:1})
			.setCaption("Invoice Detail: "+ids)
			.trigger('reloadGrid');			
		}
	},
	editurl: "server.php"
})
.navGrid('#pager10',{add:true,edit:true,del:true, search: false}
);

jQuery("#list10_d").jqGrid({
	height: 100,
   	url:'subgrid.php?q=1&id=0',
	datatype: "json",
   	colNames:['No','Item', 'Qty', 'Unit','Line Total'],
   	colModel:[
   		{name:'num',index:'num', width:55, editable:true, edittype: "text"},
   		{name:'item',index:'item', width:180, editable:true, edittype: "text"},
   		{name:'qty',index:'qty', width:80, align:"right", editable:true, edittype: "text"},
   		{name:'unit',index:'unit', width:80, align:"right", editable:true, edittype: "text"},		
   		{name:'linetotal',index:'linetotal', width:80,align:"right", sortable:false, search:false, editable:true, edittype: "text"}
   	],
   	rowNum:5,
   	rowList:[5,10,20],
   	imgpath: gridimgpath,
   	pager: jQuery('#pager10_d'),
   	sortname: 'item',
    viewrecords: true,
    sortorder: "asc",
	multiselect: false,
	caption:"Invoice Detail",
	editurl: 'subgrid.php'
}).navGrid('#pager10_d',{add:true,edit:true,del:true}, 
	{onclickSubmit: function(re, postdata){	
		var invoice_id = master.getGridParam('selrow');
		return {"invoice_id": invoice_id};		
	}},
    {onclickSubmit: function(re, postdata){
		var invoice_id = master.getGridParam('selrow');
		return {"invoice_id": invoice_id};
	}}	
);

jQuery("#ms1").click( function() {
	var s;
	s = jQuery("#list10_d").getMultiRow();
	alert(s);
});
