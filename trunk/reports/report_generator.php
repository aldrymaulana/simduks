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
        $x_axis->set_labels(array("Gedangan", "Sawo","3","4","5","6","7","8","9","10"));
        
        $chart = new open_flash_chart();
        $chart->set_title( $title );
        $chart->add_element( $bar );
        $chart->set_x_axis($x_axis );
        
        echo $chart->toPrettyString();
        break;
    case "5":
        include "../includes/helpers.inc.php";
        echo "<label for='kecamatan'>Kecamatan</label>";
        echo select("kecamatan", "id", "nama_kecamatan","kecamatan",'class="text ui-widget ui-widget-content ui-corner-all"');
        echo "<label for='desa'>Desa/Kelurahan</label>";
		//<select name="desa" id="desa" value="" class="text ui-widget ui-widget-content ui-corner-all" />       
        break;
}


