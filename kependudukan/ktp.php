<?php
session_start();
include_once "../includes/helpers.inc.php";

if(isset($_GET['q'])){
    $req = $_GET['q'];
   
    switch($req){
        case 1:
            $page = $_GET["page"];
            $limit = $_GET["rows"];
            $sord = $_GET["sord"];
            $sidx = $_GET["sidx"];
            $total_pages = "";
            if(!$sidx){
                $sidx = 1;
            }
            $kec_id = $_GET["kecamatan_id"];
            $sql = "select count(*) as count from penduduk p, keluarga l, alamat a, kelurahan k
            where (year(curdate()) - year(p.tgl_lahir)) > 16 and p.keluarga_id = l.id and
            l.alamat_id = a.id and a.kelurahan_id = k.id and k.kecamatan_id = $kec_id";
            $conn = MysqlManager::get_connection();
            $result = $conn->query($sql);
            check_error($conn);
            $count = $result->fetch_object()->count;
            if($page > $total_pages){
                $total_pages = ceil($count/$limit);
            } else {
                $total_pages = 0;
            }
            $start = $limit * $page - $limit;
            if($start < 0){
                $start = 0;
            }
            $sql = "select p.id as id, p.nik as nik, p.nama as nama, p.tgl_lahir as tgl_lahir, a.alamat as alamat, a.rukun_tetangga as rt,
            a.rukun_warga as rw, k.nama_kelurahan as nama_kelurahan from penduduk p, keluarga l, alamat a,
            kelurahan k where (year(curdate()) - year(p.tgl_lahir)) > 17 and p.keluarga_id = l.id and
            l.alamat_id = a.id and a.kelurahan_id = k.id and k.kecamatan_id = $kec_id order by $sidx $sord";
            $result = $conn->query($sql);
            check_error($conn);
            $resp = "";
            $resp->page = $page;
            $resp->total = $total_pages;
            $resp->records = $count;
            $i = 0;
            while($row = $result->fetch_object()){
                $resp->rows[$i]['id'] = $row->id;
                $long_alamat = $row->alamat." RT/RW ".sprintf("%03d",$row->rt)."/".sprintf("%03d",$row->rw)." ".$row->nama_kelurahan;
                $resp->rows[$i]['cell'] = array($row->id, $row->nik, $row->nama, $long_alamat, $row->tgl_lahir );
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