<?php
  
  namespace Acreation\Bitoneer;
  
  class OutputService{
    
    const TEMPLATE_DIR = '../templates/';
    
    public static function getFullUrl(){
      return BASE_URL.SUBFOLDER;
    }
    
    public static function getParams($params){
      return array_merge($params, \App::getGlobalParams());
    }
    
    public static function addFilters($env){
      $env->addFilter(new \Twig_SimpleFilter('money', function ($float){
        $currency = (defined('CURRENCY')) ? CURRENCY : '€';
        return Converters::formatCurrency($float, $currency);
      }));
      
      $env->addFilter(new \Twig_SimpleFilter('german_date', function($string){
        return Converters::convertToGermanDate($string);
      }));
    }
    
    public static function getEnvironment($loader){
      $env = new \Twig_Environment($loader);
      static::addFilters($env);
      
      return $env;
    }
    
    public static function getContent($template_name, $params = array()){
      $loader = new \Twig_Loader_Filesystem(static::TEMPLATE_DIR);
      $twig = static::getEnvironment($loader);
      
      $all_params = static::getParams($params);
      return static::render($twig, $template_name, $all_params);
    }
    
    public static function getContentViaString($content, $params = array()){
      $loader = new \Twig_Loader_String();
      $twig = static::getEnvironment($loader);
      
      $all_params = static::getParams($params);
      return static::render($twig, $content, $all_params);
    }
    
    public static function render($twig, $content, $params){
      return $twig->render($content, $params);
    }
    
    public static function output($content){
      echo $content;
    }
    
    public static function generate($template_name, $params = array()){
      $content = static::getContent($template_name, $params);
      static::output($content);
    }
    
  }

?>