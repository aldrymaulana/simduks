<?php
session_start();
include_once "../includes/helpers.inc.php";

if(isset($_GET['q'])){
    $req = $_GET['q'];
    /*
     select count(*) as count from penduduk p, keluarga l, alamat a, kelurahan k
     where (year(curdate()) - year(p.tgl_lahir)) > 16 and p.keluarga_id = l.id
     and l.alamat_id = a.id and a.kelurahan_id = k.id and k.kecamatan_id = 4;
    */
    switch($req){
        case 1:
            
            break;
        case 2:
            break;
    }
}
?>