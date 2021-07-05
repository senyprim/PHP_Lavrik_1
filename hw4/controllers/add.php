<?php

$fieldNames=['title','content','id_category'];
$result = false;
$errors = [];
$fields=[];
//Запрашиваем все категории чтобы показать список
//(так как при ошибочных post запросах мы должны показывать все категории опять)
$categories = getAllCategory();
if ('POST'==$_SERVER["REQUEST_METHOD"]) {
	$fields=extractFields($_POST,$fieldNames);
	//Валидация
	$errors=validateArticle($fields);
	if (
		!checkCategoryId($fields['id_category']) ||
		!arrayContainsId($categories,intval($fields['id_category'])))
	{
		$errors['category']='Выбранная категория не существует';
	}
	if (empty($errors))
	{
		$fields=encodeFields($fields);
		$result = addArticle( $fields );
		$notice = $result?'Запись успешно сохраннена':'Что то пошло не так. Запись не сохраннена. Попробуйте позже';
		header('Location: index.php?c=article&id='.getLastId().'&notice='.$notice);
		exit();
	}
}
$aside = render('aside',['id'=>$fields['id']]);

$form = render('articles/article-form',[
	'title'=>'Add Article',
	'action'=>'add',
	'categories'=>$categories,
	'button'=>'Add Article',
	'fields'=>$fields,
	'errors'=>$errors,
]);

$content = render ('two-col-content',[
	'notice'=>$notice,
	'aside'=>$aside,
	'article'=>$form,
]);



