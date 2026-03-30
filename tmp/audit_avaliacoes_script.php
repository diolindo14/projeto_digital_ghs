<?php
require_once 'core/Database.php';
$db = Database::getInstance();

$stmt = $db->query("
    SELECT a.*, d.nome as disciplina_nome
    FROM avaliacoes a
    JOIN disciplinas d ON a.disciplina_id = d.id
    WHERE a.turma_id = 7
");
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

file_put_contents('c:/xampp/htdocs/green/tmp/audit_avaliacoes.json', json_encode($res, JSON_PRETTY_PRINT));
echo "OK";
