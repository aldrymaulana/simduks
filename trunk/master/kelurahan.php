<?php
session_start();

if(isset($_POST['oper']))
{
    if($_POST['oper'] == 'edit')
    {
        include '../includes/mysqli.inc.php';        
        $id = $_POST['id'];
        $kec_id = $_POST['kecamatan_id'];
        $nama_kelurahan = $_POST['nama_kelurahan'];
        $lurah = $_POST['lurah'];
        
        $sql = "update kelurahan set lurah = '$lurah', nama_kelurahan = '$nama_kelurahan',
            kecamatan_id = $kec_id where id=$id";
       
        $result = $mysqli_connection->query($sql); //mysqli_query($link, $sql);
        if(!$result)
        {
            $error = "Error, cannot update kelurahan ".mysqli_connect_error();
            include '../includes/error.html.php';
            exit();
        }
        $mysqli_connection->close(); //mysqli_close($link);
    } elseif($_POST['oper'] == 'del')
    {
        include '../includes/mysqli.inc.php';
        $id = $_POST['id'];
        $sql = "delete from kelurahan where id=$id";
       
        $result = $mysqli_connection->query($sql); //mysqli_query($link, $sql);
        check_error($mysqli_connection);
        
        $mysqli_connection->close(); //mysqli_close($link);
    } elseif($_POST['oper'] == 'add')
    {
        include '../includes/mysqli.inc.php';
        $lurah = $_POST['lurah'];
        $nama_kelurahan = $_POST['nama_kelurahan'];
        $kecamatan_id  = $_POST['kecamatan_id'];
        
        $sql = "insert into kelurahan set lurah = '$lurah', nama_kelurahan = '$nama_kelurahan',
            kecamatan_id = '$kecamatan_id'";
        
        $result = $mysqli_connection->query($sql);// mysqli_query($link, $sql);
        if(!$result)
        {
            $error = "tidak dapat menambah kelurahan ".mysqli_connect_error();
            include '../includes/error.html.php';
            exit();
        }
        $mysqli_connection->close(); //mysqli_close($link);
    }
}
elseif(isset($_GET['q']))
{
    include '../includes/helpers.inc.php';
    $resp = "";
    $req = $_GET['q'];
    $page = $_GET['page'];
    $limit = $_GET['rows'];
    $sord = $_GET['sord'];
    $sidx = $_GET['sidx'];
    $total_pages = '';
    if(!$sidx)
        $sidx = 1;
        /*
    $kecamatan_id = $_GET['kecamatan_id'];
    if(0 == $kecamatan_id)
    {
        echo json_encode($resp);
        exit();
    }*/
    $wh = "";
     $searchOn = Strip($_REQUEST['_search']);
     if($searchOn=='true') {
         $fld = Strip($_REQUEST['searchField']);
         if( $fld=='id' || $fld =='invdate' || $fld=='name' || $fld=='amount' || $fld=='tax' || $fld=='total' || $fld=='note' ) {
             $fldata = Strip($_REQUEST['searchString']);
             $foper = Strip($_REQUEST['searchOper']);
             // costruct where
             $wh .= " AND ".$fld;
             switch ($foper) {
                 case "bw":
                     $fldata .= "%";
                     $wh .= " LIKE '".$fldata."'";
                     break;
                 case "eq":
                     if(is_numeric($fldata)) {
                             $wh .= " = ".$fldata;
                     } else {
                             $wh .= " = '".$fldata."'";
                     }
                     break;
                 case "ne":
                     if(is_numeric($fldata)) {
                             $wh .= " <> ".$fldata;
                     } else {
                             $wh .= " <> '".$fldata."'";
                     }
                     break;
                 case "lt":
                     if(is_numeric($fldata)) {
                             $wh .= " < ".$fldata;
                     } else {
                             $wh .= " < '".$fldata."'";
                     }
                     break;
                 case "le":
                     if(is_numeric($fldata)) {
                             $wh .= " <= ".$fldata;
                     } else {
                             $wh .= " <= '".$fldata."'";
                     }
                     break;
                 case "gt":
                     if(is_numeric($fldata)) {
                             $wh .= " > ".$fldata;
                     } else {
                             $wh .= " > '".$fldata."'";
                     }
                     break;
                 case "ge":
                     if(is_numeric($fldata)) {
                             $wh .= " >= ".$fldata;
                     } else {
                             $wh .= " >= '".$fldata."'";
                     }
                     break;
                 case "ew":
                     $wh .= " LIKE '%".$fldata."'";
                     break;
                 case "ew":
                     $wh .= " LIKE '%".$fldata."%'";
                     break;
                 default :
                     $wh = "";
             }
         }
     }
     
     include '../includes/mysqli.inc.php';
     switch($req)
     {
         case 1:// request data agama
            // get total data
            $kecamatan_id = $_GET['kecamatan_id'];
            if(!isset($_GET['kecamatan_id']))
            {
               $sql = "select count(*) as count from kelurahan";
            }
            else
            {
               $sql = "select count(*) as count from kelurahan where kecamatan_id = ".$_GET['kecamatan_id'];
            }
            $result = $mysqli_connection->query($sql);// mysqli_query($link, $sql);
			check_error($mysqli_connection);
            $row = $result->fetch_object();// mysqli_fetch_array($result);
            $count = $row->count;// $row['count'];  
            
            if($count > 0){
                $total_pages = ceil($count/$limit);
            }else{
                $total_pages = 0;
            }
            if($page > $total_pages)
                $page = $total_pages;
            $start = $limit * $page - $limit;
            if($start < 0)
                $start = 0;
            $sql = "";
            // TODO: 
            // perbaiki query .. optimize it.
            
            if(!isset($_GET['kecamatan_id']))
            {
                if(sizeof($wh) > 2)
                    $sql = "select kk.id, kk.lurah, kk.nama_kelurahan from kelurahan kk, kecamatan kec where ".$wh." order by ".$sidx." ".$sord." limit ".$start.", ".$limit;
                else
                    $sql = "select id, lurah, nama_kelurahan from kelurahan order by ".$sidx." ".$sord." limit ".$start.", ".$limit;
            }
            else
            {
                if(sizeof($wh) > 2)
                    $sql = "select kk.id, kk.lurah, kk.nama_kelurahan from kelurahan kk, kecamatan kec where kk.kecamatan_id = kec.id and kk.kecamatan_id =".$kecamatan_id.", ".$wh." order by ".$sidx." ".$sord." limit ".$start.", ".$limit;
                else
                    $sql = "select kk.id, kk.lurah, kk.nama_kelurahan from kelurahan kk, kecamatan kec where kk.kecamatan_id = kec.id and kk.kecamatan_id = ".$kecamatan_id." order by ".$sidx." ".$sord." limit ".$start.", ".$limit;
            }
           
           $result = $mysqli_connection->query($sql);// mysqli_query($link, $sql);
           check_error($mysqli_connection);
           $resp->page =$page;
           $resp->total = $total_pages;
           $resp->records = $count;
           $i = 0;
           while($row =  $result->fetch_object())
           {
               $resp->rows[$i]['id'] = $row->id;// $row[id];
               $resp->rows[$i]['cell'] = array($row->id, $row->lurah, $row->nama_kelurahan); //array($row[id], $row[lurah], $row[nama_kelurahan]);
               $i++;            
           }
           //mysqli_close($link);
           $mysqli_connection->close();
           echo json_encode($resp);
           break;
        case 2:            
            // getting kelurahan id based on kecamatan
            if(!isset($_SESSION['kecamatan_id']))
            {
                echo "error, authorized failure. you should login first...";
                exit();
            }
            $kecamatan_id = $_SESSION['kecamatan_id'];        
            $add = array();
            $add[] = array("key"=>"-5", "value"=>"Capil");
            $add[] = array("key"=>"-6", "value"=>"KUA");
            echo select("kelurahan", "id", "nama_kelurahan","kecamatan_id",
                "class='select ui-widget-content ui-corner-all'", "kecamatan_id=$kecamatan_id",1, $add);
        break;
     }
     
    
    exit();
}
?>
