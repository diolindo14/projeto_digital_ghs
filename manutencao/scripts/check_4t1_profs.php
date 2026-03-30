<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$stmt = $db->prepare("SELECT pd.professor_id, u.nome_completo, d.nome as disciplina 
                      FROM professor_disciplina pd 
                      JOIN professores p ON pd.professor_id = p.id 
                      JOIN utilizadores u ON p.utilizador_id = u.id 
                      JOIN disciplinas d ON pd.disciplina_id = d.id 
                      WHERE pd.turma_id = 17");
$stmt->execute();
foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo "Prof ID: " . $row['professor_id'] . " | " . $row['nome_completo'] . " | Disc: " . $row['disciplina'] . PHP_EOL;
}
