<?php
session_start();
include_once "../includes/helpers.inc.php";

if(isset($_REQUEST['q']))
{
    $request_type = $_REQUEST['q'];
    switch($request_type)
    {
        case 1:
            $connection = MysqlManager::get_connection();
            
            // get list of keluarga based on kartu keluarga
            $kk_id = $_REQUEST['keluarga_id'];
            $search = $_REQUEST['_search'];
            $page = $_REQUEST['page'];
            $rows = $_REQUEST['rows'];
            $order_column = $_REQUEST['sidx'];
            $order = $_REQUEST['sord'];
            
            $count_query = "select count(*) as count from penduduk where keluarga_id = $kk_id";
            
            $result = $connection->query($count_query);            
            check_error($connection);
            $row = $result->fetch_array();
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

            $sql = "SELECT p.id as id, p.nik as nik, p.nama as nama, p.jenis_kelamin as jenis_kelamin,
                p.status_nikah as status_nikah, p.status_hub_kel as status_hub_kel,
                p.gol_darah as gol_darah, p.tmp_lahir as tmp_lahir, p.tgl_lahir as tgl_lahir,
                a.agama as agama, pen.pendidikan as pendidikan, pek.pekerjaan as pekerjaan,
                p.wni as wni FROM penduduk p, agama a, pendidikan pen, pekerjaan pek where p.keluarga_id = $kk_id
                AND p.agama_id = a.id AND p.pendidikan_id = pen.id AND p.pekerjaan_id = pek.id
                order by $order_column $order limit $start, $rows";
            
            // XXX - sementara abaikan filter data
            $resp = "";
            $resp->page = $page;
            $resp->total = $total_pages;
            $resp->records = $count;

            $result = $connection->query($sql);
            check_error($connection);
            $i = 0;
            while($row = $result->fetch_array()){               
                $resp->rows[$i]['id'] = $row['id'];
                $resp->rows[$i]['cell'] = array($row['id'], $row['nik'], $row['nama'],
                    $row['jenis_kelamin'], $row['status_nikah'], $row['status_hub_kel'],
                    $row['gol_darah'], $row['tmp_lahir'], $row['tgl_lahir'], $row['agama'],
                    $row['pendidikan'], $row['pekerjaan'], $row['wni']);
                $i++;    
            }
            MysqlManager::close_connection($connection);
            echo json_encode($resp);
            break;
        case 2:
            if(isset($_REQUEST['id']))
            {
                
                $data_type = $_REQUEST['id'];
                switch($data_type)
                {
                    case "jenis_kelamin":                        
                        echo select_enum_without_default_value("penduduk",
                            "jenis_kelamin","id='jenis_kelamin' class='ui-widget-content ui-corner-all'");
                        break;
                    case "gol_darah":
                        echo select_enum_without_default_value("penduduk",
                            "gol_darah","id='gol_darah' class='ui-widget-content ui-corner-all'");
                        break;
                    case "status_nikah":                        
                        echo select_enum_without_default_value("penduduk",
                            "status_nikah", "id='status_nikah' class='ui-widget-content ui-corner-all'");
                        break;
                    case "status_hub_kel":                        
                        echo select_enum_without_default_value("penduduk",
                            "status_hub_kel", "id='status_hub_keluarga' class='ui-widget-content ui-corner-all'");
                        break;
                    case "agama":                        
                        echo select("agama","id","agama", "agama",
                            "class='ui-widget-content ui-corner-all'");
                        break;
                    case "pendidikan":                        
                        echo select("pendidikan", "id", "pendidikan", "pendidikan",
                            "class='ui-widget-content ui-corner-all'");
                        break;
                    case "pekerjaan":                        
                        echo select("pekerjaan", "id","pekerjaan", "pekerjaan",
                            "class='ui-widget-content ui-corner-all'");
                        break;
                    case "warga_negara":                       
                        echo select_enum_without_default_value("penduduk", "wni",
                            "class='ui-widget-content ui-corner-all'");
                        break;
                    case "kecamatan":
                        echo select("kecamatan", "id", "nama_kecamatan","kecamatan_id","class='ui-widget-content ui-corner-all'");
                        break;
                }
            }
            break;
        case 3: // cari data ayah & ibu
           
            $nama = $_GET['nama'];
            $ortu = $_GET["ortu"];
            $result->nama ="nama ".$nama;
            $result->nik = "1234567";
            echo json_encode($result);
            break;
        case 4: // cari data penduduk
            $nik = $_GET['nik'];
            $connection = MysqlManager::get_connection();
            $sql = "SELECT p.id as id, p.nik as nik, p.nama as nama, p.jenis_kelamin as jenis_kelamin, p.photo as photo,
                p.status_nikah as status_nikah, p.gol_darah as gol_darah, p.tmp_lahir as tmp_lahir, p.tgl_lahir as tgl_lahir,
                a.agama as agama, pen.pendidikan as pendidikan, pek.pekerjaan as pekerjaan, p.keluarga_id as keluarga_id,
                p.wni as wni FROM penduduk p, agama a, pendidikan pen, pekerjaan pek where p.nik = '$nik' 
                AND p.agama_id = a.id AND p.pendidikan_id = pen.id AND p.pekerjaan_id = pek.id";
            $result = $connection->query($sql);
            check_error($connection);
            $row = $result->fetch_object();
            $resp = "";
            $resp->id = $row->id;
            $resp->nik = $row->nik;
            $resp->nama = $row->nama;
            $resp->keluarga_id = $row->keluarga_id;
            $resp->jenis_kelamin  = $row->jenis_kelamin;
            $resp->status_nikah = $row->status_nikah;            
            $resp->gol_darah = $row->gol_darah;
            $resp->tempat_lahir = $row->tmp_lahir;
            $resp->tgl_lahir = $row->tgl_lahir;
            $resp->agama = $row->agama;
            $resp->pendidikan = $row->pendidikan;
            $resp->pekerjaan = $row->pekerjaan;
            $resp->wni = $row->wni;
            $resp->photo = $row->photo;
            $keluarga_id = $row->keluarga_id;
            // check umur
            $umur = CalculateAge($row->tgl_lahir);
            $resp->umur = $umur;
            // find alamat
            $sql = "select alamat_id from keluarga where id = $keluarga_id";
            $result = $connection->query($sql);
            check_error($connection);
            $alamat_id = $result->fetch_object()->alamat_id;
            $sql = "select a.alamat as alamat, a.rukun_tetangga as rt, a.rukun_warga as rw,
                kel.nama_kelurahan as kelurahan, kec.nama_kecamatan as kecamatan, kec.kodepos as kodepos 
                from alamat a, kelurahan kel, kecamatan kec where a.id = $alamat_id and a.kelurahan_id = kel.id and
                kel.kecamatan_id = kec.id ";
            $result = $connection->query($sql);
            check_error($connection);
            $row = $result->fetch_object();
            $alamat = "";
            $alamat->alamat = $row->alamat;
            $alamat->rt = $row->rt;
            $alamat->rw = $row->rw;
            $alamat->kelurahan = $row->kelurahan;
            $alamat->kecamatan = $row->kecamatan;
            $alamat->kodepos = $row->kodepos;
            
            $resp->alamat = $alamat;
            echo json_encode($resp);
            MysqlManager::close_connection($connection);
            break;
        case 5: // get alamat
            $connection = MysqlManager::get_connection();
            $keluarga_id = $_GET['kk_id'];
            $sql = "select alamat_id from keluarga where id = $keluarga_id";
            $result = $connection->query($sql);
            
            check_error($connection);
            $alamat_id = $result->fetch_object()->alamat_id;
            $sql = "select a.alamat as alamat, a.rukun_tetangga as rt, a.rukun_warga as rw,
                kel.nama_kelurahan as kelurahan, kec.nama_kecamatan as kecamatan, kec.kodepos as kodepos 
                from alamat a, kelurahan kel, kecamatan kec where a.id = $alamat_id and a.kelurahan_id = kel.id and
                kel.kecamatan_id = kec.id ";
          
            $result = $connection->query($sql);
            check_error($connection);
            $row = $result->fetch_object();
            $alamat = "";
            $alamat->keluarga_id = $keluarga_id;
            $alamat->alamat = $row->alamat;
            $alamat->rt = $row->rt;
            $alamat->rw = $row->rw;
            $alamat->kelurahan = $row->kelurahan;
            $alamat->kecamatan = $row->kecamatan;
            $alamat->kodepos = $row->kodepos;
            echo json_encode($alamat);
            MysqlManager::close_connection($connection);
            break;
        case "6":
            echo "<li><label for='desa_baru' id='lbl_desa'>Desa/Kelurahan</label></li>";
            echo "<li><label for='kecamatan_baru'>Kecamatan</label>";
            echo select("kecamatan", "id", "nama_kecamatan","kecamatan_baru",'class="ui-widget-content ui-corner-all"');
            echo "</li>";		       
            break;
        case "7":            
            $kec_id = $_GET['kecamatan_id'];
            echo select("kelurahan", "id", "nama_kelurahan", "desa_baru",
                'class="wui-widget-content ui-corner-all"',
                "kecamatan_id = $kec_id");
            break;
        case "8":
            $kecamatan_id = $_GET['kecamatan_id'];
            $sql = "select kodepos from kecamatan where id = $kecamatan_id";
            $connection = MysqlManager::get_connection();
            $result = $connection->query($sql);
            check_error($connection);
            echo $result->fetch_object()->kodepos;
            MysqlManager::close_connection($connection);
            break;
        default:
            echo "";
            break;
    }
}

