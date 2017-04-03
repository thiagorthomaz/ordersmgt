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
  private $discount;
  private $quantity;
  private $unit_price;
  
  
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
