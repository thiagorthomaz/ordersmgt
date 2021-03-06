<?php

namespace app\model;

/**
 * Description of OrderDatail
 *
 * @author thiago
 */
class OrderDetail implements \stphp\Database\iDataModel, \stphp\ArraySerializable {
  
  private $id;
  private $id_product;
  private $id_orders;
  private $discount;
  private $quantity;
  private $unit_price;
  private $date;
  
  
  function getId() {
    return $this->id;
  }

  function getId_product() {
    return $this->id_product;
  }

  function getDiscount() {
    return $this->discount;
  }

  function getQuantity() {
    return $this->quantity;
  }

  function getUnit_price() {
    return $this->unit_price;
  }

  function getId_orders() {
    return $this->id_orders;
  }


  function getDate() {
    return $this->date;
  }

  function setDate($date) {
    $this->date = $date;
  }

  function setId_orders($id_orders) {
    $this->id_orders = $id_orders;
  }

  function setId($id) {
    $this->id = $id;
  }

  function setId_product($id_product) {
    $this->id_product = $id_product;
  }

  function setDiscount($discount) {
    $this->discount = $discount;
  }

  function setQuantity($quantity) {
    $this->quantity = $quantity;
  }

  function setUnit_price($unitPrice) {
    $this->unit_price = $unitPrice;
  }
  
  public function arraySerialize() {
    $vars = get_object_vars($this);
    return $vars;
  }

  public function getFieldsDescriptor() {
    
  }

}
