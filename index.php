<?php 

session_start();

require_once("vendor/autoload.php");

use \Slim\slim;
use \Hcode\Page;
use \Hcode\PageAdmin;

$app = new Slim();

$app->config('debug', true);

require_once("views/admin/admin.php");
require_once("views/admin/admin_category.php");
require_once("views/admin/admin_products.php");

$app->get('/', function() {
    
	$page = new Page();

	$page->setTpl("index");

});

$app->run();

 ?>