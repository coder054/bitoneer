<?php
  
  namespace Acreation\Bitoneer;
  
  class ApiService{
    
    public static function templateAction(){
      $id = Helpers::getParam('id');
      $file_name = $id.'.html';
      
      $file_path = static::TEMPLATE_FOLDER.$file_name;
      $file_content = Helpers::getFileContents($file_path);
      
      if (!$file_content){
        \Flight::json(array(
          'errorCode' => 1,
          'message' => 'Template not found'
        ), 400);
      }
      
      \Flight::json(array(
        'template' => $file_content
      ));
    }
    
    public static function minifyScriptsAction(){
      try {
        $content = DataService::getContentMinifiedScripts(static::SCRIPT_FOLDER, 'scripts');
        ScriptMinifier::toBrowser($content);
        
      } catch (\Exception $exc){
        \Flight::json(array(
          'errorCode' => $exc->getCode(),
          'message' => $exc->getMessage()
        ), 400);
      }
    }
    
  }
  
?>