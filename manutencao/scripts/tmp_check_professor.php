<?php
require_once 'core/Database.php';

$db = Database::getInstance();
$stmt = $db->query("SHOW CREATE TABLE professores");
$res = $stmt->fetch(PDO::FETCH_ASSOC);
echo "Tabela Professores:\n";
echo $res['Create Table'];

echo "\n\nTabela Utilizadores:\n";
$stmt2 = $db->query("SHOW CREATE TABLE utilizadores");
$res2 = $stmt2->fetch(PDO::FETCH_ASSOC);
echo $res2['Create Table'];

echo "\n\nTabela Professor_Disciplina:\n";
$stmt3 = $db->query("SHOW CREATE TABLE professor_disciplina");
$res3 = $stmt3->fetch(PDO::FETCH_ASSOC);
echo $res3['Create Table'];
