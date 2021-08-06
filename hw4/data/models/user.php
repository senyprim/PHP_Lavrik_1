<?php
const USER_QUERY_GET_BY_ID = 'select * from v_users where id=:id';
const USER_QUERY_GET_BY_NAME = 'select * from v_users where login=:name';
const USER_QUERY_GET_VALID_BY_NAME = 'select * from v_users 
where user_name=:name and status.name!="deleted"';
const USER_QUERY_GET_BY_SESSION_TOKEN = 'select b.* from sessions a 
left join v_users b on a.id_user=b.id where a.token=:token';
const USER_QUERY_ADD = 'insert users(login,password,id_role,id_status) values (:login,:password,:id_role,:id_status)';
const STATUS_QUERY_GET_BY_ID = 'select * from status where id=:id';
const ROLE_QUERY_GET_BY_ID = 'select * from roles where id=:id';
const ROLE_QUERY_GET_ALL = 'select a.* from roles a left join status b on a.id_status=b.id  where b.name!="deleted"';
const SESSION_QUERY_GET_BY_TOKEN = 'select * from sessions where token=:token';
const SESSION_QUERY_ADD = 'insert sessions(token,id_user) values (:token,:id_user)';
const USER_NAME_REGEX_VALIDATE = '/^[0-9a-z]{3,10}$/';
const USER_PASSWORD_REGEX_VALIDATE = '/^[0-9a-zA-Z]{3,10}$/';
const SESSION_TOKEN_SYMBOLS = '0123456789abcdefghijklmnopqrstuvwxyz';

include_once(BASE_DIR . '/core/db.php');

function getUserById(?int $id): ?array
{
    if (empty($id)) return null;
    $result = query(USER_QUERY_GET_BY_ID, [':id' => $id])->fetch();
    return $result === false ? null : $result;
}
function getUserByName(?string $name): ?array
{
    if (empty($name)) return null;
    $result = query(USER_QUERY_GET_BY_NAME, [':name' => $name])->fetch();
    return $result === false ? null : $result;
}
function getUserBySessionToken(?string $token): ?array
{
    if (empty($token)) return null;
    $result = query(USER_QUERY_GET_BY_SESSION_TOKEN, [':token' => $token])->fetch();
    return $result === false ? null : $result;
}
function isValidUser(?array $user): bool
{
    if (empty($user) || !isset($user['status'])) return false;
    return $user['status'] === 'valid';
}
function isExistToken(string $token): bool
{
    if (empty($token)) return false;
    $result = query(SESSION_QUERY_GET_BY_TOKEN, [':token' => $token])->fetch();
    return $result === false ? false : true;
}
function addSessionToken(string $token, int $id_user): ?int
{
    if (empty($token) || isExistToken($token) || empty($id_user)) return null;
    $result = query((SESSION_QUERY_ADD), [':token' => $token, ':id_user' => $id_user])->fetch();
    return $result === false ? null : getLastId();
}
function addUser(string $login, $password, ?int $idRole = 1, ?int $idStatus = 1): bool
{
    $result = query(
        USER_QUERY_ADD,
        [
            ':login' => $login,
            ':password' => password_hash($password,PASSWORD_BCRYPT),
            ':id_role' => $idRole,
            ':id_status' => $idStatus,
        ]
    );
    return $result === false ? false : true;
};

function loginUser(?string $login, $password): ?array
{
    //Проверяем переданные данные пользователя
    if (empty($login) || empty($password))
        return null;

    $user = getUserByName($login ?? null);
    return (!empty($user) &&
        isValidUser(($user)) &&
        password_verify(
            $password ?? '',
            $user['password']
        ))
        ? $user
        : null;
}

function validateUser(?string $name, $password, ?int $idRole, ?int $idStatus): array
{
    $errors = [];
    if (!preg_match(USER_NAME_REGEX_VALIDATE, $name ?? '')) {
        $errors['login'] = 'Логин должен быть от 3 до 10 символов цифр и строчных латинских букв ' . ARTICLE_MIN_SIZE_TITLE . 'символов';
    };
    if (!preg_match(USER_PASSWORD_REGEX_VALIDATE, $password ?? '')) {
        $errors['password'] = 'Пароль должен быть от 3 до 10 символов цифр и латинских букв ' . ARTICLE_MIN_SIZE_TITLE . 'символов';
    };
    if (!checkIntId($idRole) || empty(getRoleById($idRole))) {
        $errors['role'] = 'Выбранная роль не существует';
    }
    if (!checkIntId($idStatus) || empty(getStatusById($idStatus))) {
        $errors['status'] = 'Выбраный статус не существует';
    }
    return $errors;
}

function getValidUserById(?int $id): ?array
{
    if (empty($name)) return null;
    $result = query(USER_QUERY_GET_VALID_BY_NAME, [':name' => $name])->fetch();
    return $result === false ? null : $result;
}
function getStatusById(?int $id): ?array
{
    if ($id == null) return null;
    $status = query(STATUS_QUERY_GET_BY_ID, [':id' => $id])->fetch();
    return $status === false ? null : $status;
}
function getRoleById(?int $id): ?array
{
    if ($id == null) return null;
    $role = query(ROLE_QUERY_GET_BY_ID, [':id' => $id])->fetch();
    return $role === false ? null : $role;
}
function getAllRoles(): ?array
{
    return query(ROLE_QUERY_GET_ALL)->fetchAll() ?? null;
}
function getSessionByToken(?string $token): ?array
{
    if (empty($token)) return null;
    $session = query(SESSION_QUERY_GET_BY_TOKEN, [':token' => $token])->fetch();
    return $session === false ? null : $session;
}
function getIdUserByToken(string $token): ?int
{
    $session = getSessionByToken($token);
    if (empty($session) || !isset($session['id_user'])) return null;
    return $session['id_user'];
}
function getUserByToken(string $token): ?array
{
    $session = getSessionByToken($token);
    if (empty($session) || !isset($session['id_user'])) return null;
    return $session['id_user'];
}
