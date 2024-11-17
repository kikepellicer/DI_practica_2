<?php

class BDSingleton{

    private static $instance = NULL;

    private function __construct() { }

    private function __clone() { }

    public static function getInstance(){
        //include "../inc/conf.inc.php";
        $user = "root";
        $pass = "";
        $host = "localhost";
        $port = "3306";
        $dbname = "Hospital";
        if (is_null(self::$instance)) {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8;port=$port", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            self::$instance = $pdo;
        }
        return self::$instance;
    }
}

