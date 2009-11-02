<?php
if(isset($_POST['oper']))
{
    if($_POST['oper'] == 'edit')
    {
        include '../includes/db.inc.php';
        $pekerjaan = $_POST['pekerjaan'];
        $id = $_POST['id'];
        $sql = "update pekerjaan set pekerjaan = '$pekerjaan' where id=$id";
        $result = mysqli_query($link, $sql);
        if(!$result)
        {
            $error = "Error, cannot update pekerjaan ";
            include '../includes/error.html.php';
            exit();
        }        
    } elseif($_POST['oper'] == 'del')
    {
        include '../includes/db.inc.php';
        $id = $_POST['id'];
        $sql = "delete from pekerjaan where id = $id";
        $result = mysqli_query($link, $sql);
        if(!$result)
        {
            $error = "tidak dapat menghapus data pekerjaan ";
            include '../includes/error.html.php';
            exit();
        }
    } elseif($_POST['oper'] == 'add')
    {
        include '../includes/db.inc.php';
        $pekerjaan = $_POST['pekerjaan'];
        $sql = "insert into pekerjaan (pekerjaan) values ('$pekerjaan')";
        $result = mysqli_query($link, $sql);
        if(!$result)
        {
            $error = "tidak dapat menghapus data pekerjaan ";
            include '../includes/error.html.php';
            exit();
        }
    }
}
elseif(isset($_GET['q']))
{
    include '../includes/helpers.inc.php';
    include '../includes/db.inc.php';
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
       
        $result = mysqli_query($link, "select count(*) as count from pekerjaan");
        $row = mysqli_fetch_array($result);
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
            $sql = "select id, pekerjaan from pekerjaan where ".$wh." order by ".$sidx." ".$sord." limit ".$start.", ".$limit;
        else
            $sql = "select id, pekerjaan from pekerjaan order by ".$sidx." ".$sord." limit ".$start.", ".$limit;
        
        $result = mysqli_query($link, $sql);
        
        $resp->page =$page;
        $resp->total = $total_pages;
        $resp->records = $count;
        $i = 0;
        while($row = mysqli_fetch_array($result))
        {
            $resp->rows[$i]['id'] = $row[id];
            $resp->rows[$i]['cell'] = array($row[id], $row[pekerjaan]);
            $i++;
        }
        mysqli_close($link);
        break;
        case 2:
    
        break;
    }
    echo json_encode($resp);
    exit();
}
?>