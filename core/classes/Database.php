<?php 

namespace core\classes;

use Exception;
use PDO;
use PDOException;

class Database {
  
    private $ligacao;
    
    private function ligar() {
        $this->ligacao = new PDO(
            'mysql:'.
            'host='.MYSQL_SERVER.';'.
            'dbname='.MYSQL_DATABASE.';'.
            'charset='.MYSQL_CHARSET,
            MYSQL_USER,
            MYSQL_PASS,
            array(PDO::ATTR_PERSISTENT => true)
        );

        $this->ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    private function desligar() {
        $this->ligacao = null;
    }

    //==================== SELECT ===========================

    public function select($sql, $parametros = null) {
        $sql = trim($sql);
        if (!preg_match("/^SELECT/i", $sql)) {
           throw new Exception("Base de dados não é uma instrução Select");
        }
        $this->ligar();

        $resultados = null;
        try {
        if (!empty($parametros)) {
            $executar = $this->ligacao->prepare($sql);
            $executar->execute($parametros);
            $resultados = $executar->fetchAll(PDO::FETCH_CLASS);            
        } else {
            $executar = $this->ligacao->prepare($sql);
            $executar->execute();
            $resultados = $executar->fetchAll(PDO::FETCH_CLASS); 
        }
        } catch (PDOException $e) {
           return false;
        }
        $this->desligar();

        return $resultados;

    }

     //====================== INSERT ================================

     public function insert($sql, $parametros = null) {
        $sql = trim($sql);
        if (!preg_match("/^INSERT/i", $sql)) {
           throw new Exception("Base de dados não é uma instrução INSERT");
        }
        $this->ligar();

        $resultados = null;
        try {
        if (!empty($parametros)) {
            $executar = $this->ligacao->prepare($sql);
            $executar->execute($parametros);           
        } else {
            $executar = $this->ligacao->prepare($sql);
            $executar->execute();
        }
        } catch (PDOException $e) {
           return false;
        }
        $this->desligar();

    }

    //=========================== UPDATE ===========================

    public function update($sql, $parametros = null) {
        $sql = trim($sql);
        // verifica se é uma instrução Update 
        if (!preg_match("/UPDATE/i", $sql)) {
           throw new Exception("Base de dados não é uma instrução UPDATE");
        }
        $this->ligar();

        $resultados = null;
        try {
        if (!empty($parametros)) {
            $executar = $this->ligacao->prepare($sql);
            $executar->execute($parametros);           
        } else {
            $executar = $this->ligacao->prepare($sql);
            $executar->execute();
        }
        } catch (PDOException $e) {
           return false;
        }
        $this->desligar();

    }

    //========================= DELETE =============================

    public function delete($sql, $parametros = null) {
        $sql = trim($sql);
        if (!preg_match("/^DELETE/i", $sql)) {
           throw new Exception("Base de dados não é uma instrução DELETE");
        }
        $this->ligar();

        $resultados = null;
        try {
        if (!empty($parametros)) {
            $executar = $this->ligacao->prepare($sql);
            $executar->execute($parametros);           
        } else {
            $executar = $this->ligacao->prepare($sql);
            $executar->execute();
        }
        } catch (PDOException $e) {
           return false;
        }
        $this->desligar();

    }

    //========================= GENÉRICO =============================

    public function statement($sql, $parametros = null) {
        $sql = trim($sql);
        if (preg_match("/^(SELECT|DELETE|INSERT|UPDATE)/i", $sql)) {
           throw new Exception("instrução inválida");
        }
        $this->ligar();

        $resultados = null;
        try {
        if (!empty($parametros)) {
            $executar = $this->ligacao->prepare($sql);
            $executar->execute($parametros);           
        } else {
            $executar = $this->ligacao->prepare($sql);
            $executar->execute();
        }
        } catch (PDOException $e) {
           return false;
        }
        $this->desligar();

    }

}
