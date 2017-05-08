<?php

class Users
{
    private $db;

    public function __construct()
    {
        require_once 'AutoLoad.php';
        $this->db = DB::getDB();

    }

    //запрос всех данных пользователей
    public function DataFullUsers()
    {
        $result = $this->db->query('SELECT * FROM Users');
        $users = $result->fetchAll(PDO::FETCH_CLASS, 'User');
        return $users;
    }

    //запрос данных пользователя по Id
    public function DataUser($id)
    {
        $result = $this->db->prepare('SELECT * FROM Users where id=:id');
        $result->execute(array('id' => $id));
        $result->setFetchMode(PDO::FETCH_CLASS, 'User');
        $user = $result->fetch();
        return $user;
    }

    //проверка user на существование
    public function CheckLoginAndPass($login, $pass)
    {

        $result = $this->db->prepare('SELECT id FROM Users where login = :login and pass= :pass');
        $result->execute(array('login' => $login, 'pass' => $pass));
        if ($result->rowCount() == 1)
            return true;
        else
            return false;
    }

//проверка логина на существование
    public function FindLogin($login)
    {
        $result = $this->db->prepare('SELECT id FROM Users where login = :login');
        $result->execute(array('login' => $login));
        if ($result->rowCount() >= 1)
            return true;
        else
            return false;

    }

//возвращает id пользователя по введенному login
    public function FindIdUser($login)
    {
        $result = $this->db->prepare('SELECT id FROM Users where login = :login');
        $result->execute(array('login' => $login));
        //$user = $result->fetchAll(PDO::FETCH_CLASS, 'User');
        if ($result->rowCount() == 1)
            return $result->fetchColumn();
        else
            return false;
    }

//добавить нового пользователя
    public function InsertUser($user)
    {
        $result = $this->db->prepare('INSERT INTO `Users` (name, login,pass) VALUES (:name, :login, :pass)');
        $result->execute(array('login' => $user->login, 'name' => $user->name, 'pass' => $user->pass));
        if ($result->rowCount() == 1)
            return true;
        else return false;

    }

//удалить пользователя по id
    public function DeleteUser($id)
    {
        $result = $this->db->prepare('delete from `Users` where `id`=:id');
        $st = $result->execute(array('id' => $id));
        if ($st)
            echo 'Yes';
        else
            echo 'No';
    }
    //проверка логина на соответствие нормам
   public function checkLogin($str) {
        $error = '';
        if(!$str) {
            $error = 'Вы не ввели логин';
            return $error;
        }
        $pattern = '/^[-_.a-z\d]{4,16}$/i';
        $result = preg_match($pattern, $str);
        if(!$result) {
            $error = 'Недопустимые символы в логине или логин слишком короткий (длинный)';
            return $error;
        }
        $user=new Users();
        if($user->FindLogin($str))
        {
            $error = 'Пользователь с таким логином уже существует';
            return $error;
        }

        return true;
    }
    //проверка имени на соответствии нормам
    public  function checkName($str) {
        $error = '';
        if(!$str) {
            $error = 'Вы не ввели имя пользователя';
            return $error;
        }
        $pattern = '/^([а-яёa-z]+)$/iu';
        $result = preg_match($pattern, $str);
        if(!$result) {
            $error = 'Недопустимые символы в имени пользователя';
            return $error;
        }
        return true;
    }
    //проверка пароля на соответствие нормам
    public function checkPassword($str) {
        $error = '';
        if(!$str) {
            $error = 'Вы не ввели пароль';
            return $error;
        }
        $pattern = '/^[_!)(.a-z\d]{6,16}$/i';
        $result = preg_match($pattern, $str);
        if(!$result) {
            $error = 'Недопустимые символы в пароле пользователя или пароль слишком короткий (длинный)';
            return $error;
        }

        return true;
    }
    //хэширование пароля
    public static  function HashPassword ($login,$pass)
    {
       return md5(md5($pass).$login);
    }

    //выход из системы
    public static function Logout ()
    {
       // if(!session_name())
            session_start();
            unset($_SESSION['login']);
        unset($_SESSION['UserAgent']);
    }
    // проверка на авторизацию
    public  static function checkAuth ()
    {
            session_start();
        if (isset($_SESSION['login']) and isset($_SESSION['UserAgent']))
        {
            if (md5($_SERVER['HTTP_USER_AGENT']) != $_SESSION['UserAgent']) {
                Logout();
                return false;
            }
            return true;
        }
        return false;
    }
}

?>