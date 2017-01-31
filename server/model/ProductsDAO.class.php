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
    
  }
  
}
