<?php
  //include('ConfigFile/functionMessage.php');
  include('ConfigFile/Message.php');

  if (isset($_POST['submit'])) {

    $message = new Message($_POST['message_data']);
    $message->process();

    if ($message->statusLength !== 'pass') {

      echo "Your data is: {$message->statusLength} <br>";
      echo "Length of your data: {$message->length} <br>";
      echo "Please try again";
  
    }

    if ($message->statusLength === 'pass') {


      echo "Your data is {$message->statusDB} to store in Database <br>";

    }

  }

  $data = Message::show_message();
  

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
    //$reverseData = array_reverse($data);

    foreach($data as $data){
      $time = $data['created_on'];
      
      //echo strlen($data['message']);
      echo "<h3>" . $data['message_data'] . "</h3>";
      echo "<h5>Created on:". ' ' . date("Y-m-d  h:i:sa", $time) . "</h5><hr>";
    }
    ?>
  </div>
</body>
</html>
