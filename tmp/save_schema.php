<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$res = $db->query("SHOW CREATE TABLE concordancia_notas");
$row = $res->fetch(PDO::FETCH_ASSOC);
file_put_contents('c:/xampp/htdocs/green/tmp/schema.txt', $row['Create Table']);
echo "OK";
