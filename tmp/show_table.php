<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$res = $db->query("SHOW CREATE TABLE concordancia_notas");
print_r($res->fetch(PDO::FETCH_ASSOC));
