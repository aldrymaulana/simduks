var kecgrid = jQuery("#kecgrid").jqGrid({
    url : "master/kecamatan.php?q=1",
    datatype: "json",
    colNames: ['Id', 'Kode Wilayah', 'Camat', 'Kecamatan', 'Kode Pos'],
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
    onSelectRow: function(ids){
        if(null == ids){
            ids = 0;
            if(kelgrid.getGridParam("records") > 0){
                kelgrid.setGridParam({url: "kependudukan/ktp.php?q=1&kecamatan_id=" + ids, page: 1}).trigger("reloadGrid");
            } 
        }else {
            kelgrid.setGridParam({url: "kependudukan/ktp.php?q=1&kecamatan_id=" + ids, page: 1}).trigger("reloadGrid");
        }
    },
    caption: "Daftar Kecamatan"
}).navGrid("#kecnav", {add: false, edit:false, del:false, search : false});

var kelgrid = jQuery("#kelgrid").jqGrid({
    master : kecgrid,
    url : "kependudukan/ktp.php?q=1&kecamatan_id=0",
    datatype: "json",
    colNames: ["Id", "NIK", "Nama", "Alamat","Tgl Lahir"],
    colModel: [
        {name: "id", index : "id", width: 55},
        {name: "nik", index: "nik", width: 100},
        {name: "nama", index: "nama", width: 200},
        {name: "alamat", index: "alamat", width: 250},
        {name: "tgl_lahir", index: "tgl_lahir", width: 100}
    ],
    rowNum: 10,
    rowList: [10, 20, 30],
    imgpath: gridimgpath,
    pager : jQuery("#kelnav"),
    sortname: "id",
    multiselect : false,
    caption : "Daftar Penduduk ber-KTP"
}).navGrid("#kelnav",{add:false, edit:false, del: false, search: false});