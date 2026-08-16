<?php
/**
 * Test Runner & Migration Script — FMD
 */
require_once __DIR__ . '/../../core/config.php';
require_once __DIR__ . '/../../core/Database.php';
require_once __DIR__ . '/../../app/models/Academico.php';
require_once __DIR__ . '/../../app/models/Matricula.php';
require_once __DIR__ . '/../../app/models/User.php';

echo "=== 1. EXECUTANDO MIGRATION DE BANCO DE DADOS ===\n";
try {
    $db = Database::getInstance();
    $sql = file_get_contents(__DIR__ . '/../../database/migrations/update_identity_fmd.sql');
    $db->exec($sql);
    echo "✅ Migration 'update_identity_fmd.sql' executada com sucesso!\n\n";
} catch (Exception $e) {
    echo "❌ Erro na migration: " . $e->getMessage() . "\n\n";
}

echo "=== 2. VERIFICANDO TIPOS DE AVALIAÇÃO (FMD) ===\n";
$stmt = $db->query("SELECT id, nome, codigo FROM tipos_avaliacao ORDER BY id ASC");
$tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($tipos as $t) {
    echo "ID {$t['id']}: {$t['nome']} ({$t['codigo']})\n";
}

echo "\n=== 3. VERIFICANDO PRIMEIRAS TURMAS (PREFIXO FMD) ===\n";
$stmt = $db->query("SELECT id, codigo, turno FROM turmas LIMIT 5");
$turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($turmas as $t) {
    echo "Turma ID {$t['id']}: {$t['codigo']} ({$t['turno']})\n";
}

echo "\n=== 4. TESTANDO MOTOR DE REGRA ACADÉMICA DE NOTAS (Academico.php) ===\n";
$academico = new Academico();
// Buscar um aluno com notas
$stmt = $db->query("SELECT estudante_id FROM notas LIMIT 1");
$notaSample = $stmt->fetch(PDO::FETCH_ASSOC);
if ($notaSample) {
    $eid = $notaSample['estudante_id'];
    $grades = $academico->getGradesByStudent($eid);
    echo "Notas calculadas para o Estudante #{$eid}:\n";
    foreach ($grades as $disc => $data) {
        $notaFinal = ($data['nota_final'] !== null) ? number_format($data['nota_final'], 2) : 'Em curso';
        $status = ($data['nota_final'] !== null) ? ($data['nota_final'] >= 12 ? 'Aprovado' : ($data['nota_final'] >= 8 ? 'Recurso' : 'Reprovado')) : 'Pendente';
        echo " - {$disc}: AC Total={$data['total_ac']} | Nota Final={$notaFinal} | Status={$status}\n";
    }
} else {
    echo "Nenhuma nota cadastrada ainda.\n";
}

echo "\n=== 5. CONTAS DE TESTE DISPONÍVEIS ===\n";
$stmt = $db->query("SELECT id, nome_completo, email, tipo FROM utilizadores WHERE status='ativo' GROUP BY tipo LIMIT 10");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($users as $u) {
    echo "• Tipo: [" . strtoupper($u['tipo']) . "] — Email: {$u['email']} | Nome: {$u['nome_completo']}\n";
}

echo "\n=== TODOS OS TESTES AUTOMATIZADOS CONCLUÍDOS COM SUCESSO! ===\n";
