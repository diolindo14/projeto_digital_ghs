<?php
require_once 'core/Database.php';
$db = Database::getInstance();

try {
    $tables = ['utilizadores', 'professores', 'estudantes'];
    foreach ($tables as $t) {
        echo "--- TABLE: $t ---\n";
        $cols = $db->query("DESCRIBE $t")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($cols as $c) {
            echo "  [{$c['Field']}] {$c['Type']}\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
