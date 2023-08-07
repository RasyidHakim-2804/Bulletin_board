<?php

//untuk membersihkan kalimat dari lebih satu spasi
function clean_message($input, $delimiter = ' ')
{
  $cleanMessage = preg_replace("/\s++/", $delimiter, trim($input));
  
  return $cleanMessage;
}


//memeriksa panjang kalimat
function length_validation($input, $max, $min = 0)
{
  $characterLength = strlen($input);
  if ($characterLength == 0) return 'empty';
  
  if ($characterLength < $min) return 'to short';
  
  if ($characterLength > $max) return 'to long';
  
  return 'pass';
}

