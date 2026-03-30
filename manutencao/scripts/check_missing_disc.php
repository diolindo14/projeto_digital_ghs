<?php
$db = new PDO('mysql:host=localhost;dbname=ghsespf_db', 'root', '');
$needed = ['IGE', 'FIS', 'MAT', 'QUIM', 'TI', 'APL', 'GDA', 'ING', 'PORT', 'MAT1', 'AED', 'POO', 'ALGA', 'ECC', 'HM', 'SO', 'JAVASCR', 'FBD', 'CDSI', 'RD1', 'TC', 'PHP', 'PI', 'RD2', 'IPM', 'SID', 'MCG', 'IA', 'TSI', 'ES', 'MC', 'SQLSRV', 'AO', 'JAVASTD', 'MA', 'VBNET', 'SR', 'AD LINUX', 'WT', 'IS'];

$existing = $db->query("SELECT codigo FROM disciplinas")->fetchAll(PDO::FETCH_COLUMN);
$missing = array_diff($needed, $existing);

echo "Disciplinas em falta: " . json_encode(array_values($missing)) . "\n";
