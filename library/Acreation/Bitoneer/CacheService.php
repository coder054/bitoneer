<?php
  
  namespace Acreation\Bitoneer;
  
  class CacheService{
    
    private static $cache;
    
    public static function get(){
      if (isset(static::$cache)){
        return static::$cache;
      }
      
      $cache_type = defined('CACHE_TYPE') ? CACHE_TYPE : 'file_system';
      
      if ($cache_type === 'sqlite'){
        $driver = new \Stash\Driver\Sqlite();
        
        $options = array(
          'nesting' => 1
        );
      } else {
        $driver = new \Stash\Driver\FileSystem();
      }
      
      $options['path'] = dirname(__FILE__).CACHE_PATH;
      
      $driver->setOptions($options);
      
      $stash = new \Stash\Pool($driver);
      
      static::$cache = $stash;
      
      return static::$cache;
    }
    
  }

?>