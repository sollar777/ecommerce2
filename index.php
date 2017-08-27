<?php 

session_start();
require_once("vendor/autoload.php");

use \Slim\slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;


$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Page();

	$page->setTpl("index");

});

$app->get('/admin', function() {
    
    User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("index");

});

$app->get('/admin/login', function(){

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
		]);

	$page->setTpl("login");

});

$app->post('/admin/login', function(){

	User::Login($_POST["usuario"], $_POST["password"]);

	header("Location: /admin");
	exit;
});

$app->get('/admin/logout', function(){

	User::logout();

	header("Location: /admin/login");
	exit;

});

$app->get('/admin/users', function(){

	User::verifyLogin();

	$users = User::listAll();

	$page = new PageAdmin();
	$page->setTpl("users", array(
			"users"=>$users
		));

});

$app->get('/admin/categorias', function(){

	User::verifyLogin();

	$categorias = Category::listAll();

	$page = new PageAdmin();
	$page->setTpl("categorias", array(
			"categorias"=>$categorias
		));

});

$app->get('/admin/users/create', function(){
	
	User::verifyLogin();
	$page = new PageAdmin();
	$page->setTpl("users-create");

});

$app->get('/admin/categoria/create', function(){
	
	User::verifyLogin();
	$page = new PageAdmin();
	$page->setTpl("categorias-create");

});

$app->get('/admin/users/:iduser/delete', function($iduser){

	User::verifyLogin();

	$user = new User();
	$user->get((int)$iduser);
	$user->delete();

	header("Location: /admin/users");
	exit;

});

$app->get('/admin/categoria/:iduser/delete', function($categoria){

	User::verifyLogin();

	$category = new Category();
	$category->get((int)$categoria);
	$category->delete();

	header("Location: /admin/categorias");
	exit;

});

$app->get('/admin/users/:iduser', function($iduser){
	
	User::verifyLogin();

	$user = new User();
	$user->get((int)$iduser);

	$page = new PageAdmin();
	$page->setTpl("users-update", array(
			"user"=>$user->getValues()
		));

});

$app->get('/admin/categoria/:iduser', function($categoria){
	
	User::verifyLogin();

	$category = new Category();
	$category->get((int)$categoria);

	$page = new PageAdmin();
	$page->setTpl("categorias-update", array(
			"category"=>$category->getValues()
		));

});

$app->post('/admin/users/create', function(){

	User::verifyLogin();

	$user = new User();
	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
	$_POST["despassword"] = password_hash($_POST["despassword"], PASSWORD_DEFAULT, [
		"cost"=>12
	]);
	$user->setData($_POST);
	$user->save();

	header("Location: /admin/users");
	exit;

});

$app->post('/admin/categoria/create', function(){

	User::verifyLogin();

	$category = new Category();
	$category->setData($_POST);
	$category->save();

	header("Location: /admin/categorias");
	exit;

});

$app->post('/admin/users/:iduser', function($iduser){

	User::verifyLogin();

	$user = new User();
	$user->get((int)$iduser);
	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
	$user->setData($_POST);
	$user->update();

	header("Location: /admin/users");
	exit;

});

$app->post('/admin/categoria/:idcategory', function($categoria){

	User::verifyLogin();

	$category = new Category();
	$category->get((int)$categoria);
	$category->setData($_POST);
	$category->update();

	header("Location: /admin/categorias");
	exit;

});

$app->get('/categories/:idcategory', function($idcategory) {
    
    User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new Page();

	$page->setTpl("category", [
		"category"=>$category->getValues()
		]);

});

$app->run();

 ?>