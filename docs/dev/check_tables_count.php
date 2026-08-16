<?php
require_once __DIR__ . '/../../core/config.php';
require_once __DIR__ . '/../../core/Database.php';

$db = Database::getInstance();
$tables = $db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

echo "=== TABELAS EXISTENTES E CONTAGEM DE REGISTOS ===\n\n";
foreach ($tables as $t) {
    $count = $db->query("SELECT COUNT(*) FROM `$t`")->fetchColumn();
    echo str_pad($t, 35) . ": $count registos\n";
}
