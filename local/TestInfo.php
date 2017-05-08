<?php session_start() ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Страница информации о тесте</title>
</head>
<body>
<?php
require_once 'AutoLoad.php';
require_once 'Blocks/Authorization.php';
$id_test = isset( $_GET['id_test'] ) ? intval( $_GET['id_test'] ) : NULL; //проверка на существование
if((isset($id_test)) and ($id_test!=0)) {
    $Tests = new Tests();
    $TestInfo = $Tests->GetTest($id_test);
    if ($TestInfo) //если данные найдены
    {
        $html='';
        $html.=' <h3>Информация о тесте</h3>
 <div>
  <p>Название:'.$TestInfo->title.'</p>
  <p>Описание:'.$TestInfo->text.'</p>
   <p>Дата создания:'.$TestInfo->date.'</p>';
    if (Users::checkAuth()) {
       $code_access= Access::CheckAccessTest($id_test, $_SESSION['login']);
        require_once 'Constants/Access.php';
       if ($code_access=='0') $html=include('404.php');
        elseif ($code_access=='false') $html.='<p> Данный тест недоступен для вас. Для получения доступа обратитесь к администратору</p>';
        elseif ($code_access & A_BLACK) $html.='<p> Вы внесены в черный список по отношению к данному тесту. Для получения доступа обратитесь к администратору</p>';
        elseif ($code_access & A_READ) {
            $html .= '<form name="test" method="post" action="testing.php">
      <input type="hidden" name="id_test" value="' . $TestInfo->id . '">
      <p><input id="next" type="submit" value="Начать тестирование"> </p> </form>';

       if ($code_access & A_EDIT) {
                $html .= '<form name="test" method="post" action="editTest.php">
      <input type="hidden" name="id_test" value="' . $TestInfo->id . '">
      <p><input id="next" type="submit" value="Редактировать тест"> </p> </form>';
            }
}


    } else $html.= '<p>Доступ к тестам для гостей закрыт. Пожалуйста, зарегистрируйтесь</p>';

        echo $html.'</div>';
    }
    else echo include('404.php');
}
else
{
    include('404.php');
}
?>
</body>
</html>

