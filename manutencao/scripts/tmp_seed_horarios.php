<?php
require_once 'core/Database.php';

$db = Database::getInstance();
$db->query("DELETE FROM horarios");
$db->query("ALTER TABLE horarios AUTO_INCREMENT = 1");

$schedules = [
    'GHS-1M1' => [
        'tempos' => [
            1 => ['07:20', '08:50'],
            2 => ['09:10', '10:40'],
            3 => ['10:45', '12:15'],
            4 => ['12:20', '13:50']
        ],
        'dias' => [
            'Segunda' => [1 => 'IGE(Lab1)', 2 => 'QUIM(S1)', 3 => 'TI(S1)', 4 => 'PORT(S1)'],
            'Terça'   => [1 => 'FIS(S1)', 2 => 'MAT(S1)', 3 => 'TI(S1)', 4 => null],
            'Quarta'  => [1 => 'MAT(S1)', 2 => 'FIS(S1)', 3 => 'ING(S1)', 4 => 'QUIM(S1)'],
            'Quinta'  => [1 => 'IGE(Lab1)', 2 => 'APL(S1)', 3 => 'GDA(S1)', 4 => 'ING(S1)'],
            'Sexta'   => [1 => 'MAT(S1)', 2 => 'GDA(S1)', 3 => 'PORT(S1)', 4 => null]
        ]
    ],
    'GHS-1T1' => [
        'tempos' => [
            1 => ['13:00', '14:30'],
            2 => ['14:35', '16:05'],
            3 => ['16:10', '17:40'],
            4 => ['17:45', '19:15']
        ],
        'dias' => [
            'Segunda' => [1 => 'TI', 2 => 'MAT', 3 => 'GDA', 4 => 'PORT'],
            'Terça'   => [1 => 'QUIM', 2 => 'IGE', 3 => 'MAT', 4 => 'APL'],
            'Quarta'  => [1 => 'APL', 2 => 'FIS', 3 => 'IGE', 4 => 'QUIM'],
            'Quinta'  => [1 => 'PORT', 2 => 'ING', 3 => 'FIS', 4 => null],
            'Sexta'   => [1 => 'GDA', 2 => 'TI', 3 => 'ING', 4 => null]
        ]
    ],
    'GHS-2M1' => [
        'tempos' => [
            1 => ['07:20', '08:50'],
            2 => ['09:10', '10:40'],
            3 => ['10:45', '12:15'],
            4 => ['12:20', '13:50']
        ],
        'dias' => [
            'Segunda' => [1 => 'MAT', 2 => 'AED', 3 => 'POO', 4 => null],
            'Terça'   => [1 => 'PORT', 2 => 'POO', 3 => 'ALGA', 4 => 'MAT(S3)'],
            'Quarta'  => [1 => 'ECC', 2 => 'ALGA', 3 => 'ALGA', 4 => 'MAT(S2)'],
            'Quinta'  => [1 => 'ING', 2 => 'ALGA', 3 => 'ALGA', 4 => 'ING(S2)'],
            'Sexta'   => [1 => 'IGE', 2 => 'ALGA', 3 => 'POO', 4 => null]
        ]
    ],
    'GHS-3M1' => [
        'tempos' => [
            1 => ['07:20', '08:50'],
            2 => ['09:10', '10:40'],
            3 => ['10:45', '12:15'],
            4 => ['12:20', '13:50']
        ],
        'dias' => [
            'Segunda' => [1 => 'HM', 2 => 'FBD', 3 => 'TC', 4 => 'RD1'],
            'Terça'   => [1 => 'CDSI', 2 => 'JAVASCR', 3 => 'FBD', 4 => null],
            'Quarta'  => [1 => 'PHP', 2 => 'RD1', 3 => 'SO', 4 => 'HM'],
            'Quinta'  => [1 => 'SO', 2 => 'PHP', 3 => 'JAVASCR', 4 => null],
            'Sexta'   => [1 => 'TC', 2 => 'SO', 3 => 'CDSI', 4 => null]
        ]
    ],
    'GHS-4N1' => [
        'tempos' => [
            1 => ['17:45', '19:15'],
            2 => ['19:20', '20:50'],
            3 => ['20:55', '22:25'],
            4 => ['22:30', '24:00']
        ],
        'dias' => [
            'Segunda' => [1 => 'IA', 2 => 'MC', 3 => 'ES', 4 => 'MCG'],
            'Terça'   => [1 => 'PI', 2 => 'RD2', 3 => 'TSI', 4 => null],
            'Quarta'  => [1 => 'SID', 2 => 'IPM', 3 => 'MC', 4 => null],
            'Quinta'  => [1 => 'ES', 2 => 'MCG', 3 => 'RD2', 4 => null],
            'Sexta'   => [1 => 'TSI', 2 => 'IA', 3 => 'IPM', 4 => null]
        ]
    ],
    'GHS-4T1' => [
        'tempos' => [
            1 => ['13:00', '14:30'],
            2 => ['14:35', '16:05'],
            3 => ['16:10', '17:40'],
            4 => ['17:45', '19:15']
        ],
        'dias' => [
            'Segunda' => [1 => 'IA', 2 => 'MC', 3 => 'ES', 4 => 'MCG'],
            'Terça'   => [1 => 'PI', 2 => 'RD2', 3 => 'TSI', 4 => null],
            'Quarta'  => [1 => 'SID', 2 => 'IPM', 3 => 'MC', 4 => null],
            'Quinta'  => [1 => 'ES', 2 => 'MCG', 3 => 'RD2', 4 => null],
            'Sexta'   => [1 => 'TSI', 2 => 'IA', 3 => 'IPM', 4 => null]
        ]
    ],
    'GHS-5NBD1' => [
        'tempos' => [
            1 => ['17:45', '19:15'],
            2 => ['19:20', '20:50'],
            3 => ['20:55', '22:25'],
            4 => ['22:30', '24:00']
        ],
        'dias' => [
            'Segunda' => [1 => 'SQLSRV', 2 => 'AO', 3 => 'JAVASTD', 4 => 'MC'],
            'Terça'   => [1 => 'SQLSRV', 2 => 'VBNET', 3 => 'MA', 4 => null],
            'Quarta'  => [1 => 'AO', 2 => 'JAVASTD', 3 => 'MA', 4 => null],
            'Quinta'  => [1 => 'SQLSRV', 2 => 'JAVASTD', 3 => 'VBNET', 4 => null],
            'Sexta'   => [1 => 'AO', 2 => 'VBNET', 3 => 'MC', 4 => null]
        ]
    ],
    'GHS-5TRD1' => [
        'tempos' => [
            1 => ['13:00', '14:30'],
            2 => ['14:35', '16:05'],
            3 => ['16:10', '17:40'],
            4 => ['17:45', '19:15']
        ],
        'dias' => [
            'Segunda' => [1 => 'IS', 2 => 'MC', 3 => 'AD', 4 => 'SR'],
            'Terça'   => [1 => 'SR', 2 => 'AO', 3 => 'LINUX', 4 => 'WT'],
            'Quarta'  => [1 => 'WT', 2 => 'IS', 3 => 'MC', 4 => null],
            'Quinta'  => [1 => 'AD', 2 => 'SR', 3 => 'AO', 4 => null],
            'Sexta'   => [1 => 'LINUX', 2 => 'WT', 3 => 'IS', 4 => null]
        ]
    ]
];

