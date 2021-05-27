<?php

  namespace Acreation\Bitoneer;
  
  class Factory{
    
    public static $instances;
    
    public static function get($class_name, $id){
      if (!Validators::isArray(self::$instances)){
        return FALSE;
      }
      
      if (!isset(self::$instances[$class_name])){
        return FALSE;
      }
      
      if (!isset(self::$instances[$class_name][$id])){
        return FALSE;
      }
      
      return self::$instances[$class_name][$id];
    }
    
    public static function set($obj){
      $class = $obj->getClass();
      $id = $obj->getId();
      
      if (!Validators::isArray(self::$instances)){
        self::$instances = array();
      }
      
      if (!isset(self::$instances[$class->getName()])){
        self::$instances[$class->getName()] = array();
      }
      
      self::$instances[$class->getName()][$id] = $obj;
      return TRUE;
    }
    
    public static function remove($obj){
      $class = $obj->getClass();
      $id = $obj->getId();
      
      if (!Validators::isArray(self::$instances)){
        return TRUE;
      }
      
      if (!isset(self::$instances[$class->getName()])){
        return TRUE;
      }
      
      if (!isset(self::$instances[$class->getName()][$id])){
        return TRUE;
      }
      
      unset(self::$instances[$class->getName()][$id]);
      return TRUE;
    }
    
  }

?>