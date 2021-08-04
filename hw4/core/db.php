<?php

declare(strict_types=1);
const INTEGER_ID_REGEX_VALIDATE='/^[1-9]\d*$/';

function getPDO()
{
    static $pdo;
    $opt = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => TRUE,
    );
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHAR;

    if (null === $pdo) {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $opt);
    }
    return $pdo;
}
function checkError(PDOStatement $prepare)
{
    $error = $prepare->errorInfo();
    if (!!$error[0] && $error[0] !== PDO::ERR_NONE) {
        throw new ErrorException($error[2]);
        exit();
    }
}
function getLastId(): string
{
    return getPDO()->lastInsertId();
}
function query(string $query, array $params = []): PDOStatement
{
    $prepare = getPDO()->prepare($query); //Подготавливаем запрос
    $prepare->execute($params); //Выполняем запрос
    checkError($prepare); //Вызываем ошибку если нужно
    return $prepare; //Возвращаем результат
}
function checkIntId(?string $id){
    return !!preg_match(INTEGER_ID_REGEX_VALIDATE,$id??'');
}

