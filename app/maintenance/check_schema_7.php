<?php
require_once 'core/Database.php';
$db = Database::getInstance();
try {
    $stmt = $db->query("DESCRIBE matriculas");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
