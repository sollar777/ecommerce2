<?php

 	use \Slim\slim;
 	use \Hcode\PageAdmin;
	use \Hcode\Model\User;
	use \Hcode\Model\Category;

	$app->get('/admin/categorias', function(){

	User::verifyLogin();

	$categorias = Category::listAll();

	$page = new PageAdmin();
	$page->setTpl("categorias", array(
			"categorias"=>$categorias
		));

});


$app->get('/admin/categoria/create', function(){
	
	User::verifyLogin();
	$page = new PageAdmin();
	$page->setTpl("categorias-create");

});



$app->get('/admin/categoria/:iduser/delete', function($categoria){

	User::verifyLogin();

	$category = new Category();
	$category->get((int)$categoria);
	$category->delete();

	header("Location: /admin/categorias");
	exit;

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



$app->post('/admin/categoria/create', function(){

	User::verifyLogin();

	$category = new Category();
	$category->setData($_POST);
	$category->save();

	header("Location: /admin/categorias");
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

?>