jQuery(document).ready(function(){
    
	$("#tgl_lahir").datepicker({
	    dateFormat : "yy-mm-dd",
		onSelect : function(dateText, inst) {
			$("#tgl_lahir").text(dateText);
		}
	});
	
	$.ajax({
		url: "kependudukan/penduduk.php?q=2&id=gol_darah",
		type: "get",
		dataType: "html",
		data: {},
		success : function(data, status) {
			$("#lbl_gol_darah").after(data);
		}
	});
	
	$.ajax({
		url: "kependudukan/penduduk.php?q=2&id=jenis_kelamin",
		type: "get",
		dataType: "html",
		data: {},
		success: function(data, status){
			$("#lbl_jenis_kelamin").after(data);
		}
	})
	
	$.ajax({
		url : "kependudukan/penduduk.php?q=2&id=kecamatan",
		type: "get",
		dataType: "html",
		data: {},
		success: function(data, status){
			$("#lbl_kecamatan").after(data);
		}
	});
	
	$("#load_ayah").click(function(event){
		event.preventDefault();
		$.ajax({
			url : "kependudukan/penduduk.php",
			type: "get",
			dataType : "json",
			data: {
				q : 4,
				nik : $("#nik_ayah").val()
			},
			success : function(data, status){
				$("#li_nama_ayah").remove();
				var html = "<li id=\"li_nama_ayah\">";
				html += "<label for=\"nama_ayah\">Nama Ayah</label>";
				html += "<input type=\"text\" class=\"text ui-widget-content ui-corner-all\" name=\"nama_ayah\" id=\"nama_ayah\"  readonly=\"readonly\" value=\"" + data.nama + "\"/>";
				html += "</li>";
				$("#li_ayah").after(html);
			}
		})
	});
	
	$("#load_ibu").click(function(event){
		event.preventDefault();
		$.ajax({
			url : "kependudukan/penduduk.php",
			type: "get",
			dataType : "json",
			data: {
				q : 4,
				nik : $("#nik_ibu").val()
			},
			success : function(data, status){
				$("#li_nama_ibu").remove();
				var html = "<li id=\"li_nama_ibu\">";
				html += "<label for=\"nama_ibu\">Nama Ibu</label>";
				html += "<input type=\"text\" class=\"text ui-widget-content ui-corner-all\" name=\"nama_ibu\" id=\"nama_ibu\" readonly=\"readonly\" value=\"" + data.nama + "\"/>";
				html += "</li>";
				$("#li_ibu").after(html);
			}
		})
	});
	
	
	$("#save").click(function(event){
		$("#report_link").remove();
		event.preventDefault();
		$.ajax({
			url: "kependudukan/kelahiran.php",
			type: "post",
			dataType: "html",
			data: {
				no_akte: $("#no_akte").val(),
				nama: $("#nama_anak").val(),
				jenis_kelamin : $("#jenis_kelamin").val(),
				gol_darah : $("#gol_darah").val(),
				tempat_lahir : $("#tmp_lahir").val(),
				tanggal_lahir : $("#tgl_lahir").val(),
				jam_lahir : $("#jam_lahir").val(),
				nik_ayah : $("#nik_ayah").val(),
				nik_ibu : $("#nik_ibu").val(),
				saksi1 : $("#saksi_1").val(),
				saksi2 : $("#saksi_2").val(),
				mode : $("#mode").val(),
				penduduk_id : $("#penduduk_id").val(),
				kecamatan_id : $("#kecamatan_id").val()
				},
			success : function(data, status){
				$("#save").after(data);
			}
		});
	});
	
	$("#cancel").click(function(event){
		event.preventDefault();
		$("#report_link").remove();
	});
	
	$("#load_foto").click(function(event){
		event.preventDefault();
		$("#fotodialog").dialog("open");
	});
});
