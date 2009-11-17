<?php
session_start();
include_once "../includes/helpers.inc.php";

if(isset($_POST['oper']))
{
    $connection = MysqlManager::get_connection();
    if($_POST['oper'] == 'edit')
    {               
        $id = $_POST['id'];
        $kec_id = $_POST['kecamatan_id'];
        $nama_kelurahan = $_POST['nama_kelurahan'];
        $lurah = $_POST['lurah'];
        
        $sql = "update kelurahan set lurah = '$lurah', nama_kelurahan = '$nama_kelurahan',
            kecamatan_id = $kec_id where id=$id";
       
        $result = $connection->query($sql); //mysqli_query($link, $sql);
        check_error($connection);
    } elseif($_POST['oper'] == 'del')
    {
        
        $id = $_POST['id'];
        $sql = "delete from kelurahan where id=$id";
       
        $result = $connection->query($sql); //mysqli_query($link, $sql);
        check_error($connection);
    } elseif($_POST['oper'] == 'add')
    {       
        $lurah = $_POST['lurah'];
        $nama_kelurahan = $_POST['nama_kelurahan'];
        $kecamatan_id  = $_POST['kecamatan_id'];
        
        $sql = "insert into kelurahan set lurah = '$lurah', nama_kelurahan = '$nama_kelurahan',
            kecamatan_id = '$kecamatan_id'";
        
        $result = $connection->query($sql);// mysqli_query($link, $sql);
        check_error($connection);
    }
}
elseif(isset($_GET['q']))
{    
    $resp = "";
    $req = $_GET['q'];
    $connection = MysqlManager::get_connection(); 
     switch($req)
     {
         case 1:// request data agama
            $page = $_GET['page'];
            $limit = $_GET['rows'];
            $sord = $_GET['sord'];
            $sidx = $_GET['sidx'];
            $total_pages = '';
            if(!$sidx)
                $sidx = 1;
            
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
            $result = $connection->query($sql);
			check_error($connection);
            $row = $result->fetch_object();
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
           
           $result = $connection->query($sql);// mysqli_query($link, $sql);
           check_error($connection);
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
           
           echo json_encode($resp);
           break;
        case 2:            
            // getting kelurahan id based on kecamatan
            if(!isset($_SESSION['region']))
            {
                echo "error, authorized failure. you should login first...";
                exit();
            }
            $kecamatan_id = $_SESSION['region'];
            $add = array();
            if($kecamatan_id <=0 ){
                $add = get_capil_kua_key();
            }          
           
            echo select("kelurahan", "id", "nama_kelurahan","kecamatan_id",
                "class='select ui-widget-content ui-corner-all'", "kecamatan_id=$kecamatan_id",1, $add);
        break;
     }
    MysqlManager::close_connection($connection);
}
?>
