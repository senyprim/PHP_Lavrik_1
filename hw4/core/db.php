<?php

declare(strict_types=1);
const INTEGER_ID_REGEX_VALIDATE = '/^[1-9]\d+$/';

class Db
{
    const INTEGER_ID_REGEX_VALIDATE = '/^[1-9]\d+$/';
    static private $defaultOptionsPDO = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => TRUE,
    );
    protected $pdo;
    protected $prepare;
    public function __construct(string $connectionString, $user, $password, $options = null)
    {
        if (empty($connectionString) || empty($user)) {
            die();
        }
        try {
            $options = $options ?? self::$defaultOptionsPDO;
            $this->pdo = new PDO($connectionString, $user, $password, $options);
        } catch (PDOException $err) {
            throw new Exception($err->getMessage());
        }
    }
    public function getPrepare()
    {
        return $this->prepare;
    }
    public function prepare(string $query): Db
    {
        $this->prepare = $this->pdo->prepare($query);
        return $this;
    }
    public function execute(array $params = []): PDOStatement
    {
        if (empty($this->getPrepare())) {
            throw new ErrorException('Отсутствует запрос для выполнения');
        };
        $result = $this->getPrepare()->execute($params);
        return $result ? $this->getPrepare() : null;
    }
    
    public function query(string $query,array $params=[]):PDOStatement{
        return $this->prepare($query)->execute($params);
    }

    function checkIntId(?string $id):bool
    {
        return !!preg_match(self::INTEGER_ID_REGEX_VALIDATE, $id ?? '');
    }
    function getLastId(): string
    {
        return $this->pdo->lastInsertId();
    }
}

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
function checkIntId(?string $id)
{
    return !!preg_match(INTEGER_ID_REGEX_VALIDATE, $id ?? '');
}
