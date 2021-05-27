<?php
  
  namespace Acreation\Bitoneer;
  
  abstract class DataModel extends BaseClass{
    private $storage;
    protected $service_class;
    
    public function __construct($id){
      $this->setId($id);
      
      if ($id !== 0){
        $this->load();
      }
    }
    
    abstract protected function load();
    
    protected function getServiceClass(){
      return $this->service_class;
    }
    
    protected function callServiceClassMethod($method){
      return call_user_func(array(self::buildClassName(self::getNamespace(), $this->getServiceClass()), $method));
    }
    
    protected function getFields(){
      return $this->callServiceClassMethod('getFields');
    }
    
    protected function getFieldByMethod($method){
      foreach ($this->getFields() as $field){
        if ($field['function'] == $method){
          return $field;
        }
      }
      
      return FALSE;
    }
    
    private function setStorageValue($key, $value){
      $this->storage[$key] = $value;
    }
    
    protected function getStorageValue($key){
      if (!isset($this->storage[$key])){
        return NULL;
      }
      
      return $this->storage[$key];
    }
    
    public function __call($func, $arguments){
      $type = substr($func, 0, 3);
      $method = substr($func, 3);
      
      $field = $this->getFieldByMethod($method);
      
      if (!$field){
        throw new \Exception('method not defined');
      }
      
      if ($type === 'get'){
        return $this->getStorageValue($field['field']);
      } else if ($type === 'set'){
        $value = $arguments[0];
        
        if (!DataModelHelper::hasValidValue($field, $value)){
          return FALSE;
        }
        
        $this->setStorageValue(
          $field['field'],
          DataModelHelper::getCastedValue($field, $value)
        );
                
        return TRUE;
      }
      
      throw new \Exception('type not defined');
    }
    
    protected function setId($val){
      if (!Validators::isIdentifier($val)){
        return FALSE;
      }
      
      $this->setStorageValue('id', (int) $val);
      return TRUE;
    }
    
    public function getId(){
      return $this->getStorageValue('id');
    }
    
    public function isValid(){
      foreach ($this->getFields() as $field){
        if (!$field['required']){
          continue;
        }
        
        if (is_null($this->callFunc(array(
          'method' => 'get',
          'function' => $field['function']
        )))){
          return FALSE;
        }
      }
      
      return TRUE;
    }
    
    protected function generateFields(){
      $fields = array();
      
      foreach ($this->getFields() as $field){
        $fields[] = $field['field'];
      }
      
      return $fields;
    }
    
    public function inFind($field){
      return (isset($field['in_find']) && !$field['in_find']) ? FALSE : TRUE;
    }
    
    protected function generateValues($settings = array()){
      $values = array();
      
      foreach ($this->getFields() as $field){
        if(
          isset($settings['for_find']) &&
          $settings['for_find'] &&
          !static::inFind($field)
        ){
          continue;
        }
        
        $value = $this->callFunc(array(
          'method' => 'get',
          'function' => $field['function']
        ));
        
        $values[] = DataModelHelper::generateOutputValue($field, $value);
      }
      
      return $values;
    }
    
    public function getClass(){
      return Helpers::getClass($this);
    }
    
    public function callFunc($settings){
      if (!isset($settings['value'])){
        $settings['value'] = NULL;
      }
      
      return call_user_func(
        array($this, $settings['method'].$settings['function']),
        $settings['value']
      );
    }
    
  }
  
?>