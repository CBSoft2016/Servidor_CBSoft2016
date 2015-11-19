<?php
include_once './libs/Slim/Slim.php';
require_once './classes/dbHelper.php';

$app=new Slim();
$db=new dbHelper();

$app->get('/getperguntas/:idpalestra', function ($idpalestra) use ($app) {
    global $db;
    $stmt = $db->selectperguntas("perguntaspalestras","id,pergunta,nomeusuario"," idpalestra = '$idpalestra'");
    echo json_encode($stmt);
    
});
$app->post('/avaliarpalestra', function () use ($app) {
    global $db;
    $idpalestra="palestra01";
    $nota=3;
    $email="aaa@hotmail.com";
    $db->insert("avaliacao", array("idpalestra"=>$idpalestra,"email"=>$email,"nota"=>$nota));
    
});
$app->post('/cadastrapergunta',  function () use ($app){
       global $db;
      $postvalores = $app->request()->post();
   
      $idpalestra=$postvalores['idpalestra'];
      $pergunta=$postvalores['pergunta'];
      $nomeusuario=$postvalores['nomeusuario'];
     
      
     $db->insert("perguntaspalestras", array("idpalestra"=>$idpalestra,"pergunta"=>$pergunta,"nomeusuario"=>$nomeusuario));
    
});

$app->get('/', function () use ($app) {
    $app->render('home.php'); 
});
$app->get('/iframe', function () use ($app) {
    $app->render('iframe.php'); 
});



$app->run();

?>