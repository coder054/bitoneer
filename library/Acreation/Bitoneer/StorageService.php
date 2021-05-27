<?php
  
  namespace Acreation\Bitoneer;
  
  class StorageService{
    
    const SCOPE_APP = 'app';
    const SCOPE_USER = 'user';
    
    // START SESSION
    public static function start($config){
      static::setParams($config);
      static::enable();
    }
    
    // DESTROY SESSION
    public static function destroyAll(){
      if (!static::getSession()){
        return TRUE;
      }
      
      static::setSession();
      
      if (ini_get("session.use_cookies")){
        $params = session_get_cookie_params();
        
        setcookie(
          session_name(),
          '',
          time() - 42000,
          $params['path'],
          $params['domain'],
          $params['secure'], 
          $params['httponly']
        );
      }
      
      session_destroy();
    }
    
    public static function destroy($scope){
      if (!static::getScope($scope)){
        return TRUE;
      }
      
      static::setScope($scope);
      
      return TRUE;
    }
    
    public static function getAll($scope){
      $output = array();
      
      if (!($values = static::getScope($scope))){
        return $output;
      }
            
      foreach ($values as $key => $value){
        $output[] = $key;
      }
      
      return $output;
    }
    
    public static function get($scope, $key){
      if (!($values = static::getScope($scope))){
        return FALSE;
      }
      
      return (isset($values[$key])) ? $values[$key] : FALSE;
    }
    
    public static function set($scope, $key, $value){
      if (!static::getScope($scope)){
        static::setScope($scope);
      }
      
      $_SESSION[SESSION_KEY][$scope][$key] = $value;
      
      return TRUE;
    }
    
    public static function reset($scope, $key){
      unset($_SESSION[SESSION_KEY][$scope][$key]);
      return TRUE;
    }
    
    private static function setParams($config){
      if (defined('SESSION_SAVE_PATH')){
        session_save_path(SESSION_SAVE_PATH);
        ini_set('session.gc_probability', 1);
      }
      
      session_set_cookie_params(0, $config->path, '', $config->secure, TRUE);
    }
    
    private static function enable(){
      session_start();
    }
    
    private static function getSession(){
      return isset($_SESSION[SESSION_KEY]) ? $_SESSION[SESSION_KEY] : FALSE;
    }
    
    private static function setSession(){
      $_SESSION[SESSION_KEY] = array();
      return TRUE;
    }
    
    private static function getScope($scope){
      if (!(static::getSession())){
        return FALSE;
      }
      
      return isset($_SESSION[SESSION_KEY][$scope]) ? $_SESSION[SESSION_KEY][$scope] : FALSE;
    }
    
    private static function setScope($scope){
      if (!(static::getSession())){
        static::setSession();
      }
      
      $_SESSION[SESSION_KEY][$scope] = array();
      
      return TRUE;
    }
    
  }

?>