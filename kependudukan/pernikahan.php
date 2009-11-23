<?php
session_start();
include_once "../includes/helpers.inc.php";

if(isset($_GET["q"])){
    $req = $_GET["q"];
    
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
            $sql = "select count(*) as count from pernikahan where kecamatan_id = $kec_id";
            $conn = MysqlManager::get_connection();
            $result = $conn->query($sql);
            check_error($conn);
            $count = $result->fetch_object()->count;
            if($page > $total_pages){
                $total_pages = ceil ($count/$limit);
            } else {
                $total_pages = 0;
            }
            $start = $limit * $page - $limit;
            if($start < 0){
                $start = 0;
            }
            $sql = "select n.id as id, n.no_pernikahan as no_pernikahan, p.nama as pria, pp.nama as wanita,
            n.tanggal as tanggal, kel.nama_kelurahan as nama_kelurahan from pernikahan as n, penduduk as p,
            penduduk as pp, kelurahan as kel where
            n.kecamatan_id = $kec_id and p.id = n.pria and pp.id = n.wanita and kel.id = n.kelurahan_id
            order by $sidx $sord";
            
            $result = $conn->query($sql);
            check_error($conn);
            $resp = "";
            $resp->page = $page;
            $resp->total = $total_pages;
            $resp->count = $count;
            $i = 0;
            while($row = $result->fetch_object()){
                $resp->rows[$i]['id'] = $row->id;
                $resp->rows[$i]['cell'] = array($row->id, $row->no_pernikahan, $row->pria,
                                                $row->wanita, $row->tanggal, $row->nama_kelurahan);
                $i++;
            }
            MysqlManager::close_connection($conn);
            echo json_encode($resp);
            break;
    }
}
?>