<?php
include "connection.php";
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
if(!$link)
{
  $error = 'unable to connect to the database server.';
  include('error.html.php');
  exit();
}

if(!mysqli_set_charset($link, 'utf8'))
{
  $output = 'unable to set database connection encoding.';
  include('output.html.php');
  exit();
}

if(!mysqli_select_db($link, DB_NAME))
{
  $error = 'Unable to locate the simduk database.';
  include('error.html.php');
  exit();
}

?>