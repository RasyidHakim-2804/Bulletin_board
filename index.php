<?php
  include('ConfigFile/process.php');

  if (isset($_POST['submit'])) {

    $result = proses($_POST['message_data']);

    if ($result['lengthStatus'] != 'pass') {

      echo "Your data is: {$result['lengthStatus']} <br>";
      echo "Length of your data: {$result['length']} <br>";
      echo "Please try again";
  
    }

    if ($result['lengthStatus'] == 'pass') {

      echo "Your data is {$result['statusDB']} to store in Database <br>";

    }

    
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
    <form action="" method="post">
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
