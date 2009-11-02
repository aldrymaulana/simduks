<?php
$dbhost = 'localhost';
$dbuser   = 'root';
$dbpassword = 'heru';
$database = 'griddemo';

$mysqli_connection = new mysqli($dbhost, $dbuser,$dbpassword, $database);
if(mysqli_connect_errno())
{
    echo "error connecting to database :".mysqli_connect_error();
    exit();
}


function check_error($connection)
{
    if(mysqli_errno($connection))
    {
        echo "error query :".mysqli_error($connection);
        exit();
    }
}
?>
