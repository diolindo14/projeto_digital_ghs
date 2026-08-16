<?php
require_once __DIR__ . '/../../core/config.php';
require_once __DIR__ . '/../../core/Database.php';

$db = Database::getInstance();

$modules = [
    'anos' => 'Anos Curriculares',
    'disciplinas' => 'Disciplinas (Curriculo)',
    'professores' => 'Professores',
    'turmas' => 'Gestão de Turmas Formadas'
];

echo "=== VERIFICAÇÃO DE MÓDULOS E TABELAS ===\n\n";

foreach ($modules as $table => $label) {
    $count = $db->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
    echo str_pad($label, 30) . " : $count registos carregados dinamicamente\n";
}

echo "\n=========================================\n";
