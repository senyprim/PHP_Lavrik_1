<?php
include (__DIR__.'/init.php');

addLog(getLogInfo());

$cname = $_GET['c'] ?? 'index';
$path = "controllers/$cname.php";
$title='Articles';
$header=render('header');
$footer=render('footer');
if (checkControllerName($cname) && file_exists($path)){
    include_once($path);
}
else{
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
	$content=render('errors/404');
}

$page= render('layout',[
	'title'=>$title,
	'header'=>$header,
	'content'=>$content,
	'footer'=>$footer,
]);
echo $page;
