<?php
require_once 'core/Database.php';
$db = Database::getInstance();

function printTable($db, $table) {
    echo "--- $table ---\n";
    $stmt = $db->query("DESCRIBE $table");
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        echo sprintf("%-20s | %-15s | %-5s\n", $row['Field'], $row['Type'], $row['Null']);
    }
    echo "\n";
}

printTable($db, 'estudantes');
printTable($db, 'matriculas');
printTable($db, 'anos');
