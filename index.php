<?php 

require_once("vendor/autoload.php");

use \Hcode\DB\Sql;


$app = new \Slim\Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$teste = new Sql();

	$results = $teste->select('SELECT * FROM Tb_users');

	echo json_encode($results);


});

$app->run();

 ?>