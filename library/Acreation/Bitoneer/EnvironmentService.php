<?php
  
  namespace Acreation\Bitoneer;
  
  class EnvironmentService{
    private static $arr;
        
    public static function getArray(){
      if (static::$arr){
        return static::$arr;
      }
      
      require(dirname( __FILE__ ).'/../../../../../../config/environments.php');
      
      static::$arr = $environments;
      return $environments;
    }
    
    private static function getSection($key){
      $arr = static::getArray();
      
      if (isset($arr[$key])){
        return $arr[$key];
      }
    }
    
    private static function getGlobal(){
      return static::getSection('global');
    }
    
    public static function getEnv($key = 'APPLICATION_ENV'){
      return getenv($key);
    }
    
    public static function get($key){
      $global = static::getGlobal();
      
      $changer = static::getSection($key);
      
      if (!$changer){
        return $global;
      }
      
      foreach ($global as $key => $value){
        if (isset($changer[$key])){
          $global[$key] = $changer[$key];
        }
      }
      
      return $global;
    }
    
    public static function setDefines($key){
      $values = static::get($key);
      
      if (!$values){
        return FALSE;
      }
      
      foreach ($values as $key => $value){
        if (defined($key)){
          continue;
        }
        
        define($key, $value);
      }
      
      return TRUE;
    }
    
  }

?>