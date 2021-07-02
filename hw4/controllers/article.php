<?php

$fieldNames=['title','content','category','id','dt_add'];
$fields = null;

if ($_SERVER["REQUEST_METHOD"] === "GET") {
	$id = ($_GET['id'] ?? '');
	if (checkArticleId($id)) {
		$fields =extractFields(getArticle(intval($id)),$fieldNames);
	}
}

if (!empty($fields)){
	$content = render('articles/article',$fields);
} else {
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
	$content=render('erros/404');
};