<?php
require_once 'core/Database.php';
$db = Database::getInstance();

$audit = [];

// Feedbacks
$stmt = $db->query("SELECT * FROM concordancia_notas ORDER BY data_resposta DESC LIMIT 10");
$audit['feedbacks'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Professor Assignments
$stmt = $db->query("
    SELECT pd.*, d.nome as disciplina_nome, t.codigo as turma_codigo, p.id as prof_id, u.nome_completo as prof_nome
    FROM professor_disciplina pd
    JOIN disciplinas d ON pd.disciplina_id = d.id
    JOIN turmas t ON pd.turma_id = t.id
    JOIN professores p ON pd.professor_id = p.id
    JOIN utilizadores u ON p.utilizador_id = u.id
");
$audit['all_assignments'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

file_put_contents('c:/xampp/htdocs/green/tmp/audit_result.json', json_encode($audit, JSON_PRETTY_PRINT));
echo "OK";
