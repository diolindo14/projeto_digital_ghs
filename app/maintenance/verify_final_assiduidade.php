<?php
require_once 'core/Database.php';
require_once 'app/models/Frequencia.php';

$frequenciaModel = new Frequencia();
$attendance = $frequenciaModel->getDetailedAttendanceForProfessor(1);

echo "Total records for Professor 1: " . count($attendance) . "\n";
foreach($attendance as $a) {
    echo "Data: {$a['data']} | Status: {$a['status']} | Fonte: {$a['marcado_por_nome']}\n";
}
