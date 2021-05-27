<?php
  
  namespace Acreation\Bitoneer;
  
  class Generators {
    
    public static function generateRandomString($length){
      $randstr = "";
      
      for ($i = 0; $i < $length; $i++) {
        
        $randnum = mt_rand(0, 61);
        if ($randnum < 10) {
          $randstr .= chr($randnum + 48);
        } else if ($randnum < 36) {
          $randstr .= chr($randnum + 55);
        } else {
          $randstr .= chr($randnum + 61);
        }
      }
      
      return $randstr;
    }
    
    public static function getFileNameFromText($text, $replace = array(), $delimiter = '-'){
      if (!empty($replace)){
        $text = str_replace((array) $replace, ' ', $text);
      }
      
      $clean1 = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
      $clean2 = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean1);
      $clean3 = strtolower(trim($clean2, '-'));
      
      return preg_replace("/[\/_|+ -]+/", $delimiter, $clean3);
    }
    
  }

?>