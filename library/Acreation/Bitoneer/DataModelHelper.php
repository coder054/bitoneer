<?php
  
  namespace Acreation\Bitoneer;
  
  class DataModelHelper{
    
    public static function isDefaultValue($field, $value){
      if (
        !is_null($field['default_val']) &&
        ($field['default_val'] === $value)
      ){
        return TRUE;
      }
    }
    
    public static function hasValidValue($field, $value){
      if (static::isDefaultValue($field, $value)){
        return TRUE;
      }
      
      if ($field['type'] === 'string'){
        return Validators::isString($value);
      } else if ($field['type'] === 'filled_string'){
        return Validators::isFilledString($value);
      } else if ($field['type'] === 'filled'){
        return Validators::isNotEmpty($value);
      } else if ($field['type'] === 'email'){
        return Validators::isEmail($value);
      } else if ($field['type'] === 'integer'){
        return Validators::isInteger($value);
      } else if ($field['type'] === 'identifier'){
        return Validators::isIdentifier($value);
      } else if ($field['type'] === 'boolean'){
        return Validators::isBoolean($value);
      } else if ($field['type'] === 'float'){
        return Validators::isFloat($value);
      } else if ($field['type'] == 'date'){
        return Validators::isDate($value);
      } else if ($field['type'] == 'datetime'){
        return Validators::isDateTime($value);
      }
      
      return FALSE;
    }
    
    public static function getCastedValue($field, $value){
      if (
        ($field['type'] === 'string') ||
        ($field['type'] === 'filled_string') ||
        ($field['type'] === 'email') ||
        ($field['type'] === 'date') ||
        ($field['type'] === 'datetime')
      ){
        return (string) $value;
      } else if (
        ($field['type'] === 'integer') ||
        ($field['type'] === 'identifier')
      ){
        return (int) $value;
      } else if ($field['type'] === 'boolean'){
        return (bool) $value;
      } else if ($field['type'] === 'float'){
        return (float) $value;
      }
      
      return $value;
    }
    
    public static function generateOutputValue($field, $value){
      if ($field['type'] === 'boolean'){
        return $value ? 1 : 0;
      }
      
      return $value;
    }
    
  }
  
?>