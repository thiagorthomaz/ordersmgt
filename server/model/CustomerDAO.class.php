<?php

namespace app\model;

/**
 * Description of CustomerDAO
 *
 * @author thiago
 */
class CustomerDAO extends \app\model\DAO {
  
  
  public function getModel() {
    return new \app\model\Customer();
  }

  public function getTable() {
    return "tab_customers";
  }

  public function modeltoArray(\stphp\Database\iDataModel $data_model) {
    
  }

}
