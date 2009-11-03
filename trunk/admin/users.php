<?php
session_start();

if(isset($_GET['q'])) {
	

    $req = $_GET['q'];
    $page = $_GET['page'];
	$limit = $_GET['rows'];
	$sord = $_GET['sord'];
	$sidx = $_GET['sidx'];
	$group_id = $_GET['group_id'];
	if(!sidx) {
        $sidx = 1;
	}

    switch($req) {
        case 1:
			include_once "../includes/mysqli.inc.php";
			include_once "../includes/helpers.inc.php";
            $sql = "select count(*) as count from users where username not like 'admin'";
            $result =  $mysqli_connection->query($sql);
			check_error($mysqli_connection);
			$row = $result->fetch_object();
			$count = $row->count;
			if($count and $count > 0)
			{
			   $total_pages = ceil($count/$limit);
			}
			else 
			{
			    $total_pages = 0;
			}

			if($page > $total_pages)
			{
			    $page = $total_pages;
			}
			$start = $limit * $page - $limit;
			if($start < 0)
			{
                 $start = 0;
			}
			$sql = "select id ,username, password from users where group_id = $group_id";
			$result = $mysqli_connection->query($sql);
			check_error($mysqli_connection);
			$resp->page = $page;
			$resp->total = $total_pages;
			$resp->records = $count;
			$i = 0;
			while($row = $result->fetch_object())
			{
                $resp->rows[$i]['id'] = $row->id;
				$resp->rows[$i]['cell'] = array($row->id, $row->username, $row->password);
				$i++;
			}
			$mysqli_connection->close();
			echo json_encode($resp);
            break;
        case 2:
			include_once "../includes/helpers.inc.php";
			echo select('kecamatan', 'id', 'nama_kecamatan', "nama_kecamatan");
            break;
    }
}

if(isset($_POST['oper']))
{
	include "../includes/mysqli.inc.php";
	$oper = $_POST['oper'];
	switch($oper)
	{
		case "add":
			$username = $_POST['username'];
			$password = $_POST['password'];
			$group_id = $_POST['group_id'];
			$sql = "insert into users set username='$username', password=password('$password'), group_id = $group_id";
			$mysqli_connection->query($sql);
			check_error($mysqli_connection);
			$mysqli_connection->close();
			break;
		case "edit":
			$username = $_POST['username'];
			$password = $_POST['password'];
			$id = $_POST['id'];
			$sql = "update users set username = '$username', password = password('$password') where id = $id";
			$mysqli_connection->query($sql);
			check_error($mysqli_connection);
			$mysqli_connection->close();
			break;
		case "del":
			$id = $_POST['id'];
			$sql = "delete from users where id = $id";
			$mysqli_connection->query($sql);
			check_error($mysqli_connection);
			$mysqli_connection->close();
			break;
	}
}

if(isset($_POST['data'])) {
    $data_request = $_POST['data'];
    switch($data_request) {
        case 1:
        // already exist a user
            if(isset($_SESSION['user'])) {
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

            if(isset($_POST['username']) and isset($_POST['password'])) {
                $user = $_POST['username'];
                $pass = $_POST['password'];

                if(true == do_login($user, $pass)) {
                    $_SESSION['user'] = $user;
                    // adding session var with current user' kecamatan rights
					$_SESSION['kecamatan_id'] = get_kecamatan($user);
                    $resp = array('result'=>1, 'menu' => retrieve_admin_menus(), 'user'=> $user);
                    echo json_encode($resp);
                }
                else {
                    $resp = array('result' => -1, 'menu' => array(), 'user' => '');
                    echo json_encode($resp);
                }

            } else {
                $resp = array('result' => -1, 'menu' => array(), 'user' => '');
                echo json_encode($resp);
            }
            break;
        case 3: // processing log out information
            session_unregister('user');
			session_unregister('kecamatan_id');
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

function retrieve_admin_menus() {
    $menus = array();
    array_push($menus, '<li><a href="master/agama.html" class="ui-widget-content ui-state-default">Agama</a></li>');
    array_push($menus, '<li><a href="master/kb.html" class="ui-widget-content ui-state-default">Kb</a></li>');
    array_push($menus, '<li><a href="master/pekerjaan.html" class="ui-widget-content ui-state-default">Pekerjaan</a></li>');
    array_push($menus, '<li><a href="master/pendidikan.html" class="ui-widget-content ui-state-default">Pendidikan</a></li>');
    array_push($menus, '<li><a href="master/kecamatan.html" class="ui-widget-content ui-state-default">Kecamatan</a></li>');
    array_push($menus, '<li><a href="kependudukan/kartukeluarga.html" class="ui-widget-content ui-state-default">KK</a></li>');
    array_push($menus, '<li><a href="admin/users.html" class="ui-widget-content ui-state-default">Users</a></li>');
	array_push($menus, '<li><a href="report.html" class="ui-widget-content ui-state-default">Report</a></li>');
    return $menus;
}


function do_login($username, $password) {
    require_once "../includes/helpers.inc.php";
    return check_valid_user_password($username, $password) == 0 ? false: true;
}

function get_kecamatan($username)
{		
    require_once "../includes/helpers.inc.php";
	return get_kecamatan_from_username($username);
}
?>
