<?php
include "dbconfig.php";
if(isset($_POST['oper']))
{
    $oper = $_POST['oper'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    switch($oper)
    {
        case 'add':
            $sql = "insert into alamat set nama = '$nama', alamat = '$alamat'";
            $result = $mysqli_connection->query($sql);
            check_error($mysqli_connection);           
            $mysqli_connection->close();
            break;
        case 'edit':
            $id = $_POST['id'];
            $sql = "update alamat set nama = '$nama', alamat = '$alamat'
                where id = $id";
            $result = $mysqli_connection->query($sql);
            check_error($mysqli_connection);
            $mysqli_connection->close();
            break;
        case 'del':
            
            break;
    }
}
else if(isset($_GET['q']))
{
    $q = $_GET['q'];
    switch($q)
    {
        case "1":
            $search = $_GET['_search'];
            $page = $_GET['page'];
            $limit = $_GET['rows'];
            $sidx = $_GET['sidx'];
            $sord = $_GET['sord'];
            
            if(!$sidx)
                $sidx = 1;
            if(!$sord)
                $sord = "asc";
            if(!$limit)
                $limit = 10;
                
            $wh = "";
            $search = Strip($search);
            if($search == 'true')
            {
                $fld = Strip($_GET['searchField']);
                // TODO process nanti saja
            }
            $sql = "select count(*) as count from alamat";
            $result = $mysqli_connection->query($sql);
            check_error($mysqli_connection);
            $count = 0;
            if($result)
            {
                $row = $result->fetch_object();
                $count = $row->count;
            }
            if($count > 0)
                $total_pages = ceil($count / $limit);
            else
                $total_pages = 0;
                
            if($page > $total_pages )
                $page = $total_pages;
            
            $start = $limit * $page -$limit;
            if($start < 0)
                $start = 0;
                
            $sql = "select id, nama, alamat from alamat order by $sidx $sord limit
                $start, $limit";
           
            $resp = $mysqli_connection->query($sql);
            check_error($mysqli_connection);
            $responce->page = $page;
            $responce->total = $total_pages;
            $responce->records = $count;
            $i = 0;
            while($row = $resp->fetch_object())
            {
                $responce->rows[$i]['id'] = $row->id;
                $responce->rows[$i]['cell'] = array($row->id, $row->nama, $row->alamat);
                $i++;
            }
            echo json_encode($responce);
            $result->close();
            $mysqli_connection->close();
            break;
        case "2":
            
            break;
    }
}

function Strip($value)
{
	if(get_magic_quotes_gpc() != 0)
  	{
    	if(is_array($value))  
			if ( array_is_associative($value) )
			{
				foreach( $value as $k=>$v)
					$tmp_val[$k] = stripslashes($v);
				$value = $tmp_val; 
			}				
			else  
				for($j = 0; $j < sizeof($value); $j++)
        			$value[$j] = stripslashes($value[$j]);
		else
			$value = stripslashes($value);
	}
	return $value;
}
function array_is_associative ($array)
{
    if ( is_array($array) && ! empty($array) )
    {
        for ( $iterator = count($array) - 1; $iterator; $iterator-- )
        {
            if ( ! array_key_exists($iterator, $array) ) { return true; }
        }
        return ! array_key_exists(0, $array);
    }
    return false;
}
?>