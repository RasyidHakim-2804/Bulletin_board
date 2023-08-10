<?php

//untuk membersihkan kalimat dari lebih satu spasi
function string_cleaner($input, $delimiter = ' ')
{
  $cleanString = preg_replace("/\s++/", $delimiter, trim($input));
  
  return $cleanString;
}


//memeriksa panjang kalimat
function length_validation($input, $min = 0, $max = false)
{
  $characterLength = strlen($input);

  if ($characterLength === 0) return 'empty';
  
  if ($characterLength < $min) return 'to short';
  
  if ( ($max !== false) && ($characterLength > $max) ) return 'to long';
  
  return 'pass';
}

