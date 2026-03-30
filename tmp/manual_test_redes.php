<?php
require_once 'core/Database.php';
require_once 'app/models/Nota.php';

$notaModel = new Nota();
$estudante_id = 4;
$turma_id = 7;
$disciplina_id = 30; // Redes Digitais
$status = 'Reclamado';
$comentario = 'TESTE: Reclamação para Redes Digitais';

$res = $notaModel->registrarFeedback($estudante_id, $turma_id, $disciplina_id, $status, $comentario);
echo "Inserção de Resposta: " . ($res ? "Sucesso" : "Falha") . "\n";

$reclamacoes = $notaModel->getFeedbacksParaProfessor(1); // Domingos Correia
echo "Reclamacoes encontradas para Prof 1: " . count($reclamacoes) . "\n";
print_r($reclamacoes);
