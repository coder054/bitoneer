<?php
  
  namespace Acreation\Bitoneer;
  
  class Helpers{
    
    public static function getHttpMethod(){
      $request = Flight::request();
      return $request->method;
    }
    
    public static function getInputStreamParams(){
      $post_vars = array();
      parse_str(file_get_contents("php://input"), $post_vars);
      
      return $post_vars;
    }
    
    public static function getParam($key){
      if (
        isset($_REQUEST[$key]) &&
        ($_REQUEST[$key] != '')
      ){
        return $_REQUEST[$key];
      }
    }
    
    public static function getPostParam($key){
      if (
        isset($_POST[$key]) &&
        ($_POST[$key] != '')
      ){
        return $_POST[$key];
      }
    }
    
    public static function getInputStreamParam($check_key){
      $params = self::getInputStreamParams();
      
      foreach ($params as $key => $value){
        if ($check_key !== $key){
          continue;
        }
        
        return $value;
      }
    }
    
    public static function getIp(){
      if (getenv('HTTP_CLIENT_IP')){
        return getenv('HTTP_CLIENT_IP');
      } else if(getenv('HTTP_X_FORWARDED_FOR')){
        return getenv('HTTP_X_FORWARDED_FOR');
      } else if(getenv('HTTP_X_FORWARDED')){
        return getenv('HTTP_X_FORWARDED');
      } else if(getenv('HTTP_FORWARDED_FOR')){
        return getenv('HTTP_FORWARDED_FOR');
      } else if(getenv('HTTP_FORWARDED')){
        return getenv('HTTP_FORWARDED');
      } else if(getenv('REMOTE_ADDR')){
        return getenv('REMOTE_ADDR');
      }
      
      return FALSE;
    }
    
    public static function getExternalIp(){
      return file_get_contents('http://phihag.de/ip/');
    }
    
    public static function getFileContents($file_path){
      if (file_exists($file_path)){
        return file_get_contents($file_path);
      }
      
      return FALSE;
    }
    
    public static function externalFileExists($file_path){
      $file_cont = @file_get_contents($file_path);
      return ($file_cont === FALSE) ? FALSE : TRUE;
    }
    
    public static function shuffleLimit($entries, $shuffle = FALSE, $limit = 0){
      if ($shuffle){
        shuffle($entries);
      }
      
      $output = array();
      
      foreach ($entries as $key => $entry){
        if (($limit > 0) && (($key + 1) > $limit)){
          break;
        }
        
        $output[] = $entry;
      }
      
      return $output;
    }
    
    public static function sortArrayByKey($arr, $sort_key, $sorting = SORT_DESC){
      $sorter = array();
      
      foreach ($arr as $key => $row){
        $sorter[$key] = $row[$sort_key];
      }
      
      array_multisort($sorter, $sorting, $arr);
      return $arr;
    }
    
    public static function getViaCurl($url, $fields){
      $fields_string = '';
      
      foreach ($fields as $key => $value){
        $fields_string .= $key.'='.$value.'&';
      }
      
      $ch = curl_init();
      
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim($fields_string, '&'));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      
      $content = curl_exec($ch);
      curl_close($ch);
      
      return $content;
    }
    
    public static function debug($value){
      echo '<pre>';
      echo 'print_r:<br /><br />';
      print_r($value);
      echo '<br /><br />';
      
      echo 'var_dump:<br /><br />';
      var_dump($value);
      echo '</pre>';
    }
    
    private static function getClassPath($class){
      return get_class($class);
    }
    
    public static function getClass($class){
      $path = self::getClassPath($class);
      return new \ReflectionClass($path);
    }
  }

?>