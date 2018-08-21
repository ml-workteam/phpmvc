<?php
/**
 * Check databese connection
 * 
 * Temporary file - should be deleted in production
 */

 $host = 'localhost';
 $db_name = 'mvc';
 $user = 'root';
 $password = '';

 /**
  * create connection
  */
try {
  $db = new PDO ("mysql:host=$host;dbname=$db_name", $user, $password);
} catch (PDOException $e) {
    echo $e->getMessage();
}

$sql = "SELECT title FROM posts WHERE id = 1";
$statement = $db->query($sql);
$row = $statement->fetchObject();
echo $row->title;