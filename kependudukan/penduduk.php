<?php
session_start();
include_once "../includes/helpers.inc.php";

if(isset($_REQUEST['q']))
{
    $request_type = $_REQUEST['q'];
    switch($request_type)
    {
        case 1:
            $connection = MysqlManager::get_connection();
            
            // get list of keluarga based on kartu keluarga
            $kk_id = $_REQUEST['keluarga_id'];
            $search = $_REQUEST['_search'];
            $page = $_REQUEST['page'];
            $rows = $_REQUEST['rows'];
            $order_column = $_REQUEST['sidx'];
            $order = $_REQUEST['sord'];
            
            $count_query = "select count(*) as count from penduduk where keluarga_id = $kk_id";
            
            $result = $connection->query($count_query);            
            check_error($connection);
            $row = $result->fetch_array();
            $count = $row['count'];

            if($count > 0) {
                    $total_pages = ceil($count / $rows);
            } else {
                    $total_pages = 0;
            }
            if($page > $total_pages) 
                    $page = $total_pages;
            $start = $rows * $page - $rows;
            if($start < 0)
                    $start = 0;

            $sql = "SELECT p.id as id, p.nik as nik, p.nama as nama, p.jenis_kelamin as jenis_kelamin,
                p.status_nikah as status_nikah, p.status_hub_kel as status_hub_kel,
                p.gol_darah as gol_darah, p.tmp_lahir as tmp_lahir, p.tgl_lahir as tgl_lahir,
                a.agama as agama, pen.pendidikan as pendidikan, pek.pekerjaan as pekerjaan,
                p.wni as wni FROM penduduk p, agama a, pendidikan pen, pekerjaan pek where p.keluarga_id = $kk_id
                AND p.agama_id = a.id AND p.pendidikan_id = pen.id AND p.pekerjaan_id = pek.id
                order by $order_column $order limit $start, $rows";
            // XXX - sementara abaikan filter data
            $resp = "";
            $resp->page = $page;
            $resp->total = $total_pages;
            $resp->records = $count;

            $result = $connection->query($sql);
            check_error($connection);
            $i = 0;
            while($row = $result->fetch_array()){
                $resp->rows[$i]['id'] = $row['id'];
                $resp->rows[$i]['cell'] = array($row[id], $row[nik], $row[nama],
                    $row[jenis_kelamin], $row[status_nikah], $row[status_hub_kel],
                    $row[gol_darah], $row[tmp_lahir], $row[tgl_lahir], $row[agama],
                    $row[pendidikan], $row[pekerjaan], $row[wni]);
                $i++;    
            }
            MysqlManager::close_connection($connection);
            echo json_encode($resp);
            break;
        case 2:
            if(isset($_REQUEST['id']))
            {
                
                $data_type = $_REQUEST['id'];
                switch($data_type)
                {
                    case "jenis_kelamin":                        
                        echo select_enum_without_default_value("penduduk",
                            "jenis_kelamin","id='jenis_kelamin' class='ui-widget-content ui-corner-all'");
                        break;
                    case "gol_darah":
                        echo select_enum_without_default_value("penduduk",
                            "gol_darah","id='gol_darah' class='ui-widget-content ui-corner-all'");
                        break;
                    case "status_nikah":                        
                        echo select_enum_without_default_value("penduduk",
                            "status_nikah", "id='status_nikah' class='ui-widget-content ui-corner-all'");
                        break;
                    case "status_hub_kel":                        
                        echo select_enum_without_default_value("penduduk",
                            "status_hub_kel", "id='status_hub_keluarga' class='ui-widget-content ui-corner-all'");
                        break;
                    case "agama":                        
                        echo select("agama","id","agama", "agama",
                            "class='ui-widget-content ui-corner-all'");
                        break;
                    case "pendidikan":                        
                        echo select("pendidikan", "id", "pendidikan", "pendidikan",
                            "class='ui-widget-content ui-corner-all'");
                        break;
                    case "pekerjaan":                        
                        echo select("pekerjaan", "id","pekerjaan", "pekerjaan",
                            "class='ui-widget-content ui-corner-all'");
                        break;
                    case "warga_negara":                       
                        echo select_enum_without_default_value("penduduk", "wni",
                            "class='ui-widget-content ui-corner-all'");
                        break;
                }
            }
            break;
        case 3: // cari data ayah & ibu
            include "../includes/mysqli.inc.php";
            $nama = $_GET['nama'];
            $ortu = $_GET["ortu"];
            $result->nama ="nama ".$nama;
            $result->nik = "1234567";
            echo json_encode($result);
            break;
        
        default:
            echo "";
            break;
    }
}

