<?php
  
  namespace Acreation\Bitoneer;
  
  class Formatters {

    // ESCAPED EINEN STRING FÜR FRONTEND-AUSGABE
    public static function escapeString($string) {
      if (Validators::isString($string)) {
        return htmlentities($string, ENT_COMPAT, 'UTF-8');
      }
    }
    
    public static function escapeArray($arr){
      $output = array();
      
      foreach ($arr as $key => $val){
        $output[$key] = static::escapeString($val);
      }
      
      return $output;
    }
    
    // ENTFERNT ALLE HTML-TAGS
    public static function removeFormat($string) {
      return strip_tags($string);
    }
    
    public static function formatFloat($float, $position = 2) {
      if (Validators::isFloat($float)) {
        return (float) number_format($float, $position, '.', ',');
      }
    }
    
    // WANDELT IN DEUTSCHE ZAHLENFORMATIERUNG UM
    public static function formatGermanFloat($float, $position = 2) {
      if (Validators::isFloat($float)) {
        return number_format($float, $position, ',', '.');
      } else {
        throw new \Exception('No valid float!');
      }
    }
    
    // KONVERTIERT DEUTSCHE ZAHLENFORMATIERUNG ZURÜCK
    public static function reconvertFloat($float) {
      $float = str_replace('.', '', $float);
      $float = str_replace(',', '.', $float);
      
      if (Validators::isFloat($float)) {
        return $float;
      }
    }
    
    // KÜRZT TEXT AUF ANGEGEBENE ZEICHENLÄNGE
    public static function shortenText($string, $length = 200) {
      if (strlen($string) > $length) {
        return substr($string, 0, $length) . ' ...';
      } else {
        return $string;
      }
    }
    
    public static function clearText($text){
      $html_free = strip_tags($text);
      return str_replace(array("\r\n", "\r", "\n"), "", $html_free);
    }
    
  }

?>