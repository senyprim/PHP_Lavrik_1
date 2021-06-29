<?php
include_once(__DIR__ . '/constants.php');
include_once(BASE_DIR . '/models/article.php');
include_once(BASE_DIR . '/models/category.php');
include_once(BASE_DIR . '/core/functions.php');
include_once(BASE_DIR . '/models/logs.php');
addLog();

$fieldNames = ['title', 'content', 'id_category', 'id'];
$result = false;
$article = null;
$errors = [];
$fields=null;
$categories = getAllCategory();
//Берем id из get или post запроса
$id = ($_SERVER["REQUEST_METHOD"] === "GET") ? $_GET['id'] ?? '' : $_POST['id'] ?? '';
//Получаем запись по id
if (checkArticleId($id)) {
	$article = getArticle(intval($id));
	$fields = extractFields($article, $fieldNames);
}
//Если запрос пост и такая запись существует
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($article)) {
	//Берем данные с запроса
	$fields = extractFields($_POST, $fieldNames);
	//Валидируем
	$errors = validateArticle($fields);
	if (
		!checkCategoryId($article['id_category']) ||
		!arrayContainsId($categories, intval($article['id_category']))
	) {
		$errors[] = CATEGORY_ERROR_NOT_EXIST;
	}
	if (empty($errors)) {
		$fields = encodeFields($fields);
		$result = editArticle($fields);
		if ($result) {
			header('Location: article.php?id=' . $fields['id']);
			exit();
		}
		$errors[] = 'Something went wrong - record not updated. Try later';
	}
}

if (empty($article)) {
	$titleView = 'Article not found';
	include(BASE_DIR . '/views/fail.php');
} else {
	$titleForm = 'Edit Article';
	$buttonForm = 'Edit Article';
	$action='edit.php';
	include(BASE_DIR . '/views/article-form.php');
}
