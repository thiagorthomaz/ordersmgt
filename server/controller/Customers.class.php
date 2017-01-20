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
    
    $customer1 = new \app\model\Customer();
    $customer1->setId(1);
    $customer1->setCredit(0);
    $customer1->setEmail("joao@email.com");
    $customer1->setName("João Silva");
    $customer1->setPhone("00111111111");
    
    
    $customer2 = new \app\model\Customer();
    $customer2->setId(2);
    $customer2->setCredit(10);
    $customer2->setEmail("pedro@email.com");
    $customer2->setName("Pedro Silva");
    $customer2->setPhone("00222222222");
    
    
    $customer3 = new \app\model\Customer();
    $customer3->setId(3);
    $customer3->setCredit(10);
    $customer3->setEmail("maria@email.com");
    $customer3->setName("Maria Oliveira");
    $customer3->setPhone("00333333333");
    
    
    $this->addResponseContent($customer1, true);
    $this->addResponseContent($customer2, true);
    $this->addResponseContent($customer3, true);
    
    return $this->getResponse();
    
    exit;
  }

  public function delete() {
    
  }

  public function get() {
    
  }

  public function post() {
    
  }

  public function update() {
    
  }

}
