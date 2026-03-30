<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$stmt = $db->query("SELECT id, numero, nome, ordem FROM anos ORDER BY ordem");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo "ID: {$row['id']} | Numero: {$row['numero']} | Nome: {$row['nome']} | Ordem: {$row['ordem']}\n";
}
