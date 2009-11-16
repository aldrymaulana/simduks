<?php
include_once '../includes/helpers.inc.php';
if(isset($_POST['oper']))
{
    if($_POST['oper'] == 'edit')
    {
        $conn = MysqlManager::get_connection();
        $kb = $_POST['kb'];
        $id = $_POST['id'];
        $sql = "update kb set kb = '$kb' where id=$id";
        $result = $conn->query($sql);
        check_error($conn);
        MysqlManager::close_connection($conn);
    } elseif($_POST['oper'] == 'del')
    {        
        $conn = MysqlManager::get_connection();
        $id = $_POST['id'];
        $sql = "delete from kb where id = $id";
        $result =$conn->query($sql);
        check_error($conn);
        MysqlManager::close_connection($conn);
    } elseif($_POST['oper'] == 'add')
    {
        $conn = MysqlManager::get_connection();
        $kb = $_POST['kb'];
        $sql = "insert into kb (kb) values ('$kb')";
        $result = $conn->query($sql);
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
            $result = $conn->query("select count(*) as count from kb");
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
                $sql = "select id, kb from kb where ".$wh." order by ".$sidx." ".$sord." limit ".$start.", ".$limit;
            else
                $sql = "select id, kb from kb order by ".$sidx." ".$sord." limit ".$start.", ".$limit;
            
            $result = $conn->query($sql);
            
            $resp->page =$page;
            $resp->total = $total_pages;
            $resp->records = $count;
            $i = 0;
            while($row = $result->fetch_object())
            {
                $resp->rows[$i]['id'] = $row->id;
                $resp->rows[$i]['cell'] = array($row->id, $row->kb);
                $i++;
            }
            MysqlManager::close_connection($conn);
            echo json_encode($resp);
        break;
        case 2:
    
        break;
    }
}
?>