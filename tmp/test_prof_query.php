<?php
require_once 'core/Database.php';
require_once 'app/models/Nota.php';

$notaModel = new Nota();
$prof_id = 1; // Domingos Correia - Redes Digitais
$reclamacoes = $notaModel->getFeedbacksParaProfessor($prof_id);

echo "Professor ID: $prof_id\n";
echo "Reclamacoes encontradas: " . count($reclamacoes) . "\n";
print_r($reclamacoes);

// Também checar se existem reclamações 'soltas' no banco
$db = Database::getInstance();
$res = $db->query("SELECT * FROM concordancia_notas WHERE status = 'Reclamado'");
echo "\nTodas as reclamações 'Reclamado' no banco:\n";
print_r($res->fetchAll(PDO::FETCH_ASSOC));
