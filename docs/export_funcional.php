<?php
// Manual do Utilizador v1.0 — Faculdade Moderna de Direito (FMD)
?>
<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <title>FMD — Manual do Utilizador v1.0</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0b1120;
            --accent: #1e3a8a;
            --accent-green: #059669;
            --light: #f9fafb;
            --border: #e2e8f0;
            --text: #374151;
            --muted: #6b7280;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; color: var(--text); background: #fff; padding: 40px 60px; line-height: 1.6; font-size: 13px; }

        .cover { display: flex; align-items: flex-start; justify-content: space-between; border-bottom: 2px solid var(--border); padding-bottom: 25px; margin-bottom: 35px; }
        .cover-left h1 { font-size: 26px; font-weight: 700; color: var(--primary); margin: 6px 0; }
        .cover-left p { color: var(--muted); font-size: 13px; }
        .cover-right { text-align: right; font-size: 12px; color: var(--muted); }
        .cover-right .version { display: inline-block; background: var(--light); border: 1px solid var(--border); color: var(--primary); padding: 3px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; margin-bottom: 6px; }

        h2 { font-size: 16px; font-weight: 700; color: var(--primary); margin: 30px 0 12px; padding-bottom: 6px; border-bottom: 2px solid var(--accent); }
        h3 { font-size: 14px; font-weight: 600; color: var(--accent); margin: 20px 0 10px; }
        p { margin-bottom: 10px; text-align: justify; }
        ul, ol { padding-left: 20px; margin-bottom: 12px; }
        li { margin-bottom: 5px; }

        table { width: 100%; border-collapse: collapse; margin: 15px 0 25px; font-size: 12px; border: 1px solid var(--border); }
        thead th { background: var(--light); color: var(--primary); padding: 10px 12px; text-align: left; font-weight: 600; border-bottom: 1px solid var(--border); }
        tbody td { border-bottom: 1px solid var(--border); padding: 8px 12px; vertical-align: top; }

        .step-card { background: var(--light); border: 1px solid var(--border); border-radius: 6px; padding: 15px; margin-bottom: 15px; }
        .step-card strong { color: var(--primary); }

        .footer { margin-top: 40px; padding-top: 15px; font-size: 11px; color: var(--muted); display: flex; justify-content: space-between; border-top: 1px solid var(--border); }

        @media print {
            @page { margin: 0.5cm; }
            body { padding: 30px 40px; }
        }
    </style>
</head>

