<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$stmt = $db->query("SELECT * FROM concordancia_notas");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($rows);
