<?php
namespace Core;

use App\Config;
use PDO;

/**
 * Base Model class
 */
abstract class Model {
    protected static function getDB(){

        static $db = null;

        if ($db === null) {
            try {
                $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8';
                $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);
                return $db;

            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
}