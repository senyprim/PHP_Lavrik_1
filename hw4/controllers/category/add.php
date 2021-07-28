<?php

$fieldNames = ['name','id'];
$result = false;
$errors = [];
$fields = extractFields([], $fieldNames);

if ('POST' == $_SERVER["REQUEST_METHOD"]) {
	$fields = extractFields($_POST, $fieldNames);
	//Валидация
	$errors = validateCategory($fields);
	
	if (empty($errors)) {
		$fields = encodeFields($fields);
		try{
			$result = addCategory($fields);
			$notice = $result ? 'Запись успешно сохраннена' : 'Что то пошло не так. Запись не сохраннена. Попробуйте позже';
		}
		catch (PDOException $e){
			if ($e->errorInfo[1]==1062){
				$errors['name'] = 'Сохранение не возможно. Категория с таким именем уже есть';
			}
		}
		

		if ($result) {
			header('Location: ' . BASE_URL . '/category/' . getLastId() . '?notice=' . urlencode($notice));
			exit();
		}
	}
}
$aside = renderTwig('aside', [
	'id' => $fields['id'] ?? null,
	'editPath' => 'category/edit',
	'deletePath' => 'category/delete'
]);

$form = renderTwig('category/category-form', [
	'title' => 'Add Category',
	'action' => 'add',
	'button' => 'Add Category',
	'fields' => $fields,
	'errors' => $errors,
]);

$content = renderTwig('two-col-content', [
	'notice' => $notice,
	'aside' => $aside,
	'article' => $form,
]);
