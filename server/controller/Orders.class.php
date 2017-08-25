<?php

namespace app\controller;

/**
 * Description of Orders
 *
 * @author thiago
 */
class Orders extends \app\controller\Controller {

  public function post() {
    
  }

  public function all() {

    $dao = new \app\model\OrderDAO();
    $orders = $dao->selectAll(100, $dao->getModel());

    foreach ($orders as $o) {
      $purchase = new \app\model\Purchase($o);
      $this->addResponseContent($purchase, true);
    }

    return $this->getResponse();
  }

  public function get() {

    $order_id = $this->request->getParams("order_id");
    $data_model = new \app\model\Order();
    $data_model->setId($order_id);

    $purchase = new \app\model\Purchase($data_model);

    $this->addResponseContent($purchase);

    return $this->getResponse();
  }

  public function saveOrder() {

    $id = $this->request->getParams("id");
    $customer = $this->request->getParams("customer");
    $paid = $this->request->getParams("paid");
    $required_date = $this->request->getParams("required_date");
    $shipped_date = $this->request->getParams("shipped_date");

    if (is_null($required_date)) {
      $required_date = date("Y-m-d H:i:s");
    }


    if (is_null($paid) || !$paid) {
      $paid = 0;
    }

    $order_dao = new \app\model\OrderDAO();
    $order = new \app\model\Order();

    $order->setId($id);
    $order->setId_customer($customer['id']);
    if (!is_null($required_date)) {
      $order->setRequired_date($this->formatDate($required_date, "Y-m-d H:i:s"));
    }

    if (!is_null($shipped_date)) {
      $formated_shipped_date = $this->formatDate($shipped_date, "Y-m-d H:i:s");
      $order->setShipped_date($this->formatDate($formated_shipped_date, "Y-m-d H:i:s"));
    }

    $order->setPaid($paid);
    $order->setOrder_date(date("Y-m-d H:i:s"));

    if (!is_null($id)) {
      $criteria = array('id' => $id);
      $saved = $order_dao->update($order, $criteria);
    } else {
      $saved = $order_dao->insert($order);
    }

    if ($saved) {
      $this->addResponseContent($order);
      return $this->getResponse();
    } else {
      $rs = $order_dao->getResultset();
      $error_msg = $rs->getError_message();

      $error = new \app\view\ErrorView();
      $error->setMessange("Failed to save the order! " . $error_msg);
      return $error;
    }
  }

  public function saveProduct() {

    $order_detail = new \app\model\OrderDetail();
    $order_detail_dao = new \app\model\OrderDetailDAO();
    $param_order_detail = $this->request->getParams("OrderDetail");
    $product_dao = new \app\model\ProductsDAO();

    if (isset($param_order_detail['id'])) {
      $id = $param_order_detail['id'];
    } else {
      $id = null;
    }

    if (isset($param_order_detail['discount'])) {
      $discount = $param_order_detail['discount'];
    } else {
      $discount = 0;
    }

    if (isset($param_order_detail['quantity'])) {
      $quantity = $param_order_detail['quantity'];
    } else {
      $quantity = 0;
    }

    if (!isset($param_order_detail['product_id'])) {
      $product_id = -1;
    } else {
      $product_id = $param_order_detail['product_id'];
    }

    if (!isset($param_order_detail['date'])) {
      $order_detail->setDate(date("Y-m-d H:i:s"));
    }
    
    $order_id = $param_order_detail['order_id'];

    $product = new \app\model\Product();
    $product->setId($product_id);
    $product_result = $product_dao->select($product);

    if (!isset($product_result[0]) || empty($product_result[0])) {
      $error = new \app\view\ErrorView();
      $error->setMessange("Product not found! ");
      return $error;
    } else {
      $product = $product_result[0];
    }

    $unit_price = $product->getUnit_price();


    $order_detail->setDiscount($discount);
    $order_detail->setQuantity($quantity);
    $order_detail->setId_product($product_id);
    $order_detail->setId_orders($order_id);
    $order_detail->setUnit_price($unit_price);

    if (!is_null($id)) {
      $criteria = array('id' => $id);
      $order_detail->setId($id);
      $saved = $order_detail_dao->update($order_detail, $criteria);
    } else {
      $saved = $order_detail_dao->insert($order_detail);
    }

    if (!$saved) {
      $rs = $order_detail_dao->getResultset();
      $msg = $rs->getError_message();
      $error = new \app\view\ErrorView();
      $error->setMessange("Failed " . $error);
    } else {
      $success = new \app\view\SuccessView();
      $success->setMessange("Product inserted.");
      return $success;
    }
  }

  public function deleteDetail() {

    $detail_id = $this->request->getParams("detail_id");
    $detail_dao = new \app\model\OrderDetailDAO();
    $order = $detail_dao->getModel();
    $order->setId($detail_id);
    $found = $detail_dao->select($order);

    $deleted = false;

    if (isset($found[0])) {
      $order = $found[0];
      $deleted = $detail_dao->delete($order);
    }

    if (!$deleted) {
      $rs = $order_detail_dao->getResultset();
      $msg = $rs->getError_message();
      $error = new \app\view\ErrorView();
      $error->setMessange("Failed " . $error);
    } else {
      $success = new \app\view\SuccessView();
      $success->setMessange("Product deleted.");
      return $success;
    }
  }

  public function productsFromOrder() {

    $id_order = $this->request->getParams("order_id");

    $product_dao = new \app\model\ProductsDAO();
    $products = $product_dao->findByOrderId($id_order);

    foreach ($products as $p) {
      $this->addResponseContent($p, true);
    }

    return $this->getResponse();
  }

  public function deleteAdjustment() {

    $adjustment_id = $this->request->getParams("id");

    $adjustment_dao = new \app\model\AdjustmentDAO();
    $adjustment = $adjustment_dao->getModel();
    $adjustment->setid($adjustment_id);

    $adjustment_rs = $adjustment_dao->select($adjustment);

    $error = new \app\view\ErrorView();
    

    if (isset($adjustment_rs[0])) {
      
      $adjustment = $adjustment_rs[0];
      
      if ($adjustment_dao->delete($adjustment)) {

        $success = new \app\view\SuccessView();  
        $success->setMessange("Adjustment deleted");
        return $success;
        
      } else {

        $error->setMessange("Fail to delete adjustment.");
        return $error;    
        
      }

    } else {
      $error->setMessange("Adjustment not found.");
      return $error;  
    }

  }

  public function saveAdjustment() {

    $id_order = $this->request->getParams("order_id");
    $credit = $this->request->getParams("credit");
    $date = $this->request->getParams("date");
    $change = $this->request->getParams("change");

    if (is_null($change)) {
      $change = 0; //False
    }

    $adjustment_dao = new \app\model\AdjustmentDAO();
    $adjustment = new \app\model\Adjustment();
    $adjustment->setId_order($id_order);
    $adjustment->setCredit($credit);
    $adjustment->setChange($change);
    $adjustment->setDate($this->formatDate($date, "Y-m-d"));

    if (empty($adjustment->getCredit())) {
      $error = new \app\view\ErrorView();
      $error->setMessange("Credit must be grater than 0.");
      return $error;
    }

    if (!$adjustment_dao->insert($adjustment)) {
      $rs = $adjustment_dao->getResultset();

      $error = new \app\view\ErrorView();
      $error->setMessange("Failed to save the adjustment. " . $rs->getError_message());
      return $error;
    } else {
      $success = new \app\view\SuccessView();
      $success->setMessange("Adjustment saved.");
      return $success;
    }
  }

}
