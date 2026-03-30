<?php
require_once 'core/Database.php';
$db = Database::getInstance();

$stmt = $db->query("
    SELECT n.*, a.disciplina_id, d.nome as disciplina_nome
    FROM notas n
    JOIN avaliacoes a ON n.avaliacao_id = a.id
    JOIN disciplinas d ON a.disciplina_id = d.id
    WHERE a.disciplina_id = 30
");
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

file_put_contents('c:/xampp/htdocs/green/tmp/audit_notas_redes.json', json_encode($res, JSON_PRETTY_PRINT));
echo "OK";
