<?php
  
  namespace Acreation\Bitoneer;
  
  class AppException extends Exception{
    
    private $params;
    
    public function setParams(array $params){
      $this->params = $params;
    }
    
    public function getParams() {
      return $this->params;
    }
    
  }
  
?>