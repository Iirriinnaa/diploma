<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="/js/jquery-1.11.3.js"></script>
    <script src="/js/Tests/testing_1.1.js" type="text/javascript"></script>
    <title>Тестирование</title>
</head>
<body>
<div id="QuestionDIV">
   <?php
   $id_test = isset($_POST['id_test']) ? intval($_POST['id_test']) : NULL; //проверка на существование
   if ((isset($id_test)) and ($id_test != 0)) {
       require_once 'AutoLoad.php';
       $Tests = new Tests();
       $TestInfo = $Tests->GetTest($id_test);
       $flagAccess=true;
       if ($TestInfo) //если данные найдены
       {
           if (Users::checkAuth()) {
               $code_access= Access::CheckAccessTest($id_test, $_SESSION['login']);
               require_once 'Constants/Access.php';
               if (($code_access=='0') or ($code_access=='false') or ($code_access & A_BLACK))
               {
                   $flagAccess=false;
                   if ($code_access=='0')
                   {
                       echo include('404.php');
                   }
                   if ($code_access=='false')
                   {
                       echo "У вас нет прав на прохождение данного теста";
                   }
                   if (($code_access & A_BLACK))
                   {
                       echo "Вы находитесь в черном списке по отношению к данному тесту. За подробностями обратитесь к администратору!";
                   }
               }
               elseif (($code_access & A_READ))
               {
                   $id_questions = $Tests->GetIdQuestions($TestInfo->id_first_TB);
                   $_SESSION['id_question'] = $id_questions;
                   $_SESSION['current_Q'] = 0;
                   $_SESSION['id_answers'] = array();
                   $_SESSION['id_test'] = $id_test;
               }

           } else
           {
               $flagAccess=false;
               echo "Вы не авторизованны! Проидите авторизацию!";
           }
           if (!$flagAccess) {
               unset ($_SESSION['id_test']);
           }
       } else echo include('404.php');

   } else echo include('404.php');
//include ('GetQuestion.php');
?>
</div>

</body>
</html>
