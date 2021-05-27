<?php
  
  namespace Acreation\Bitoneer;
  
  abstract class StaticDataModelService extends DataModelService{
    
    protected static $data_path = '';
    protected static $data;
    
    public static function getData(){
      $path = static::$data_path;
      
      if (isset(static::$data[$path])){
        return static::$data[$path];
      }
      
      $data = array();
      require(dirname(__FILE__).'/../../../../../'.$path);
      
      static::$data[$path] = $data;
      return $data;
    }
    
    public static function getAllIds(){
      $entries = static::getData();
      $output = array();
      
      foreach ($entries as $entry){
        $output[] = $entry['id'];
      }
      
      return $output;
    }
    
    public static function isValidId($id){
      $ids = static::getAllIds();
      return in_array($id, $ids);
    }
    
  }

?>