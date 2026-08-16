<?php
require_once __DIR__ . '/../../core/config.php';
require_once __DIR__ . '/../../core/Database.php';

$db = Database::getInstance();

echo "=== DESCRIBE utilizadores ===\n";
print_r($db->query("DESCRIBE utilizadores")->fetchAll(PDO::FETCH_ASSOC));

echo "\n=== DESCRIBE estudantes ===\n";
print_r($db->query("DESCRIBE estudantes")->fetchAll(PDO::FETCH_ASSOC));

echo "\n=== DESCRIBE professores ===\n";
print_r($db->query("DESCRIBE professores")->fetchAll(PDO::FETCH_ASSOC));

echo "\n=== SHOW TABLES ===\n";
print_r($db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN));

echo "\n=== SAMPLE utilizadores row ===\n";
print_r($db->query("SELECT id, nome_completo, email, tipo, status FROM utilizadores LIMIT 3")->fetchAll(PDO::FETCH_ASSOC));
