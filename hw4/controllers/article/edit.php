<?php

$fieldNames = ['title', 'content', 'id_category', 'id'];
$result = false;
$article = null;
$errors = [];
$fields = null;
$categories = getAllCategory();
//Берем id из get или post запроса
$id = ($_SERVER["REQUEST_METHOD"] === "GET") ?  URL_PARAMS['id'] : $_POST['id'] ?? '';
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
		!checkCategoryId($fields['id_category']) ||
		!arrayContainsId($categories, intval($fields['id_category']))
	) {
		$errors['category'] = CATEGORY_ERROR_NOT_EXIST;
	}
	if (empty($errors)) {
		$fields = encodeFields($fields);
		$result = editArticle($fields);
		$notice = $result
			? 'Article update succesfull!'
			: 'Something went wrong - record not updated. Try later';
		if ($result) {
			header('Location: ' . BASE_URL . '/article/' . $fields['id']);
			exit();
		}
	}
}
$aside = renderTwig('aside', [
	'id' => $fields['id'],
	'editPath' => 'article/edit',
	'deletePath' => 'article/delete'
]);
$form = renderTwig('articles/article-form', [
	'title' => 'Edit Article',
	'action' => 'edit',
	'categories' => $categories,
	'button' => 'Update Article',
	'fields' => $fields,
	'errors' => $errors,
]);
if (empty($article)) {
	$notice = 'Article not found';
}
$content = renderTwig('two-col-content', [
	'notice' => $notice,
	'aside' => $aside,
	'article' => $form,
]);
