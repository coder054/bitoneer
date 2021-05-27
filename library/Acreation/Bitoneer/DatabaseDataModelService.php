<?php
  
  namespace Acreation\Bitoneer;
  
  abstract class DatabaseDataModelService extends DataModelService{
    
    protected static $table_name = '';
    protected static $id_string = 'id';
    
    public static function getTableName(){
      return static::$table_name;
    }
    
    public static function getIdString(){
      return static::$id_string;
    }
    
    public static function tableExists(){
      try {
        $db = Database::getConnection();
        
        $select_string = 'SELECT 1 FROM ';
        $select_string .= Database::buildTableName(static::getTableName());
        $select_string .= ' LIMIT 1';
        
        $result = $db->query($select_string);
      } catch (Exception $e){
        $e = FALSE;
        
        return FALSE;
      }
      
      return ($result !== FALSE);
    }
    
    public static function getAllIds(){
      return Database::getIds(array(
        'select_val' => static::getIdString(),
        'table' => static::getTableName()
      ));
    }
    
    public static function isValidId($id){
      return (Database::getId(array(
        'table' => static::getTableName(),
        'clause' => static::getIdString().' = ?',
        'values' => array($id)
      ))) ? TRUE : FALSE;
    }
    
  }

?>