<?php

//untuk membersihkan kalimat dari lebih satu spasi
function string_cleaner(string $input,string $delimiter = ' '): string
{
  $cleanString = preg_replace("/\s++/", $delimiter, trim($input));
  
  return $cleanString;
}


//memeriksa panjang kalimat
function length_validation(string $input,int $min = 0,int $max = 0): string
{
  $characterLength = strlen($input);

  if ($characterLength === 0) return 'empty';
  
  if ($characterLength < $min) return 'to short';
  
  if ( ($max !== 0) && ($characterLength > $max) ) return 'to long';
  
  return 'pass';
}

