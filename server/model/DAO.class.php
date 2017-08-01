<?php


namespace app\model;

/**
 * Description of Model
 *
 * @author thiago
 */
abstract class DAO extends \stphp\Database\MySQL {
  
  public function __construct() {
  
    
    $pdo_config = new \app\config\PDOConfig();
    $pdo_config->setUser("root");
    $pdo_config->setpassword("masterkey");
    
    
    $this->connect($pdo_config);
  }
  
}
