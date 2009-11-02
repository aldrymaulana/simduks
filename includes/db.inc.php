<?php
$link = mysqli_connect('localhost', 'root', 'heru');
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

if(!mysqli_select_db($link, 'kohana'))
{
  $error = 'Unable to locate the simduk database.';
  include('error.html.php');
  exit();
}

?>