<body>

    <div class="cover">
        <div class="cover-left">
            <img src="../img/faculdade.png" alt="Faculdade Moderna de Direito" style="height: 60px; border-radius: 6px; margin-bottom: 20px;">
            <h1>Manual do Utilizador — Plataforma FMD</h1>
            <p>Guia Prático Operacional para Estudantes, Docentes, Secretaria e Administração</p>
        </div>
        <div class="cover-right">
            <div class="version">v1.0 FMD</div><br>
            <strong>Data:</strong> Agosto 2026<br>
            <strong>Faculdade Moderna de Direito</strong>
        </div>
    </div>

    <h2>1. Visão Geral dos Portais</h2>
    <p>A plataforma académica da Faculdade Moderna de Direito (FMD) disponibiliza 4 perfis funcionais com permissões específicas de Role-Based Access Control (RBAC):</p>
    <ul>
        <li><strong>Portal do Estudante:</strong> Acompanhamento de notas, assiduidade, matrículas, pagamentos, exames e certidões.</li>
        <li><strong>Portal do Professor:</strong> Gestão de turmas, pautas de avaliação contínua (AC1-AC4) e exames, sumários e contestações.</li>
        <li><strong>Secretaria / Tesouraria:</strong> Validação documental de matrículas, emissão de recibos e controlo de propinas.</li>
        <li><strong>Painel da Administração / Direção:</strong> Governação académica global, auditoria, turmas, comunicados e estatísticas.</li>
    </ul>

    <h2>2. Guia do Estudante</h2>
    
    <h3>2.1 Cadastro e Login</h3>
    <div class="step-card">
        <p><strong>1. Primeiro Acesso:</strong> Aceda à página de Autenticação em <code>/auth</code>. Se ainda não possui conta, clique em "Cadastre-se" e preencha os seus dados pessoais. A conta ficará pendente de aprovação pela Secretaria.</p>
        <p><strong>2. Início de Sessão:</strong> Após aprovação, introduza o seu e-mail e palavra-passe. O sistema redirecionará automaticamente para o Portal do Estudante.</p>
    </div>

    <h3>2.2 Candidatura e Matrícula (Prazo de 48 Horas)</h3>
    <div class="step-card">
        <p><strong>Submissão de Matrícula:</strong> Uma vez aprovada a conta inicial, o estudante dispõe de <strong>48 horas</strong> para submeter o formulário de matrícula em <code>/matricula</code>, carregando os ficheiros obrigatórios (B.I., Fotografias, Certificado e Comprovativo de Pagamento).</p>
        <p><strong>Prazo Expirado:</strong> Se decorrerem mais de 48 horas sem submissão, a intenção de matrícula expira, sendo necessário contactar a Secretaria.</p>
    </div>

    <h3>2.3 Avaliação Contínua e Exames</h3>
    <p>No separador <strong>"Avaliação Contínua"</strong>, o estudante consulta as suas classificações estruturadas:</p>
    <ul>
        <li><strong>AC1:</strong> Frequência / Teste Escrito de Teoria Geral (0–5 val.)</li>
        <li><strong>AC2:</strong> Resolução de Casos Práticos (0–5 val.)</li>
        <li><strong>AC3:</strong> Redação de Peça Processual / Pesquisa (0–5 val.)</li>
        <li><strong>AC4:</strong> Participação / Simulações de Julgamento (0–5 val.)</li>
        <li><strong>Exame Final:</strong> Prova de Época Normal / Recurso (0–20 val.)</li>
    </ul>
    <p><strong>Resultado Final:</strong> <code>(AC_total + Exame) / 2</code>. Média ≥ 12 (Aprovado); 8 a 11.9 (Admitido a Recurso); < 8 (Reprovado).</p>

    <h3>2.4 Contestação e Mediação Académica (8 Etapas)</h3>
    <p>Caso discorde de uma classificação lançada, o estudante pode abrir uma contestação no seu portal. O processo segue um fluxo formal de 8 etapas, incluindo resposta do professor, contra-argumentação única do aluno, escalada à Direção e reunião presencial de mediação com ata final.</p>

    <h3>2.5 Certificados de Mérito</h3>
    <p>Alunos com médias de excelência integrando o ranking do semestre/ano podem visualizar e imprimir os seus <strong>Certificados de Mérito Digitalmente Autenticados</strong> (com validação QR Code) na secção "Mérito & Diplomas".</p>

    <h2>3. Guia do Professor</h2>

    <h3>3.1 Lançamento de Pautas e Notas</h3>
    <div class="step-card">
        <p><strong>1. Selecionar Turma e Disciplina:</strong> No Portal Docente, escolha a turma e disciplina atribuída.</p>
        <p><strong>2. Lançar Notas:</strong> Preencha os campos de AC1 a AC4 e Exame Final para cada estudante. O cálculo da nota final e da situação pedagógica é automático.</p>
        <p><strong>3. Resposta a Contestações:</strong> No separador de contestações, o professor lê o argumento do estudante e introduz a sua resposta fundamentada.</p>
    </div>

    <h3>3.2 Registo de Sumários e Faltas</h3>
    <p>O professor regista digitalmente a matéria leccionada (sumário) e marca as faltas dos estudantes em cada aula, alimentando os relatórios de assiduidade.</p>

    <h2>4. Guia da Secretaria / Tesouraria</h2>
    <div class="step-card">
        <p><strong>Validação de Matrículas:</strong> Analise as candidaturas pendentes, verifique a conformidade dos documentos (B.I., Certificado) e o pagamento da taxa. Aprove ou rejeite com justificação fundamentada.</p>
        <p><strong>Emissão de Recibos:</strong> Registe pagamentos manuais ou confirme comprovativos bancários, gerando recibos digitais com número de série único para o estudante.</p>
    </div>

    <h2>5. Guia da Administração / Direção</h2>
    <div class="step-card">
        <p><strong>Gestão Académica:</strong> Cadastro de Cursos, Anos Curriculares, Semestres, Disciplinas Jurídicas, Turmas, Professores e Estudantes.</p>
        <p><strong>Mediação & Convocatórias:</strong> Resolução de impasses pedagógicos, agendamento de reuniões formais com emissão de convocatórias e relatórios estatísticos (ECharts).</p>
        <p><strong>Auditoria de Segurança:</strong> Inspeção de logs de auditoria imutáveis registando todas as ações sensíveis com IP, utilizador e timestamp.</p>
    </div>

    <div class="footer">
        <span>&copy; 2026 Faculdade Moderna de Direito (FMD). Manual do Utilizador v1.0.</span>
        <span>Documento Funcional</span>
    </div>

</body>
</html>