if(isset($_POST['oper']))
{
    $conn = MysqlManager::get_connection();
    $operation = $_POST['oper'];
    switch($operation)
    {
        case "add":            
            $agama = $_POST['agama'];
            $gol_darah = $_POST['gol_darah'];
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $kk_id = $_POST['kk_id'];
            $nama = $_POST['nama'];
            $pekerjaan = $_POST['pekerjaan'];
            $pendidikan = $_POST['pendidikan'];
            $status_hub_kel = $_POST['status_hub_kel'];
            $status_nikah = $_POST['status_nikah'];
            $tgl_lahir = $_POST['tgl_lahir'];
            $tempat_lahir = $_POST['tmp_lahir'];
            $kewarganegaraan = $_POST['warga'];
            $kecamatan_id = $_SESSION['kecamatan_id'];
            // calculate nik first.
            $laki = $jenis_kelamin == 'Perempuan' ? false : true;
            $nik = nik($kecamatan_id, $tgl_lahir, $laki);
            echo $nik;
            $sql = "insert into penduduk set nik = '$nik', nama = '$nama', status_hub_kel = '$status_hub_kel',
                tmp_lahir = '$tempat_lahir', tgl_lahir = '$tgl_lahir', pendidikan_id = $pendidikan,
                pekerjaan_id = $pekerjaan, gol_darah = '$gol_darah', agama_id = $agama,
                wni = '$kewarganegaraan', status_nikah = '$status_nikah', jenis_kelamin = '$jenis_kelamin',
                keluarga_id = $kk_id";
            $conn->query($sql);
            check_error($conn);
            MysqlManager::close_connection($conn);
            echo "ok";           
            break;
        case "edit":
            $id = $_POST['id'];
            $agama = $_POST['agama'];
            $gol_darah = $_POST['gol_darah'];
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $kk_id = $_POST['kk_id'];
            $nama = $_POST['nama'];
            $pekerjaan = $_POST['pekerjaan'];
            $pendidikan = $_POST['pendidikan'];
            $status_hub_kel = $_POST['status_hub_kel'];
            $status_nikah = $_POST['status_nikah'];
            $tgl_lahir = $_POST['tgl_lahir'];
            $tempat_lahir = $_POST['tmp_lahir'];
            $kewarganegaraan = $_POST['warga'];
            $kecamatan_id = $_SESSION['kecamatan_id'];
            // calculate nik first.
            $laki = $jenis_kelamin == 'Perempuan' ? false : true;
            $nik = nik($kecamatan_id, $tgl_lahir, $laki);
            $sql = "update penduduk set nik = '$nik', nama = '$nama', status_hub_kel = '$status_hub_kel',
                tmp_lahir = '$tempat_lahir', tgl_lahir = '$tgl_lahir', pendidikan_id = $pendidikan,
                pekerjaan_id = $pekerjaan, gol_darah = '$gol_darah', agama_id = $agama,
                wni = '$kewarganegaraan', status_nikah = '$status_nikah', jenis_kelamin = '$jenis_kelamin',
                keluarga_id = $kk_id where id = $id";
            $conn->query($sql);
            check_error($conn);
            MysqlManager::close_connection($conn);
            echo "ok";           
            break;
        case "del":
            $id = $_POST['id'];
            $sql = "delete from penduduk where id = $id";
            $conn->query($sql);
            check_error($conn);
            MysqlManager::close_connection($conn);
            echo "ok";
            break;
        case "upload":
            $penduduk_id = $_POST['penduduk_id'];
            $userfile_tmp = $_FILES['photo']['tmp_name'];
            $resp = "";            
            if(is_uploaded_file($userfile_tmp)){
                $filename = basename($_FILES['photo']['name']);
                $file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
                $resp->filename = $filename;
                $resp->file_ext = $file_ext;
                $filename  = $penduduk_id.".".$file_ext;
                $image_path = "../statics/images/foto/".$filename;
                if(file_exists($image_path)){
                    unlink($image_path);
                }
                move_uploaded_file($userfile_tmp, $image_path);
                $image_path = "statics/images/foto/$filename";
                $connection = MysqlManager::get_connection();
                $sql = "update penduduk set photo = '$filename' where id=$penduduk_id";
                $result = $connection->query($sql);
                check_error($connection);
                MysqlManager::close_connection($connection);
                
                echo '<div id="outer">';
                echo '  <img src="'.$image_path.'" id="preview" />';                   
                echo '</div>';
            }           
            break;
        case "pindahalamat":
            $penduduk_id = $_POST["penduduk_id"];
            $tgl_pindah = $_POST["tgl_pindah"];
            $kk_id_lama = $_POST["kk_id_lama"];
            $kk_id_baru = $_POST["kk_id_baru"];
            $keterangan = $_POST["keterangan"];
            // insert pindah alamat
            $connection = MysqlManager::get_connection();
            $sql = "insert into pindah_alamat set penduduk_id = $penduduk_id,
                tgl_pindah = '$tgl_pindah', kk_id_lama = $kk_id_lama, kk_id_baru =
                $kk_id_baru, keterangan = '$keterangan'";
            $result = $connection->query($sql);
            check_error($connection);
            // update penduduk id
            $sql = "update penduduk set keluarga_id = $kk_id_baru where id = $penduduk_id";
            $result = $connection->query($sql);
            check_error($connection);
            MysqlManager::close_connection($connection);
            echo "<p style=\"color: green;\">Pindah Alamat success</p>";
            break;
    }
}

?>
