<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=ghsespf_db', 'root', '');
    $stmt = $db->query("SHOW TABLES LIKE 'sumario%'");
    while($row = $stmt->fetch()) echo "Found: " . $row[0] . "\n";
    $stmt = $db->query("SHOW TABLES LIKE 'frequencia%'");
    while($row = $stmt->fetch()) echo "Found: " . $row[0] . "\n";
    $stmt = $db->query("SHOW TABLES LIKE 'chamada%'");
    while($row = $stmt->fetch()) echo "Found: " . $row[0] . "\n";
    $stmt = $db->query("SHOW TABLES LIKE 'presenca%'");
    while($row = $stmt->fetch()) echo "Found: " . $row[0] . "\n";
} catch (Exception $e) { echo $e->getMessage(); }
