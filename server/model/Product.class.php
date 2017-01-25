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
  private $unitPrice;

  function getId() {
    return $this->id;
  }

  function getName() {
    return $this->name;
  }

  function getDescription() {
    return $this->description;
  }

  function getUnitPrice() {
    return $this->unitPrice;
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

  function setUnitPrice($unitPrice) {
    $this->unitPrice = $unitPrice;
  }

  public function arraySerialize() {
    $vars = get_object_vars($this);
    foreach ($vars as &$v){
      $v = utf8_encode($v);
    }
    return $vars;
  }

  public function getFieldsDescriptor() {
    
  }

}
