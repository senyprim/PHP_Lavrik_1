<?php

$fieldNames = ['title', 'content', 'id_category'];
$result = false;
$errors = [];
$fields = extractFields([], $fieldNames);
//Запрашиваем все категории чтобы показать список
//(так как при ошибочных post запросах мы должны показывать все категории опять)
$categories = getAllCategory();
if ('POST' == $_SERVER["REQUEST_METHOD"]) {
	$fields = extractFields($_POST, $fieldNames);
	//Валидация
	$errors = validateArticle($fields);
	if (
		!checkCategoryId($fields['id_category']) ||
		!arrayContainsId($categories, intval($fields['id_category']))
	) {
		$errors['category'] = 'Выбранная категория не существует';
	}
	if (empty($errors)) {
		$fields = encodeFields($fields);
		$result = addArticle($fields);
		$notice = $result ? 'Запись успешно сохраннена' : 'Что то пошло не так. Запись не сохраннена. Попробуйте позже';

		if ($result) {
			header('Location: ' . BASE_URL . '/article/' . getLastId() . '?notice=' . urlencode($notice));
			exit();
		}
	}
}
$aside = renderTwig('aside', [
	'id' => $fields['id'] ?? null,
	'editPath' => 'article/edit',
	'deletePath' => 'article/delete'
]);

$form = renderTwig('articles/article-form', [
	'title' => 'Add Article',
	'action' => 'add',
	'categories' => $categories,
	'button' => 'Add Article',
	'fields' => $fields,
	'errors' => $errors,
]);

$content = renderTwig('two-col-content', [
	'notice' => $notice,
	'aside' => $aside,
	'article' => $form,
]);
