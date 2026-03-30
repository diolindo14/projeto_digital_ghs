<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$stmt = $db->query("SHOW TABLES");
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
print_r($tables);
