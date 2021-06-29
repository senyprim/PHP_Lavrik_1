<?php

include_once __DIR__ . '/constants.php';
include_once BASE_DIR . '/models/article.php';
include_once BASE_DIR . '/core/functions.php';
include_once(BASE_DIR . '/models/logs.php');
addLog();

$fieldNames=['title','content','category','id'];
$fields = null;

if ($_SERVER["REQUEST_METHOD"] === "GET") {
	$id = ($_GET['id'] ?? '');
	if (checkArticleId($id)) {
		$fields =extractFields(getArticle(intval($id)),$fieldNames);
	}
}

if (!empty($fields)){
	include(BASE_DIR.'/views/article.php');
} else {
	header('HTTP/1.0 404 Not Found');
	include(BASE_DIR.'/views/errors/error404.php');
};