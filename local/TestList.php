<?php session_start() ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Страница вариантов ответа</title>
</head>
<body>
<?php require_once 'Blocks/Authorization.php';?>
<h3>Список тестов</h3>
<?php
require_once 'AutoLoad.php';
$myTest = new Tests();
$ListTest=$myTest->ActiveListTest();

foreach ($ListTest as $test) {
    ?>
<p><a href="TestInfo.php?id_test=<?=$test->id ?>"><?= $test->title ?></a></p>
<?php
}
?>
</body>
</html>

