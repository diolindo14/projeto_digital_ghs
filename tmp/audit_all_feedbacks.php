<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$res = $db->query("SELECT * FROM concordancia_notas");
file_put_contents('c:/xampp/htdocs/green/tmp/all_feedbacks.json', json_encode($res->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT));
echo "OK";
