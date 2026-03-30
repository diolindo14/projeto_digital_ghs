<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$stmt = $db->query("SELECT codigo, turno FROM turmas WHERE ativa=1");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
$stmt = $db->query("SELECT t.codigo, COUNT(m.id) as count FROM turmas t LEFT JOIN matriculas m ON t.id = m.turma_id GROUP BY t.codigo");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
