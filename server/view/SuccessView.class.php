<?php

namespace app\view;

/**
 * Description of SuccessView
 *
 * @author thiago
 */
class SuccessView extends \stphp\http\HttpResponse {
  
  private $message;
  
  public function getStatus() {
    return 200;
  }

  public function getType() {
    return "json";
  }

  public function setMessange($message){
    $this->message = $message;
  }
  
  public function serialize() {
    return json_encode(array("message" => $this->message, "content" => $this->content, "type" => "success"));
  }
  
}