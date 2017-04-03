<?php

namespace app\model;

/**
 * Description of OrderDAO
 *
 * @author thiago
 */
class OrderDAO extends \app\model\DAO {
  
  public function getModel() {
    return new \app\model\Order();
  }

  public function getTable() {
    return "tab_orders";
  }

  public function modeltoArray(\stphp\Database\iDataModel $data_model) {
    return $data_model->arraySerialize();
  }
  
}
