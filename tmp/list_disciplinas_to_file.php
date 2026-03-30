<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$res = $db->query("SELECT id, nome FROM disciplinas");
file_put_contents('c:/xampp/htdocs/green/tmp/list_disciplinas.json', json_encode($res->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT));
echo "OK";
