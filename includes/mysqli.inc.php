<?php
include "connection.php";

if(!extension_loaded('mysqli'))
{
   echo "Mysqli extension has not been installed";
   exit();
}

class MysqlManager
{   
    public static function get_connection(){
        if(!extension_loaded('mysqli'))
        {
            echo "Mysqli extension has not been installed";
            exit();
        }
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME, DB_PORT);
        if(mysqli_connect_errno())
        {
            echo "koneksi ke database gagal :".mysqli_connect_error();
        }
        return $connection;
    }
   
   public static function close_connection($connection){
        $connection->close();
   }
}
?>