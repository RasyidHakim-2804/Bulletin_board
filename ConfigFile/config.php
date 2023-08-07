<?php

$server   = "localhost";
$user     = "root";
$password = "rootRoot";
$database = "bulletin_board";

$conn = mysqli_connect($server,$user,$password,$database);
if ($conn->connect_error) {
  die("Failed to connect because:". ' ' . mysqli_connect_error());
}


//function query, untuk menjalankan syntax SQL
function query($query) 
{
  global $conn;
  $result = mysqli_query($conn, $query);
  //mengecek adanya eror pada syntax
  if(!$result){
      echo mysqli_error($conn);
  } else {
      return $result;
  }
}

//function assoc, untuk menampilkan data dari tabel
function assoc($table)
{
  $data = [];
  while ($row = mysqli_fetch_assoc($table)) {
      $data[] = $row;
  }
  return $data;
} 



