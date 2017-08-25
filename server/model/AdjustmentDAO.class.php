<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\model;

/**
 * Description of Tab_order_ajustmentDAO
 *
 * @author thiago
 */
class AdjustmentDAO extends \app\model\DAO {

  public function getModel() {
    return new \app\model\Adjustment();
  }

  public function getTable() {
    return "tab_order_adjustment";
  }

  public function modeltoArray(\stphp\Database\iDataModel $data_model) {
    return $data_model->arraySerialize();
  }
  
public function total($id_order){
  $sql = "select sum(toa.credit) as total_credit, sum(toa.change) as total_change from tab_order_adjustment toa where toa.id_order = :id_order";
  $rs = $this->sendQuery($sql, array("id_order" => $id_order));
  $total = $rs->getResultSet();
  
  if (isset($total[0])) {
    return $total[0];
  } else {
    return array( 'total_credit' => 0, 'total_change' => 0 );
  }

}

  public function findByOrderId($id_order) {

    $sql = "select id from tab_order_adjustment where id_order = :id_order";
    $rs = $this->sendQuery($sql, array("id_order" => $id_order));
    $adjustments = $rs->getResultSet();
    
    $details = array();
    foreach ($adjustments as $o ){
      $model = $this->getModel();
      $model->setId($o['id']);
      $r = $this->select($model);
      $details[] = $r[0];
    }
    return $details;
  }

}
