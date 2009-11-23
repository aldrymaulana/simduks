var kecgrid = jQuery("#kecgrid").jqGrid({
    url: "master/kecamatan.php?q=1",
    datatype: "json",
    colNames : ["Id", "Kode Wilayah", "Camat", "Kecamatan", "Kode Pos"],
    colModel : [
        {name: "id", index: "id", width: 55},
        {name: "kd_wilayah", index : "kd_wilayah", width: 100, editable: true},
        {name: "camat", index : "camat", width: 200, editable : true},
        {name: "nama_kecamatan", index: "nama_kecamatan", width: 200, editable: true},
        {name: "kodepos", index : "kodepos", width: 100, editable : true}
    ],
    rowNum : 10,
    rowList : [10, 20, 30, 40],
    imgpath : gridimgpath,
    pager : jQuery("#kecnav"),
    sortname: "id",
    multiselect : false,
    onSelectRow : function(ids){
        if(null == ids){
            ids = 0;
            if(nikahGrid.getGridParam("records") > 0){
                nikahGrid.setGridParam({url: "kependudukan/pernikahan.php?q=1&kecamatan_id=" + ids, page: 1}).trigger("reloadGrid");
            } 
        }else {
            nikahGrid.setGridParam({url: "kependudukan/pernikahan.php?q=1&kecamatan_id=" + ids, page: 1}).trigger("reloadGrid");
        }
    },
    caption : "Daftar Kecamatan"
}).navGrid("#kecnav", {add:false, edit:false, del:false, search:false});

var nikahGrid = jQuery("#pernikahangrid").jqGrid({
    master: kecgrid,
    url : "kependudukan/pernikahan.php?q=1&kecamatan_id=0",
    datatype: "json",
    colNames: ["Id", "No Pernikahan", "Pria", "Wanita", "Tanggal", "Alamat"],
    colModel: [
        {name:"id", index:"id", width:55},
        {name: "no_pernikahan", index: "no_pernikahan", width: 100},
        {name: "pria", index: "pria", width: 100},
        {name: "wanita", index: "wanita", width: 100},
        {name: "tanggal", index: "tanggal", width: 100},
        {name: "alamat", index: "alamat", width: 200}
    ],
    rowNum : 10,
    rowList: [10, 20, 30],
    imgpath : gridimgpath,
    pager : jQuery("#pernikahannav"),
    sortname: "id",
    multiselect : false,
    caption: "Daftar Pernikahan"
}).navGrid("#pernikahannav",{add:false, edit:false, del:false, search:false});

$("#report").click(function(event){
    $("#flash").html("");
    var selrow = nikahGrid.getGridParam('selrow');
    if( selrow == null){
        event.preventDefault();
        $("#flash").html("<p style=\"color: red\">Silahkan Pilih daftar pernikahan dulu</p>");
    } else {
        $("#report").attr("href", "reports/pdf/lap4.php?pernikahan_id=" + selrow);
        $("#report").attr("target", "_blank");
    }
});