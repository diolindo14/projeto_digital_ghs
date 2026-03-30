<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$stmt = $db->query("SELECT * FROM matriculas");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT);
