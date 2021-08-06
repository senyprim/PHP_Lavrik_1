<?php
class UserRepository
{
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




    private $db;
    public function __construct(Db $db)
    {
        $this->db = $db;
    }
    public function addUser(UserClass $user):int
    {
        $result = query(
            USER_QUERY_ADD,
            [
                ':login' => $user->getLogin(),
                ':password' => $user->getPassword(),
                ':id_role' => $user->getRole()->getId(),
                ':id_status' => $user->getStatus()->getId(),
            ]
        );
        return $result === false ? false : true;
    };
    }
}
