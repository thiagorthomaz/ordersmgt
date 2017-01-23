<?php



namespace app\view;


/**
 * Description of ResponseJSON
 *
 * @author thiago
 */
class View extends \stphp\http\HttpResponse {
  
  function __construct() {
    
  }
  
  public function notFound(){
    echo "Not found";
    exit;
  }

  public function getStatus() {
    return 200;
  }

  public function getType() {
    return "json";
  }

  public function serialize() {
    return json_encode(array("content" => $this->content));
  }

}
