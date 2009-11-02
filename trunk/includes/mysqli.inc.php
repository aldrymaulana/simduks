<?php
define('DB_HOST','localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'heru');
define('DB_NAME', 'kohana');
define('DB_PORT', '3306');

if(!extension_loaded('mysqli'))
{
   echo "Mysqli extension has not been installed";
   exit();
}

$mysqli_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME, DB_PORT);

// checking connection
if(mysqli_connect_errno())
{
   echo "koneksi ke database gagal :".mysqli_connect_error();
}

function check_error($connection)
{
   if(mysqli_errno($connection))
   {
      $error = "error query :".mysqli_error($connection);
      include "error.html.php";
      exit();
   }
}
?>
