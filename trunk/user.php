<?php
session_start();
if(isset($_POST['data'])){
	$data_request = $_POST['data'];	
	switch($data_request){
		case 1:
			// already exist a user
			if(isset($_SESSION['user'])){
				$menus = retrieve_admin_menus();
				$user = $_SESSION['user'];
				$resp = array('result'=>1, 'menu' => $menus, 'user' => $user);
				echo json_encode($resp);
			} else { // no user exist in session
				$resp = array('result'=>-1, 'menu' => '');
				echo json_encode($resp);
			}
			break;
		case 2: // processing login information
			if(isset($_POST['username'])) {
				$user = $_POST['username'];
				$_SESSION['user'] = $user;
				$resp = array('result'=>1, 'menu' => retrieve_admin_menus(), 'user'=> $user);
				echo json_encode($resp);
			} else {
				$resp = array('result' => -1, 'menu' => array(), 'user' => '');
				echo json_encode($resp);
			}
			break;
		case 3: // processing log out information			
			session_unregister('user');
			break;
		case 4: // getting menus after user already login			
			if(isset($_SESSION['user'])) {
				$user = $_SESSION['user'];
				$resp = array('menu' => retrieve_admin_menus(), 'user' => $user);
				echo json_encode($resp);
			} else {
				$resp = array('menu' => '', 'user'=>'');
				echo json_encode($resp);
			}
			break;
		default:
			echo "-1";
			break;
	}
}

function retrieve_admin_menus()
{
	$menus = array();
	array_push($menus, '<li><a href="text-styles.php" class="ui-widget-content ui-state-default">Text Styles</a></li>');
	array_push($menus, '<li><a href="masterex.php" class="ui-widget-content ui-state-default">Master</a></li>');
	array_push($menus, '<li><a href="celledit.php" class="ui-widget-content ui-state-default">Cell</a></li>');
	array_push($menus, '<li><a href="personil.html" class="ui-widget-content ui-state-default">Personil</a></li>');
	return $menus;
}
?>