$stmtTurmas = $db->query("SELECT id, codigo FROM turmas")->fetchAll(PDO::FETCH_KEY_PAIR);
// Flip so we can lookup id by codigo: $turmasDict['GHS-1M1'] = 1
$turmasDict = array_flip($stmtTurmas);

$stmtDisc = $db->query("SELECT id, codigo FROM disciplinas")->fetchAll(PDO::FETCH_KEY_PAIR);
$discDict = array_flip($stmtDisc);

$profReq = $db->query("SELECT id FROM professores LIMIT 1")->fetch();
$defaultProfId = $profReq ? $profReq['id'] : null;

if (!$defaultProfId) {
    // Create a dummy professor
    $db->query("INSERT INTO utilizadores (nome_completo, email, senha, tipo, status) VALUES ('Corpo Docente', 'docentes@ghs.test', '123456', 'professor', 'ativo')");
    $uid = $db->lastInsertId();
    $db->prepare("INSERT INTO professores (utilizador_id, bi, telefone, especialidade) VALUES (?, '0000', '0000', 'Geral')")->execute([$uid]);
    $defaultProfId = $db->lastInsertId();
}

$insStmt = $db->prepare("INSERT INTO horarios (turma_id, disciplina_id, dia_semana, hora_inicio, hora_fim, sala, tempo_aula, professor_id) 
                         VALUES (:tid, :did, :dia, :ini, :fim, :sala, :tempo, :pid)"); 

$count = 0;
foreach ($schedules as $turmaCode => $data) {
    if (!isset($turmasDict[$turmaCode])) {
        // Create turma if missing
        $db->prepare("INSERT INTO turmas (codigo, ano_id, turno) VALUES (?, ?, ?)")->execute([
            $turmaCode, 
            substr($turmaCode, 4, 1), 
            (strpos($turmaCode, 'M') !== false ? 'Manhã' : (strpos($turmaCode, 'T') !== false ? 'Tarde' : 'Noite'))
        ]);
        $turmasDict[$turmaCode] = $db->lastInsertId();
    }
    
    $tId = $turmasDict[$turmaCode];
    $tempos = $data['tempos'];
    
    foreach ($data['dias'] as $dia => $slots) {
        foreach ($slots as $tNum => $slotStr) {
            if (!$slotStr) continue; // null
            
            // Extract sigla and sala
            $salaVal = 'S/D';
            $sigla = $slotStr;
            
            if (preg_match('/^([A-Z0-9]+)\((.*?)\)$/', $slotStr, $matches)) {
                $sigla = $matches[1];
                $salaVal = $matches[2];
            }
            
            $mappedSigla = $sigla;
            if ($sigla == 'PORT') $mappedSigla = 'POR'; 
            if ($sigla == 'JAVASCR') $mappedSigla = 'JS';
            if ($sigla == 'SQLSRV') $mappedSigla = 'SQL Server';

            if (!isset($discDict[$mappedSigla])) {
                try {
                    $anoNum = substr($turmaCode, 4, 1);
                    $stmtAno = $db->prepare("SELECT id FROM anos WHERE numero = ?");
                    $stmtAno->execute([$anoNum]);
                    $aRow = $stmtAno->fetch();
                    $aId = $aRow ? $aRow['id'] : 1; // Fallback to id 1
                    
                    $db->prepare("INSERT INTO disciplinas (codigo, nome, ano_id, carga_horaria) VALUES (?, ?, ?, 60)")->execute([
                        $mappedSigla, $mappedSigla, $aId
                    ]);
                    $discDict[$mappedSigla] = $db->lastInsertId();
                    echo "Added missing discipline: $mappedSigla\n";
                } catch (Exception $e) {
                    echo "Erro ao inserir disciplina $mappedSigla: " . $e->getMessage() . "\n";
                    continue; // Pular se falhar
                }
            }
            
            $dId = $discDict[$mappedSigla];
            
            $insStmt->execute([
                ':tid' => $tId,
                ':did' => $dId,
                ':dia' => $dia,
                ':ini' => $tempos[$tNum][0],
                ':fim' => $tempos[$tNum][1],
                ':sala' => $salaVal,
                ':tempo' => $tNum,
                ':pid' => $defaultProfId
            ]);
            $count++;
        }
    }
}

echo "Sucesso: $count horários inseridos.\n";
