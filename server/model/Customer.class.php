<?php

namespace app\model;

/**
 * Description of Customer
 *
 * @author thiago
 */
class Customer implements \stphp\Database\iDataModel, \stphp\ArraySerializable  {
  
  private $id;
  private $name;
  private $email;
  private $phone;
  private $credit;
  
  
  function getId() {
    return $this->id;
  }

  function getName() {
    return $this->name;
  }

  function getEmail() {
    return $this->email;
  }

  function getPhone() {
    return $this->phone;
  }

  function getCredit() {
    return $this->credit;
  }

  function setId($id) {
    $this->id = $id;
  }

  function setName($name) {
    $this->name = $name;
  }

  function setEmail($email) {
    $this->email = $email;
  }

  function setPhone($phone) {
    $this->phone = $phone;
  }

  function setCredit($credit) {
    $this->credit = $credit;
  }


  public function arraySerialize() {
    $vars = get_object_vars($this);
    foreach ($vars as &$v){
      $v = utf8_encode($v);
    }
    return $vars;
  }

  public function getDescription($field) {
    
  }

  public function getFieldsDescriptor() {
    
  }

}
