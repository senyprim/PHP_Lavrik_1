<?php
declare(strict_types=1);

class Db
{
    protected static $instance = null;

    public static function getInstance():?PDO
    {
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => TRUE,
        );
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHAR;

        if (self::$instance === null) {
            self::$instance = new PDO($dsn, DB_USER, DB_PASS, $opt);
        }

        return self::$instance;
    }
    

    public static function checkError(PDOStatement $prepare)
    {
        $error = $prepare->errorInfo();
        if (!!$error[0] && $error[0]!== PDO::ERR_NONE) {
            throw new ErrorException($error[2]);
            exit();
        }
    }

    public static function query(string $query, array $params = []):PDOStatement
    {
        // echo var_dump($query);
        // echo var_dump($params);
        $prepare = self::getInstance()->prepare($query);//Подготавливаем запрос
        $prepare->execute($params);//Выполняем запрос
        self::checkError($prepare);//Вызываем ошибку если нужно
        return $prepare;//Возвращаем результат
    }
    public static function getLastId() : string{
		return self::getInstance()->lastInsertId();
	}

}