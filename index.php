<?php
  include('ConfigFile/function.php');

  $resultDB = '';

  if ( isset($_POST['submit']) ) {
    $message = clean_message($_POST['message']);
    $lenght  = strlen($message);
    $status  = long_validation($message, 10, 200);
    
    echo "Your message           : {$message}<br>";
    echo "Lenght of your message: {$lenght}<br>";
    
    if ($status == 'pass') {
      $resultDB = add_message($message);
      echo "Status of saving to database: {$resultDB}<br>";
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
      <textarea name="message" id="message" cols="70" rows="3" style="resize:none"></textarea><br />
      <input type="submit" name="submit" value="Sumbit">
    </form>
  </div>
  <hr><br><br>
  <div>
    <?php
    $reverseData = array_reverse($data);

    foreach($reverseData as $data){
      $time = strtotime($data['time']);
      
      //echo strlen($data['message']);
      echo "<h3>" . htmlspecialchars($data['message']) . "</h3>";
      echo "<h5>Created on:". ' ' . date("Y-m-d  h:i:sa", $time) . "</h5><hr>";
    }
    ?>
  </div>
</body>
</html>
