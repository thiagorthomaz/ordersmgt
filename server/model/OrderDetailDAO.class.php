<?php

namespace app\model;

/**
 * Description of OrderDatailDAO
 *
 * @author thiago
 */
class OrderDetailDAO extends \app\model\DAO {
  
  public function getModel() {
    return new \app\model\OrderDetail();
  }

  public function getTable() {
    return "tab_order_details";
  }
  
  public function findByOrderId($id_order){
    
    $sql = "select id from tab_order_details where id_orders = :id_orders";
    $rs = $this->sendQuery($sql, array("id_orders" => $id_order));
    $orders = $rs->getResultSet();
    
    $details = array();
    foreach ($orders as $o){
      $model = $this->getModel();
      $model->setId($o['id']);
      $r = $this->select($model);
      $details[] = $r[0];
      
    }
    return $details;

  }
  
  public function modeltoArray(\stphp\Database\iDataModel $data_model) {
    return $data_model->arraySerialize();
  }
  
}
