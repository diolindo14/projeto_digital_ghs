<?php
require_once 'core/Database.php';

$db = Database::getInstance();
$turmas = $db->query("SELECT id, codigo, turno FROM turmas")->fetchAll(PDO::FETCH_ASSOC);
echo "Turmas:\n";
print_r($turmas);

$disciplinas = $db->query("SELECT id, codigo, nome FROM disciplinas")->fetchAll(PDO::FETCH_ASSOC);
echo "\nDisciplinas:\n";
print_r($disciplinas);
