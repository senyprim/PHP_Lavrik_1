<?php
function indexOfId(array $array,?int $id):int{
    if (!$array || $id==null) return -1;
    foreach($array as $key=>$item){
        if (isset($item['id']) && $item['id']==$id) return $key;
    }
    return -1;
}
function arrayContainsId(array $array, ?int $id):bool{
    return indexOfId($array,$id)>=0;
}
function extractFields(?array $array,?array $fieldNames):array{
    $result=[];
    if (empty($fieldNames)) return $result;
    foreach($fieldNames as $field){
        $result[$field] =isset($array[$field])?trim($array[$field]):null;
    }
    return $result;
}
function encodeFields(array $fields):array{
    $result=[];
    foreach($fields as $key=>$value){
        $result[$key] = htmlspecialchars($value);
    }
    return $result;
}
function user_sort(?array $a):?array
{
    if (!$a) return $a;
    sort($a);
    return $a;
}
//Удаляет токен из сессии и куков если по нему не возможно авторизоваться (просроченный или недествительный)
function clearToken(){
    unset($_SESSION['token']);
    setcookie('token','',time()-1,BASE_URL);
}
//Возвращает залогиненного пользователя
function getLoginUser():?array{
    $token = $_SESSION['token'] ?? $_COOKIE['token'] ?? null;
    $user=null;
	if ($token != null) {
		//Найти пользователя по токену
		$user = getUserBySessionToken($token);
		//Удалить токен из сессии и куков при недействительном пользователе
		if (empty($user) || !isValidUser($user)) {
			clearToken();
            return null;
		}
	}
    return $user;
}

