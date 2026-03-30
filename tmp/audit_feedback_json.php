<?php
require_once 'core/Database.php';
$db = Database::getInstance();

$audit = [];

// Feedbacks
$stmt = $db->query("SELECT * FROM concordancia_notas ORDER BY data_resposta DESC LIMIT 5");
$audit['feedbacks'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Professor Assignments for "Redes Digitais"
$stmt = $db->query("
    SELECT pd.*, d.nome as disciplina_nome, t.codigo as turma_codigo, p.id as prof_id, u.nome_completo as prof_nome
    FROM professor_disciplina pd
    JOIN disciplinas d ON pd.disciplina_id = d.id
    JOIN turmas t ON pd.turma_id = t.id
    JOIN professores p ON pd.professor_id = p.id
    JOIN utilizadores u ON p.utilizador_id = u.id
    WHERE d.nome LIKE '%Redes%'
");
$audit['redes_assignments'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($audit, JSON_PRETTY_PRINT);
