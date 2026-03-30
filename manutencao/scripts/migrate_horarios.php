<?php
// ============================================================
// MIGRATION: Academic Schedule System - GHS
// Run once at: http://localhost/green/migrate_horarios.php
// ============================================================
require_once 'core/Database.php';
$db = Database::getInstance();
$db->exec("SET NAMES utf8mb4");

// ---- STEP 1: Ensure horarios table has sigla columns -------
$db->exec("
    ALTER TABLE horarios 
    ADD COLUMN IF NOT EXISTS disciplina_sigla VARCHAR(20) NULL AFTER sala,
    ADD COLUMN IF NOT EXISTS disciplina_nome_cache VARCHAR(200) NULL AFTER disciplina_sigla,
    ADD COLUMN IF NOT EXISTS tempo INT NULL AFTER disciplina_nome_cache
");

// ---- STEP 2: Ensure disciplinas have 'codigo' (sigla) ------
// Get anos IDs
$anos = [];
foreach ($db->query("SELECT id, ordem FROM anos") as $row) {
    $anos[$row['ordem']] = $row['id'];
}

// Legenda: sigla => [nome, ano_order]
$disciplinaMap = [
    // 1º ANO
    'MAT'    => ['Matemática',                                         1],
    'FIS'    => ['Física',                                             1],
    'PORT'   => ['Português',                                          1],
    'TI'     => ['Tecnologias Informáticas',                           1],
    'APL'    => ['Aplicações Informáticas',                            1],
    'GDA'    => ['Geometria Descritiva A e B',                         1],
    'ING'    => ['Inglês',                                             1],
    'QUIM'   => ['Química',                                            1],
    'IGE'    => ['Informática e Gestão',                               1],
    // 2º ANO (some shared)
    'ECC'    => ['Circuitos para Comunicações',                        2],
    'AED'    => ['Algoritmos e Estruturas de Dados',                   2],
    'POO'    => ['Programação Orientada a Objectos',                   2],
    'ALGA'   => ['Álgebra Linear, Geométrica Analítica Vetorial',      2],
    // 3º ANO
    'HM'     => ['Hardware e Microprocessador',                        3],
    'CDSI'   => ['Concepção e Desenvolvimento de Sistemas Informáticos',3],
    'PHP'    => ['Programação em PHP',                                 3],
    'SO'     => ['Sistemas Operativos',                                3],
    'TC'     => ['Teoria da Computação',                               3],
    'FBD'    => ['Fundamentos de Bases de Dados',                      3],
    'JAVASCR'=> ['JavaScript',                                         3],
    'RD1'    => ['Redes Digitais — Fundamentos',                       3],
    // 4º ANO
    'IA'     => ['Inteligência Artificial',                            4],
    'PI'     => ['Processamento de Informação',                        4],
    'SID'    => ['Sistemas Distribuídos',                              4],
    'ES'     => ['Engenharia de Software',                             4],
    'TSI'    => ['Tecnologia para Sistemas Inteligentes',              4],
    'MC'     => ['Metodologia Científica',                             4],
    'RD2'    => ['Redes Digitais — Sistemas, Aplicação e Serviços',    4],
    'IPM'    => ['Interação Pessoa–Máquina',                           4],
    'MCG'    => ['Multimédia e Computação Gráfica',                    4],
    // 5º ANO
    'SQLSRV' => ['SQL Server',                                         5],
    'AO'     => ['Análise e Optimização',                              5],
    'VBNET'  => ['Visual Basic .NET',                                  5],
    'JAVASTD'=> ['Java Standard',                                      5],
    'MA'     => ['Matemática Aplicada',                                5],
    'IS'     => ['Infraestrutura e Servidores',                        5],
    'SR'     => ['Sistemas de Redes',                                  5],
    'WT'     => ['Web Technologies',                                   5],
    'AD'     => ['Administração de Redes',                             5],
    'LINUX'  => ['Sistemas Linux',                                     5],
];

// Upsert disciplines
$discIds = [];
foreach ($disciplinaMap as $sigla => [$nome, $anoOrdem]) {
    $ano_id = $anos[$anoOrdem] ?? null;
    if (!$ano_id) continue;
    $stmt = $db->prepare("SELECT id FROM disciplinas WHERE codigo = :codigo");
    $stmt->execute([':codigo' => $sigla]);
    $existing = $stmt->fetchColumn();
    if ($existing) {
        $discIds[$sigla] = $existing;
    } else {
        $ins = $db->prepare("INSERT INTO disciplinas (codigo, nome, ano_id, carga_horaria, credito) VALUES (:c, :n, :a, 90, 3)");
        $ins->execute([':c' => $sigla, ':n' => $nome, ':a' => $ano_id]);
        $discIds[$sigla] = $db->lastInsertId();
    }
}

// ---- STEP 3: Turmas ----------------------------------------
$turmasDef = [
    'GHS-1M1'  => ['ano'=>1, 'turno'=>'Manhã',  'esp'=>null],
    'GHS-1T1'  => ['ano'=>1, 'turno'=>'Tarde',  'esp'=>null],
    'GHS-2M1'  => ['ano'=>2, 'turno'=>'Manhã',  'esp'=>null],
    'GHS-3M1'  => ['ano'=>3, 'turno'=>'Manhã',  'esp'=>null],
    'GHS-4N1'  => ['ano'=>4, 'turno'=>'Noite',  'esp'=>null],
    'GHS-5NBD1'=> ['ano'=>5, 'turno'=>'Noite',  'esp'=>'Banco de Dados'],
    'GHS-5TRD1'=> ['ano'=>5, 'turno'=>'Tarde',  'esp'=>'Redes de Computadores'],
];

$turmaIds = [];
foreach ($turmasDef as $codigo => $td) {
    $stmt = $db->prepare("SELECT id FROM turmas WHERE codigo = :c");
    $stmt->execute([':c' => $codigo]);
    $existing = $stmt->fetchColumn();
    if ($existing) {
        $turmaIds[$codigo] = $existing;
    } else {
        $ins = $db->prepare("INSERT INTO turmas (codigo, ano_id, turno, especializacao, vagas) VALUES (:c, :a, :t, :e, 40)");
        $ins->execute([
            ':c' => $codigo,
            ':a' => $anos[$td['ano']],
            ':t' => $td['turno'],
            ':e' => $td['esp'],
        ]);
        $turmaIds[$codigo] = $db->lastInsertId();
    }
}

// ---- STEP 4: Schedules -------------------------------------
// Format: [turma, dia, tempo, hora_inicio, hora_fim, sigla, sala]
$schedules = [
    // GHS-1M1 – MANHÃ
    ['GHS-1M1','Segunda',1,'07:20','08:50','IGE','Lab1'],
    ['GHS-1M1','Segunda',2,'09:10','10:40','QUIM','S1'],
    ['GHS-1M1','Segunda',3,'10:45','12:15','TI','S1'],
    ['GHS-1M1','Segunda',4,'12:20','13:50','PORT','S1'],
    ['GHS-1M1','Terça',  1,'07:20','08:50','FIS','S1'],
    ['GHS-1M1','Terça',  2,'09:10','10:40','MAT','S1'],
    ['GHS-1M1','Terça',  3,'10:45','12:15','TI','S1'],
    ['GHS-1M1','Quarta', 1,'07:20','08:50','MAT','S1'],
    ['GHS-1M1','Quarta', 2,'09:10','10:40','FIS','S1'],
    ['GHS-1M1','Quarta', 3,'10:45','12:15','ING','S1'],
    ['GHS-1M1','Quarta', 4,'12:20','13:50','QUIM','S1'],
    ['GHS-1M1','Quinta', 1,'07:20','08:50','IGE','Lab1'],
    ['GHS-1M1','Quinta', 2,'09:10','10:40','APL','S1'],
    ['GHS-1M1','Quinta', 3,'10:45','12:15','GDA','S1'],
    ['GHS-1M1','Quinta', 4,'12:20','13:50','ING','S1'],
    ['GHS-1M1','Sexta',  1,'07:20','08:50','MAT','S1'],
    ['GHS-1M1','Sexta',  2,'09:10','10:40','GDA','S1'],
    ['GHS-1M1','Sexta',  3,'10:45','12:15','PORT','S1'],

    // GHS-1T1 – TARDE
    ['GHS-1T1','Segunda',1,'13:00','14:30','TI','S1'],
    ['GHS-1T1','Segunda',2,'14:35','16:05','MAT','S1'],
    ['GHS-1T1','Segunda',3,'16:10','17:40','GDA','S1'],
    ['GHS-1T1','Segunda',4,'17:45','19:15','PORT','S1'],
    ['GHS-1T1','Terça',  1,'13:00','14:30','QUIM','S1'],
    ['GHS-1T1','Terça',  2,'14:35','16:05','IGE','S1'],
    ['GHS-1T1','Terça',  3,'16:10','17:40','MAT','S1'],
    ['GHS-1T1','Terça',  4,'17:45','19:15','APL','S1'],
    ['GHS-1T1','Quarta', 1,'13:00','14:30','APL','S1'],
    ['GHS-1T1','Quarta', 2,'14:35','16:05','FIS','S1'],
    ['GHS-1T1','Quarta', 3,'16:10','17:40','IGE','S1'],
    ['GHS-1T1','Quarta', 4,'17:45','19:15','QUIM','S1'],
    ['GHS-1T1','Quinta', 1,'13:00','14:30','PORT','S1'],
    ['GHS-1T1','Quinta', 2,'14:35','16:05','ING','S1'],
    ['GHS-1T1','Quinta', 3,'16:10','17:40','FIS','S1'],
    ['GHS-1T1','Sexta',  1,'13:00','14:30','GDA','S1'],
    ['GHS-1T1','Sexta',  2,'14:35','16:05','TI','S1'],
    ['GHS-1T1','Sexta',  3,'16:10','17:40','ING','S1'],

    // GHS-2M1 – MANHÃ
    ['GHS-2M1','Segunda',1,'07:20','08:50','MAT','S1'],
    ['GHS-2M1','Segunda',2,'09:10','10:40','AED','S1'],
    ['GHS-2M1','Segunda',3,'10:45','12:15','POO','S1'],
    ['GHS-2M1','Terça',  1,'07:20','08:50','PORT','S1'],
    ['GHS-2M1','Terça',  2,'09:10','10:40','POO','S1'],
    ['GHS-2M1','Terça',  3,'10:45','12:15','ALGA','S1'],
    ['GHS-2M1','Terça',  4,'12:20','13:50','MAT','S3'],
    ['GHS-2M1','Quarta', 1,'07:20','08:50','ECC','S1'],
    ['GHS-2M1','Quarta', 2,'09:10','10:40','ALGA','S1'],
    ['GHS-2M1','Quarta', 3,'10:45','12:15','ALGA','S1'],
    ['GHS-2M1','Quarta', 4,'12:20','13:50','MAT','S2'],
    ['GHS-2M1','Quinta', 1,'07:20','08:50','ING','S1'],
    ['GHS-2M1','Quinta', 2,'09:10','10:40','ALGA','S1'],
    ['GHS-2M1','Quinta', 3,'10:45','12:15','ALGA','S1'],
    ['GHS-2M1','Quinta', 4,'12:20','13:50','ING','S2'],
    ['GHS-2M1','Sexta',  1,'07:20','08:50','IGE','S1'],
    ['GHS-2M1','Sexta',  2,'09:10','10:40','ALGA','S1'],
    ['GHS-2M1','Sexta',  3,'10:45','12:15','POO','S1'],

    // GHS-3M1 – MANHÃ
    ['GHS-3M1','Segunda',1,'07:20','08:50','HM','S1'],
    ['GHS-3M1','Segunda',2,'09:10','10:40','FBD','S1'],
    ['GHS-3M1','Segunda',3,'10:45','12:15','TC','S1'],
    ['GHS-3M1','Segunda',4,'12:20','13:50','RD1','S1'],
    ['GHS-3M1','Terça',  1,'07:20','08:50','CDSI','S1'],
    ['GHS-3M1','Terça',  2,'09:10','10:40','JAVASCR','S1'],
    ['GHS-3M1','Terça',  3,'10:45','12:15','FBD','S1'],
    ['GHS-3M1','Quarta', 1,'07:20','08:50','PHP','S1'],
    ['GHS-3M1','Quarta', 2,'09:10','10:40','RD1','S1'],
    ['GHS-3M1','Quarta', 3,'10:45','12:15','SO','S1'],
    ['GHS-3M1','Quarta', 4,'12:20','13:50','HM','S1'],
    ['GHS-3M1','Quinta', 1,'07:20','08:50','SO','S1'],
    ['GHS-3M1','Quinta', 2,'09:10','10:40','PHP','S1'],
    ['GHS-3M1','Quinta', 3,'10:45','12:15','JAVASCR','S1'],
    ['GHS-3M1','Sexta',  1,'07:20','08:50','TC','S1'],
    ['GHS-3M1','Sexta',  2,'09:10','10:40','SO','S1'],
    ['GHS-3M1','Sexta',  3,'10:45','12:15','CDSI','S1'],

    // GHS-4N1 – NOITE
    ['GHS-4N1','Segunda',1,'17:45','19:15','IA','S1'],
    ['GHS-4N1','Segunda',2,'19:20','20:50','MC','S1'],
    ['GHS-4N1','Segunda',3,'20:55','22:25','ES','S1'],
    ['GHS-4N1','Segunda',4,'22:30','23:59','MCG','S1'],
    ['GHS-4N1','Terça',  1,'17:45','19:15','PI','S1'],
    ['GHS-4N1','Terça',  2,'19:20','20:50','RD2','S1'],
    ['GHS-4N1','Terça',  3,'20:55','22:25','TSI','S1'],
    ['GHS-4N1','Quarta', 1,'17:45','19:15','SID','S1'],
    ['GHS-4N1','Quarta', 2,'19:20','20:50','IPM','S1'],
    ['GHS-4N1','Quarta', 3,'20:55','22:25','MC','S1'],
    ['GHS-4N1','Quinta', 1,'17:45','19:15','ES','S1'],
    ['GHS-4N1','Quinta', 2,'19:20','20:50','MCG','S1'],
    ['GHS-4N1','Quinta', 3,'20:55','22:25','RD2','S1'],
    ['GHS-4N1','Sexta',  1,'17:45','19:15','TSI','S1'],
    ['GHS-4N1','Sexta',  2,'19:20','20:50','IA','S1'],
    ['GHS-4N1','Sexta',  3,'20:55','22:25','IPM','S1'],

    // GHS-5NBD1 – NOITE (Banco de Dados)
    ['GHS-5NBD1','Segunda',1,'17:45','19:15','SQLSRV','Lab3'],
    ['GHS-5NBD1','Segunda',2,'19:20','20:50','AO','Lab3'],
    ['GHS-5NBD1','Segunda',3,'20:55','22:25','JAVASTD','Lab3'],
    ['GHS-5NBD1','Segunda',4,'22:30','23:59','MC','Lab3'],
    ['GHS-5NBD1','Terça',  1,'17:45','19:15','SQLSRV','Lab3'],
    ['GHS-5NBD1','Terça',  2,'19:20','20:50','VBNET','Lab3'],
    ['GHS-5NBD1','Terça',  3,'20:55','22:25','MA','Lab3'],
    ['GHS-5NBD1','Quarta', 1,'17:45','19:15','AO','Lab3'],
    ['GHS-5NBD1','Quarta', 2,'19:20','20:50','JAVASTD','Lab3'],
    ['GHS-5NBD1','Quarta', 3,'20:55','22:25','MA','Lab3'],
    ['GHS-5NBD1','Quinta', 1,'17:45','19:15','SQLSRV','Lab3'],
    ['GHS-5NBD1','Quinta', 2,'19:20','20:50','JAVASTD','Lab3'],
    ['GHS-5NBD1','Quinta', 3,'20:55','22:25','VBNET','Lab3'],
    ['GHS-5NBD1','Sexta',  1,'17:45','19:15','AO','Lab3'],
    ['GHS-5NBD1','Sexta',  2,'19:20','20:50','VBNET','Lab3'],
    ['GHS-5NBD1','Sexta',  3,'20:55','22:25','MC','Lab3'],

    // GHS-5TRD1 – TARDE (Redes)
    ['GHS-5TRD1','Segunda',1,'13:00','14:30','IS','Lab2'],
    ['GHS-5TRD1','Segunda',2,'14:35','16:05','MC','Lab2'],
    ['GHS-5TRD1','Segunda',3,'16:10','17:40','AD','Lab2'],
    ['GHS-5TRD1','Segunda',4,'17:45','19:15','SR','Lab2'],
    ['GHS-5TRD1','Terça',  1,'13:00','14:30','SR','Lab2'],
    ['GHS-5TRD1','Terça',  2,'14:35','16:05','AO','Lab2'],
    ['GHS-5TRD1','Terça',  3,'16:10','17:40','LINUX','Lab2'],
    ['GHS-5TRD1','Terça',  4,'17:45','19:15','WT','Lab2'],
    ['GHS-5TRD1','Quarta', 1,'13:00','14:30','WT','Lab2'],
    ['GHS-5TRD1','Quarta', 2,'14:35','16:05','IS','Lab2'],
    ['GHS-5TRD1','Quarta', 3,'16:10','17:40','MC','Lab2'],
    ['GHS-5TRD1','Quinta', 1,'13:00','14:30','AD','Lab2'],
    ['GHS-5TRD1','Quinta', 2,'14:35','16:05','SR','Lab2'],
    ['GHS-5TRD1','Quinta', 3,'16:10','17:40','AO','Lab2'],
    ['GHS-5TRD1','Sexta',  1,'13:00','14:30','LINUX','Lab2'],
    ['GHS-5TRD1','Sexta',  2,'14:35','16:05','WT','Lab2'],
    ['GHS-5TRD1','Sexta',  3,'16:10','17:40','IS','Lab2'],
];

// Clear existing schedule entries for these turmas
$turmaIdsCsv = implode(',', array_values($turmaIds));
if ($turmaIdsCsv) {
    $db->exec("DELETE FROM horarios WHERE turma_id IN ($turmaIdsCsv)");
}

// Insert schedules
$ins = $db->prepare("
    INSERT INTO horarios (turma_id, disciplina_id, dia_semana, hora_inicio, hora_fim, sala, disciplina_sigla, disciplina_nome_cache, tempo)
    VALUES (:tid, :did, :dia, :inicio, :fim, :sala, :sigla, :nome, :tempo)
");

$inserted = 0;
$errors = [];
foreach ($schedules as $s) {
    [$turma, $dia, $tempo, $inicio, $fim, $sigla, $sala] = $s;
    $tid = $turmaIds[$turma] ?? null;
    $did = $discIds[$sigla] ?? null;
    if (!$tid || !$did) {
        $errors[] = "Missing: turma=$turma sigla=$sigla";
        continue;
    }
    $nomeDisciplina = $disciplinaMap[$sigla][0] ?? $sigla;
    $ins->execute([
        ':tid'   => $tid,
        ':did'   => $did,
        ':dia'   => $dia,
        ':inicio'=> $inicio,
        ':fim'   => $fim,
        ':sala'  => $sala,
        ':sigla' => $sigla,
        ':nome'  => $nomeDisciplina,
        ':tempo' => $tempo,
    ]);
    $inserted++;
}

echo "<h2>✅ Migração concluída</h2>";
echo "<p>Registos inseridos: <strong>$inserted</strong></p>";
if ($errors) {
    echo "<p>Erros: <pre>" . implode("\n", $errors) . "</pre></p>";
}
echo "<p><a href='/green/'>← Voltar</a></p>";
