<?php
  
  namespace Acreation\Bitoneer;
  
  class Converters{
    
    public static function stampToGermanDate($tstamp){
      return date('d.m.Y', $tstamp);
    }
    
    public static function stampToGermanDateTime($tstamp){
      return date('d.m.Y, H:i', $tstamp).' Uhr';
    }
    
    public static function convertToGermanDate($sql_date){
      if (
        Validators::isDate($sql_date) ||
        Validators::isDateTime($sql_date)
      ){
        return static::stampToGermanDate(strtotime($sql_date));
      }
    }
    
    public static function convertToGermanDateTime($sql_date){
      if (
        Validators::isDate($sql_date) ||
        Validators::isDateTime($sql_date)
      ){
        return static::stampToGermanDateTime(strtotime($sql_date));
      }
    }
    
    public static function toSqlDateTime($string){
      if (Validators::isFilledString($string)){
        return date('Y-m-d H:i:s', strtotime($string));
      }
    }
    
    public static function valuesToStamp($day, $month, $year){
      return strtotime($year.'-'.$month.'-'.$day.' 00:00:00');
    }
    
    public static function formatCurrency($float, $currency = 'EUR'){
      return Formatters::formatGermanFloat($float).' '.$currency;
    }
    
    public static function formatVat($float){
      return Formatters::formatGermanFloat($float, 1).' %';
    }
    
    public static function getSqlDate($tstamp = NULL){
      if(is_null($tstamp)){
        $tstamp = time();
      }
      
      return date('Y-m-d', $tstamp);
    }
    
    public static function getSqlDateTime($tstamp = NULL){
      if(is_null($tstamp)){
        $tstamp = time();
      }
      
      return date('Y-m-d H:i:s', $tstamp);
    }
    
    public static function getFileNameFromText($text, $replace = array(), $delimiter = '-') {
      if (!empty($replace)) {
        $text = str_replace((array) $replace, ' ', $text);
      }
      
      $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
      $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
      $clean = strtolower(trim($clean, '-'));
      $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
      
      return $clean;
    }
  }
  
?>