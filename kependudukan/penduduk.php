<?php
if(isset($_REQUEST['q']))
{
    $request_type = $_REQUEST['q'];
    switch($request_type)
    {
        case 1:
            include '../includes/db.inc.php';
            
            // get list of keluarga based on kartu keluarga
            $kk_id = $_REQUEST['keluarga_id'];
            $search = $_REQUEST['_search'];
            $page = $_REQUEST['page'];
            $rows = $_REQUEST['rows'];
            $order_column = $_REQUEST['sidx'];
            $order = $_REQUEST['sord'];
            
            $count_query = "select count(*) as count from penduduk where keluarga_id = $kk_id";
            
            $result = mysqli_query($link, $count_query);            
            if(!$result)
            {
                $error = "cannot counting penduduk which keluarga_id = $kk_id";
                include "../includes/error.html.php";
                exit();
            }
            $row = mysqli_fetch_array($result);
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

            $sql = "SELECT id, nik, nama, jenis_kelamin, status_nikah, status_hub_kel FROM penduduk where keluarga_id = $kk_id order by $order_column $order limit $start, $rows";
            // XXX - sementara abaikan filter data
            $resp = "";
            $resp->page = $page;
            $resp->total = $total_pages;
            $resp->records = $count;

            $result = mysqli_query($link, $sql);
            if(!$result) {
                $error = "failed fetch data from penduduk with SQL:$sql";
                include "../includes/error.html.php";
                exit();
            }
            $i = 0;
            while($row = mysqli_fetch_array($result)){
                $resp->rows[$i]['id'] = $row['id'];
                $resp->rows[$i]['cell'] = array($row[id], $row[nik], $row[nama], $row[jenis_kelamin], $row[status_nikah], $row[status_hub_kel]);
                $i++;    
            }
            mysqli_close($link);
            echo json_encode($resp);
            break;
        case 2:
            if(isset($_REQUEST['id']))
            {
                $data_type = $_REQUEST['id'];
                switch($data_type)
                {
                    case "jenis_kelamin":
                        echo "<select><option value='Laki-laki'>Laki-laki</option><option value='Perempuan'>Perempuan</option></select>";
                        break;
                    case "golongan_darah":
                        echo "<select><option value='-'>-</option><option value='A'>A</option><option value='B'>B</option><option value='AB'>AB</option><option value='O'>O</option></select>";
                        break;
                    case "status_nikah":
                        include '../includes/helpers.inc.php';
                        echo select_enum_without_default_value("penduduk", "status_nikah", "class='select ui-widget-content ui-corner-all'");
                        break;
                    case "status_hub_kel":
                        include '../includes/helpers.inc.php';
                        echo select_enum_without_default_value("penduduk", "status_hub_kel", "class='select ui-widget-content ui-corner-all'");
                        break;
                }
            }
            break;
        default:
            echo "";
            break;
    }
}
?>
