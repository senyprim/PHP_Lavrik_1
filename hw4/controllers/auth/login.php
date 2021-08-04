<?php
if ('POST' == $_SERVER["REQUEST_METHOD"] && isset($_POST['loginFrm'])) {
    //Проверяем переданные данные 
    //Если все верно создаем токен и записываем в таблицу сессий
    //Дабавляем этот токен в SESSION  и куки если стоит флажок запомнить
    //Если не верно очищаем пароль 

    $loginFrm=$_POST['loginFrm']??null;
    $user = getUserByName($loginFrm['login']??null);
    if (
        !empty($user) &&
        isValidUser(($user)) &&
        password_verify(
            $loginFrm['password']??'',
            $user['password']
        )
    ) {
        //Проверка пройдена
        //Формируем токен и пытаемся записать в базу
        do {
            $token = generateToken();
        } while (empty($id_session = addSessionToken($token, $user['id'])));
        //Сохраняем в сессии
        $_SESSION['token'] = $token;
        if ($loginFrm['remember']) {
            setcookie('token', $token, 60 * 60, BASE_URL);
        }
    } 
}

