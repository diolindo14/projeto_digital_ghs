<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$stmt = $db->query("SELECT * FROM disciplinas");
echo json_encode($stmt->fetchAll(), JSON_PRETTY_PRINT);
