<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$res = $db->query("SELECT * FROM leitura_comunicados")->fetchAll(PDO::FETCH_ASSOC);
echo "TOTAL READ ENTRIES: " . count($res) . "\n";
print_r($res);
