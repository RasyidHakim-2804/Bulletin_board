<?php
  include('ConfigFile/function.php');

  if (isset($_GET['lengthStatus']) && isset($_GET['length'])) {

    $lengthStatus = urldecode($_GET['lengthStatus']);
    $length       = urldecode($_GET['length']);

    echo "Your data is: {$lengthStatus} <br>";
    echo "Length of your data: {$length} <br>";
    echo "Please try again";

  }

  if (isset($_GET['result']) && isset($_GET['length'])) {
    $statusDB = urldecode($_GET['result']);
    $length   = urldecode($_GET['length']);

    echo "Your data is '{$statusDB}' to store in Database <br>";
    echo "Length of your data: {$length} <br>";
  }

  $table_message = query("SELECT * FROM message");
  $data = assoc($table_message);
  

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <div>
    <form action="process.php" method="post">
      <h4>Your message must be 10 to 200 characters long</h4>
      <h4>Spaces at the beginning and at the end of a sentence are not counted</h4>
      <textarea name="message_data" cols="70" rows="3" style="resize:none"></textarea><br />
      <input type="submit" name="submit" value="Submit">
    </form>
  </div>
  <hr><br><br>
  <div>
    <?php
    $reverseData = array_reverse($data);

    foreach($reverseData as $data){
      $time = strtotime($data['time']);
      
      //echo strlen($data['message']);
      echo "<h3>" . htmlspecialchars($data['message_data']) . "</h3>";
      echo "<h5>Created on:". ' ' . date("Y-m-d  h:i:sa", $time) . "</h5><hr>";
    }
    ?>
  </div>
</body>
</html>
