<?php

namespace app\model;

/**
 * Description of Tab_order_ajustment
 *
 * @author thiago
 */
class Adjustment implements \stphp\Database\iDataModel, \stphp\ArraySerializable {

  private $id;
  private $id_order;
  private $date;
  private $credit;
  private $change;

  function getId() {
    return $this->id;
  }

  function getId_order() {
    return $this->id_order;
  }

  function getDate() {
    return $this->date;
  }

  function getCredit() {
    return $this->credit;
  }

  function getChange() {
    return $this->change;
  }

  function setChange($change) {
    $this->change = $change;
  }
  
  function setId($id) {
    $this->id = $id;
  }

  function setId_order($id_order) {
    $this->id_order = $id_order;
  }

  function setDate($date) {
    $this->date = $date;
  }

  function setCredit($credit) {
    $this->credit = $credit;
  }

  public function arraySerialize() {
    $vars = get_object_vars($this);
    return $vars;
  }

  public function getFieldsDescriptor() {
    
  }

}
