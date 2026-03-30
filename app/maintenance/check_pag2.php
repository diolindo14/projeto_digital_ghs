<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$st = $db->query("SHOW COLUMNS FROM pagamentos");
while ($r = $st->fetch(PDO::FETCH_ASSOC)) echo "COL: " . $r['Field'] . " | TYPE: " . $r['Type'] . "\n";
