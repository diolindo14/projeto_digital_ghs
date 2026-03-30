<?php
require_once 'core/Database.php';
require_once 'app/models/Frequencia.php';

$db = Database::getInstance();
$frequenciaModel = new Frequencia();

// Let's find a valid class/subject to link to Professor 2
$stmt = $db->query("SELECT turma_id, disciplina_id FROM horarios WHERE professor_id = 2 LIMIT 1");
$horario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($horario) {
    echo "Inserting test attendance for Prof 2...\n";
    $stmt = $db->prepare("
        INSERT INTO assiduidade_professores (professor_id, turma_id, disciplina_id, data, tempo, status, marcado_por, justificacao)
        VALUES (2, :tid, :did, CURDATE(), '07:20 - 08:50', 'Presença', 13, 'Teste de Depuração AI')
        ON DUPLICATE KEY UPDATE justificacao = 'Teste de Depuração AI Recente'
    ");
    $stmt->execute([
        ':tid' => $horario['turma_id'],
        ':did' => $horario['disciplina_id']
    ]);

    // Now check if it's visible via the model
    $attendance = $frequenciaModel->getDetailedAttendanceForProfessor(2);
    echo "Records found for Prof 2: " . count($attendance) . "\n";
    print_r($attendance);
} else {
    echo "Prof 2 has no scheduled classes in the 'horarios' table.\n";
    // Let's try to just insert with NULLs if the table allows it (unlikely but let's see)
    // Or just fetch some random turma/disc
    $stmt = $db->query("SELECT id as tid FROM turmas LIMIT 1");
    $t = $stmt->fetch();
    $stmt = $db->query("SELECT id as did FROM disciplinas LIMIT 1");
    $d = $stmt->fetch();

    $stmt = $db->prepare("
        INSERT INTO assiduidade_professores (professor_id, turma_id, disciplina_id, data, tempo, status, marcado_por, justificacao)
        VALUES (2, :tid, :did, CURDATE(), '07:20', 'Presença', 13, 'Teste de Depuração AI (Generic)')
    ");
    $stmt->execute([':tid' => $t['tid'], ':did' => $d['did']]);

    $attendance = $frequenciaModel->getDetailedAttendanceForProfessor(2);
    echo "Records found for Prof 2 (Generic): " . count($attendance) . "\n";
}
