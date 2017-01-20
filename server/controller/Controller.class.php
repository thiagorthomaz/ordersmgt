<?php


namespace app\controller;


/**
 * Description of Controller
 *
 * @author thiago
 */
abstract class Controller extends \stphp\Controller {
  
  protected function addResponseContent(\stphp\ArraySerializable $content, $append_to = null) {
    $this->response->addContent($content, $append_to);    
  }
  
  
}
