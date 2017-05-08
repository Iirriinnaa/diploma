<?php

class Answer
{
    //private $db;
    public $id;
    public $text;

   /* public $weight=array();
    public function __construct()
    {
        // require_once 'ClassUser.php';
        require_once 'AutoLoad.php';
        //require_once '/../dbcn.php';
       // $this->db = new DB("mysql:host=localhost;dbname=Test", "root", "");
        $this->db = DB::getDB();
        $result = $this->db->prepare('select id_TB,value from AnswerWeight where id_Answer=:id');
        $result->execute(array('id' => $this->id));
        $result->setFetchMode(PDO::FETCH_CLASS, 'AnswerWeight');
        $this->weight= $result->fetchAll();
    }
    */
}