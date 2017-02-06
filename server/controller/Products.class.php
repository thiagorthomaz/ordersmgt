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
    unset($params['Products_post']);
    
    $product = new \app\model\Product();
    

    foreach ($params as $field => $value) {
      call_user_func(array($product, "set".$field), $value);
    }

    $dao = new \app\model\ProductsDAO();
    
    if ($dao->insert($product)) {
      $this->addResponseContent($product);
      return $this->getResponse();
    } else {
      $message = new \app\view\ErrorView();
      $message->setMessange("We do have some problems to insert: " . $product->getName() . ", please try again.");
      return $message;
    }
    
    
    
  }
  
  
}
