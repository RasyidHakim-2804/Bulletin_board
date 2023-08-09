<?php
  //include('ConfigFile/functionMessage.php');
  include('ConfigFile/messageFunction.php');
  //ok


  if (isset($_POST['submit'])) {

    $response  = process_add_message($_POST['message_data']);

    if ($response['response'] === FALSE) {

      echo "Your data is: {$response['statusLength']} <br>";
      echo "Length of your data: {$response['length']} <br>";
      echo "Please try again";
  
    }

    if ($response['response'] === TRUE) {

      echo "Your data is {$response['statusQuery']} to store in Database <br>";

    }

  }

  $data = get_message();
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
