<?php

$fieldNames = ['name', 'id'];
$result = false;
$category = null;
$errors = [];
$fields = null;
//Берем id из get или post запроса
$id = ($_SERVER["REQUEST_METHOD"] === "GET") ?  URL_PARAMS['id'] : $_POST['id'] ?? '';
//Получаем запись по id
if (checkCategoryId($id)) {
	$category = getCategory(intval($id));
	$fields = extractFields($category, $fieldNames);
}
//Если запрос пост и такая запись существует
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($category)) {
	//Берем данные с запроса
	$fields = extractFields($_POST, $fieldNames);
	//Валидируем
	$errors = validateCategory($fields);
	
	if (empty($errors)) {
		$fields = encodeFields($fields);
		try{
			$result = editCategory($fields);
			if (!!$result){
				$notice='Category update succesfull!';
				header('Location: ' . BASE_URL . '/category/' . $fields['id'].'/?notice=' . urlencode($notice));
				exit();
			}
			else{
				$notice='Something went wrong - record not updated. Try later';
			}

		}
		catch(PDOException $e){
			$notice='Ошибка записи.';
		}
	}
}
$aside = renderTwig('aside', [
	'id' => $fields['id'],
	'editPath' => 'category/edit',
	'deletePath' => 'category/delete'
]);
$form = renderTwig('category/category-form', [
	'title' => 'Edit Category',
	'action' => 'edit',
	'button' => 'Update Category',
	'fields' => $fields,
	'errors' => $errors,
]);
if (empty($category)) {
	$notice = 'Category not found';
}
$content = renderTwig('two-col-content', [
	'notice' => $notice,
	'aside' => $aside,
	'article' => $form,
]);
