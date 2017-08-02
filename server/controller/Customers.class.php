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
    unset($params['Customers_post']);
        
    $customer = new \app\model\Customer();
    
    foreach ($params as $field => $value) {
      call_user_func(array($customer, "set".$field), $value);
    }

    $date = $customer->getBirthday();
    $customer->setBirthday($this->formatDate($date, "Y-m-d"));
    
    $dao = new \app\model\CustomerDAO();
    
    if (!empty($customer->getId())) {
      $criteria = array("id" => $customer->getId());
      $saved = $dao->update($customer, $criteria);
    } else {
      $saved = $dao->insert($customer);
    }
    
    if ($saved) {
      $this->addResponseContent($customer);
      return $this->getResponse();
    } else {
      $message = new \app\view\ErrorView();
      $message->setMessange("We do have some problems to insert: " . $customer->getName() . ", please try again.");
      return $message;
    }
    
    
    
  }

  public function update() {
    
  }

}
