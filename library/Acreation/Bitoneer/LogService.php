<?php
  
  namespace Acreation\Bitoneer;
  
  class LogService {
    
    public static function save($exception) {
      $filename = date('Y-m-d') . '-errorlog.txt';
      
      file_put_contents(
        dirname(__FILE__) . '/../../../../../../errorlogs/' .$filename,
        
        "-------------------------------\n" .
        Converters::getSqlDateTime() . "\n" .
        "-------------------------------\n" .
        $exception->getMessage() . "\n" .
        "-------------------------------\n" .
        $exception->getTraceAsString() . "\n\n",
        
        FILE_APPEND
      );
    }
    
  }

?>