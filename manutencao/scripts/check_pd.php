<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$stmt = $db->prepare("SELECT d.nome, t.codigo as turma FROM professor_disciplina pd JOIN disciplinas d ON pd.disciplina_id = d.id JOIN turmas t ON pd.turma_id = t.id WHERE pd.professor_id = 13");
$stmt->execute();
foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo $row['turma'] . " | " . $row['nome'] . PHP_EOL;
}
