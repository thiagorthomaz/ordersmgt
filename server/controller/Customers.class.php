<?php

namespace app\controller;

/**
 * Description of Customers
 *
 * @author thiago
 */
class Customers extends \app\controller\Controller {
  
  function __construct() {
    parent::__construct();
    $this->response = new \app\view\View();
  }
  
  public function all(){
    
    $dao = new \app\model\CustomerDAO();
    $customers = $dao->selectAll(100, $dao->getModel());
    
    foreach ($customers as $c){
      $this->addResponseContent($c, true);
    }
    
    
    return $this->getResponse();
  
  }

  public function delete() {
    
  }

  public function get() {
    
  }

  public function post() {
    
    $params = $this->getRequest()->getAllParams();
    print_r($params);
    
    exit;
    
  }

  public function update() {
    
  }

}
