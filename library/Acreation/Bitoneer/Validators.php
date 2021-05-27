<?php
  
  namespace Acreation\Bitoneer;
  
  class Validators {

    // VALIDIERT INTEGER-WERTE
    public static function isInteger($int) {
      return filter_var($int, FILTER_VALIDATE_INT) ? TRUE : FALSE;
    }
    
    // VALIDIERT INTEGER-WERTE GRÖSSER 0
    public static function isIdentifier($int) {
      return (static::isInteger($int) && $int > 0);
    }
    
    // VALIDIERT KETTE MIT MINDESTENS EINEM ZEICHEN
    public static function isNotEmpty($string) {
      return (strlen($string) > 0);
    }
    
    // VALIDIERT STRINGS
    public static function isString($string) {
      return (is_string($string));
    }
    
    // VALIDIERT STRINGS MIT MINDESTENS EINEM ZEICHEN
    public static function isFilledString($string) {
      return (static::isString($string) && static::isNotEmpty($string));
    }
    
    // VALIDIERT FLIESKOMMAZAHLEN
    public static function isFloat($float) {
      return (($float == 0) || filter_var($float, FILTER_VALIDATE_FLOAT));
    }
    
    // VALIDIERT ARRAYS
    public static function isArray($array) {
      return (is_array($array));
    }
    
    // VALIDIERT BOOLEANS
    public static function isBoolean($bool) {
      return (is_bool($bool));
    }
    
    // VALIDIERT EMAIL ADRESSEN
    public static function isEmail($email) {
      return filter_var($email, FILTER_VALIDATE_EMAIL) ? TRUE : FALSE;
    }
    
    // VALIDIERT ORDERNAMEN/BENUTZERNAMEN
    public static function isFolderName($folder_name) {
      return preg_match('/^[a-z0-9_-]+$/', $folder_name) ? TRUE : FALSE;
    }
    
    public static function isFileName($file_name){
      $path = pathInfo($file_name);
      return ($path['basename'] === $file_name);
    }
    
    // VALIDIERT URLS
    public static function isUrl($url) {
      return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED) ? TRUE : FALSE;
    }
    
    // VALIDIERT IPS
    public static function isIp($ip) {
      return filter_var($ip, FILTER_VALIDATE_IP) ? TRUE : FALSE;
    }
    
    // VALIDIERT DATUMSANGABEN
    public static function isDate($date) {
      //match the format of the date
      if (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts)) {
        //check weather the date is valid of not
        if (checkdate($parts[2], $parts[3], $parts[1])) {
          return TRUE;
        }
        
        return FALSE;
      }
      
      return FALSE;
    }
    
    public static function isDateTime($date_time) {
      return (preg_match('/\\A(?:^((\\d{2}(([02468][048])|([13579][26]))[\\-\\/\\s]?((((0?[13578])|(1[02]))[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])|(3[01])))|(((0?[469])|(11))[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])|(30)))|(0?2[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])))))|(\\d{2}(([02468][1235679])|([13579][01345789]))[\\-\\/\\s]?((((0?[13578])|(1[02]))[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])|(3[01])))|(((0?[469])|(11))[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])|(30)))|(0?2[\\-\\/\\s]?((0?[1-9])|(1[0-9])|(2[0-8]))))))(\\s(((0?[0-9])|(1[0-9])|(2[0-3]))\\:([0-5][0-9])((\\s)|(\\:([0-5][0-9])))?))?$)\\z/', $date_time)) ? TRUE : FALSE;
    }
    
  }

?>