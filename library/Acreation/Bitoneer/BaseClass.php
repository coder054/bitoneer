<?php

  namespace Acreation\Bitoneer;
  
  abstract class BaseClass{
    
    protected static function getNamespace(){
      return substr(get_called_class(), 0, strrpos(get_called_class(), '\\'));
    }
    
    protected static function buildClassName($namespace, $class_name){
      return $namespace.'\\'.$class_name;
    }
    
    protected static function getClassName(){
      $namespace = self::getNamespace();
      $class_name = static::$class_name;
      
      return self::buildClassName($namespace, $class_name);
    }
    
  }

?>