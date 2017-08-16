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

  public function findByOrderId($id_order) {

    $sql = "select id from tab_order_details where id_orders = :id_orders";
    $rs = $this->sendQuery($sql, array("id_orders" => $id_order));
    $orders = $rs->getResultSet();

    $details = array();
    foreach ($orders as $o) {
      $model = $this->getModel();
      $model->setId($o['id']);
      $r = $this->select($model);
      $details[] = $r[0];
    }
    return $details;
  }

  public function total($id_order) {
    $sql = "select tod.id_product, ( (SUM(tod.quantity) * max(tod.unit_price)) - sum(tod.discount)) as total "
      . "from tab_order_details tod "
      . "where tod.id_orders = :id_orders "
      . "group by tod.id_product";

    $rs = $this->sendQuery($sql, array("id_orders" => $id_order));
    $total = $rs->getResultSet();

    $sum = 0;

    if (isset($total[0])) {
      foreach ($total as $t) {
        $sum += $t['total'];
      }
    }
    
    return $sum;
    
  }

  public function modeltoArray(\stphp\Database\iDataModel $data_model) {
    return $data_model->arraySerialize();
  }

}
