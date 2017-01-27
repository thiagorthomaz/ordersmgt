<?php

namespace app\config;

/**
 * Description of PDOConfig
 *
 * @author thiago
 */
class PDOConfig implements \stphp\Database\iConnectionDB {

  private $user;
  private $password;

  public function getDatabase() {
    return "ordersmgt";
  }

  public function getDriver() {
    return "mysql";
  }

  public function getHost() {
    return "localhost";
  }

  public function getPort() {
    return "3306";
  }

  public function getUser() {
    return $this->user;
  }

  public function getPassword() {
    return $this->password;
  }

  public function setUser($username) {
    $this->user = $username;
  }

  public function setpassword($pass) {
    $this->password = $pass;
  }

}
