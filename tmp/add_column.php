<?php
require_once 'core/Database.php';
$db = Database::getInstance();
try {
    $db->query("ALTER TABLE assiduidade_professores ADD COLUMN justificacao TEXT NULL AFTER status");
    echo "Coluna justificacao adicionada com sucesso.";
} catch (Exception $e) {
    echo "Erro ou coluna já existe: " . $e->getMessage();
}
