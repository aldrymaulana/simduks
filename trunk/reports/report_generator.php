<?php

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
        srand((double)microtime()*1000000);
        $data = array();
        
        // add random height bars:
        for( $i=0; $i<10; $i++ )
          $data[] = rand(2,9);
        
        require_once('../php-ofc-library/open-flash-chart.php');
        
        $title = new title("Pekerjaan");
        
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
    case "4": // penghasilan
        srand((double)microtime()*1000000);
        $data = array();
        
        // add random height bars:
        for( $i=0; $i<10; $i++ )
          $data[] = rand(2,9);
        
        require_once('../php-ofc-library/open-flash-chart.php');
        
        $title = new title("Penghasilan Penduduk");
        
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
        include "../includes/helpers.inc.php";
        echo "<li><label for='kecamatan'>Kecamatan</label>";
        echo select("kecamatan", "id", "nama_kecamatan","kecamatan",'class="ui-widget-content ui-corner-all"');
        echo "</li><li><label for='kelurahan' id='lbl_desa'>Desa/Kelurahan</label></li>";		       
        break;
    case "6":
        include "../includes/helpers.inc.php";
        $kec_id = $_GET['kecamatan_id'];
        echo select("kelurahan", "id", "nama_kelurahan", "kelurahan",
            'class="ui-widget-content ui-corner-all"',
            "kecamatan_id = $kec_id");
        break;
}


