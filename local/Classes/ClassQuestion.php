<?php
class Question
{
    public $id;
    public $id_TB;
    private $db;
public $title;
    public $type;
    public $text;
   public $answer;
    public function __construct()
    {
        // require_once 'ClassUser.php';
        require_once 'AutoLoad.php';
        //require_once '/../dbcn.php';
       // $this->db = new DB("mysql:host=localhost;dbname=Test", "root", "");
        $this->db = DB::getDB();
        $result = $this->db->prepare('select id,text from Answer where id_Question=:id');
        $result->execute(array('id' => $this->id));
        $result->setFetchMode(PDO::FETCH_CLASS, 'Answer');
        $this->answer= $result->fetchAll();
    }
}