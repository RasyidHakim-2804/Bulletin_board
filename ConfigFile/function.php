<?php

include('config.php');


//function query, untuk menjalankan syntax SQL
function query($query) 
{
  global $db;
  $result = mysqli_query($db, $query);
  //mengecek adanya eror pada syntax
  if(!$result){
      echo mysqli_error($db);
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


//untuk membersihkan kalimat dari lebih satu spasi
function clean_message($message, $delimiter = ' ')
{
  $cleanMessage = preg_replace("/\s++/", $delimiter, trim($message));
  
  return $cleanMessage;
}

//memeriksa panjang kalimat
function length_validation($message, $max, $min = 0)
{
  $characterLength = strlen($message);
  if ($characterLength == 0) return 'empty';
  
  if ($characterLength < $min) return 'to short';
  
  if ($characterLength > $max) return 'to long';
  
  return 'pass';
}


//menambah data pesan ke MYSQL
function add_data($table, $collumn, $data)
{
  $query = "INSERT INTO $table ($collumn) VALUE ('$data')";
  
  $result = query($query);

  //mengembalikan response bila gagal
  if ($result) return 'success'; 
  
  return 'fail';
  
}
