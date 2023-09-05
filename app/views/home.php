<?php

if (isset($response)) {

  if (isset($response['no-valid'])) {
    $status = $response['no-valid'];

    echo "Your data is: {$status['statusLength']} <br>";
    echo "Length of your data: {$status['length']} <br>";
    echo "Please try again";
  }

  if ($response === true) {
    echo "Your data is success to store in Database <br>";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bulletin Board</title>
  <style>
    th, td {
      padding: 15px;
    }
    table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
    }
  </style>
</head>
<body>
  <div>
    <form action="message" method="POST">
      <h4>Your message must be 10 to 200 characters long</h4>
      <h4>Spaces at the beginning and at the end of a sentence are not counted</h4>
      <textarea name="message_data" cols="70" rows="3" style="resize:none"></textarea><br />
      <input type="submit" name="submit" value="Submit">
    </form>
    <form action="home" method="GET">
      <input type="submit" value="Refresh">
    </form>
  </div>
  <hr><br><br>

  <!-- show data -->
  <div>
    <table style="width: 70%;">
      <tr>
        <th>ID</th>
        <th>MESSAGE</th>
        <th>CREATED ON</th>
      </tr>
      <?php
      foreach($row as $data){
        $time = $data['time'];
        echo '<tr>';
        echo '<td>' . $data['id']   . '</td>';
        echo '<td>' . $data['body'] . '</td>';
        echo '<td><h4>' . date("Y-m-d  h:i:sa", $time) . '</h4></td>';
        echo '<tr>';
      }
      ?>
    </table>
    
  </div>
</body>
</html>
