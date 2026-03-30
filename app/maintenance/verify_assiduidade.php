<?php
require_once 'core/Database.php';
require_once 'app/models/Frequencia.php';

$frequenciaModel = new Frequencia();
// Professor ID 1 is Domingos Correia (based on my previous check_users_profs.php)
$attendance = $frequenciaModel->getDetailedAttendanceForProfessor(1);

echo json_encode([
    'count' => count($attendance),
    'sample' => !empty($attendance) ? $attendance[0] : null
], JSON_PRETTY_PRINT);
