<?php
require_once 'core/Database.php';

$db = Database::getInstance();
$stmt = $db->query("SELECT h.*, t.codigo FROM horarios h JOIN turmas t ON h.turma_id = t.id");
$horarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($horarios)) {
    echo "NO SCHEDULES FOUND IN THE DATABASE.";
} else {
    foreach ($horarios as $h) {
        echo "Horario: " . $h['codigo'] . " - " . $h['dia_semana'] . " " . $h['hora_inicio'] . "\n";
    }
}
