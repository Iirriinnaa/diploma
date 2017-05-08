<?php
require_once 'AutoLoad.php';
if (isset($_POST['submit-logout']))
{
    Users::Logout();
}
$html='';
$html.='<div id="Authorization">';
require_once 'AutoLoad.php';
if (Users::checkAuth())
{
    $html.='<p>Вы зашли по логином '.$_SESSION['login'].' <form action="" method = "post">
<input type="submit" name="submit-logout" id="logout" value="Выйти из системы" /> </form> </p>';
} else{
    $html.='<p>Вы не авторизованы. Для авторизации перейдите на <a href="login.php"> страницу авторизации.</a></p>
<p>Если вы не зарегистрированы в системе, <a href="registration.php">зарегистрируйтесь</a></p> ';
}
$html.='</div>';
echo $html;
?>