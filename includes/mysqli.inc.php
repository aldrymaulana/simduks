<?php
include "connection.php";

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


?>