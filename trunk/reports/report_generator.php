<?php
include_once "../includes/helpers.inc.php";
$request = $_GET['q'];
switch($request)
{
    case "1": // usia productive
        srand((double)microtime()*1000000);
        $data = array();
        
        // add random height bars:
        for( $i=0; $i<10; $i++ )
          $data[] = rand(2,9);
        
        require_once('../php-ofc-library/open-flash-chart.php');
        
        $title = new title("Penduduk Usia Produktif");
        
        $bar = new bar();
        $bar->set_values( $data );
        $bar->colour = '#D54C78';
       
        $x_axis = new x_axis();
        $x_axis->set_colour('#909090');
        $x_axis->set_labels(array(1,2,3,4,5,6,7,8,9,10));
        
        $chart = new open_flash_chart();
        $chart->set_title( $title );
        $chart->add_element( $bar );
        $chart->set_x_axis($x_axis );
        
        echo $chart->toPrettyString();
        break;
    case "2": //pendidikan
        srand((double)microtime()*1000000);
        $data = array();
        
        // add random height bars:
        for( $i=0; $i<10; $i++ )
          $data[] = rand(2,9);
        
        require_once('../php-ofc-library/open-flash-chart.php');
        
        $title = new title("Pendidikan");
        
        $bar = new bar();
        $bar->set_values( $data );
        $bar->colour = '#D54C78';
       
        $x_axis = new x_axis();
        $x_axis->set_colour('#909090');
        $x_axis->set_labels(array(1,2,3,4,5,6,7,8,9,10));
        
        $chart = new open_flash_chart();
        $chart->set_title( $title );
        $chart->add_element( $bar );
        $chart->set_x_axis($x_axis );
        
        echo $chart->toPrettyString();
        break;
    case "3": // pekerjaaan
        
        $sql = "select count(k.pekerjaan) as count, k.pekerjaan as pekerjaan from  pekerjaan k,
        penduduk p, alamat a, keluarga l, kelurahan kel where p.pekerjaan_id = k.id
        and p.keluarga_id = l.id and l.alamat_id = a.id and a.kelurahan_id = kel.id
        and kel.kecamatan_id = 4 group by k.id";
        $conn = MysqlManager::get_connection();
        $result = $conn->query($sql);
        check_error($conn);
        $ds = array();
        $length = 0;
        while($row = $result->fetch_object()){
            $ds[] = array($row->count, $row->pekerjaan);
            $length++;
        }
        MysqlManager::close_connection($conn);
        
        $data = array();
       
        for($i=0; $i <  $length; $i++ )
        {
            $arr = $ds[$i];
            $data[] = (int)$arr[0];
        }
        
        require_once('../php-ofc-library/open-flash-chart.php');
        
        $title = new title("Pekerjaan".$_GET['kecamatan_id']);
        
        $bar = new bar();
        $bar->set_values( $data );
        $bar->colour = '#D54C78';
       
        $x_axis = new x_axis();
        $x_axis->set_colour('#909090');
        $labels = array();
        for($i = 0; $i < $length; $i++){
            $arr = $ds[$i];
            $labels[] = $arr[1];
        }
        $x_axis->set_labels_from_array($labels);
        
        $chart = new open_flash_chart();
        $chart->set_title( $title );
        $chart->add_element( $bar );
        $chart->set_x_axis($x_axis );
        
        echo $chart->toPrettyString();
        
        break;
    case "4": // penghasilan
        srand((double)microtime()*1000000);
        $data = array();
        
        // add random height bars:
        for( $i=0; $i<10; $i++ )
          $data[] = rand(2,9);
        
        require_once('../php-ofc-library/open-flash-chart.php');
        
        $title = new title("Penghasilan Penduduk ");
        
        $bar = new bar();
        $bar->set_values( $data );
        $bar->colour = '#D54C78';
       
        $x_axis = new x_axis();
        $x_axis->set_colour('#909090');
       
        $x_axis->set_labels_from_array(array("Gedangan", "Sawo","3","4","5","6","7","8","9","10"));
       
        $y_axis = new y_axis();
        $y_axis->set_label_text(array( "Make garden look sexy","Paint house","Move into house" ));
        
        $chart = new open_flash_chart();
        $chart->set_title( $title );
        $chart->add_element( $bar );
        $chart->set_x_axis($x_axis );
        $chart->add_y_axis($y_axis);
        
        echo $chart->toPrettyString();
        break;
    case "5":
        
        $additional = array();
        $additional[] = array("key"=>'all', "value"=>"All");
        echo "<li><label for='kecamatan'>Kecamatan</label>";
        echo select("kecamatan", "id", "nama_kecamatan","kecamatan",'class="ui-widget-content ui-corner-all"',"",-1,$additional);
        echo "</li><li><label for='kelurahan' id='lbl_desa'>Desa/Kelurahan</label></li>";		       
        break;
    case "6":
        
        $kec_id = $_GET['kecamatan_id'];
        if($kec_id != "all"){
            $additional = array();
            $additional[] = array("key"=>'all', "value"=>"All");
            echo select("kelurahan", "id", "nama_kelurahan", "kelurahan",
                'class="ui-widget-content ui-corner-all"',
                "kecamatan_id = $kec_id",-1, $additional);
        }        
        break;
}
