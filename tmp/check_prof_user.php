<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$res = $db->query("SELECT id, utilizador_id FROM professores WHERE id = 1");
print_r($res->fetch(PDO::FETCH_ASSOC));
