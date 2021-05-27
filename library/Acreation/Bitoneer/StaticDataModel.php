<?php
  
  namespace Acreation\Bitoneer;
  
  abstract class StaticDataModel extends DataModel{
    
    protected function getData(){
      return $this->callServiceClassMethod('getData');
    }
    
    protected function load(){
      if (!($id = $this->getId())){
        throw new \Exception('id not set!');
      }
      
      $data = $this->getData();
      
      foreach ($data as $entry){
        if ($entry['id'] !== $id){
          continue;
        }
        
        $this->setId($id);
        
        foreach ($this->getFields() as $value){
          $this->callFunc(array(
            'method' => 'set',
            'function' => $value['function'],
            'value' => $entry[$value['field']]
          ));
        }
        
        return TRUE;
      }
      
      throw new \Exception('id not valid!');
    }
    
  }
  
?>