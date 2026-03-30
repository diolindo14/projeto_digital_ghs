<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$result = $db->query("DESCRIBE concordancia_notas");
print_r($result->fetchAll(PDO::FETCH_ASSOC));
