<?php
require_once __DIR__ . '/../../core/config.php';
require_once __DIR__ . '/../../core/Database.php';

$db = Database::getInstance();
foreach(['anos','disciplinas','professores','turmas','tipos_avaliacao','tipos_pagamento'] as $t) {
    echo "=== $t ===\n";
    foreach ($db->query("DESCRIBE $t")->fetchAll(PDO::FETCH_ASSOC) as $col) {
        echo "  - " . $col['Field'] . " (" . $col['Type'] . ")\n";
    }
    echo "\n";
}
