<?php

include_once BASE_DIR . '/models/article.php';

$fieldNames=['title','content','category','id'];
$fields = null;

if ($_SERVER["REQUEST_METHOD"] === "GET") {
	$id = ($_GET['id'] ?? '');
	if (checkArticleId($id)) {
		$fields =extractFields(getArticle(intval($id)),$fieldNames);
	}
}

if (!empty($fields)){
	include(BASE_DIR.'/views/view-article.php');
} else {
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
	include(BASE_DIR.'/views/errors/view-error404.php');
};