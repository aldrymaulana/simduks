<?php

$request = $_GET['q'];
switch($request)
{
    case "1":
        srand((double)microtime()*1000000);
        $data = array();
        
        // add random height bars:
        for( $i=0; $i<10; $i++ )
          $data[] = rand(2,9);
        
        require_once('../php-ofc-library/open-flash-chart.php');
        
        $title = new title("Penduduk Usia Productive");
        
        $bar = new bar();
        $bar->set_values( $data );
        $bar->colour = '#D54C78';
        /*
        $x_axis = new OFC_Elements_Axis_X();
        $x_axis->set_3d( 5 );
        $x_axis->colour = '#909090';
        $x_axis->set_labels( array(1,2,3,4,5,6,7,8,9,10) );
        */
        $x_axis = new x_axis();
        $x_axis->set_colour('#909090');
        $x_axis->set_labels(array(1,2,3,4,5,6,7,8,9,10));
        
        $chart = new open_flash_chart();
        $chart->set_title( $title );
        $chart->add_element( $bar );
        $chart->set_x_axis($x_axis );
        
        echo $chart->toPrettyString();
        break;
}


