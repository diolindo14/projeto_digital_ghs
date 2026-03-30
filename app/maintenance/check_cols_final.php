<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$stmt = $db->query("SHOW COLUMNS FROM concordancia_notas");
$cols = $stmt->fetchAll(PDO::FETCH_COLUMN);
echo implode(", ", $cols);
