<?php
  
  namespace Acreation\Bitoneer;
  
  class ScriptMinifier{
    
    public static function getFileContent($file_path){
      return Helpers::getFileContents($file_path);
    }
    
    public static function fileExists($file_path){
      return file_exists($file_path);
    }
    
    public static function isValidFileName($file_name){
      return Validators::isFileName($file_name);
    }
    
    public static function buildPath($path, $file_name){
      return $path.$file_name;
    }
    
    public static function getFullPath($path, $file_name){
      if (!self::isValidFile($path, $file_name)){
        return FALSE;
      }
      
      return self::buildPath($path, $file_name);
    }
    
    public static function isValidFile($path, $file_name){
      if (!self::isValidFileName($file_name)){
        return FALSE;
      }
      
      $full_path = self::buildPath($path, $file_name);
      
      if (!self::fileExists($full_path)){
        return FALSE;
      }
      
      return TRUE;
    }
    
    public static function minifyContent($content){
      return \JShrink\Minifier::minify($content, array('flaggedComments' => FALSE));
    }
    
    public static function minify($file_path){
      $content = self::getFileContent($file_path);
      return self::minifyContent($content);
    }
    
    public static function toBrowser($content){
      header('Content-Type: application/javascript');
      echo $content;
    }
    
    public static function output($file_path){
      $content = self::minify($file_path);
      return self::toBrowser($content);
    }
    
  }
  
?>