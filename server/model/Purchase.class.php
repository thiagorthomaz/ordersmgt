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
  private $order_detail = array();
  private $total_order = 0;
  private $total_change = 0;
  private $total_credit = 0;
  private $total_paid = 0;

  private $adjustments = array();
  
  public function __construct(\app\model\Order $order) {
    
    $dao = new \app\model\OrderDAO();
    $this->order = $dao->select($order)[0];
    
    $id_customer = $this->order->getId_customer();
    
    $id_order = $this->order->getId();
    
    $customer_dao = new \app\model\CustomerDAO();
    $order_detail_dao = new \app\model\OrderDetailDAO();
    $product_dao = new \app\model\ProductsDAO();
    $adjustment_dao = new \app\model\AdjustmentDAO();
    $this->adjustments = $adjustment_dao->findByOrderId($order->getId());
    $total_adjustment = $adjustment_dao->total($order->getId());
    
    $customer = $customer_dao->getModel();
    $customer->setId($id_customer);
    
    $order_detail = $order_detail_dao->getModel();
    
    $this->order_detail = $order_detail_dao->findByOrderId($order->getId());
    $this->total_order = $order_detail_dao->total($order->getId());
    $this->total_paid = $total_adjustment['total_credit'];
    $this->total_change = $total_adjustment['total_change'];
    $this->total_credit = $total_adjustment['total_credit'] - $total_adjustment['total_change'] - $this->total_order;
    
    
    
    


    $product = $product_dao->getModel();
    
    $this->customer = $customer_dao->select($customer)[0];
    
  }

  public function arraySerialize() {
    $vars = get_object_vars($this);
    foreach ($vars as &$v){
      if ($v instanceof \stphp\ArraySerializable) {
        $v = $v->arraySerialize();
      } else {
         if (is_array($v)) {
          foreach ($v as &$sub_v) {
            $sub_v = $sub_v->arraySerialize();
          }          
        }
      }
      
    }
    return $vars;
  }
  
}
