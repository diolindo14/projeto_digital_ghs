<?php
/**
 * Seed Oficial da Estrutura Académica da Faculdade Moderna de Direito (FMD)
 * Popula: Anos Curriculares (1-4), Disciplinas de Direito, Professores, Turmas, Tipos de Avaliação e Pagamentos.
 */
require_once __DIR__ . '/../../core/config.php';
require_once __DIR__ . '/../../core/Database.php';

$db = Database::getInstance();

echo "======================================================\n";
echo "   FMD - POVOAMENTO DA ESTRUTURA ACADÉMICA DE DIREITO \n";
echo "======================================================\n\n";

try {
    $db->exec("SET FOREIGN_KEY_CHECKS = 0");

    // 1. ANOS CURRICULARES (1.º ao 4.º Ano — Licenciatura em Direito FMD)
    $db->exec("TRUNCATE TABLE anos");
    $stmtAno = $db->prepare("INSERT INTO anos (id, numero, nome, descricao, mensalidade, ordem) VALUES (:id, :num, :nome, :desc, :valor, :ordem)");
    $anos = [
        ['id' => 1, 'num' => 1, 'nome' => '1.º Ano', 'desc' => '1.º Ano — Licenciatura em Direito', 'valor' => 25000, 'ordem' => 1],
        ['id' => 2, 'num' => 2, 'nome' => '2.º Ano', 'desc' => '2.º Ano — Licenciatura em Direito', 'valor' => 25000, 'ordem' => 2],
        ['id' => 3, 'num' => 3, 'nome' => '3.º Ano', 'desc' => '3.º Ano — Licenciatura em Direito', 'valor' => 25000, 'ordem' => 3],
        ['id' => 4, 'num' => 4, 'nome' => '4.º Ano', 'desc' => '4.º Ano — Licenciatura em Direito', 'valor' => 25000, 'ordem' => 4],
    ];
    foreach ($anos as $a) {
        $stmtAno->execute($a);
    }
    echo "[OK] 4 Anos Curriculares FMD cadastrados.\n";

    // 2. DISCIPLINAS (Plano Curricular Oficial FMD)
    $db->exec("TRUNCATE TABLE disciplinas");
    $stmtDisc = $db->prepare("INSERT INTO disciplinas (codigo, nome, ano_id, carga_horaria, credito, descricao, ativa) VALUES (:codigo, :nome, :ano_id, :carga, :credito, :desc, 1)");
    $disciplinas = [
        // 1º Ano
        ['codigo' => 'IED', 'nome' => 'Introdução ao Estudo do Direito', 'ano_id' => 1, 'carga' => 60, 'credito' => 6.0, 'desc' => 'Conceitos fundamentais da ciência jurídica e fontes do direito.'],
        ['codigo' => 'TGC', 'nome' => 'Teoria Geral do Direito Civil', 'ano_id' => 1, 'carga' => 60, 'credito' => 6.0, 'desc' => 'Pessoas, bens e negócios jurídicos.'],
        ['codigo' => 'DCO', 'nome' => 'Direito Constitucional', 'ano_id' => 1, 'carga' => 60, 'credito' => 6.0, 'desc' => 'Organização do poder político e direitos fundamentais.'],
        ['codigo' => 'CPO', 'nome' => 'Ciência Política e Instituições', 'ano_id' => 1, 'carga' => 45, 'credito' => 4.0, 'desc' => 'Sistemas de governo e teorias do Estado.'],
        ['codigo' => 'HDC', 'nome' => 'História do Direito', 'ano_id' => 1, 'carga' => 45, 'credito' => 4.0, 'desc' => 'Evolução histórica das fontes e sistemas jurídicos.'],
        ['codigo' => 'ECO', 'nome' => 'Economia Política', 'ano_id' => 1, 'carga' => 45, 'credito' => 4.0, 'desc' => 'Princípios económicos aplicados ao direito.'],

        // 2º Ano
        ['codigo' => 'DOB', 'nome' => 'Direito das Obrigações', 'ano_id' => 2, 'carga' => 60, 'credito' => 6.0, 'desc' => 'Contratos, responsabilidade civil e cumprimento das obrigações.'],
        ['codigo' => 'DPN', 'nome' => 'Direito Penal', 'ano_id' => 2, 'carga' => 60, 'credito' => 6.0, 'desc' => 'Teoria do crime, penas e segurança jurídica.'],
        ['codigo' => 'DAD', 'nome' => 'Direito Administrativo', 'ano_id' => 2, 'carga' => 60, 'credito' => 6.0, 'desc' => 'Atos e procedimentos administrativos da administração pública.'],
        ['codigo' => 'DIP', 'nome' => 'Direito Internacional Público', 'ano_id' => 2, 'carga' => 45, 'credito' => 4.0, 'desc' => 'Tratados, soberania e organizações internacionais.'],

        // 3º Ano
        ['codigo' => 'DRE', 'nome' => 'Direitos Reais', 'ano_id' => 3, 'carga' => 60, 'credito' => 6.0, 'desc' => 'Propriedade, posse e direitos das coisas.'],
        ['codigo' => 'DCM', 'nome' => 'Direito Comercial e Sociedades', 'ano_id' => 3, 'carga' => 60, 'credito' => 6.0, 'desc' => 'Empresas, sociedades comerciais e títulos de crédito.'],
        ['codigo' => 'DPC', 'nome' => 'Direito Processual Civil', 'ano_id' => 3, 'carga' => 60, 'credito' => 6.0, 'desc' => 'Ações judiciais, petição inicial e recursos cíveis.'],
        ['codigo' => 'DPP', 'nome' => 'Direito Processual Penal', 'ano_id' => 3, 'carga' => 60, 'credito' => 6.0, 'desc' => 'Inquérito, instrução e julgamento criminal.'],
        ['codigo' => 'DTR', 'nome' => 'Direito do Trabalho', 'ano_id' => 3, 'carga' => 45, 'credito' => 4.0, 'desc' => 'Contrato de trabalho, direitos laborais e cessação.'],
        ['codigo' => 'DFS', 'nome' => 'Direito Fiscal e Tributário', 'ano_id' => 3, 'carga' => 45, 'credito' => 4.0, 'desc' => 'Impostos, taxas e contencioso tributário.'],

        // 4º Ano
        ['codigo' => 'FAM', 'nome' => 'Direito da Família e Sucessões', 'ano_id' => 4, 'carga' => 60, 'credito' => 6.0, 'desc' => 'Casamento, filiação, divórcio e herança.'],
        ['codigo' => 'PPR', 'nome' => 'Prática Processual e Simulação', 'ano_id' => 4, 'carga' => 60, 'credito' => 6.0, 'desc' => 'Simulações de julgamentos e redação de peças jurídicas.'],
        ['codigo' => 'FDI', 'nome' => 'Filosofia do Direito', 'ano_id' => 4, 'carga' => 45, 'credito' => 4.0, 'desc' => 'Justiça, ética e teorias contemporâneas do Direito.'],
        ['codigo' => 'DIR', 'nome' => 'Direito Internacional Privado', 'ano_id' => 4, 'carga' => 45, 'credito' => 4.0, 'desc' => 'Conflitos de leis no espaço e nacionalidade.'],
        ['codigo' => 'EDJ', 'nome' => 'Ética e Deontologia Jurídica', 'ano_id' => 4, 'carga' => 45, 'credito' => 4.0, 'desc' => 'Deveres profissionais de advogados e magistrados.'],
        ['codigo' => 'DFU', 'nome' => 'Direitos Fundamentais e Humanos', 'ano_id' => 4, 'carga' => 45, 'credito' => 4.0, 'desc' => 'Proteção nacional e internacional dos Direitos Humanos.'],
    ];
    foreach ($disciplinas as $d) {
        $stmtDisc->execute($d);
    }
    echo "[OK] " . count($disciplinas) . " Disciplinas FMD cadastradas.\n";

    // 3. PROFESSORES (Corpo Docente FMD)
    $db->exec("TRUNCATE TABLE professores");
    $stmtUserProf = $db->prepare("INSERT INTO utilizadores (nome_completo, email, senha, tipo, status, data_criacao) VALUES (:nome, :email, :senha, 'professor', 'ativo', NOW())");
    $stmtProf = $db->prepare("INSERT INTO professores (utilizador_id, bi, telefone, especialidade, grau_academico, data_contratacao) VALUES (:uid, :bi, :tel, :esp, :grau, NOW())");

    $professores = [
        ['nome' => 'Prof. Dr. Armando Mango', 'email' => 'armando.mango@fmd.edu', 'bi' => '000000001GB', 'tel' => '955000001', 'esp' => 'Direito Constitucional', 'grau' => 'Doutor em Direito'],
        ['nome' => 'Prof. Dra. Fatumata Djau', 'email' => 'fatumata.djau@fmd.edu', 'bi' => '000000002GB', 'tel' => '955000002', 'esp' => 'Direito Penal e Processo Penal', 'grau' => 'Mestre em Direito'],
        ['nome' => 'Prof. Dr. Suleimane Cassamá', 'email' => 'suleimane.cassama@fmd.edu', 'bi' => '000000003GB', 'tel' => '955000003', 'esp' => 'Direito Civil e Obrigações', 'grau' => 'Doutor em Direito'],
        ['nome' => 'Prof. Dra. Aissatu Baldé', 'email' => 'aissatu.balde@fmd.edu', 'bi' => '000000004GB', 'tel' => '955000004', 'esp' => 'Direito Administrativo e Fiscal', 'grau' => 'Mestre em Direito'],
        ['nome' => 'Prof. Dr. Mamadu Saliu Djaló', 'email' => 'mamadu.djalo@fmd.edu', 'bi' => '000000005GB', 'tel' => '955000005', 'esp' => 'Direito Comercial e do Trabalho', 'grau' => 'Mestre em Direito'],
    ];

    $pw = password_hash('123456', PASSWORD_BCRYPT);
    foreach ($professores as $p) {
        $stmtUserProf->execute([':nome' => $p['nome'], ':email' => $p['email'], ':senha' => $pw]);
        $uid = $db->lastInsertId();
        $stmtProf->execute([
            ':uid' => $uid,
            ':bi' => $p['bi'],
            ':tel' => $p['tel'],
            ':esp' => $p['esp'],
            ':grau' => $p['grau']
        ]);
    }
    echo "[OK] " . count($professores) . " Professores FMD cadastrados.\n";

    // 4. TURMAS FORMADAS (FMD - Licenciatura em Direito)
    $db->exec("TRUNCATE TABLE turmas");
    $stmtTurma = $db->prepare("INSERT INTO turmas (codigo, ano_id, turno, numero_turma, sala_principal, vagas, ativa) VALUES (:codigo, :ano_id, :turno, :num, :sala, :vagas, 1)");
    $turmas = [
        ['codigo' => 'FMD-1M1', 'ano_id' => 1, 'turno' => 'Manhã', 'num' => 1, 'sala' => 'S1', 'vagas' => 50],
        ['codigo' => 'FMD-1T1', 'ano_id' => 1, 'turno' => 'Tarde', 'num' => 1, 'sala' => 'S2', 'vagas' => 50],
        ['codigo' => 'FMD-1N1', 'ano_id' => 1, 'turno' => 'Noite', 'num' => 1, 'sala' => 'S3', 'vagas' => 50],

        ['codigo' => 'FMD-2M1', 'ano_id' => 2, 'turno' => 'Manhã', 'num' => 1, 'sala' => 'S4', 'vagas' => 50],
        ['codigo' => 'FMD-2N1', 'ano_id' => 2, 'turno' => 'Noite', 'num' => 1, 'sala' => 'S5', 'vagas' => 50],

        ['codigo' => 'FMD-3M1', 'ano_id' => 3, 'turno' => 'Manhã', 'num' => 1, 'sala' => 'S6', 'vagas' => 50],
        ['codigo' => 'FMD-3N1', 'ano_id' => 3, 'turno' => 'Noite', 'num' => 1, 'sala' => 'S7', 'vagas' => 50],

        ['codigo' => 'FMD-4M1', 'ano_id' => 4, 'turno' => 'Manhã', 'num' => 1, 'sala' => 'AULA MAGNA', 'vagas' => 50],
        ['codigo' => 'FMD-4N1', 'ano_id' => 4, 'turno' => 'Noite', 'num' => 1, 'sala' => 'AULA MAGNA', 'vagas' => 50],
    ];
    foreach ($turmas as $t) {
        $stmtTurma->execute($t);
    }
    echo "[OK] " . count($turmas) . " Turmas FMD cadastradas.\n";

    // 5. TIPOS DE AVALIAÇÃO FMD
    $db->exec("TRUNCATE TABLE tipos_avaliacao");
    $stmtTipoAv = $db->prepare("INSERT INTO tipos_avaliacao (id, codigo, nome, pontuacao_maxima, peso_relativo, ordem, ativo) VALUES (:id, :codigo, :nome, 20.00, :peso, :ordem, 1)");
    $tiposAv = [
        ['id' => 1, 'codigo' => 'ac1', 'nome' => 'AC1 — Teoria Geral', 'peso' => 20.00, 'ordem' => 1],
        ['id' => 2, 'codigo' => 'ac2', 'nome' => 'AC2 — Casos Práticos', 'peso' => 20.00, 'ordem' => 2],
        ['id' => 3, 'codigo' => 'ac3', 'nome' => 'AC3 — Peça Processual / Pesquisa', 'peso' => 20.00, 'ordem' => 3],
        ['id' => 4, 'codigo' => 'ac4', 'nome' => 'AC4 — Participação & Simulações', 'peso' => 20.00, 'ordem' => 4],
        ['id' => 5, 'codigo' => 'exame', 'nome' => 'Exame Final', 'peso' => 50.00, 'ordem' => 5],
    ];
    foreach ($tiposAv as $ta) {
        $stmtTipoAv->execute($ta);
    }
    echo "[OK] 5 Tipos de Avaliação FMD cadastrados.\n";

    // 6. TIPOS DE PAGAMENTO FMD
    $db->exec("TRUNCATE TABLE tipos_pagamento");
    $stmtTipoPag = $db->prepare("INSERT INTO tipos_pagamento (codigo, nome, valor, recorrente, obrigatorio, descricao) VALUES (:codigo, :nome, :val, :rec, :obrig, :desc)");
    $tiposPag = [
        ['codigo' => 'PROPINA', 'nome' => 'Propina Mensal', 'val' => 25000, 'rec' => 1, 'obrig' => 1, 'desc' => 'Mensalidade escolar FMD (25.000 FCFA)'],
        ['codigo' => 'MAT_GERAL', 'nome' => 'Matrícula — Regime Geral', 'val' => 10000, 'rec' => 0, 'obrig' => 1, 'desc' => 'Taxa de candidatura/matrícula regime geral (10.000 FCFA)'],
        ['codigo' => 'MAT_ESPECIAL', 'nome' => 'Matrícula — Regime Especial', 'val' => 20000, 'rec' => 0, 'obrig' => 0, 'desc' => 'Taxa de candidatura/matrícula regime especial (20.000 FCFA)'],
        ['codigo' => 'MAT_TRANSF', 'nome' => 'Matrícula — Transferência', 'val' => 25000, 'rec' => 0, 'obrig' => 0, 'desc' => 'Taxa de transferência (25.000 FCFA)'],
        ['codigo' => 'CERTIFICADO', 'nome' => 'Emissão de Certificado', 'val' => 5000, 'rec' => 0, 'obrig' => 0, 'desc' => 'Certificado de estudos / declaração com notas'],
        ['codigo' => 'RECURSO', 'nome' => 'Exame de Recurso', 'val' => 5000, 'rec' => 0, 'obrig' => 0, 'desc' => 'Inscrição para exame de recurso'],
    ];
    foreach ($tiposPag as $tp) {
        $stmtTipoPag->execute($tp);
    }
    echo "[OK] " . count($tiposPag) . " Tipos de Pagamento FMD cadastrados.\n";

    $db->exec("SET FOREIGN_KEY_CHECKS = 1");

    echo "\n======================================================\n";
    echo " SUCESSO: Estrutura Académica da FMD Povoada! \n";
    echo "======================================================\n";

} catch (Exception $e) {
    $db->exec("SET FOREIGN_KEY_CHECKS = 1");
    echo "\n[ERRO] " . $e->getMessage() . "\n";
}
