<?php
class DB extends PDO
{
    private static $db = null;

    public static function getDB ()
    {
        if ( is_null ( self::$db ) )
        {
            self::$db = new DB ("mysql:host=localhost;dbname=Test", "root", "");
        }
        return self::$db;
}
    public $error = true; // выводить сообщения об ошибках на экран? (true/false)

  public function __construct($dsn, $username='', $password='', $driver_options=array())
  {
      try {
          parent::__construct($dsn, $username, $password, $driver_options);

          $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('DBStatement', array($this)));

          $this->query("SET NAMES 'utf8'");
      } catch (PDOException $e) {
          echo "Не могу связаться с БД...";
          file_put_contents('../PDOErrors.txt', $e->getMessage(), FILE_APPEND);
          exit();
      }
  }

    public function prepare($sql, $driver_options=array())
    {
        try {
            return parent::prepare($sql, $driver_options);
        }  
        catch(PDOException $e) {  
            $this->error($e->getMessage());
        }
    }
    
    public function query($sql)
    {
        try {
            return parent::query($sql);
        }  
        catch(PDOException $e) {  
            $this->error($e->getMessage());
        }
    }
    
    public function exec($sql)
    {
        try {
            return parent::exec($sql);
        }  
        catch(PDOException $e) {  
            $this->error($e->getMessage());
        }
    }
    
    public function error($msg)
    {
        if($this->error)
        {
            echo $msg;
        }
        else
        {
            echo "Произошла ошибка в работе с базой данных...";
			
        }
		  file_put_contents('PDOErrors.txt', date("m.d.y, H:i:s").' '.$msg.PHP_EOL, FILE_APPEND);
        
        exit();
    }
}

class DBStatement extends PDOStatement 
{
    protected $db;
    
    protected function __construct($db) {
        $this->db = $db;
    }
    
    public function execute($data=array())
    {
        try {
            return parent::execute($data);
        }  
        catch(PDOException $e) {
            $this->db->error($e->getMessage());
        }
    }
}
?>
