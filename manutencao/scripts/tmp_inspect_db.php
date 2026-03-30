<?php
require_once 'core/Database.php';

$db = Database::getInstance();

$data = [];

foreach (['anos', 'turmas', 'disciplinas', 'professores', 'tipos_avaliacao'] as $table) {
    if ($table === 'professores') {
        $stmt = $db->query("SELECT p.id, u.nome_completo FROM professores p JOIN utilizadores u ON p.utilizador_id = u.id");
    } else if ($table === 'disciplinas') {
        $stmt = $db->query("SELECT id, nome, codigo FROM disciplinas");
    } else {
        $stmt = $db->query("SELECT * FROM $table");
    }
    $data[$table] = $stmt->fetchAll();
}

echo json_encode($data, JSON_PRETTY_PRINT);
