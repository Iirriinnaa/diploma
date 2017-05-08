<?php
class Tests
{
    private $db;

    public function __construct()
    {
        require_once 'AutoLoad.php';
        $this->db = DB::getDB();
    }

    //запрос всех тестов
    public function ActiveListTest()
    {
        $result = $this->db->query('SELECT * FROM Test WHERE status=1');
        $tests = $result->fetchAll(PDO::FETCH_CLASS, 'Test');
        return $tests;
    }

    // запрос одного теста
    public function GetTest($id_test)
    {
        $result = $this->db->prepare('SELECT * FROM Test WHERE id=:id_test');
        $result->execute(array('id_test' => $id_test));
        if ($result->rowCount()>0) {
        $result->setFetchMode(PDO::FETCH_CLASS, 'Test');
            $test = $result->fetch();
            return $test;
      }
       else return false;
    }

    //запрос первого блока вопросов
    public function GetFirstTestBlock($id_test)
    {
        $result = $this->db->prepare('select Q.id,Q.title,Q.type FROM Question Q,(SELECT TB.id FROM TestBlock TB, (SELECT id FROM LevelTest WHERE (id_test=:id_test) AND (number=1)) LT WHERE (TB.id_LT=Lt.id)) Tblock WHERE Q.id_TB=Tblock.id');
        $result->execute(array('id_test' => $id_test));
        $result->setFetchMode(PDO::FETCH_CLASS, 'Question');
        $question = $result->fetchAll();
        return $question;
    }

    //запрос n-ого блока вопросов
    public function GetTestBlock($id_TB)
    {
        $result = $this->db->prepare('select id,title,type from Question where id_TB=:id_TB');
        $result->execute(array('id_TB' => $id_TB));
        $result->setFetchMode(PDO::FETCH_CLASS, 'Question');
        $question = $result->fetchAll();
        return $question;
    }

    public function GetIdQuestions($id_TB)
    {
        $result = $this->db->prepare('select id from Question where id_TB=:id_TB');
        $result->execute(array('id_TB' => $id_TB));
        //$result->setFetchMode(PDO::FETCH_COLUMN);
        $IdQuestion = $result->fetchAll(PDO::FETCH_COLUMN);
        return $IdQuestion;
    }
//возврат объекта вопроса по id вопроса
    public function GetQuestion($id_Q)
    {
        $result = $this->db->prepare('select * from Question where id=:id_Q');
        $result->execute(array('id_Q' => $id_Q));
        if ($result->rowCount()>0) {
        $result->setFetchMode(PDO::FETCH_CLASS, 'Question');
        $question = $result->fetch();
        return $question;
        }
        else return false;

    }
    //возврат весов по данным ответам
    public function GetAnswerWeight ($id_answers)
{
    $result = $this->db->prepare('SELECT id_TB,sum(value) as value FROM `AnswerWeight` WHERE id_Answer in (:id_answers) group by id_TB');
    $result->execute(array('id_answers' => implode(',',$id_answers)));
    if ($result->rowCount()>0) {
        $result->setFetchMode(PDO::FETCH_CLASS, 'AnswerWeight');
        $AnswerWeight = $result->fetchAll();
        return $AnswerWeight;
    }
    else return false;
}
    //Возвращает значение флага на результирующий блок
    public function GetResultTB($id_TB)
    {
        $result = $this->db->prepare('select result_block from TestBlock where id=:id_TB');
        $result->execute(array('id_TB' => $id_TB));
        if ($result->rowCount() == 1)
            return $result->fetchColumn();
        else
            return false;

    }
    //запрос текста блока вопросов
    public function GetTextTB($id_TB)
    {
        $result = $this->db->prepare('select text from TestBlock where id=:id_TB');
        $result->execute(array('id_TB' => $id_TB));
        if ($result->rowCount() == 1)
            return $result->fetchColumn();
        else
            return false;

    }
}

?>