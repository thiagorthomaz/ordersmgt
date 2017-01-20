<?php


$core_path = "/var/www/html/stphp";
$app_path = "/var/www/html/ordersmgt";

ini_set('display_errors', 'On');
error_reporting(E_ALL);


require_once $core_path . '/stphp/config/config.php';
require_once $core_path . '/stphp/STPHP.class.php';


stphp\config\AutoLoad::addNamespace("stphp", $core_path . "/stphp");
stphp\config\AutoLoad::addNamespace("stphp\\Database", $core_path . "/stphp/Database");
stphp\config\AutoLoad::addNamespace("stphp\\Exception", $core_path . "/stphp/Exception");
stphp\config\AutoLoad::addNamespace("stphp\\rest", $core_path . "/stphp/rest");
stphp\config\AutoLoad::addNamespace("stphp\\http", $core_path . "/stphp/http");

//stphp\config\AutoLoad::addNamespace("app\\config", $app_path . "/config");

stphp\config\AutoLoad::addNamespace("app\\controller", $app_path . "/server/controller");
stphp\config\AutoLoad::addNamespace("app\\model", $app_path . "/server/model");
stphp\config\AutoLoad::addNamespace("app\\view", $app_path . "/server/view");
stphp\config\AutoLoad::addNamespace("app\\exception", $app_path . "/server/exception");
stphp\config\AutoLoad::addNamespace("app\\model", $app_path . "/server/model");


stphp\STPHP::registerExtensions();
stphp\STPHP::registerAutoload();
$session = new stphp\Session();


$session->start();


try{
  
  $app = new stphp\STPHP();
  $app->handle();
  
} catch (\app\exception\AppException $auth_exc){
  echo json_encode(array("error" => $auth_exc->getMessage()));
}