<?php session_start();
require_once 'AutoLoad.php';
    if ((isset( $_SESSION['id_test'])) and ( $_SESSION['id_test']!=0)) {
        $Tests = new Tests();
        $TestInfo = $Tests->GetTest($_SESSION['id_test']);
        $answers = ($_POST['answer']);
        if ((isset($answers)) and ($answers != 0)) {
            $_SESSION['id_answers'] = array_merge($_SESSION['id_answers'], $answers);
            $_SESSION['current_Q']++;
        }
        if ($_SESSION['current_Q'] + 1 > count($_SESSION['id_question'])) {
            $AnswerWeights = $Tests->GetAnswerWeight($_SESSION['id_answers']);
            if ($AnswerWeights) {
                $max = -1;
                $id_next_TB = 0;
                foreach ($AnswerWeights as $answerWeight) {
                    if ($answerWeight->value > $max) {
                        $max = $answerWeight->value;
                        $id_next_TB = $answerWeight->id_TB;
                    }
                }
                if ($id_next_TB != 0) {
                    if ($Tests->GetResultTB($id_next_TB)==0) {
                        $id_questions = $Tests->GetIdQuestions($id_next_TB);
                        $_SESSION['id_question'] = $id_questions;
                        $_SESSION['current_Q'] = 0;
                        $_SESSION['id_answers'] = array();
                    } else if (($Tests->GetResultTB($id_next_TB)==1))
                    {
                        echo '<h3>Результат тестирования:</h3>';
                        echo $Tests->GetTextTB($id_next_TB);
                        echo '<br><br><button id=\"next2\">На главную</button></p>';
                    }
                } else echo include('404.php');
            } else echo 'Тест закончен';
        }

        $html = GetQuest($TestInfo->title, $_SESSION['id_question'][$_SESSION['current_Q']]);
        echo $html;
    } else include('404.php');


function GetQuest($titleTest,$id_question)
{
    $html = "";
        $Tests = new Tests();
        $Question = $Tests->GetQuestion($id_question);
        if ($Question) {

            $html = ' <h3>Вы проходи тест:' . $titleTest . '</h3>';
            $html .= '<p>' . $Question->title . '</p>';
            if ($Question->type == 0) //0-тип radio
            {
                foreach ($Question->answer as $Ans) {
                    $html .= '<input type="radio" name = "answer" class="answer" value= ' . $Ans->id . '> ' . $Ans->text . '<Br>';
                }
            }
            if ($Question->type == 1)//1-тип checkbox
            {
                foreach ($Question->answer as $Ans) {
                    $html .= '<input type="checkbox" class="answer" value= ' . $Ans->id . '> ' . $Ans->text . '<Br>';
                }
            }
            $html .= '<button id="next">Следующий</button></p>';
        }
    return $html;
}

?>