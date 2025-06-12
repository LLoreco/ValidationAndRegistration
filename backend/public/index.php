<?php
class Database{
    private $host = 'localhost';
    private $db_name = 'PHPAuthAndRegister';
    private $user = 'postgres';
    private $password = 'Abcdefg111';
    private $connection;

    public function connect(){
        $this->connection = null;
        try {
            $connection = new PDO("pgsql: host = $this->host; dbname = $this->db_name", $this->user, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connection;
        }
        catch(PDOException $e){
            echo "Database connection error: " . $e->getMessage();
            return null;
        }
    }
}
?>