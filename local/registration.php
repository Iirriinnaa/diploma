<?php
header('Content-Type: text/html; charset=utf-8');
require_once 'AutoLoad.php';
$fields = array();
$reg=false;
if (isset($_POST['submit']))
{
    $users=new Users();
    $errors= array();
    $fields['login'] = trim($_POST['login']);
    $fields['name'] = trim($_POST['name']);
    $password = trim($_POST['password']);
    $password_again = trim($_POST['password_again']);
    $errors['name'] = $users->checkName($fields['name']) === true ? '' : $users->checkName($fields['name']);
    $errors['login'] = $users->checkLogin($fields['login']) === true ? '' : $users->checkLogin($fields['login']);
    $errors['password'] = $users->checkPassword($password) === true ? '' : $users->checkPassword($password);
    $errors['password_again'] = ($users->checkPassword($password) === true && $password === $password_again) ? '' : 'Введенные пароли не совпадают';
    if($errors['login'] == '' && $errors['password'] == '' && $errors['password_again'] == '' && $errors['name']=='') {
        $user=new User();
        $user->login=$fields['login'];
        $user->name= $fields['name'];
        $user->pass= Users::HashPassword($fields['login'],$password);
        $reg=$users->InsertUser($user);
        if ($reg)
        {
            $message= '<p>Вы успешно зарегистрировались в системе. Сейчас вы будете переадресованы к странице авторизации. Если это не произошло, перейдите на неё по <a href="login.php">прямой ссылке</a>.</p>';
            header('Refresh: 5; URL = login.php');
        }
    }

}
?>
<html>
<head>
    <title>Регистрация пользователей</title>
    <link href="css/login.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php if (!$reg) { ?>
<form action="" method="post">
    <div class="row">
        <label for="login">Укажите ваш логин:</label>
        <input type="text" class="text" name="login" id="login" value="<?=$fields['login'];?>" />
        <div class="error" id="login-error"><?=$errors['login'];?></div>
        <div class="instruction" id="login-instruction">В имени пользователя могут быть только символы латинского алфавита, цифры, символы '_', '-', '.'. Длина имени пользователя должна быть не короче 4 символов и не длиннее 16 символов</div>
    </div>
    <div class="row">
        <label for="login">Укажите ваше имя:</label>
        <input type="text" class="text" name="name" id="name" value="<?=$fields['name'];?>" />
        <div class="error" id="name-error"><?=$errors['name'];?></div>
        <div class="instruction" id="login-instruction">В имени пользователя могут быть только символы латинского алфавита, либо символы только русского алфавита. Длина имени пользователя должна быть не короче 4 символов и не длиннее 16 символов</div>
    </div>
    <div class="row">
        <label for="password">Напишите ваш пароль:</label>
        <input type="password" class="text" name="password" id="password" value="" />
        <div class="error" id="password-error"><?=$errors['password'];?></div>
        <div class="instruction" id="password-instruction">В пароле вы можете использовать только символы латинского алфавита, цифры, символы '_', '!', '(', ')'. Пароль должен быть не короче 6 символов и не длиннее 16 символов</div>
    </div>
    <div class="row">
        <label for="password_again">Повторите введенный пароль:</label>
        <input type="password" class="text" name="password_again" id="password_again" value="" />
        <div class="error" id="password_again-error"><?=$errors['password_again'];?></div>
        <div class="instruction" id="password_again-instruction">Повторите введенный ранее пароль</div>
    </div>
    <div class="row">
        <input type="submit" name="submit" id="btn-submit" value="Зарегистрироваться" />
        <input type="reset" name="reset" id="btn-reset" value="Очистить" />
    </div>
</form>
<?php } else echo $message ?>
</body>
</html>

