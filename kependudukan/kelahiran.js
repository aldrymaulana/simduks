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
	
	$("#lookup_ayah").click(function(event){
		event.preventDefault();
		$("#search_ayah").dialog("open");
	});
	
	$("#search_ayah").dialog({
		bgiframe: true,
		autoOpen: false,
		modal: true,
		buttons:{
			"Cari": function() {
				var search_name = $("#name_ayah").val();				
				$.ajax({
					url: "kependudukan/penduduk.php",
					type: "get",
					data: {
						q : 3,
						ortu: "ayah",
						nama: search_name						
					},
					dataType : 'json',
					cache: false,
					success: function(data, status) {
						$("#hasil_search_ayah").html(data.nama);		
						$("#nik_ayah").val(data.nik);												
					}
				});
								
			},
			"Tutup" : function() {
				$(this).dialog("close");
			}
		},
		close: function() {
			$("#hasil_search_ayah").html("");
			$("#name_ayah").val("");
		}
	});
	
	$("#lookup_ibu").click(function(event){
		event.preventDefault();
		$("#search_ibu").dialog("open");
	});
	
	$("#search_ibu").dialog({
		bgiframe: true,
		autoOpen: false,
		modal: true,
		buttons:{
			"Cari": function() {
				var search_name = $("#name_ibu").val();				
				$.ajax({
					url: "kependudukan/penduduk.php",
					type: "get",
					data: {
						q : 3,
						ortu: "ibu",
						nama: search_name						
					},
					dataType : 'json',
					cache: false,
					success: function(data, status) {
						$("#hasil_search_ibu").html(data.nama);		
						$("#nik_ibu").val(data.nik);												
					}
				});
								
			},
			"Tutup" : function() {
				$(this).dialog("close");
			}
		},
		close: function() {
			$("#hasil_search_ibu").html("");
			$("#name_ibu").val("");
		}
	});

	$("#save").click(function(event){
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
				penduduk_id : $("#penduduk_id").val()
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
});
