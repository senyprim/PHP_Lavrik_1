<?php
$fieldNames = ['id', 'login', 'id_role','password','id_status','password_confirm'];
$result = false;
$errors = [];
$fields = extractFields([], $fieldNames);

if ('POST'===$_SERVER["REQUEST_METHOD"]) {
    $fields = extractFields($_POST, $fieldNames);
    $errors=validateUser($fields['login'],$fields['password'],$fields['id_role'],$fields['id_status']);
    if ($fields['password']!==$fields['password_confirm']){
        $errors['password_confirm']='Подтверждение пароля не совпадает';
    }
    if (empty($errors)) {
		//$fields = encodeFields($fields);//Кодировка нужна для вывода данных (при сохранении в базу она не нужна)
		$result = addUser($fields['login'],$fields['password'],$fields['id_role'],$fields['id_status']);
        if (isset($_SESSION['forbiddenUrl'])){
            
        }
		if ($result) {
			header('Location: ' . BASE_URL . '/user/' . getLastId());
			exit();
		}
	}
}

$content=renderTwig('auth/register',[
    'title'=>'Добавление нового пользователя',
    'action'=>'register',
    'fields'=>$fields,
    'roles'=>getAllRoles(),
    'errors'=>$errors,
    'button'=>'Добавить пользователя',
]);
