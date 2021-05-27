<?php
  
  namespace Acreation\Bitoneer;
  
  abstract class DataModelService extends BaseClass{
    protected static $class_name = '';
    protected static $fields = array();
    
    public static function getFields(){
      return static::$fields;
    }
    
    public static function getById($id){
      $class_name = self::getClassName();
      $obj = Factory::get($class_name, $id);
      
      if ($obj){
        return $obj;
      }
      
      return new $class_name($id);
    }
    
    public static function getByIds($ids){
      $objs = array();
      
      foreach ($ids as $id){
        $objs[] = static::getById($id);
      }
      
      return $objs;
    }
    
    public static function getRandomByIds($ids, $limit = 0){
      $new_ids = $ids;
      shuffle($new_ids);
      
      $objs = array();
      
      foreach ($new_ids as $key => $id){
        if (($limit > 0) && ($key >= $limit)){
          break;
        }
        
        $objs[] = static::getById($id);
      }
      
      return $objs;
    }
    
    public static function getDataArrays($objs){
      if (!Validators::isArray($objs)){
        throw new \Exception('is no array');
      }
      
      $output = array();
      
      foreach ($objs as $obj){
        $output[] = static::getDataArray($obj);
      }
      
      return $output;
    }
    
  }

?>