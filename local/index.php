<?php //__autoload()
require_once 'AutoLoad.php';
header('Content-Type: text/html; charset=utf-8');
//require_once './Classes/ClassUsers.php';
/*$myobj = new users();
$users = $myobj->dataFullUsers();
foreach ($users as $user) {
    $arr = get_object_vars($user);
    echo '<pre>';
    foreach ($arr as $key => $val)
        echo $key . ' ' . $val . ' ';
}
$s = $myobj->CheckLoginAndPass('tatarin', 'admin');
if ($s) {
    echo '<pre>';
    echo('CheckLoginAndPass: Все норм!');
}
$id = $myobj->FindIdUser('tatarin');
echo '<pre>';
echo 'FindIdUser: ' . $id;
$dataUser = $myobj->dataUser($id);
echo '<pre>';
echo 'dataUser:';
$arr1 = get_object_vars($dataUser);
echo '<pre>';
foreach ($arr1 as $key => $val)
    echo $key . ' ' . $val . ' ';
$dataUser->login = 'tatarinNew';
//$myobj->InsertUser($dataUser);
$myobj->DeleteUser('36');

$myTest = new Tests();
$Tests = $myTest->ListFullTest();
foreach ($Tests as $test) {
    $arr = get_object_vars($test);
    echo '<pre>';
    foreach ($arr as $key => $val)
        echo $key . ' ' . $val . ' ';
}
$Questions=$myTest->GetFirstTestBlock(1);
echo '<pre>';
foreach ($Questions as $question) {
    echo '<pre>';
echo "$question->title:";
    echo '<pre>';
    foreach ($question->answer as $ans) {
        echo '<pre>';
        echo $ans->text;
        echo '<pre>';
        foreach ($ans->weight as $wei) {
            echo '<pre>';
            echo ("$wei->id_TB; $wei->value");
        }
    }
    }
echo "НОВЫЙ НОВЫЙ НОВЫЙ";
$Questions=$myTest->GetTestBlock(5);
echo '<pre>';
foreach ($Questions as $question) {
    echo '<pre>';
    echo "$question->title:";
    echo '<pre>';
    foreach ($question->answer as $ans) {
        echo '<pre>';
        echo $ans->text;
        echo '<pre>';
        foreach ($ans->weight as $wei) {
            echo '<pre>';
            echo ("$wei->id_TB; $wei->value");
        }
    }
}
*/
require_once 'Blocks/Authorization.php';
?>
<p><a href="TestList.php">Список тестов</a></p>
