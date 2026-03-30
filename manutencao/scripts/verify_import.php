<?php
require_once 'core/Database.php';
$db = Database::getInstance();

echo "CONTAGEM DE DADOS:\n";
$tables = ['utilizadores' => "tipo='aluno'", 'estudantes' => "1=1", 'matriculas' => "1=1", 'horarios' => "1=1", 'disciplinas' => "1=1"];
foreach ($tables as $table => $cond) {
    $stmt = $db->query("SELECT COUNT(*) as total FROM $table WHERE $cond");
    echo "$table: " . $stmt->fetch()['total'] . "\n";
}

echo "\nDISTRIBUIÇÃO POR TURMA:\n";
$stmt = $db->query("SELECT t.codigo, COUNT(m.id) as total_alunos FROM turmas t LEFT JOIN matriculas m ON t.id = m.turma_id GROUP BY t.codigo");
print_r($stmt->fetchAll());

echo "\nHORÁRIOS POR TURMA:\n";
$stmt = $db->query("SELECT t.codigo, COUNT(h.id) as total_horarios FROM turmas t LEFT JOIN horarios h ON t.id = h.turma_id GROUP BY t.codigo");
print_r($stmt->fetchAll());
