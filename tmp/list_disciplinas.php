<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$res = $db->query("SELECT id, nome FROM disciplinas");
print_r($res->fetchAll(PDO::FETCH_ASSOC));
