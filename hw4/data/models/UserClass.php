<?php
declare(strict_types=1);

use UserClass as GlobalUserClass;

class UserClass{
    const USER_NAME_REGEX_VALIDATE = '/^[0-9a-z]{3,10}$/';
    const USER_NAME_ERROR_MESSAGE = 'Имя должно состоять из строчных латинских букв и цифр от 3х до 10 символов.';
    
    const USER_PASSWORD_REGEX_VALIDATE = '/^[0-9a-zA-Z]{3,10}$/';
    const USER_PASSWORD_ERROR_MESSAGE = 'Пароль должен состоять из строчных латинских букв и цифр от 3х до 10 символов.';

    protected $id;
    protected $login;
    protected $password;
    protected $dt_add;
    protected $role;
    protected $status;

    protected $isHashPassword=true;

    public function __construct(int $id,string $login, $password, $dt_add,RoleClass $role,StatusClass $status)
    {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
        $this->dt_add = $dt_add;
        $this->role = $role;
        $this->status = $status;
    }
    public function password_verify(string $password):bool{
        return password_verify($password,$this->getPassword());
    }

    public function getId():int
    {
        return $this->id;
    }

    public function setId(int $id):UserClass
    {
        $this->id = $id;
        return $this;
    }

    public function getLogin():string
    {
        return $this->login;
    }

    public function setLogin(string $login):UserClass
    {
        $this->login = $login;
        return $this;
    }

    public function getPassword():string
    {
        return $this->password;
    }

    public function setHashPassword(string $password):UserClass
    {
        $this->isHashPassword=true;
        $this->password = $password;
        return $this;
    }
    public function setNotHashPassword(string $password):UserClass{
        $this->isHashPassword=false;
        $this->password=$password;
        return $this;
    }

    public function getDt_add():string
    {
        return $this->dt_add;
    }

    public function setDt_add($dt_add)
    {
        $this->dt_add = $dt_add;
        return $this;
    }

    public function getRole():RoleClass
    {
        return $this->role;
    }

    public function setRole(RoleClass $role)
    {
        $this->role = $role;
        return $this;
    }

    public function getStatus():StatusClass
    {
        return $this->status;
    }

    public function setStatus(StatusClass $status)
    {
        $this->status = $status;
        return $this;
    }
    public function validate():?array{
        $errors=[];
        if (!preg_match($this->login,self::USER_NAME_REGEX_VALIDATE)){
            $errors['login']=self::USER_NAME_ERROR_MESSAGE;
        }
        if (!$this->isHashPassword && !preg_match($this->login,self::USER_NAME_REGEX_VALIDATE)){
            $errors['password']=self::USER_PASSWORD_ERROR_MESSAGE;
        }
        if(empty($this->status) || empty($this->status->getId())

        return $errors;
    }
}