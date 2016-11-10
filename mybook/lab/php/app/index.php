<?php
namespace App;

$root_path = dirname(__FILE__);
var_dump($root_path);
$auto_loader_file = $root_path.'/frame/autoloader.class.php';
require_once $auto_loader_file;

AutoLoader::get($root_path);

$hello = Frame\Router::getInstance();
var_dump($hello);
?>
