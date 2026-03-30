<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$stmt = $db->query("SHOW TABLES LIKE 'pagamentos'");
$exists = $stmt->rowCount() > 0;
echo $exists ? "TABLE EXISTS\n" : "TABLE NOT FOUND\n";
if ($exists) {
    $st = $db->query("SHOW COLUMNS FROM pagamentos");
    while ($r = $st->fetch(PDO::FETCH_ASSOC)) echo "COL: " . $r['Field'] . "\n";
}
