<?php
$html = "";
if ($_SESSION['current_Q']+1 <= count($_SESSION['id_question'])) {
$id_question=$_SESSION['id_question'][$_SESSION['current_Q']];
    $Tests=new Tests();
    $Question=$Tests->GetQuestion($id_question);
    if ($Question) {

        $html = ' <h3>Вы проходи тест:' . $TestInfo->title . '</h3>';
        //$html .= ' <form name="test" method="post" action="testing.php?id_test=' . $_SESSION['id_test'] . '">';
        $html .= '<p>' . $Question->title .'</p>';
        if ($Question->type == 0) //0-тип radio
        {
            foreach ($Question->answer as $Ans) {
                $html .= '<input type="radio" name="answer" value= ' . $Ans->id . '> ' . $Ans->text . '<Br>';
            }
        }
        if ($Question->type == 1)//1-тип checkbox
        {
            foreach ($Question->answer as $Ans) {
                $html .= '<input type="checkbox" name="answer" value= ' . $Ans->id . '> ' . $Ans->text . '<Br>';
            }
        }
            $_SESSION['current_Q']++;
           // $html .= ' <p><input id="next" type="submit" value="Отправить"> </p> </form>';
        $html.='<p><button id="next">Следующий</button></p>';
    }


}
echo $html;


?>