<?php

class Access
{
    //проверка доступа пользователя к тесту, в случае ошибки ответ 0, в случает запрета доступа ответ false, в случае положительного результата возвращает роль пользователя
    public static function CheckAccessTest($id_test, $login)
    {
        require_once 'AutoLoad.php';
        $db = DB::getDB();
        $result = $db->prepare('SELECT limit_access FROM Test WHERE id=:id_test');
        $result->execute(array('id_test' => $id_test));
        if ($result->rowCount() == 1)
            $limit_access = $result->fetchColumn();
        else
            return 0;
        $users = new Users();
        $id_user = $users->FindIdUser($login);
        if ($id_user == false) return 0;
        $code_access = self::GetCodeAccess($id_test, $id_user);
        if ($code_access != false) {
            return $code_access;
        } else
        {
            if ($limit_access) return 'false';
            else return '010000';
        }
    }

    //запрос доступа к данным
    public static function GetCodeAccess($id_test, $id_user)
    {
        require_once 'AutoLoad.php';
        $db = DB::getDB();
        $result = $db->prepare('SELECT bit_or(code_access) FROM Access WHERE id_user=:id_user and id_test=:id_test and date >= NOW() ');
        $result->execute(array('id_test' => $id_test, 'id_user' => $id_user));
        if ($result->rowCount() == 1)
            return $result->fetchColumn();
        else return false;

    }

//определяет роль пользователя по отношению к тесту
    public static function GetRoleUser($code_access)
    {
        require_once 'Constants/Access.php';
        if ($code_access & A_BLACK) return 'BLACK';
        if ($code_access & A_ADMIN) return 'ADMIN';
        if ($code_access & A_EDITOR) return 'EDITOR';
        if ($code_access & A_TUTOR) return 'TUTOR';
        if ($code_access & A_TEST) return 'TEST';
        return false;

    }

    //
}
?>