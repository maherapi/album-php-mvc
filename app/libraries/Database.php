<?php
    class Database {
        private $dbh;
        private $error;
        private $stmt;
        
        public function __construct() {
            $db = DB;
            switch($db) {
                case 'SQLITE':
                    $this->connectSqlite();
                    break;
                case 'MYSQL':
                    $this->connectMysql();
                    break;
            }
        }
        
        public function query($query) {
            $this->stmt = $this->dbh->prepare($query);
        }
        
        public function bind($param, $value, $type = null) {
            if (is_null ($type)) {
                switch (true) {
                    case is_int ($value) :
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool ($value) :
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null ($value) :
                        $type = PDO::PARAM_NULL;
                        break;
                    default :
                        $type = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param, $value, $type);
        }
        
        public function execute(){
            return $this->stmt->execute();
        }
        
        public function resultset(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }
        
        public function single(){
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        private function connectMysql() {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
            $options = $this->getConnectionOptions();
    
            try {
                $this->dbh = new PDO ($dsn, DB_USER, DB_PASS, $options);
            } catch ( PDOException $e ) {
                $this->error = $e->getMessage();
            }
        }

        private function connectSqlite() {
            $dsn = 'sqlite:' . DB_PATH;
            $options = $this->getConnectionOptions();

            try {
                $this->dbh = new PDO ($dsn, null, null, $options);
            } catch ( PDOException $e ) {
                $this->error = $e->getMessage();
            }
        }

        private function getConnectionOptions() {
            $options = array (
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
            );
            return $options;
        }
    }
    