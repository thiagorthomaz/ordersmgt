<?php

namespace app\model;


/**
 * Description of Product
 *
 * @author thiago
 */
class Product implements \stphp\Database\iDataModel, \stphp\ArraySerializable {
  
  private $id;
  private $name;
  private $description;
  private $unit_price;

  function getId() {
    return $this->id;
  }

  function getName() {
    return $this->name;
  }

  function getDescription() {
    return $this->description;
  }

  function getUnit_price() {
    return $this->unit_price;
  }

  function setId($id) {
    $this->id = $id;
  }

  function setName($name) {
    $this->name = $name;
  }

  function setDescription($description) {
    $this->description = $description;
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
