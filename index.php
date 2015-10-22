<?php
include_once './libs/Slim/Slim.php';
require_once './classes/dbHelper.php';

$app=new Slim();

$app->get('/pergunta/:idpalestra', function () use ($app) {
   $db=new dbHelper();

   

    
});
$app->run();

?>