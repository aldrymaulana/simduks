var gridimgpath = '../themes/base/images';

jQuery(document).ready(function(){
	$('#loading').ajaxStart(function(){
                    $(this).fadeIn();                    
                }).ajaxStop(function(){
                    $(this).fadeOut();                    
                });
	
    $('#login').click(function(event) {
		//check confirmation from server to determine if current uses is already login/log out.
		$.ajax({
			url: "admin/users.php",
			type: "POST",
			data: {data: 1},
			dataType: 'json',
			success: showform
		});		
		event.preventDefault();
	})
	.hover(
		function(){ 
			$(this).addClass("ui-state-hover"); 
		},
		function(){ 
			$(this).removeClass("ui-state-hover"); 
		}
	).mousedown(function(){
		$(this).addClass("ui-state-active"); 
	})
	.mouseup(function(){
		$(this).removeClass("ui-state-active");
	});
	
	/*
	 *  determine which form data should be displayed to user
	 */
	function showform(data, status)
	{
		// -- user is already login		
		if(parseInt(data.result) > 0) {
			$('#logoutform').dialog('open');
		} else {
			$("#loginform").dialog('open');
		}
	}
	
	
	
	$("#loginform").dialog({
		bgiframe: true,
		autoOpen: false,
		modal: true,
		buttons:{
			"Login": function() {
				$.ajax({
					url: "admin/users.php",
					type: "POST",
					data: {
							data : 2,
							username: $("#name").val(),
							password: $("#password").val()
					},
					dataType : 'json',
					cache: false,
					success: function(data, status) {
						var is_valid = parseInt(data.result) == 1;
						if(is_valid) {							
							$("#login").text("Logout (" + data.user + ")");
							
							for(var index = 0; index < data.menu.length; index++) {
								$("#main-menu").append(data.menu[index]);
							}
							add_menu_effect();
							$("#loginform").dialog('close');
							
						} else {
							// TODO : show error value..
						}						
					}
				});
								
			},
			Cancel : function() {
				$(this).dialog("close");
			}
		},
		close: function() {
			
		}
	});
	
	$("#logoutform").dialog({
		bgiframe: true,
		autoOpen: false,
		modal: true,
		buttons: {
			Cancel: function() {
				$(this).dialog('close');
			},
			"Log Out": function() {
				$.ajax({
					url : "admin/users.php",
					type: "POST",
					data: {
						data: 3
					},
					success: function(data, status) {
						$("#main").text("");
						$("#login").text("Login");
						$("#main-menu ul li").each(function(index){							
							if(index > 1) {
								$(this).remove();
							}
						});
						$("#logoutform").dialog('close');
						top.location ="index.html";
					}
				});
				
			}
		},
		close: function() {
		
		}
	});
	
	function side_menu(){
		$("#side-menu li a").click(function(event){
			event.preventDefault();
			
			$.ajax({
				url : $(this).attr("href"),
				data : "get",
				dataType : "html",
				success: function(data, status){
					$("#main").html("");
					$("#main").append(data);
				}
			});
			
		});
	}
	
	function add_menu_effect() {
		$("#main-menu li a").hover(
			function() {
				$(this).addClass("ui-state-hover");
			},
			function() {
				$(this).removeClass("ui-state-hover");
			}
		).click(function(event) {
			
			var href = $(this).attr("href");
			
			if(href == "index.html") {
				top.location = href;
				return;
			}
			
			if(href != "login"){							
				$("#main").html("");								
				$.ajax({
					url: href,
					data: "get",
					data: {},
					dataType: "html",
					success: function(data, status) {
						$("#main").append(data);
					} 
				});					
			}
			event.preventDefault();
			
			
		}).mousedown(function(){
			$(this).addClass('ui-state-active');
		}).mouseup(function(){
			$(this).removeClass('ui-state-active');
		});
	}
	
	//when refresh button is pressed
	$.ajax({
		url: "admin/users.php",
		type: "POST",
		data: {
			data: 4
		},
		dataType: 'json',
		success : function(data, status) {
			if(data.menu !='') {
				for(var index = 0; index < data.menu.length; index++) {
					$("#main-menu").append(data.menu[index]);
				}				
				add_menu_effect()
			}
			
			if(data.user != '') {
				$("#login").text("logout (" + data.user + ")");
			}
		}
	});
	
	side_menu();
});