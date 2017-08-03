<?php


namespace app\model;

/**
 * Description of Model
 *
 * @author thiago
 */
abstract class DAO extends \stphp\Database\MySQL {
  
  public function __construct() {
  
    $user = getenv("MYSQL_USER");
    $passwd = getenv("MYSQL_PASSWD");
    $pdo_config = new \app\config\PDOConfig();
    $pdo_config->setUser($user);
    $pdo_config->setpassword($passwd);
    
    
    $this->connect($pdo_config);
  }
  
}
