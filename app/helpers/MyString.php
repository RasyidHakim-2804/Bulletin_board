<?php

namespace App\Helpers;

class MyString
{
  /**
   * untuk membersihkan kalimat dari lebih satu spasi
   */
  static public function sanitizeSpaces( string $input, string $delimiter = ' '): string
  {
    $cleanString = preg_replace("/\s++/", $delimiter, trim($input));
    
    return $cleanString;
  }

  
  /**
   * memeriksa panjang kalimat.
   * 'empty' akan dkembalikan jika kalimat kosong.
   * 'short' akan dikembalikan jika panjang kalimat lebih pendek dari limit.
   * 'long' akan dikembalikan jika panjang kalimat lebih panjang dari limit.
   * 'pass' akan dikembalikan jika panjang kalimat sesuai denganlimit .
   */
  static public function validateLength( string $input, int $min = 0, int $max = 0): string
  {
    $characterLength = strlen($input);

    if ($characterLength === 0) return 'empty';
    
    if ($characterLength < $min) return 'short';
    
    if ( ($max !== 0) && ($characterLength > $max) ) return 'long';
    
    return 'pass';
  }



}

