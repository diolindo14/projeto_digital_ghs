<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$tables = ['disciplinas', 'curriculos', 'anos', 'especializacoes', 'pagamentos'];
$schema = [];
foreach ($tables as $table) {
    try {
        $stmt = $db->query("DESCRIBE $table");
        $schema[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $schema[$table] = "Table not found: " . $e->getMessage();
    }
}
echo json_encode($schema, JSON_PRETTY_PRINT);
