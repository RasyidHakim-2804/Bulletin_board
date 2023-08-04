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
function clean_message($message)
{
  $cleanMessage = preg_replace("/\s+/", ' ', trim($message));
  return $cleanMessage;
}

//memeriksa panjang kalimat
function long_validation($message, $min, $max)
{
  $characterLength = strlen($message);
  if ($characterLength == 0) {
    return 'empty';
  } elseif ($characterLength < $min) {
    return 'to short';
  } elseif ($characterLength > $max) {
    return 'to long';
  }

  return 'pass';
}


//menambah data pesan ke MYSQL
function add_message($message)
{
  $query = "INSERT INTO message (message) VALUE ('$message')";
  
  $result = query($query);

  //mengembalikan response bila gagal
  if ($result) {
    return 'success';
  } else {
    return 'fail';
  }
}


// //menampilkan alert sesuai respon
// function alert($status, $message, $resultDB = '')
// {
//   if ($status == 'pass') {
//     echo "<script type ='text/JavaScript'>";  
//     echo "alert('Data {$resultDB} to add to database,"
//           . ' ' . 'Your data length:' 
//           . strlen($message) . "')";  
//     echo "</script>";
//   } else {
//     echo "<script type ='text/JavaScript'>";  
//       echo "alert('Data does not match," . ' '
//            . "Because your data is {$status}," 
//            . ' ' . "the length of your data:"
//            . ' ' . strlen($message) . "')"; 
//       echo "</script>";
//   }
// }