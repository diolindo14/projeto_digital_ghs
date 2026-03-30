<?php
require_once 'core/Database.php';
session_start();
$_SESSION['user_id'] = 1; // Temporary for testing

$db = Database::getInstance();
try {
    echo "Checking table: assiduidade_professores\n";
    $stmt = $db->query("DESCRIBE assiduidade_professores");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    
    echo "\nChecking row count:\n";
    $stmt = $db->query("SELECT COUNT(*) FROM assiduidade_professores");
    echo "Total rows: " . $stmt->fetchColumn() . "\n";

    echo "\nSample rows:\n";
    $stmt = $db->query("SELECT * FROM assiduidade_professores LIMIT 5");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
