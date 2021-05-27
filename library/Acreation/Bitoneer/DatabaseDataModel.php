<?php
  
  namespace Acreation\Bitoneer;
  
  abstract class DatabaseDataModel extends DataModel{
    
    /**
     * @param int $id
     */
    public function __construct($id = 0) {
      $fields = $this->getFields();
      
      foreach ($fields as $field){
        if (is_null($field['default_val'])){
          continue;
        }
        
        $this->callFunc(array(
          'method' => 'set',
          'function' => $field['function'],
          'value' => $field['default_val']
        ));
      }
      
      parent::__construct($id);
    }
    
    protected function getTableName(){
      return $this->callServiceClassMethod('getTableName');
    }
    
    protected function getIdString(){
      return $this->callServiceClassMethod('getIdString');
    }
    
    protected function load(){
      if (!$this->getId()){
        throw new \Exception('id not set!');
      }
      
      $string = Database::buildSelectString(array(
        'select_val' => '*',
        'table' => $this->getTableName(),
        'clause' => $this->getIdString().' = ?'
      ));
      
      $result = Database::getEntry($string, array($this->getId()));
      
      if (!$result){
        throw new \Exception('id not valid!');
      }
      
      foreach ($this->getFields() as $value){
        $this->callFunc(array(
          'method' => 'set',
          'function' => $value['function'],
          'value' => static::generateInputValue($value, $result[$value['field']])
        ));
      }
      
      Factory::set($this);
      return TRUE;
    }
    
    private static function generateInputValue($field, $value){
      if ($field['type'] === 'boolean'){
        return ($value == "1");
      }
      
      return $value;
    }
    
    private function update(){
      $fields = $this->generateFields();
      $values = $this->generateValues();
      
      $values[] = $this->getId();
      
      $string = Database::buildUpdateString(array(
        'table' => $this->getTableName(),
        'fields' => $fields,
        'clause' => $this->getIdString().' = ?'
      ));
      
      if (Database::changeEntry($string, $values)){
        return TRUE;
      }
    }
    
    private function insert(){
      $fields = $this->generateFields();
      $values = $this->generateValues();
      
      $string = Database::buildInsertString(array(
        'table' => $this->getTableName(),
        'fields' => $fields
      ));
      
      if (Database::changeEntry($string, $values)){
        return TRUE;
      }
    }
    
    private function buildClause($settings = array()){
      $fields = $this->getFields();
      
      $string = '';
      $i = 0;
      
      $count = count($fields);
      
      foreach ($fields as $field){
        if(
          isset($settings['for_find']) &&
          $settings['for_find'] &&
          !static::inFind($field)
        ){
          $count--;
          continue;
        }
        
        $string .= $field['field'].' '.$field['compare'].' ?';
        
        if ($i < ($count - 1)){
          $string .= ' AND ';
        }
        
        $i++;
      }
      
      return $string;
    }
    
    public function findId($settings = array()){
      return Database::getId(array(
        'select_val' => $this->getIdString(),
        'table' => $this->getTableName(),
        'clause' => $this->buildClause($settings),
        'values' => $this->generateValues($settings),
        'sort' => $this->getIdString().' DESC'
      ));
    }
    
    public function save(){
      if (!$this->isValid()){
        throw new \Exception ('Data not valid!');
      }
      
      if ($this->getId()){
        
        if (!$this->update()){
          throw new \Exception('update error');
        }
        
        Factory::set($this);
        return TRUE;
        
      }
      
      if (!$this->insert()){
        throw new \Exception('insert error');
      }

      $id = $this->findId();

      if (!$id){
        throw new \Exception('id could not be found');
      }

      $this->setId($id);
      Factory::set($this);

      return TRUE;
    }
    
    public function delete(){
      if (!($entry_id = $this->getId())){
        throw new \Exception('id not set!');
      }
      
      Factory::remove($this);
      
      return Database::deleteId(array(
        'id_string' => $this->getIdString(),
        'table' => $this->getTableName(),
        'value' => $entry_id
      ));
    }
    
  }
  
?>