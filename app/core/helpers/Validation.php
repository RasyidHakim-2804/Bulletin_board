<?php

namespace App\Core\Helpers;

trait Validation
{
  //untuk membersihkan kalimat dari lebih satu spasi
  public static function clearString( string $input, string $delimiter = ' '): string
  {
    $cleanString = preg_replace("/\s++/", $delimiter, trim($input));
    
    return $cleanString;
  }

  
  //memeriksa panjang kalimat
  public static function validateLength( string $input, int $min = 0, int $max = 0): string
  {
    $characterLength = strlen($input);

    if ($characterLength === 0) return 'empty';
    
    if ($characterLength < $min) return 'to short';
    
    if ( ($max !== 0) && ($characterLength > $max) ) return 'to long';
    
    return 'pass';
  }



}

