<?php
require_once 'core/Database.php';
$db = Database::getInstance();

echo "--- RECENT FEEDBACKS ---\n";
$res = $db->query("SELECT * FROM concordancia_notas ORDER BY data_resposta DESC LIMIT 5");
print_r($res->fetchAll(PDO::FETCH_ASSOC));

echo "\n--- PROFESSOR ASSIGNMENTS ---\n";
$res = $db->query("SELECT * FROM professor_disciplina");
print_r($res->fetchAll(PDO::FETCH_ASSOC));
