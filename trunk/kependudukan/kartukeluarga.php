<?php
function get_alamat_id($sql)
{
    if(strlen($sql) == 0){
        return "";
    }
    
    include '../includes/db.inc.php';
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);
    mysqli_close($link);
    return $row['id'];
}

if(isset($_POST['oper']))
{
    if($_POST['oper'] == 'edit')
    {
        include '../includes/db.inc.php';
        $alamat = $_POST['alamat'];
        $id = $_POST['id'];
        $kelurahan_id  = $_POST['kelurahan_id'];
        $kode_keluarga = $_POST['kode_keluarga'];
        $no_formulir = $_POST['no_formulir'];
        $rt = $_POST['rukun_tetangga'];
        $rw = $_POST['rukun_warga'];
        
        //find existing alamt
        $find_existingalamat = "select alamat_id as id from keluarga where id = $id";
        $existing_alamatid = get_alamat_id($find_existingalamat);
        
        //check alamat in post attribute.
        $find_alamat = "select id from alamat where alamat='$alamat' and rukun_tetangga = $rt and rukun_warga=$rw and kelurahan_id = $kelurahan_id ";
        $alamatid = get_alamat_id($find_alamat);
        if(strlen($alamatid) > 0){
            //alamat already exist, and not match with existing alamat id      
            if($existing_alamatid != $alamatid){
                // XXX should be handled by change alamat form
                $existing_alamatid = $alamatid;
            }
        } else {
            // no current alamat exist
            // update existing alamat id with new values
            $update_alamat = "update alamat set alamat = '$alamat', rukun_tetangga = $rt, rukun_warga = $rw, kelurahan_id = $kelurahan_id where id = $existing_alamatid";
           
            $result = mysqli_query($link, $update_alamat);
            if(!$result) {
                $error = "error updating alamat ...";
                include "../includes/error.html.php";
                exit();
            }             
        }
        
        // update keluarga
        $sql = "update keluarga set kode_keluarga = '$kode_keluarga', no_formulir = '$no_formulir',
            alamat_id = $existing_alamatid where id = $id";
        
        $result = mysqli_query($link, $sql);
        if(!$result)
        {
            $error = "Error, cannot update keluarga ";
            include '../includes/error.html.php';
            exit();
        }  
             
    } elseif($_POST['oper'] == 'del')
    {
        include '../includes/db.inc.php';
        $id = $_POST['id'];
        $sql = "delete from keluarga where id = $id";
        $result = mysqli_query($link, $sql);
        if(!$result)
        {
            $error = "tidak dapat menghapus data kecamatan ";
            include '../includes/error.html.php';
            exit();
        }
    } elseif($_POST['oper'] == 'add')
    {
        include '../includes/db.inc.php';
        $alamat = $_POST['alamat'];
        $rt = $_POST['rukun_tetangga'];
        $rw  = $_POST['rukun_warga'];
        $kelurahan_id = $_POST['kelurahan_id'];
        $kode_keluarga = $_POST['kode_keluarga'];
        $no_formulir = $_POST['no_formulir'];
        // check alamat first
        // if exist get it's id otherwise create new alamat records
        $find_alamat = "select id from alamat where alamat='$alamat' and rukun_tetangga = $rt and rukun_warga=$rw and kelurahan_id = $kelurahan_id ";
        
        $alamatid = get_alamat_id($find_alamat);
        if(strlen($alamatid) == 0){
            $insert_alamat = "insert into alamat set alamat = '$alamat', rukun_tetangga = $rt, rukun_warga = $rw, kelurahan_id = $kelurahan_id";
            $result = mysqli_query($link, $insert_alamat);
            if(!$result)
            {
                $error = "tidak dapat menambah alamat ";
                include '../includes/error.html.php';
                exit();
            }
            $alamatid = get_alamat_id($find_alamat);
        }
        // insert data keluarga
        $sql = "insert into keluarga set kode_keluarga = '$kode_keluarga', alamat_id = $alamatid, no_formulir = '$no_formulir'";
                
        $result = mysqli_query($link, $sql);
        if(!$result)
        {
            $error = "tidak dapat menambah keluarga ";
            include '../includes/error.html.php';
            exit();
        }
        mysqli_close($link);
        echo "success";
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
     // TODO:
     // get count of kk from a kecamatan
     // SELECT count(*) as count from keluarga kk WHERE kk.alamat_id IN (select al.id from alamat al where al.kelurahan_id in (select id from kelurahan kel where kel.kecamatan_id = 4));
    // -- LIST keluarga in kecamatan
    // select kk.id, kk.kode_keluarga, kk.no_formulir, al.alamat, al.rukun_tetangga, al.rukun_warga from keluarga kk, alamat al where kk.alamat_id = al.id and al.kelurahan_id in (select id from kelurahan where kecamatan_id = 4);
     switch($req)
     {
         case 1:// request data agama
            // get total data
            /*
            $kec_id = $_SESSION['kecamatan_id']; // The value kecamatan_id is set when user process login            
            */
            $kec_id = 5;
            $sql = "SELECT count(*) as count FROM keluarga k WHERE k.alamat_id IN (SELECT id FROM alamat a WHERE a.kelurahan_id IN (SELECT id FROM kelurahan kel WHERE kel.kecamatan_id = $kec_id ))";
            
            $result = mysqli_query($link, $sql);
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
            // TODO: 
            // perbaiki query .. optimize it.            
            if(!isset($kec_id))
            {
                if(sizeof($wh) > 2)
                    $sql = "select k.id, k.kode_keluarga, k.no_formulir, a.alamat, a.rukun_tetangga, a.rukun_warga, kel.nama_kelurahan from keluarga k, alamat a, kelurahan kel where k.alamat_id = a.id and a.kelurahan_id = kel.id and kel.kecamatan_id = $kec_id and $wh order by $sidx $sord limit $start, $limit";
                else
                    $sql = "select k.id, k.kode_keluarga, k.no_formulir, a.alamat, a.rukun_tetangga, a.rukun_warga, kel.nama_kelurahan from keluarga k, alamat a, kelurahan kel where k.alamat_id = a.id and a.kelurahan_id = kel.id and kel.kecamatan_id = $kec_id  order by $sidx $sord limit $start, $limit";
            }
            else
            {
                if(sizeof($wh) > 2)
                    $sql = "select k.id, k.kode_keluarga, k.no_formulir, a.alamat, a.rukun_tetangga, a.rukun_warga, kel.nama_kelurahan from keluarga k, alamat a, kelurahan kel where k.alamat_id = a.id and a.kelurahan_id = kel.id and kel.kecamatan_id = $kec_id and $wh order by $sidx $sord limit $start, $limit";
                else
                    $sql = "select k.id, k.kode_keluarga, k.no_formulir, a.alamat, a.rukun_tetangga, a.rukun_warga, kel.nama_kelurahan from keluarga k, alamat a, kelurahan kel where k.alamat_id = a.id and a.kelurahan_id = kel.id and kel.kecamatan_id = $kec_id  order by $sidx $sord limit $start, $limit";
            }
           //
           //echo $sql;
           //exit();
           $result = mysqli_query($link, $sql);
           $resp->page =$page;
           $resp->total = $total_pages;
           $resp->records = $count;
           $i = 0;
           while($row = mysqli_fetch_array($result))
           {
               $resp->rows[$i]['id'] = $row[id];
               $resp->rows[$i]['cell'] = array($row[id], $row[kode_keluarga], $row[no_formulir], $row[alamat], $row[rukun_tetangga], $row[rukun_warga], $row[nama_kelurahan]);
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