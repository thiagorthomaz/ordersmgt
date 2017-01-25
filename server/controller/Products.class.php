<?php


namespace app\controller;

/**
 * Description of Products
 *
 * @author thiago
 */
class Products extends \app\controller\Controller {
  
  
    public function all(){
    
    $product1 = new \app\model\Product();
    $product1->setId(1);
    $product1->setDescription("Desc 1");
    $product1->setName("Product 1");
    $product1->setUnitPrice(3);
    
    $product2 = new \app\model\Product();
    $product2->setId(2);
    $product2->setDescription("Desc 2");
    $product2->setName("Product 2");
    $product2->setUnitPrice(1.50);
    
    $product3 = new \app\model\Product();
    $product3->setId(3);
    $product3->setDescription("Desc 3");
    $product3->setName("Product 3");
    $product3->setUnitPrice(2.50);
    
    
    $this->addResponseContent($product1, true);
    $this->addResponseContent($product2, true);
    $this->addResponseContent($product3, true);
    
    return $this->getResponse();
  
  }
  
  public function post() {
    
    $params = $this->getRequest()->getAllParams();
    print_r($params);
    
    exit;
    
  }
  
  
}
