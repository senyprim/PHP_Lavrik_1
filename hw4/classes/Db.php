<?php


class Db
{
    protected static $instance = null;

    public static function instance()
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


    public function checkError(PDOStatement $prepare)
    {
        $error = $prepare->errorInfo();
        if ($error[0] !== PDO::ERR_NONE) {
            throw new ErrorException($error[2]);
        }
    }

    public function query(string $query, array $params = []):PDOStatement
    {
        $prepare = $this->pdo . prepare($query);//Подготавливаем запрос
        if (!$prepare) return false;
        if (!$prepare . execute($params)) {
            return false;
        }
        $this->checkError($prepare);


    }

}