<?php
require_once 'core/Database.php';
require_once 'app/models/Estudante.php';
$model = new Estudante();
$students = $model->getAllStudents();
echo "Total estudantes: " . count($students) . "\n";
echo "Exemplo de dados (primeiros 3):\n";
for ($i = 0; $i < min(3, count($students)); $i++) {
    echo "Nome: " . $students[$i]['nome_completo'] . " | Turma: " . ($students[$i]['turma'] ?? 'N/A') . " | Nivel: " . ($students[$i]['nivel'] ?? 'N/A') . "\n";
}
