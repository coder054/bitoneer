<?php
  
  namespace Acreation\Bitoneer;
  
  class DataService{
    
    const ERROR_JSON_INVALID = 1;
    const ERROR_NO_ARRAY = 2;
    const ERROR_FILE_PATH_INVALID = 3;
    
    public static function getContentMinifiedScripts($file_path, $param_name){
      $scripts_string = Helpers::getParam($param_name);
      
      try {
        $scripts = json_decode($scripts_string);
      } catch (Exception $exc) {
        $exc = FALSE;
        throw new \Exception('JSON not valid', self::ERROR_JSON_INVALID);
      }
      
      if (!Validators::isArray($scripts)){
        throw new \Exception('is no array', self::ERROR_NO_ARRAY);
      }
      
      $output = '';
      
      foreach ($scripts as $script){
        $script_path = ScriptMinifier::getFullPath($file_path, $script);
        
        if (!$script_path){
          throw new \Exception($script.' not valid', self::ERROR_FILE_PATH_INVALID);
        }
        
        $script_content = ScriptMinifier::getFileContent($script_path);
        $output .= $script_content;
      }
      
      return ScriptMinifier::minifyContent($output);
    }
    
  }
  
?>