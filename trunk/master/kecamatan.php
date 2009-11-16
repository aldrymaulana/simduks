<?php
include_once "../includes/helpers.inc.php";
if(isset($_POST['oper']))
{
    if($_POST['oper'] == 'edit')
    {        
        $kd_wilayah = $_POST['kd_wilayah'];
        $camat = $_POST['camat'];
        $kecamatan  = $_POST['nama_kecamatan'];
        $kodepos = $_POST['kodepos'];
        $id = $_POST['id'];
        $sql = "update kecamatan set kd_wilayah = '$kd_wilayah', camat = '$camat',
            nama_kecamatan = '$kecamatan', kodepos = '$kodepos' where id=$id";
        $conn = MysqlManager::get_connection();
        $result = $conn->query($sql);
        check_error($conn);
        MysqlManager::close_connection($conn);
    } elseif($_POST['oper'] == 'del')
    {        
        $id = $_POST['id'];
        $sql = "delete from kecamatan where id = $id";
        $conn = MysqlManager::get_connection();
        $result = $conn->query($sql);
        check_error($conn);
        MysqlManager::close_connection($conn);
    } elseif($_POST['oper'] == 'add')
    {        
        $kd_wilayah = $_POST['kd_wilayah'];
        $camat = $_POST['camat'];
        $kecamatan  = $_POST['nama_kecamatan'];
        $kodepos = $_POST['kodepos'];
        $sql = "insert into kecamatan set kd_wilayah = '$kd_wilayah', camat = '$camat',
            nama_kecamatan = '$kecamatan', kodepos = '$kodepos'";
        $conn = MysqlManager::get_connection();
        $result = $conn->query($conn);
        check_error($conn);
        MysqlManager::close_connection($conn);        
    }
}
elseif(isset($_GET['q']))
{
    
    $resp = "";
    $req = $_GET['q'];
    $page = $_GET['page'];
    $limit = $_GET['rows'];
    $sord = $_GET['sord'];
    $sidx = $_GET['sidx'];
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
    switch($req)
    {
        case 1:// request data agama
            // get total data
            $conn = MysqlManager::get_connection();
            $result = $conn->query("select count(*) as count from kecamatan");
            check_error($conn);
            $row = $result->fetch_array();
            $count = $row['count'];  
            
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
            if(sizeof($wh) > 2)
                $sql = "select id, kd_wilayah, camat, nama_kecamatan, kodepos from kecamatan where ".$wh." order by ".$sidx." ".$sord." limit ".$start.", ".$limit;
            else
                $sql = "select id, kd_wilayah, camat, nama_kecamatan, kodepos from kecamatan order by ".$sidx." ".$sord." limit ".$start.", ".$limit;
            
            $result = $conn->query($sql);
            check_error($conn);
            
            $resp->page =$page;
            $resp->total = $total_pages;
            $resp->records = $count;
            $i = 0;
            while($row = $result->fetch_object())
            {
                $resp->rows[$i]['id'] = $row->id;
                $resp->rows[$i]['cell'] = array($row->id, $row->kd_wilayah, $row->camat, $row->nama_kecamatan,$row->kodepos);
                $i++;
            }
            echo json_encode($resp);
            MysqlManager::close_connection($conn);
        break;
        case 2:
            $sql = "select id, nama_kecamatan from kecamatan";
            $conn = MysqlManager::get_connection();
            $result = $conn->query($sql);
            $ret = "<select>";
            while($row = $result->fetch_object())
            {
                $ret .= '<option value="'.$row->id.'">'.$row->nama_kecamatan.'</option>';
            }
            $ret .= '</select>';
            echo $ret;
            MysqlManager::close_connection($conn);
        break;
        case 3:
            $kec_id = $_REQUEST['id'];
            $conn = MysqlManager::get_connection();
            
            $result = $conn->query("select nama_kecamatan from kecamatan where id=$kec_id");
            $row = $result->fetch_object($result);
            echo $row->nama_kecamatan;
            MysqlManager::close_connection($conn);
            exit();
        break;
    }
    
}
?>