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

  public function modeltoArray(\stphp\Database\iDataModel $data_model) {
    return $data_model->arraySerialize();
  }
  
}
