<?php

include (__DIR__.'/init.php');
addLog(getLogInfo());
//Парсим входящий урл
$url = $_GET['querysystemurl'] ?? '';
$routes=include('routes.php');
$routerRes = parseUrl(
	$url, 
	$routes
);
//Регистрируем параметры запроса
$controller=$routerRes['controller'];
define('URL_PARAMS',$routerRes['params']);

//Если такого контролера нет переводим на контролер 404
$pathController=DIRECTORY_CONTROLLER.'/'.$controller.'.php';
if (!file_exists($pathController)){
	$controller='errors/404';
	$pathController=DIRECTORY_CONTROLLER.'/'.$controller.'.php';
}
$title='Страница статей';
$header=renderTwig('header');
$footer=renderTwig('footer');

//Запускаем контроллер
include_once($pathController);


$page= renderTwig('layout',[
	'title'=>$title,
	'header'=>$header,
	'content'=>$content,
	'footer'=>$footer,
]);
echo $page;
