<?php
  
  namespace Acreation\Bitoneer;
  
  class PageService extends StaticDataModelService{
    
    protected static $class_name = 'Page';
    protected static $data_path = '../config/pages.php';
    protected static $fields = array(
      array(
        'type' => 'string',
        'required' => TRUE,
        'default_val' => '',
        'field' => 'type',
        'function' => 'Type',
      ),
      array(
        'type' => 'identifier',
        'required' => TRUE,
        'default_val' => 0,
        'field' => 'parent_id',
        'function' => 'ParentId',
      ),
      array(
        'type' => 'boolean',
        'required' => TRUE,
        'default_val' => TRUE,
        'field' => 'visible',
        'function' => 'Visible',
      ),
      array(
        'type' => 'filled_string',
        'required' => TRUE,
        'default_val' => NULL,
        'field' => 'view_class',
        'function' => 'ViewClass',
      ),
      array(
        'type' => 'filled_string',
        'required' => TRUE,
        'default_val' => NULL,
        'field' => 'method',
        'function' => 'Method',
      ),
      array(
        'type' => 'string',
        'required' => TRUE,
        'default_val' => NULL,
        'field' => 'url',
        'function' => 'Url',
      ),
    );
    
    public static function getUrl(Page $page, $values = array(), $params = array('@id')){
      $url = OutputService::getFullUrl().$page->getUrl();
      
      if (!Validators::isArray($values)){
        $values = array($values);
      }
      
      if (count($values) === 0){
        return $url;
      }
      
      if (!Validators::isArray($params)){
        $params = array($params);
      }
      
      return str_replace($params, $values, $url);
    }
    
  }

?>