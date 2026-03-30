<?php
/**
 * Script de Importação de Alunos e Horários - 2º Semestre 2025/2026
 * Autor: Antigravity
 */

require_once 'core/Database.php';

try {
    $db = Database::getInstance();
    $db->beginTransaction();

    echo "Iniciando limpeza de dados de alunos...\n";

    // 1. Limpar dados existentes de alunos
    // Ordem: Tabelas dependentes primeiro
    $tablesToClear = [
        'concordancia_notas',
        'frequencias',
        'notas',
        'avaliacoes', // Limpar avaliações antigas também? Sim, para evitar conflitos de ID
        'pagamentos',
        'documentos_matricula',
        'matriculas',
        'estudantes',
        'horarios' // Limpar horários antigos
    ];

    foreach ($tablesToClear as $table) {
        $db->exec("DELETE FROM $table");
        echo "Tabela $table limpa.\n";
    }

    // Deletar utilizadores que são alunos
    $db->exec("DELETE FROM utilizadores WHERE tipo = 'aluno'");
    echo "Utilizadores do tipo 'aluno' removidos.\n";

    // 2. Mapeamento de Turmas (IDs baseados na inspeção anterior)
    $turmaMap = [
        'GHS-1M1' => 10,
        'GHS-1T1' => 11,
        'GHS-1N1' => 12,
        'GHS-2M1' => 13,
        'GHS-2T1' => 14, // No banco está GHS-2T2, vou mapear para 14
        'GHS-2TI' => 14, 
        'GHS-3M1' => 16,
        'GHS-3T1' => 9,
        'GHS-4T1' => 7,
        'GHS-4N1' => 18,
        'GHS-5NBD1' => 19, // Mapeado para GHS-ESP3
        'GHS-5TRD1' => 20  // Mapeado para GHS-ESP4
    ];

    $anoMap = [
        '1º Ano' => 1,
        '2º Ano' => 2,
        '3º Ano' => 3,
        '4º Ano' => 4,
        '5º Ano' => 5
    ];

    // 3. Processar Disciplinas (Mapeamento de nomes curtos para IDs)
    // Se a disciplina não existir, será criada vinculada ao ano correspondente.
    $disciplinaMap = [];
    $stmtDisc = $db->query("SELECT id, nome, codigo FROM disciplinas");
    while ($row = $stmtDisc->fetch()) {
        $disciplinaMap[strtoupper($row['nome'])] = $row['id'];
        $disciplinaMap[strtoupper($row['codigo'])] = $row['id'];
    }

    // Função para obter ou criar disciplina
    function getOrCreateDisciplina($db, &$disciplinaMap, $shortName, $ano_id) {
        $nameMap = [
            'MAT' => 'Matemática',
            'FIS' => 'Física',
            'PORT' => 'Português',
            'ING' => 'Inglês',
            'QUIM' => 'Química',
            'TI' => 'Tecnologias Informáticas',
            'APL' => 'Aplicações Informáticas',
            'GDA' => 'Geométrica Descritivas A e B',
            'IGE' => 'Introdução à Gestão Empresarial',
            'ECC' => 'Ética e Deontologia Profissional',
            'AED' => 'Algoritmos e Estruturas de Dados',
            'POO' => 'Programação Orientada a Objectos',
            'ALGA' => 'Álgebra Linear, Geométrica Analítica Vetorial',
            'HM' => 'Hardware e Microprocessador',
            'CDSI' => 'Concepção e Desenvolvimento de Sistemas Informáticos',
            'PHP' => 'Programação em Rede - PHP',
            'SO' => 'Sistemas Operativos',
            'TC' => 'Teoria da Computação',
            'FBD' => 'Bases de Dados',
            'JAVASCR' => 'Programação em Rede - JavaScript',
            'RD1' => 'Redes Digitais — Fundamentos',
            'IA' => 'Inteligência Artificial',
            'PI' => 'Processamento de Informação',
            'SID' => 'Sistemas de Informação e Decisão',
            'ES' => 'Engenharia de Software',
            'TSI' => 'Tecnologia para Sistemas Inteligentes',
            'MC' => 'Metodologia Científica',
            'RD2' => 'Redes Digitais — Sistemas e Serviços',
            'IPM' => 'Interação Pessoa–Máquina',
            'MCG' => 'Multimédia e Computação Gráfica',
            'SQLSRV' => 'Administração de SQL Server',
            'AO' => 'Arquitetura de Operações',
            'VBNET' => 'Programação em VB.NET',
            'JAVASTD' => 'Programação Java Standard',
            'MA' => 'Manutenção Avançada',
            'IS' => 'Infraestrutura de Servidores',
            'SR' => 'Segurança de Redes',
            'WT' => 'Web Technologies',
            'AD' => 'Active Directory',
            'LINUX' => 'Administração Linux'
        ];

        $fullName = isset($nameMap[strtoupper($shortName)]) ? $nameMap[strtoupper($shortName)] : $shortName;
        $key = strtoupper($fullName);

        if (isset($disciplinaMap[$key])) {
            return $disciplinaMap[$key];
        }

        // Criar disciplina se não existir
        $stmt = $db->prepare("INSERT INTO disciplinas (codigo, nome, ano_id, ativa) VALUES (:cod, :nome, :ano, 1)");
        $stmt->execute([':cod' => strtoupper($shortName), ':nome' => $fullName, ':ano' => $ano_id]);
        $id = $db->lastInsertId();
        $disciplinaMap[$key] = $id;
        return $id;
    }

    // 4. Importar Alunos
    $studentData = [
        '1º Ano - Manhã (GHS-1M1 / IMI)' => [
            'Adalgiza da Costa', 'Adul Carimo Baldé', 'Aminata Djamila Injai', 'António Alberto Lopes', 'Artimiza Augusto Tcham',
            'Benoni Domingos Pereira', 'Binto Camará', 'Bissiqué Joaquim', 'Brolim António Damas', 'Burama Gil Pombo',
            'Carlita Mangar', 'Davicson Lona Mbana', 'Desejado Correia Forbs', 'Eleutério Emilio Dias Monteiro', 'Elson Correia',
            'Emanuel Duarte Djata', 'Eugénio João Pereira', 'Eusébio Tcherno Mamudo Baldé', 'Fina Pereira', 'Isaias Paulino Incundé',
            'Jacinto Siverino Mancanha', 'João Saliu Monteiro', 'Lucas Paulo Ialá', 'Luinela Edvises Papa Cá', 'Moises Sá',
            'Naziana Nisco de Carvalho', 'Nucia Tobana Vasna', 'Raisa Ucalute Gomes', 'Rudilson Daivaneo Semedo Cá', 'Sabado Carlos Ntumbo',
            'Saico Umaro Só', 'São João Fernando Carissali', 'Silvano Augusto', 'Tcherno Mamadú Camará', 'Timotio Sete', 'Vanilson Gomes da Costa'
        ],
        '1º Ano - Tarde (GHS-1T1)' => [
            'Adelio Cá', 'Aderito António Marcos', 'Amade Embaló', 'Amadu Djulde Djaló', 'Amadú E. Da Silva Nbotche', 'Amonique Cá',
            'Bedamone Sandussa Nandiba', 'Benvinda Indiba', 'Binta Cassamá', 'Dabana Lóa Na Tcharré', 'Danilson Roel da Silva',
            'Desejado Ilidio Dias', 'Edimilson Augusto Malel', 'Emanuela Nino Sambú', 'Emerson Dias Baldé', 'Eugénio Marcelo Semedo',
            'Fodé Amara Sissé', 'Iasene Purna Ntchala', 'Ibraima Baldé', 'Jacira Correia', 'Juliana Gomes da Silva', 'Junior Augusto Landim',
            'Leovanio Silvano Mendes', 'Mindo Aduquir Júnior da Silva', 'Mohamadu Baldé', 'Neia Ntchama', 'Nicaela Alfredo Correia',
            'Pedro Seidi', 'Ronaldinho Edmilson Gomes Pereira', 'Salimatu Candé', 'Silvio Luis Caetano', 'Ussumane Sané',
            'Valdimira Cabral Gomes', 'Vasco Alexandre Na Cul'
        ],
        '4º Ano - Tarde (GHS-4T1)' => [
            'Amadú Julde Djaló', 'Dingana Nimina Embana', 'Diosives Pedro Nunes Crobute', 'Djibril Tchamo', 'Elizabete Vaz Moreno',
            'Erikson Wogna Fanda', 'Fernando Augusto Malú', 'Francisco N. Na Nhassé', 'Idjatu Dabó', 'Ivan Sajo Samananco',
            'Luizela Sanhá Pereira Tecanhe', 'Odilia Luis Pereira'
        ],
        '1º Ano - Noite (GHS-1N1)' => [
            'Manjupe Lais da Costa', 'Alfredo Tchuda', 'Arafam Cand', 'Calido Djau', 'Elizio João Pereira', 'Emanuel Biussum Iurna',
            'Sabino Carvalho', 'Serginho Pedro Gomes Vilela'
        ],
        '2º Ano - Manhã (GHS-2M1)' => [
            'Aliu Águas', 'Armando Ié', 'Bidam-Mone Na Camine', 'Celestina Gomes', 'Cesaltina Joaquim Bailambi', 'Daimara Correia Mendes',
            'Endem Camará', 'Fredinilton Pereira Bassali', 'Isis Djibril Camará', 'Jacir Abubacar Moreno Turé', 'Jovane Daniel Cutende',
            'Juelson Mendes', 'Juscelino Lopes', 'Leorooney Mendes Sá Correia', 'Marcos Bissunha Ntchama', 'Marcos M. Nampunque',
            'Mariama Tumane Quadé', 'Ncaram Bunha Cumba', 'Nelson Duarte da Silva', 'Nghale Wid Cumba', 'Tuncam Embaló', 'Zaira Alanam Nichudê'
        ],
        '2º Ano - Tarde (GHS-2T1 / 2TI)' => [
            'Andre Djata', 'António Tidjane Camará', 'Carlos Alberto Correia', 'Djabu Joãozinho da Costa', 'Eliana Correia Mendes',
            'Iaia Seidi', 'Ijaquiel Armando Sanca', 'José Silva Nhaga', 'Luisella Mané Lopes dos Santos', 'Mamadu Baldé',
            'Sat-na Faie Siga', 'Sinaider F. da Silva', 'Suaila Djata', 'Zafenate Quintino Mondi'
        ],
        '3º Ano - Manhã (GHS-3M1 / 3M1)' => [
            'Carlos Isnaba Bidonga', 'Dias Domingos Ialá', 'Dutim Rodrigues', 'Elizabete Marena', 'Elizio da Silva',
            'Hatissary Thayssa Sá Nogueira', 'Junaid Ibn Abulai Conté', 'Massirem da Costa Djaló', 'Samba Baldé',
            'Serifo Amadú Fadil Seidi', 'Tidjane Indjai', 'Tcherno Camará'
        ],
        '3º Ano - Tarde (GHS-3T1 / 3T1)' => [
            'Buba Martinho Na Forna', 'Claus Roxin Jorge da Costa', 'Fatumata Seidi', 'Gershon Quadé Ié', 'Jaqueline M. M. Lopes Nonaque',
            'Naida Na Biatchiba', 'Tussem Mendes', 'Ussumane Ponqué'
        ],
        '5º Ano - Redes Tarde (GHS-5TRD1)' => [
            'Adulai Camará', 'Aléssio José Rebelo Barbosa', 'Alqueia Nanque', 'Cabomarim Filipe Catame', 'Domingos Fafé',
            'Ela Candé', 'Francisco Andre da Silva', 'Isnaba Conha Inta-a', 'Issa Djau', 'Madjer Moaquim Malam Sanhá Baió',
            'Mafudje Bá Jau', 'Miriam Nhaga', 'Roberto Kabi Naguadé', 'Uleimato Jaló', 'Valeri Cardose'
        ],
        '5º Ano - Banco de Dados Noite (GHS-5NBD1)' => [
            'Artimiza Iano Sá', 'Badora Agostinho Djata', 'Bubacar Baldé', 'Felklin Pedro da Silva Júnior', 'Ieró Baldé',
            'Ivana Ivanovica de Oliveira Quelute', 'Leonardo António Kassama', 'Nadia Lopes Nank Ié', 'Pier Tanhá', 'Quintino Nunes'
        ]
    ];

    echo "Importando alunos...\n";
    foreach ($studentData as $header => $names) {
        // Extrair código da turma e ano
        preg_match('/(GHS-\w+)/', $header, $matches);
        $turmaCode = $matches[1];
        $turmaID = $turmaMap[$turmaCode] ?? null;

        preg_match('/(\d+)º Ano/', $header, $matches);
        $anoNum = $matches[1];
        $anoID = $anoNum; // Baseado no id = numero que vimos na inspeção

        if (!$turmaID) {
            echo "Aviso: Turma $turmaCode não encontrada.\n";
            continue;
        }

        foreach ($names as $name) {
            $email = strtolower(str_replace(' ', '.', $name)) . "@ghsesp.gw";
            $stmtUser = $db->prepare("INSERT INTO utilizadores (nome_completo, email, senha, tipo, status) VALUES (:nome, :email, :senha, 'aluno', 'ativo')");
            $stmtUser->execute([
                ':nome' => $name,
                ':email' => $email,
                ':senha' => password_hash('GHS@2025', PASSWORD_DEFAULT)
            ]);
            $userID = $db->lastInsertId();

            $stmtEst = $db->prepare("INSERT INTO estudantes (utilizador_id, bi, data_nascimento, sexo) VALUES (:uid, :bi, :nasc, 'Masculino')");
            $stmtEst->execute([
                ':uid' => $userID,
                ':bi' => 'BI' . str_pad($userID, 5, '0', STR_PAD_LEFT),
                ':nasc' => '2000-01-01'
            ]);
            $estID = $db->lastInsertId();

            $stmtMat = $db->prepare("INSERT INTO matriculas (estudante_id, ano_letivo, ano_curso_id, turma_id, turno, tipo, status, data_matricula) VALUES (:eid, 2026, :aid, :tid, :turno, 'Estudante Interno', 'Aprovada', NOW())");
            
            // Obter turno da turma
            $stmtT = $db->prepare("SELECT turno FROM turmas WHERE id = :tid");
            $stmtT->execute([':tid' => $turmaID]);
            $turno = $stmtT->fetch()['turno'];

            $stmtMat->execute([
                ':eid' => $estID,
                ':aid' => $anoID,
                ':tid' => $turmaID,
                ':turno' => $turno
            ]);
        }
    }
    echo "Alunos importados com sucesso.\n";

    // 5. Importar Horários
    echo "Importando horários...\n";

    $schedules = [
        'GHS-1M1' => [
            ['Segunda', '07:20:00', '08:50:00', 'IGE', 'Lab1'],
            ['Segunda', '09:10:00', '10:40:00', 'QUIM', 'S1'],
            ['Segunda', '10:45:00', '12:15:00', 'TI', 'S1'],
            ['Segunda', '12:20:00', '13:50:00', 'PORT', 'S1'],
            ['Terça',   '07:20:00', '08:50:00', 'FIS', 'S1'],
            ['Terça',   '09:10:00', '10:40:00', 'MAT', 'S1'],
            ['Terça',   '10:45:00', '12:15:00', 'TI', 'S1'],
            ['Quarta',  '07:20:00', '08:50:00', 'MAT', 'S1'],
            ['Quarta',  '09:10:00', '10:40:00', 'FIS', 'S1'],
            ['Quarta',  '10:45:00', '12:15:00', 'ING', 'S1'],
            ['Quinta',  '07:20:00', '08:50:00', 'IGE', 'Lab1'],
            ['Quinta',  '09:10:00', '10:40:00', 'APL', 'S1'],
            ['Quinta',  '10:45:00', '12:15:00', 'GDA', 'S1'],
            ['Quinta',  '12:20:00', '13:50:00', 'QUIM', 'S1'],
            ['Sexta',   '07:20:00', '08:50:00', 'MAT', 'S1'],
            ['Sexta',   '09:10:00', '10:40:00', 'GDA', 'S1'],
            ['Sexta',   '10:45:00', '12:15:00', 'PORT', 'S1'],
            ['Sexta',   '12:20:00', '13:50:00', 'ING', 'S1']
        ],
        'GHS-1T1' => [
            ['Segunda', '13:00:00', '14:30:00', 'TI', '1'],
            ['Segunda', '14:35:00', '16:05:00', 'MAT', '1'],
            ['Segunda', '16:10:00', '17:40:00', 'GDA', '1'],
            ['Segunda', '17:45:00', '19:15:00', 'PORT', '1'],
            ['Terça',   '13:00:00', '14:30:00', 'QUIM', '1'],
            ['Terça',   '14:35:00', '16:05:00', 'IGE', '1'],
            ['Terça',   '16:10:00', '17:40:00', 'MAT', '1'],
            ['Terça',   '17:45:00', '19:15:00', 'APL', '1'],
            ['Quarta',  '13:00:00', '14:30:00', 'APL', '1'],
            ['Quarta',  '14:35:00', '16:05:00', 'FIS', '1'],
            ['Quarta',  '16:10:00', '17:40:00', 'IGE', '1'],
            ['Quarta',  '17:45:00', '19:15:00', 'QUIM', '1'],
            ['Quinta',  '13:00:00', '14:30:00', 'PORT', '1'],
            ['Quinta',  '14:35:00', '16:05:00', 'ING', '1'],
            ['Quinta',  '16:10:00', '17:40:00', 'FIS', '1'],
            ['Sexta',   '13:00:00', '14:30:00', 'GDA', '1'],
            ['Sexta',   '14:35:00', '16:05:00', 'TI', '1'],
            ['Sexta',   '16:10:00', '17:40:00', 'ING', '1']
        ],
        'GHS-2M1' => [
            ['Segunda', '07:20:00', '08:50:00', 'MAT', '2'],
            ['Segunda', '09:10:00', '10:40:00', 'AED', '2'],
            ['Segunda', '10:45:00', '12:15:00', 'POO', '2'],
            ['Terça',   '07:20:00', '08:50:00', 'PORT', '2'],
            ['Terça',   '09:10:00', '10:40:00', 'POO', '2'],
            ['Terça',   '10:45:00', '12:15:00', 'ALGA', '2'],
            ['Terça',   '12:20:00', '13:50:00', 'MAT', 'S3'],
            ['Quarta',  '07:20:00', '08:50:00', 'ECC', '2'],
            ['Quarta',  '09:10:00', '10:40:00', 'ALGA', '2'],
            ['Quarta',  '10:45:00', '12:15:00', 'ALGA', '2'],
            ['Quarta',  '12:20:00', '13:50:00', 'MAT', 'S2'],
            ['Quinta',  '07:20:00', '08:50:00', 'ING', '2'],
            ['Quinta',  '09:10:00', '10:40:00', 'ALGA', '2'],
            ['Quinta',  '10:45:00', '12:15:00', 'ALGA', '2'],
            ['Quinta',  '12:20:00', '13:50:00', 'ING', 'S2'],
            ['Sexta',   '07:20:00', '08:50:00', 'IGE', '2'],
            ['Sexta',   '09:10:00', '10:40:00', 'ALGA', '2'],
            ['Sexta',   '10:45:00', '12:15:00', 'POO', '2']
        ],
        'GHS-3M1' => [
            ['Segunda', '07:20:00', '08:50:00', 'HM', 'Sala 03'],
            ['Segunda', '09:10:00', '10:40:00', 'FBD', 'Sala 03'],
            ['Segunda', '10:45:00', '12:15:00', 'TC', 'Sala 03'],
            ['Segunda', '12:20:00', '13:50:00', 'RD1', 'Sala 03'],
            ['Terça',   '07:20:00', '08:50:00', 'CDSI', 'Sala 03'],
            ['Terça',   '09:10:00', '10:40:00', 'JAVASCR', 'Sala 03'],
            ['Terça',   '10:45:00', '12:15:00', 'FBD', 'Sala 03'],
            ['Quarta',  '07:20:00', '08:50:00', 'PHP', 'Sala 03'],
            ['Quarta',  '09:10:00', '10:40:00', 'RD1', 'Sala 03'],
            ['Quarta',  '10:45:00', '12:15:00', 'SO', 'Sala 03'],
            ['Quinta',  '07:20:00', '08:50:00', 'SO', 'Sala 03'],
            ['Quinta',  '09:10:00', '10:40:00', 'PHP', 'Sala 03'],
            ['Quinta',  '10:45:00', '12:15:00', 'JAVASCR', 'Sala 03'],
            ['Quinta',  '12:20:00', '13:50:00', 'HM', 'Sala 03'],
            ['Sexta',   '07:20:00', '08:50:00', 'TC', 'Sala 03'],
            ['Sexta',   '09:10:00', '10:40:00', 'SO', 'Sala 03'],
            ['Sexta',   '10:45:00', '12:15:00', 'CDSI', 'Sala 03']
        ],
        'GHS-4N1' => [
            ['Segunda', '17:45:00', '19:15:00', 'IA', 'Sala 04'],
            ['Segunda', '19:20:00', '20:50:00', 'MC', 'Sala 04'],
            ['Segunda', '20:55:00', '22:25:00', 'ES', 'Sala 04'],
            ['Segunda', '22:30:00', '24:00:00', 'MCG', 'Sala 04'],
            ['Terça',   '17:45:00', '19:15:00', 'PI', 'Sala 04'],
            ['Terça',   '19:20:00', '20:50:00', 'RD2', 'Sala 04'],
            ['Terça',   '20:55:00', '22:25:00', 'TSI', 'Sala 04'],
            ['Quarta',  '17:45:00', '19:15:00', 'SID', 'Sala 04'],
            ['Quarta',  '19:20:00', '20:50:00', 'IPM', 'Sala 04'],
            ['Quarta',  '20:55:00', '22:25:00', 'MC', 'Sala 04'],
            ['Quinta',  '17:45:00', '19:15:00', 'ES', 'Sala 04'],
            ['Quinta',  '19:20:00', '20:50:00', 'MCG', 'Sala 04'],
            ['Quinta',  '20:55:00', '22:25:00', 'RD2', 'Sala 04'],
            ['Sexta',   '17:45:00', '19:15:00', 'TSI', 'Sala 04'],
            ['Sexta',   '19:20:00', '20:50:00', 'IA', 'Sala 04'],
            ['Sexta',   '20:55:00', '22:25:00', 'IPM', 'Sala 04']
        ],
        'GHS-5NBD1' => [
            ['Segunda', '17:45:00', '19:15:00', 'SQLSRV', 'Sala 05'],
            ['Segunda', '19:20:00', '20:50:00', 'AO', 'Sala 05'],
            ['Segunda', '20:55:00', '22:25:00', 'JAVASTD', 'Sala 05'],
            ['Segunda', '22:30:00', '24:00:00', 'MC', 'Sala 05'],
            ['Terça',   '17:45:00', '19:15:00', 'SQLSRV', 'Sala 05'],
            ['Terça',   '19:20:00', '20:50:00', 'VBNET', 'Sala 05'],
            ['Terça',   '20:55:00', '22:25:00', 'MA', 'Sala 05'],
            ['Quarta',  '17:45:00', '19:15:00', 'AO', 'Sala 05'],
            ['Quarta',  '19:20:00', '20:50:00', 'JAVASTD', 'Sala 05'],
            ['Quarta',  '20:55:00', '22:25:00', 'MA', 'Sala 05'],
            ['Quinta',  '17:45:00', '19:15:00', 'SQLSRV', 'Sala 05'],
            ['Quinta',  '19:20:00', '20:50:00', 'JAVASTD', 'Sala 05'],
            ['Quinta',  '20:55:00', '22:25:00', 'VBNET', 'Sala 05'],
            ['Sexta',   '17:45:00', '19:15:00', 'AO', 'Sala 05'],
            ['Sexta',   '19:20:00', '20:50:00', 'VBNET', 'Sala 05'],
            ['Sexta',   '20:55:00', '22:25:00', 'MC', 'Sala 05']
        ],
        'GHS-5TRD1' => [
            ['Segunda', '13:00:00', '14:30:00', 'IS', 'Sala 05'],
            ['Segunda', '14:35:00', '16:05:00', 'MC', 'Sala 05'],
            ['Segunda', '16:10:00', '17:40:00', 'AD', 'Sala 05'],
            ['Segunda', '17:45:00', '19:15:00', 'SR', 'Sala 05'],
            ['Terça',   '13:00:00', '14:30:00', 'SR', 'Sala 05'],
            ['Terça',   '14:35:00', '16:05:00', 'AO', 'Sala 05'],
            ['Terça',   '16:10:00', '17:40:00', 'LINUX', 'Sala 05'],
            ['Terça',   '17:45:00', '19:15:00', 'WT', 'Sala 05'],
            ['Quarta',  '13:00:00', '14:30:00', 'WT', 'Sala 05'],
            ['Quarta',  '14:35:00', '16:05:00', 'IS', 'Sala 05'],
            ['Quarta',  '16:10:00', '17:40:00', 'MC', 'Sala 05'],
            ['Quinta',  '13:00:00', '14:30:00', 'AD', 'Sala 05'],
            ['Quinta',  '14:35:00', '16:05:00', 'SR', 'Sala 05'],
            ['Quinta',  '16:10:00', '17:40:00', 'AO', 'Sala 05'],
            ['Sexta',   '13:00:00', '14:30:00', 'LINUX', 'Sala 05'],
            ['Sexta',   '14:35:00', '16:05:00', 'WT', 'Sala 05'],
            ['Sexta',   '16:10:00', '17:40:00', 'IS', 'Sala 05']
        ]
    ];

    // Obter um professor padrão (ID 1 - Domingos Correia) para usar se não houver mapeamento
    $defaultProfessorID = 1;

    foreach ($schedules as $turmaCode => $slots) {
        $turmaID = $turmaMap[$turmaCode] ?? null;
        if (!$turmaID) continue;

        // Obter ano_id da turma
        $stmtT = $db->prepare("SELECT ano_id FROM turmas WHERE id = :tid");
        $stmtT->execute([':tid' => $turmaID]);
        $anoID = $stmtT->fetch()['ano_id'];

        foreach ($slots as $slot) {
            $dia = $slot[0];
            $inicio = $slot[1];
            $fim = $slot[2];
            $discShort = $slot[3];
            $sala = $slot[4];

            $discID = getOrCreateDisciplina($db, $disciplinaMap, $discShort, $anoID);

            // Tentar encontrar professor mapeado para esta disciplina e turma
            $stmtP = $db->prepare("SELECT professor_id FROM professor_disciplina WHERE disciplina_id = :did AND turma_id = :tid LIMIT 1");
            $stmtP->execute([':did' => $discID, ':tid' => $turmaID]);
            $profRow = $stmtP->fetch();
            $profID = $profRow ? $profRow['professor_id'] : $defaultProfessorID;

            $stmtIns = $db->prepare("INSERT INTO horarios (turma_id, disciplina_id, professor_id, dia_semana, hora_inicio, hora_fim, sala) VALUES (:tid, :did, :pid, :dia, :ini, :fim, :sala)");
            $stmtIns->execute([
                ':tid' => $turmaID,
                ':did' => $discID,
                ':pid' => $profID,
                ':dia' => $dia,
                ':ini' => $inicio,
                ':fim' => $fim,
                ':sala' => $sala
            ]);
        }
    }
    echo "Horários importados com sucesso.\n";

    $db->commit();
    echo "Importação concluída com sucesso!\n";

} catch (Exception $e) {
    if (isset($db)) $db->rollBack();
    echo "Erro durante a importação: " . $e->getMessage() . "\n";
    exit(1);
}
