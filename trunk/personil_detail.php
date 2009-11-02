<?php
include "dbconfig.php";

if(isset($_GET['q']))
{
    $q = $_GET['q'];
    switch($q)
    {
        case "1":
            $search = $_GET['_search'];
            $alamat_id = $_GET['alamat_id'];
            $page = $_GET['page'];
            $rows = $_GET['rows'];
            $sidx = $_GET['sidx'];
            $sord = $_GET['sord'];
            
            // get count
            $sql = "select count(*) as count from personil where alamat_id = $alamat_id";
            $result = $mysqli_connection->query($sql);
            $row = $result->fetch_object();
            $count = $row->count;
            
            if($count > 0)
            {
                $total_pages = ceil($count/$rows);                
            }
            else
            {
                $total_pages = 0;    
            }
            
            if($page > $total_pages)
                $page = $total_pages;
                
            $start = $rows * $page - $rows;
            if($start < 0)
                $start = 0;
                
            $sql = "select id, nama_personel from personil where alamat_id = $alamat_id
                order by $sidx $sord limit $start, $rows ";
           
            $result = $mysqli_connection->query($sql);
            check_error($mysqli_connection);
            $resp->page= $page;
            $resp->total = $total_pages;
            $resp->records = $count;
            $i = 0;
            while($row = $result->fetch_object())
            {
                $resp->rows[$i]['id'] = $row->id;
                $resp->rows[$i]['cell'] = array($row->id, $row->nama_personel);
                $i++;
            }
            echo json_encode($resp);
            $mysqli_connection->close();
            break;
        case "2":
            
            break;
    }
}
else if(isset($_POST['oper']))
{
    $oper = $_POST['oper'];
    $nama = $_POST['nama_personel'];
    switch($oper)
    {
        case "add":
            $alamat_id = $_POST['alamat_id'];
            $sql = "insert into personil set nama_personel = '$nama',
                alamat_id = $alamat_id";
            $result = $mysqli_connection->query($sql);
            check_error($mysqli_connection);
            $mysqli_connection->close();
            break;
        case "edit":
            $id = $_POST['id'];
            $sql = "update personil set nama_personel = '$nama' where id = $id";
            $result = $mysqli_connection->query($sql);
            check_error($mysqli_connection);
            $mysqli_connection->close();
            break;
        case "del":
            
            break;
    }
}
?>