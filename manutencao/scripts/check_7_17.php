<?php
require_once 'core/Database.php';
$db = Database::getInstance();

echo "Turma 7 (GHS-4T1):\n";
$stmt7 = $db->query("SELECT h.dia_semana, d.nome, h.professor_id FROM horarios h JOIN disciplinas d ON h.disciplina_id = d.id WHERE h.turma_id = 7");
foreach($stmt7->fetchAll(PDO::FETCH_ASSOC) as $r) echo "  - " . $r['dia_semana'] . " | " . $r['nome'] . " (Prof: " . $r['professor_id'] . ")\n";

echo "\nTurma 17 (GHS-3N1):\n";
$stmt17 = $db->query("SELECT h.dia_semana, d.nome, h.professor_id FROM horarios h JOIN disciplinas d ON h.disciplina_id = d.id WHERE h.turma_id = 17");
foreach($stmt17->fetchAll(PDO::FETCH_ASSOC) as $r) echo "  - " . $r['dia_semana'] . " | " . $r['nome'] . " (Prof: " . $r['professor_id'] . ")\n";
?>
