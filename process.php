<?php
include('ConfigFile/function.php');

if (isset($_POST['submit'])) {
  
  array_splice($_POST, -1, 1);
  
  $data             = array_values($_POST)[0];
  $cleanData        = clean_message($data);
  $length           = strlen($cleanData);
  $lengthValidation = length_validation($cleanData, 200, 10);

  if ($lengthValidation != 'pass') {
    header(
      'Location: index.php?length=' . urlencode($length)
      . '&lengthStatus=' . urlencode($lengthValidation)
    );
  }

  if ($lengthValidation == 'pass') {

    $statusDB = add_data('message', 'message_data', $cleanData);

    header(
      'Location: index.php?result=' . urlencode($statusDB)
      . '&length=' . urlencode($length)
    );

  }
} else {
  header('Location: notfound.html');
}

//if (!isset($_POST['submit'])) header('Location: notfound.html');