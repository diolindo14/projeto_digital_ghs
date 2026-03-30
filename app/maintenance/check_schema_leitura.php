<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$table = 'leitura_comunicados';
echo "DESCRIBING TABLE $table:\n";
try {
    $cols = $db->query("DESCRIBE $table")->fetchAll(PDO::FETCH_ASSOC);
    print_r($cols);
} catch (Exception $e) {
    echo "ERROR DESCRIBING: " . $e->getMessage() . "\n";
}
