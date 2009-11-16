<?php
session_start();
include_once '../includes/helpers.inc.php';
function get_alamat_id($sql)
{
    if(strlen($sql) == 0){
        return "";
    }
    $conn = MysqlManager::get_connection();    
    $result = $conn->query($sql);
    $row = $result->fetch_array();
    MysqlManager::close_connection($conn);
    return $row['id'];
}

if(isset($_POST['oper']))
{
    if($_POST['oper'] == 'edit')
    {
        $conn = MysqlManager::get_connection();
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
           
            $result = $conn->query($update_alamat);
            
            if(!$result) {
                $error = "error updating alamat ...";
                include "../includes/error.html.php";
                exit();
            }             
        }
        
        // update keluarga
        $sql = "update keluarga set kode_keluarga = '$kode_keluarga', no_formulir = '$no_formulir',
            alamat_id = $existing_alamatid where id = $id";
        
        $result = $conn->query( $sql);
        check_error($conn);
        MysqlManager::close_connection($conn);    
    } elseif($_POST['oper'] == 'del')
    {
        $connection = MysqlManager::get_connection();
        $id = $_POST['id'];
        $sql = "delete from keluarga where id = $id";
        $result = $connection->query( $sql);
        check_error($connection);
        MysqlManager::close_connection($connection);
    } elseif($_POST['oper'] == 'add')
    {
        $connection = MysqlManager::get_connection();
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
            $result = $connection->query($insert_alamat);
            check_error($connection);
            $alamatid = get_alamat_id($find_alamat);
        }
        // insert data keluarga
        $sql = "insert into keluarga set kode_keluarga = '$kode_keluarga', alamat_id = $alamatid, no_formulir = '$no_formulir'";
                
        $result = $connection->query($sql);
        check_error($connection);
        MysqlManager::close_connection($connection);
        echo "success";
    } elseif($_POST['oper'] == 'pecahkartukeluarga'){
        $connection = MysqlManager::get_connection();
        $pindah_alamat = $_POST['gunakan_alamat_baru'];
       
        $penduduk_id = $_POST['penduduk_id'];
        $kode_keluarga = $_POST["kode_kk"];
        $no_formulir = $_POST['no_formulir'];
        $alamat_id = "";
        $status_hub_kel = $_POST['status_hub_kel_baru'];
        
        if($pindah_alamat == "true"){
            // insert new alamat
            // find alamat first if exist use it
            $alamat = $_POST['alamat_baru'];
            $rt = $_POST["rt_baru"];
            $rw = $_POST["rw_baru"];
            $kelurahan_id = $_POST["desa_baru"];
            $sql = "select count(*) as count from alamat where alamat='$alamat'
                and rukun_tetangga = $rt and rukun_warga = $rw and kelurahan_id = $kelurahan_id";
            $result = $connection->query($sql);
            check_error($connection);
            $row = $result->fetch_object();
            if($row->count <= 0){
                // insert new alamat
                $sql = "insert into alamat set alamat = '$alamat', rukun_tetangga = $rt, rukun_warga = $rw,
                    keluarga_id = $keluarga_id";
                $result = $connection->query($sql);
            }
            $sql = "select id from alamat where alamat='$alamat'
            and rukun_tetangga = $rt and rukun_warga = $rw and kelurahan_id = $kelurahan_id";
            $alamat_id = get_alamat_id($sql);
        } else {
            $sql = "select al.id as id from alamat al, penduduk p, keluarga k where
                p.keluarga_id = k.id and k.alamat_id = al.id and p.id = $penduduk_id";
            $alamat_id = get_alamat_id($sql);
        }
        // 
        $sql = "insert into keluarga set kode_keluarga = '$kode_keluarga', alamat_id = $alamat_id, no_formulir = '$no_formulir'";
        $result = $connection->query($sql);
        check_error($connection);
        //update penduduk (kepala keluarga)
        $sql = "select id from keluarga where kode_keluarga = '$kode_keluarga' and alamat_id = $alamat_id and no_formulir = '$no_formulir'";
        $result = $connection->query($sql);
        check_error($connection);
        $row = $result->fetch_object();        
        $new_kode_keluarga = $row->id;
        $sql = "update penduduk set keluarga_id = $new_kode_keluarga, status_hub_kel = '$status_hub_kel' where id = $penduduk_id";
        $result = $connection->query($sql);
        check_error($connection);
        MysqlManager::close_connection($connection);
        echo json_encode("sukses");
    }
}
elseif(isset($_GET['q']))
{
    $connection = MysqlManager::get_connection();    
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
         case 1:// request data penduduk
            // get total data
            
            $kec_id = $_SESSION['kecamatan_id']; // The value kecamatan_id is set when user process login 
            
            $sql = "SELECT count(*) as count FROM keluarga k WHERE k.alamat_id IN (SELECT id FROM alamat a WHERE a.kelurahan_id IN (SELECT id FROM kelurahan kel WHERE kel.kecamatan_id = $kec_id ))";
            
            $result = $connection->query($sql);
            check_error($connection);
            $row = $result->fetch_object();
            $count = $row->count;
            
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
            if(sizeof($wh) > 2)
                $sql = "select k.id, k.kode_keluarga, k.no_formulir, a.alamat, a.rukun_tetangga, a.rukun_warga, kel.nama_kelurahan from keluarga k, alamat a, kelurahan kel where k.alamat_id = a.id and a.kelurahan_id = kel.id and kel.kecamatan_id = $kec_id and $wh order by $sidx $sord limit $start, $limit";
            else
                $sql = "select k.id, k.kode_keluarga, k.no_formulir, a.alamat, a.rukun_tetangga, a.rukun_warga, kel.nama_kelurahan from keluarga k, alamat a, kelurahan kel where k.alamat_id = a.id and a.kelurahan_id = kel.id and kel.kecamatan_id = $kec_id  order by $sidx $sord limit $start, $limit";
            
           //
          
           //exit();
           $result = $connection->query($sql);
           check_error($connection);
           $resp->page =$page;
           $resp->total = $total_pages;
           $resp->records = $count;
           $i = 0;
           while($row = $result->fetch_object())
           {
               $resp->rows[$i]['id'] = $row->id;
               $resp->rows[$i]['cell'] = array($row->id, $row->kode_keluarga, $row->no_formulir, $row->alamat, $row->rukun_tetangga, $row->rukun_warga, $row->nama_kelurahan);
               $i++;            
           }
           
           echo json_encode($resp);
        break;
        case 2:
            
            
        break;
     }   
    MysqlManager::close_connection($connection);
}
?>