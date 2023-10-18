<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;

class OpensslHelper
{
  private static $key = "Les.W";
  private static $iv = '5f2tOxWi';

  public static function encrypt($str)
  {
    return urlencode(bin2hex(openssl_encrypt($str, 'des-ede3-cbc',self::$key, OPENSSL_RAW_DATA,self::$iv)));
  }

  public static function decrypt($str)
  {
    if ( preg_match('~%[0-9A-F]{2}~i', $str) ){
      $str = urldecode($str);
    }

    return openssl_decrypt(hex2bin($str), 'des-ede3-cbc',self::$key, OPENSSL_RAW_DATA,self::$iv);
  }
}
