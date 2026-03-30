<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$stmt = $db->prepare("SELECT h.dia_semana, d.nome as disciplina, h.professor_id, u.nome_completo 
                      FROM horarios h 
                      JOIN disciplinas d ON h.disciplina_id = d.id 
                      LEFT JOIN professores p ON h.professor_id = p.id 
                      LEFT JOIN utilizadores u ON p.utilizador_id = u.id 
                      WHERE h.turma_id = 17");
$stmt->execute();
foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo $row['dia_semana'] . " | " . $row['disciplina'] . " | Prof ID: " . $row['professor_id'] . " (" . ($row['nome_completo'] ?? 'N/A') . ")" . PHP_EOL;
}
