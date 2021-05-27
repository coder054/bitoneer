<?php
  
  namespace Acreation\Bitoneer;
  
  class App{
    
    const VIEW_CLASS = 'ViewService';
    const API_CLASS = 'ApiService';
    
    public function __construct(){
      EnvironmentService::setDefines(EnvironmentService::getEnv());
      \Flight::set('flight.log_errors', TRUE);
      
      new \App();
    }
    
    public static function enablePageRoutes(){
      $page_ids = PageService::getAllIds();
      
      foreach ($page_ids as $page_id){
        $page = PageService::getById($page_id);
        
        $type = Validators::isFilledString($page->getType()) ? $page->getType().' ' : '';
        $view_class = $page->getViewClass() ? $page->getViewClass() : static::VIEW_CLASS;
        
        \Flight::route($type.'/'.$page->getUrl(), array($view_class, $page->getMethod()));
      }
    }
    
  }

?>