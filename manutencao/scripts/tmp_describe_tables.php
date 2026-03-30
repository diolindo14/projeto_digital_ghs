<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$tables = ['horarios', 'estudantes', 'utilizadores', 'matriculas', 'disciplinas', 'turmas', 'anos'];
$schema = [];
foreach ($tables as $table) {
    $stmt = $db->query("DESCRIBE $table");
    $schema[$table] = $stmt->fetchAll();
}
echo json_encode($schema, JSON_PRETTY_PRINT);
