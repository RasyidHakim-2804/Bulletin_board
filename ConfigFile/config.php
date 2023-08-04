<?php

$server   = "localhost";
$user     = "root";
$password = "rootRoot";
$database = "bulletin_board";

$db = mysqli_connect($server,$user,$password,$database);
if (!$db) {
  die("Failed to connect because:". ' ' . mysqli_connect_error());
}


