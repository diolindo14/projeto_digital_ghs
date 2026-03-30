<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$stmt = $db->query("SELECT pd.*, u.nome_completo as professor_nome, d.nome as disciplina_nome FROM professor_disciplina pd JOIN professores p ON pd.professor_id = p.id JOIN utilizadores u ON p.utilizador_id = u.id JOIN disciplinas d ON pd.disciplina_id = d.id");
echo json_encode($stmt->fetchAll(), JSON_PRETTY_PRINT);
