<?php

namespace app\model;

/**
 * Description of Order
 *
 * @author thiago
 */
class Order implements \stphp\Database\iDataModel, \stphp\ArraySerializable {
  
  private $id;
  private $id_customer;
  private $order_date;
  private $required_date;
  private $shipped_date;
  private $paid;
  
  
  function getId() {
    return $this->id;
  }

  function getId_customer() {
    return $this->id_customer;
  }

  function getOrder_date() {
    return $this->order_date;
  }

  function getRequired_date() {
    return $this->required_date;
  }

  function getShipped_date() {
    return $this->shipped_date;
  }

  function getPaid() {
    return $this->paid;
  }

  function setPaid($paid) {
    $this->paid = $paid;
  }
  
  function setId($id) {
    $this->id = $id;
  }

  function setId_customer($id_customer) {
    $this->id_customer = $id_customer;
  }

  function setOrder_date($order_date) {
    $this->order_date = $order_date;
  }

  function setRequired_date($required_date) {
    $this->required_date = $required_date;
  }

  function setShipped_date($shipped_date) {
    if (date("Y", strtotime($shipped_date)) == 1969) {
      $shipped_date = null;
    }
    $this->shipped_date = $shipped_date;
  }

    
  public function arraySerialize() {
    $vars = get_object_vars($this);
    return $vars;
  }

  public function getFieldsDescriptor() {
    
  }

}
