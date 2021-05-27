<?php
  
  namespace Acreation\Bitoneer;
  
  class Database {
    
    public static function getConnection() {
      $connect = DB_TYPE.':';
      $connect .= 'host='.DB_SERVER.';';
      
      if (defined('DB_PORT')){
        $connect .= 'port='.DB_PORT.';';
      }
      
      $connect .= 'dbname='.DB_NAME.';';
      $connect .= 'charset=utf8';
      
      return new \PDO(
        $connect,
        DB_USER,
        DB_PASSWORD,
        array(
          \PDO::ATTR_PERSISTENT => TRUE,
        )
      );
    }
    
    public static function buildClause($settings) {
      $string = '';
      
      if (
        isset($settings['clause']) &&
        Validators::isFilledString($settings['clause'])
      ) {
        $string .= ' WHERE ' . $settings['clause'];
      }
      
      return $string;
    }
    
    public static function buildGroup($settings) {
      $string = '';
      
      if (
        isset($settings['group']) &&
        Validators::isFilledString($settings['group'])
      ) {
        $string .= ' GROUP BY ' . $settings['group'];
      }
      
      return $string;
    }
    
    public static function buildSort($settings) {
      $string = '';
      
      if (
        isset($settings['sort']) &&
        Validators::isFilledString($settings['sort'])
      ) {
        $string .= ' ORDER BY ' . $settings['sort'];
      }
      
      return $string;
    }
    
    public static function buildSelectString($settings) {
      $string = 'SELECT ' . $settings['select_val'] . ' FROM ' . static::buildTableName($settings['table']);
      
      $string .= static::buildClause($settings);
      $string .= static::buildGroup($settings);
      $string .= static::buildSort($settings);
      
      return $string;
    }
    
    public static function buildTableName($table){
      return DB_PREFIX.$table;
    }
    
    public static function buildInsertString($settings) {
      $fields = $settings['fields'];
      
      $string = 'INSERT INTO '.self::buildTableName($settings['table']).' (';
      $string .= implode($fields, ', ');
      $string .= ') VALUES (';
      
      for ($i = 0; $i < count($fields); $i++) {
        $string .= '?';
        
        if ($i < (count($fields) - 1)) {
          $string .= ', ';
        }
      }
      
      $string .= ')';
      
      return $string;
    }
    
    public static function buildUpdateString($settings) {
      $string = 'UPDATE '.self::buildTableName($settings['table']). ' SET ';
      $fields = $settings['fields'];
      
      $i = 0;
      
      foreach ($fields as $field) {
        $string .= $field . ' = ?';
        
        if ($i < (count($fields) - 1)) {
          $string .= ', ';
        }
        
        $i++;
      }
      
      $string .= static::buildClause($settings);
      
      return $string;
    }
    
    public static function buildDeleteString($settings) {
      $string = 'DELETE FROM '.self::buildTableName($settings['table']);
      $string .= static::buildClause($settings);
      
      return $string;
    }
    
    public static function getEntry($string, $values) {
      $db = static::getConnection();
      
      $query = $db->prepare($string);
      $query->execute($values);
      
      return $query->fetch(\PDO::FETCH_ASSOC);
    }
    
    public static function changeEntry($string, $values) {
      $db = static::getConnection();
      
      $query = $db->prepare($string);
      return $query->execute($values);
    }
    
    public static function getIds($settings) {
      if (!isset($settings['select_val'])) {
        $settings['select_val'] = 'id';
      }
      
      if (!isset($settings['return_val'])) {
        $settings['return_val'] = $settings['select_val'];
      }
      
      $string = static::buildSelectString($settings);
      $values = !isset($settings['values']) ? array() : $settings['values'];
      
      $db = static::getConnection();
      $query = $db->prepare($string);
      $query->execute($values);
      
      $entries = $query->fetchAll();
      $output = array();
      
      foreach ($entries as $entry) {
        $output[] = (int) $entry[$settings['return_val']];
      }
      
      return $output;
    }
    
    public static function getId($settings) {
      if (!isset($settings['select_val'])) {
        $settings['select_val'] = 'id';
      }
      
      if (!isset($settings['return_val'])) {
        $settings['return_val'] = $settings['select_val'];
      }
      
      $string = static::buildSelectString($settings);
      $values = !isset($settings['values']) ? array() : $settings['values'];
      
      $entry = static::getEntry($string, $values);
      
      if ($entry) {
        return (int) $entry[$settings['return_val']];
      }
    }
    
    public static function deleteId($settings) {
      if (!isset($settings['id_string'])){
        $settings['id_string'] = 'id';
      }
      
      $settings['clause'] = $settings['id_string'].' = ?';
      
      $db = static::getConnection();
      $string = static::buildDeleteString($settings);
      
      $query = $db->prepare($string);
      return $query->execute(array($settings['value'])) ? TRUE : FALSE;
    }
    
  }

?>