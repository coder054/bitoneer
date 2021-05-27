<?php
  
  namespace Acreation\Bitoneer;
  
  class ViewService{
    
    public static function error404Action(){
      header("HTTP/1.0 404 Not Found");
      OutputService::generate('views/error_404.html.twig');
      die();
    }
    
    public static function error500Action(\Exception $e){
      LogService::save($e);
      
      header('HTTP/1.1 500 Internal Server Error');
      OutputService::generate('views/error_500.html.twig');
      die();
    }
    
  }
  
?>