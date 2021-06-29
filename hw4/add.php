<?php
include_once (__DIR__.'/constants.php');
include_once (__DIR__.'/core/functions.php');
include_once (BASE_DIR.'/core/db.php');
include_once (BASE_DIR.'/models/article.php');
include_once (BASE_DIR.'/models/category.php');
include_once (BASE_DIR.'/models/logs.php');
addLog();

$fieldNames=['title','content','id_category'];
$result = false;
$errors = [];
$fields=[];
//Запрашиваем все категории чтобы показать список
//(так как при ошибочных post запросах мы должны показывать все категории опять)
$categories =getAllCategory();
if ('POST'==$_SERVER["REQUEST_METHOD"]) {
	$fields=extractFields($_POST,$fieldNames);
	//Валидация
	$errors=validateArticle($fields);
	if (
		!checkCategoryId($fields['id_category']) ||
		!arrayContainsId($categories,intval($fields['id_category'])))
	{
		$errors[]='Выбранная категория не существует';
	}
	if (empty($errors))
	{
		$fields=encodeFields($fields);
		$result = addArticle( $fields );
		header('Location: article.php?id='.getLastId());
		exit();
	}
}
$titleForm='Add Article';
$buttonForm='Add';
include(BASE_DIR.'/views/article-form.php');


