<?php


namespace app\controller;


/**
 * Description of Controller
 *
 * @author thiago
 */
abstract class Controller extends \stphp\Controller {
  
  protected $string_msg_error = "";
      
  function __construct() {
    parent::__construct();
    $this->response = new \app\view\View();
  }
  
  protected function addResponseContent(\stphp\ArraySerializable $content, $append_to = null) {
    $this->response->addContent($content, $append_to);    
  }
  
  protected function responseError($string = ""){
    
    $message = new \app\view\ErrorView();
    if (empty($string)) {
      $message->setMessange($this->string_msg_error);
    } else {
      $message->setMessange($string);
    }
    
    return $message;

  }
  
  
}
