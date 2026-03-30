<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$res = $db->query("DESCRIBE assiduidade_professores");
file_put_contents('c:/xampp/htdocs/green/tmp/assiduidade_columns.json', json_encode($res->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT));
echo "OK";
