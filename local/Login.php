<?php session_start();
require_once 'AutoLoad.php';
$login='';
$error='';
$auth=false;
if (isset($_POST['submit-logout']))
{
	Users::Logout();
}
if (isset($_POST['submit']))
{
	$login= trim($_POST['login']);
	$password=trim($_POST['password']);
	if ($login=='') $error='Логин не введен';
	if ($password=='' && $error=='') $error = 'Пароль не введен';
	if ($error=='') {
		$Users = new Users();
		$auth = $Users->CheckLoginAndPass($login, Users::HashPassword($login,$password));
		if ($auth) {
			$_SESSION['login'] = $login;
			$_SESSION['UserAgent'] = md5($_SERVER['HTTP_USER_AGENT']);
			$message = '<p>Вы успешно авторизовались в системе. Сейчас вы будете переадресованы на главную страницу сайта. Если это не произошло, перейдите на неё по <a href="/">прямой&nbsp;ссылке</a>.</p>';
			header('Refresh: 5; URL = /');
		} else $error = 'Пара логин-пароль не найдены';
	}
}
?>
<html>
<head>
	<title>Авторизация пользователей</title>
	<meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
	<link href="css/login.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php if (!$auth)
{
	if (Users::checkAuth())
	{
		$html= '<p> Вы уже авторизованны под логином '.$_SESSION['login'].'. </p>';
		$html.='<p> Если вы хотитите зайти под другим логином, то выйдите из системы </p>';
		$html.='<form action="" method = "post">
<input type="submit" name="submit-logout" id="logout" value="Выйти из системы" /> </form>';
		echo $html;
	} else {
	?>
<div id="full_error" class="error" style="display:
<?
echo $error ? 'inline-block' : 'none';
?>
		;">
	<?
	echo $error ? $error : '';
	?>
</div>
<form action="" method="post">
	<div class="row">
		<label for="login">Ваш логин:</label>
		<input type="text" class="text" name="login" id="login" value="<?= $login ?>" />
	</div>
	<div class="row">
		<label for="password">Ваш пароль:</label>
		<input type="password" class="text" name="password" id="password" />
	</div>
	<div class="row">
		<input type="submit" name="submit" id="btn-submit" value="Авторизоваться" />
	</div>
</form>
<p class="to_reg">Если вы не зарегистрированы в системе, <a href="registration.php">зарегистрируйтесь</a> </p>
<?php } } else echo $message ?>
</body>
</html>
