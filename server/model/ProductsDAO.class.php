<?php

namespace app\model;

/**
 * Description of ProductsDAO
 *
 * @author thiago
 */
class ProductsDAO  extends \app\model\DAO {
  
  public function getModel() {
    return new \app\model\Product();
  }

  public function getTable() {
    return "tab_products";
  }

  public function modeltoArray(\stphp\Database\iDataModel $data_model) {
    return $data_model->arraySerialize();
  }
  
  
  public function findByOrderId($id_order){
    
    $sql = "select distinct tp.* from tab_order_details tod join tab_products tp on tp.id = tod.id_product where id_orders = :id_orders";
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
  
}
