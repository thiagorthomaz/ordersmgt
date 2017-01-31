<?php


namespace app\controller;

/**
 * Description of Products
 *
 * @author thiago
 */
class Products extends \app\controller\Controller {
  
  
    public function all(){
    
      $dao = new \app\model\ProductsDAO();
      $products = $dao->selectAll(100, $dao->getModel());
      
      foreach ($products as $p){
        $this->addResponseContent($p, true);
      }
    
    
      return $this->getResponse();
  
  }
  
  public function post() {
    
    $params = $this->getRequest()->getAllParams();
    print_r($params);
    
    exit;
    
  }
  
  
}
