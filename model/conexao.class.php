<?php
abstract class Conexao{
    private $servidor = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $banco = 'crud1';
    protected $conn;
            
    protected function conexao(){
        $this->conn = new PDO('mysql:host=' . $this->servidor . ';dbname=' . $this->banco, $this->user, $this->pass);
    }
}
?>