if(isset($_POST['oper']))
{
    $conn = MysqlManager::get_connection();
    $operation = $_POST['oper'];
    switch($operation)
    {
        case "add":            
            $agama = $_POST['agama'];
            $gol_darah = $_POST['gol_darah'];
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $kk_id = $_POST['kk_id'];
            $nama = $_POST['nama'];
            $pekerjaan = $_POST['pekerjaan'];
            $pendidikan = $_POST['pendidikan'];
            $status_hub_kel = $_POST['status_hub_kel'];
            $status_nikah = $_POST['status_nikah'];
            $tgl_lahir = $_POST['tgl_lahir'];
            $tempat_lahir = $_POST['tmp_lahir'];
            $kewarganegaraan = $_POST['warga'];
            $kecamatan_id = $_SESSION['kecamatan_id'];
            // calculate nik first.
            $laki = $jenis_kelamin == 'Perempuan' ? false : true;
            $nik = nik($kecamatan_id, $tgl_lahir, $laki);
            $sql = "insert into penduduk set nik = '$nik', nama = '$nama', status_hub_kel = '$status_hub_kel',
                tmp_lahir = '$tempat_lahir', tgl_lahir = '$tgl_lahir', pendidikan_id = $pendidikan,
                pekerjaan_id = $pekerjaan, gol_darah = '$gol_darah', agama_id = $agama,
                wni = '$kewarganegaraan', status_nikah = '$status_nikah', jenis_kelamin = '$jenis_kelamin',
                keluarga_id = $kk_id";
            $conn->query($sql);
            check_error($conn);
            MysqlManager::close_connection($conn);
            echo "ok";           
            break;
        case "edit":
            $id = $_POST['id'];
            $agama = $_POST['agama'];
            $gol_darah = $_POST['gol_darah'];
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $kk_id = $_POST['kk_id'];
            $nama = $_POST['nama'];
            $pekerjaan = $_POST['pekerjaan'];
            $pendidikan = $_POST['pendidikan'];
            $status_hub_kel = $_POST['status_hub_kel'];
            $status_nikah = $_POST['status_nikah'];
            $tgl_lahir = $_POST['tgl_lahir'];
            $tempat_lahir = $_POST['tmp_lahir'];
            $kewarganegaraan = $_POST['warga'];
            $kecamatan_id = $_SESSION['kecamatan_id'];
            // calculate nik first.
            $laki = $jenis_kelamin == 'Perempuan' ? false : true;
            $nik = nik($kecamatan_id, $tgl_lahir, $laki);
            $sql = "update penduduk set nik = '$nik', nama = '$nama', status_hub_kel = '$status_hub_kel',
                tmp_lahir = '$tempat_lahir', tgl_lahir = '$tgl_lahir', pendidikan_id = $pendidikan,
                pekerjaan_id = $pekerjaan, gol_darah = '$gol_darah', agama_id = $agama,
                wni = '$kewarganegaraan', status_nikah = '$status_nikah', jenis_kelamin = '$jenis_kelamin',
                keluarga_id = $kk_id where id = $id";
            $conn->query($sql);
            check_error($conn);
            MysqlManager::close_connection($conn);
            echo "ok";           
            break;
        case "del":
            $id = $_POST['id'];
            $sql = "delete from penduduk where id = $id";
            $conn->query($sql);
            check_error($conn);
            MysqlManager::close_connection($conn);
            echo "ok";
            break;
    }
}

?>
