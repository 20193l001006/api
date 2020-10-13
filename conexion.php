<?php
        class conexion {
            private $Host = "";
            private $User = "";
            private $Password = "";
            private $DataBase = "";
            private $Connection = "";

            public function __construct() {
                $this-> Host = "us-cdbr-east-02.cleardb.com";
                $this-> User = "b6e1bcca8f1eb8";
                $this-> Password = "8f985145";
                $this-> DataBase = "heroku_9f2d938342f3d47";
            }

            public function OpenConnection() {
                try{
                    $this-> Connection = new PDO("mysql:host={$this->Host}; dbname={$this->DataBase}", $this->User, $this->Password);
                    $this-> Connection-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e){
                    $this-> Connection = false;
                }
            }

            public function ClosConnection() {
                mysql_close($this-> Connection);
            }

            public function GetConnection() {
                return $this-> Connection;
            }
        }

        $Obj = new Conexion();
        $Obj-> OpenConnection();
?>