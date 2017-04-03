<?php


namespace app\model;

/**
 * Description of Purchase
 *
 * @author thiago
 */
class Purchase implements \stphp\ArraySerializable {
  
  private $customer;
  private $order;
  private $order_detail;
  private $product;
  
  
  public function __construct(\app\model\Order $order) {
    $this->order = $order;
    
    $id_customer = $order->getId_customer();
    $id_order_detail = $order->getId_order_details();
    
    $customer_dao = new \app\model\CustomerDAO();
    $order_detail_dao = new \app\model\OrderDetailDAO();
    $product_dao = new \app\model\ProductsDAO();
    
    $customer = $customer_dao->getModel();
    $customer->setId($id_customer);
    
    $order_detail = $order_detail_dao->getModel();
    $order_detail->setId($id_order_detail);
    
    $product = $product_dao->getModel();
    
    $this->customer = $customer_dao->select($customer)[0];
    $this->order_detail = $order_detail_dao->select($order_detail)[0];
    $id_product = $this->order_detail->getId_product();
    $product->setId($id_product);
    $this->product = $product_dao->select($product)[0];
    
  }


  
  public function arraySerialize() {
    $vars = get_object_vars($this);
    foreach ($vars as &$v){
      if ($v instanceof \stphp\ArraySerializable) {
        $v = $v->arraySerialize();
      }
      
    }
    return $vars;
  }
  
}
