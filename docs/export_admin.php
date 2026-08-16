<?php
// Resumo Executivo FMD v1.0 — Faculdade Moderna de Direito
?>
<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <title>FMD — Resumo Executivo v1.0</title>
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
        .cover-left .logo { font-size: 16px; font-weight: 700; color: var(--primary); letter-spacing: 0.5px; }
        .cover-left .logo span { color: var(--accent); }
        .cover-left h1 { font-size: 26px; font-weight: 700; color: var(--primary); margin: 6px 0; }
        .cover-left p { color: var(--muted); font-size: 13px; }
        .cover-right { text-align: right; font-size: 12px; color: var(--muted); }
        .cover-right .version { display: inline-block; background: var(--light); border: 1px solid var(--border); color: var(--primary); padding: 3px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; margin-bottom: 6px; }

        h2 { font-size: 15px; font-weight: 700; color: var(--primary); margin: 30px 0 12px; padding-bottom: 6px; border-bottom: 1px solid var(--border); }
        h3 { font-size: 14px; font-weight: 600; color: var(--primary); margin: 18px 0 8px; }
        h4 { font-size: 13px; font-weight: 600; color: var(--primary); margin: 12px 0 6px; }
        p { margin-bottom: 10px; text-align: justify; }
        ul, ol { padding-left: 20px; margin-bottom: 12px; }
        li { margin-bottom: 5px; }

        table { width: 100%; border-collapse: collapse; margin: 15px 0 25px; font-size: 12px; border: 1px solid var(--border); }
        thead th { background: var(--light); color: var(--primary); padding: 10px 12px; text-align: left; font-weight: 600; border-bottom: 1px solid var(--border); }
        tbody td { border-bottom: 1px solid var(--border); padding: 8px 12px; vertical-align: top; }
        tbody tr:nth-child(even) td { background: #fafbfc; }

        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 500; border: 1px solid transparent; }
        .badge-green { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
        .badge-blue { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }
        .badge-yellow { background: #fefce8; color: #854d0e; border-color: #fef08a; }
        .badge-red { background: #fef2f2; color: #991b1b; border-color: #fecaca; }

        .info-box { background: #eff6ff; border: 1px solid #bfdbfe; border-left: 3px solid var(--accent); border-radius: 4px; padding: 12px 16px; margin: 12px 0; }
        .warning-box { background: #fefce8; border: 1px solid #fef08a; border-left: 3px solid #eab308; border-radius: 4px; padding: 12px 16px; margin: 12px 0; }
        .success-box { background: #f0fdf4; border: 1px solid #bbf7d0; border-left: 3px solid var(--accent-green); border-radius: 4px; padding: 12px 16px; margin: 12px 0; }

        .footer { margin-top: 40px; padding-top: 15px; font-size: 11px; color: var(--muted); display: flex; justify-content: space-between; border-top: 1px solid var(--border); }

        @media print {
            @page { margin: 0.5cm; }
            body { padding: 30px 40px; }
            table, pre, .info-box, .warning-box, .success-box { box-shadow: none; border: 1px solid #ccc; }
        }
    </style>
</head>

<body>

    <div class="cover">
        <div class="cover-left">
            <img src="../img/faculdade.png" alt="Faculdade Moderna de Direito" style="height: 60px; border-radius: 6px; margin-bottom: 20px;">
            <h1>Resumo Executivo da Plataforma FMD</h1>
            <p>Documento de Visão Estratégica, Governação Institucional e Arquitetura Académica</p>
        </div>
        <div class="cover-right">
            <div class="version">v1.0 FMD</div><br>
            <strong>Data:</strong> Agosto 2026<br>
            <strong>Classificação:</strong> Uso Interno Institucional<br>
            <strong>Instituição:</strong> Faculdade Moderna de Direito (FMD)
        </div>
    </div>

    <h2>1. Apresentação e Contexto Institucional</h2>
    <p>A <strong>Faculdade Moderna de Direito (FMD)</strong> é uma nova instituição universitária privada focada na área jurídica na Guiné-Bissau. Lançada no final de 2024, a sua criação partiu da iniciativa de jovens licenciados formados pela Faculdade de Direito de Bissau (pública) que decidiram criar uma alternativa de ensino de excelência na capital.</p>
    <p>O presente sistema resulta da migração e adaptação tecnológica institucional da plataforma originalmente concebida para a Escola Superior de Informática – Green Hard & Soft (GHS), devidamente transformada para responder ao modelo pedagógico, normativo e operacional do curso de <strong>Licenciatura em Direito</strong> da FMD.</p>

    <h2>2. Problema e Solução Tecnológica</h2>
    <table>
        <thead>
            <tr>
                <th width="40%">Desafio de Gestão Académica</th>
                <th width="60%">Solução Integrada na Plataforma FMD</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Matrículas presenciais e burocracia documental</td>
                <td>Submissão digital de candidaturas com triagem automatizada, validação documental e controlo estrito do prazo regulamentar de <strong>48 horas</strong>.</td>
            </tr>
            <tr>
                <td>Cálculo de Avaliação Contínua e Exames</td>
                <td><strong>Motor de Avaliação Centralizado</strong>: calcula automaticamente as 4 componentes de AC (Teoria Geral, Casos Práticos, Peças Processuais, Simulações) e Exame Final, aplicando a nota de corte oficial (Aprovado ≥12, Recurso 8–11.9, Reprovado <8).</td>
            </tr>
            <tr>
                <td>Conflitos e Contestações de Notas</td>
                <td><strong>Sistema de Mediação Académica de 8 Etapas</strong>: garante transparência total no tratamento de contestações dos estudantes com mediação pedagógica da Direção.</td>
            </tr>
            <tr>
                <td>Comunicação e Transparência Pedagógica</td>
                <td>Central de Comunicados com confirmação de leitura (Read Tracking), convocatórias diretas para reuniões e alertas em tempo real nos portais.</td>
            </tr>
        </tbody>
    </table>

    <h2>3. Perfis e Papéis de Utilizadores (RBAC)</h2>
    <table>
        <thead>
            <tr>
                <th>Perfil</th>
                <th>Acesso</th>
                <th>Principais Funcionalidades</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>⚙️ Administração</strong></td>
                <td>Direção da FMD</td>
                <td>Gestão de cursos, anos curriculares, semestres, turmas, disciplinas, professores, auditoria de logs e relatórios estratégicos.</td>
            </tr>
            <tr>
                <td><strong>🏢 Secretaria / Tesouraria</strong></td>
                <td>Corpo Administrativo</td>
                <td>Validação de matrículas, controlo de prazos (48h), emissão de recibos, certidões e gestão financeira.</td>
            </tr>
            <tr>
                <td><strong>👨‍⚖️ Professor</strong></td>
                <td>Corpo Docente</td>
                <td>Lançamento das 4 ACs e Exame, registo de sumários digitais, controlo de assiduidade e resposta a esclarecimentos pedagógicos.</td>
            </tr>
            <tr>
                <td><strong>🎓 Estudante</strong></td>
                <td>Alunos Matriculados</td>
                <td>Consulta de pautas dinâmicas, submissão de matrículas, acompanhamento da situação financeira, pedidos de mediação e certificados de mérito.</td>
            </tr>
        </tbody>
    </table>

    <h2>4. Estrutura Académica e Motor de Avaliação da FMD</h2>

    <h3>4.1 Organização Curricular</h3>
    <p>A estrutura pedagógica principal assenta na <strong>Licenciatura em Direito</strong>, organizada em <strong>4 Anos Curriculares (8 Semestres)</strong>. As disciplinas e turmas são totalmente configuráveis via painel administrativo, mantendo flexibilidade para atualizações de plano curricular sem alteração do código-fonte.</p>

    <h3>4.2 Componentes de Avaliação Contínua (AC1 a AC4)</h3>
    <p>O motor de avaliação foi adaptado ao rigor do ensino jurídico:</p>
    <ul>
        <li><strong>AC1 — Frequência / Teste Escrito de Teoria Geral</strong> (0 a 5 valores)</li>
        <li><strong>AC2 — Resolução de Casos Práticos</strong> (0 a 5 valores)</li>
        <li><strong>AC3 — Redação de Peça Processual / Pesquisa Jurídica</strong> (0 a 5 valores)</li>
        <li><strong>AC4 — Participação nas Aulas / Simulações de Julgamento</strong> (0 a 5 valores)</li>
    </ul>

    <div class="info-box">
        <strong>Fórmula da Nota Final:</strong><br>
        <code>AC_total = AC1 + AC2 + AC3 + AC4</code> (Máximo: 20 valores)<br>
        <code>Nota Final = (AC_total + Exame Final) / 2</code> (Escala 0 a 20 valores)
    </div>

    <h3>4.3 Matriz de Resultados Académicos</h3>
    <table>
        <thead>
            <tr>
                <th>Resultado</th>
                <th>Intervalo de Nota Final</th>
                <th>Estado Regulamentar</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><span class="badge badge-green">APROVADO</span></td>
                <td>Nota Final ≥ 12,0 valores</td>
                <td>Aprovação direta na disciplina.</td>
            </tr>
            <tr>
                <td><span class="badge badge-yellow">RECURSO</span></td>
                <td>8,0 ≤ Nota Final < 12,0 valores</td>
                <td>Admitido ao Exame de Recurso (máx. 3 disciplinas).</td>
            </tr>
            <tr>
                <td><span class="badge badge-red">REPROVADO</span></td>
                <td>Nota Final < 8,0 valores</td>
                <td>Reprovação direta na disciplina.</td>
            </tr>
        </tbody>
    </table>

    <h2>5. Regulamento de Matrícula (Prazo 48 Horas)</h2>
    <p>Após a aprovação do registo inicial de candidatura pela Secretaria, o estudante dispõe de <strong>48 horas regulamentares</strong> (definidas centralmente pela constante <code>MATRICULA_PRAZO_HORAS</code>) para submeter a documentação definitiva e comprovativo de pagamento. Decorrido o prazo sem submissão, a candidatura expira automaticamente.</p>

    <h2>6. Sistema de Mediação Académica (8 Etapas)</h2>
    <p>Preservado integralmente do sistema base, o fluxo de mediação garante o direito de contestação instruído em 8 passos:</p>
    <ol>
        <li>Abertura fundamentada da contestação pelo estudante.</li>
        <li>Notificação e resposta formal do docente.</li>
        <li>Contra-argumentação (única) do estudante.</li>
        <li>Identificação de impasse pedagógico.</li>
        <li>Escalação do processo à Administração/Direção.</li>
        <li>Emissão de Convocatória oficial com alerta nos portais.</li>
        <li>Reunião de mediação pedagógica.</li>
        <li>Decisão final vinculativa registada em ata.</li>
    </ol>

    <h2>7. Segurança e Proteção de Dados</h2>
    <ul>
        <li><strong>CSRF:</strong> Tokens criptográficos únicos por sessão (<code>fmd_csrf_token</code>).</li>
        <li><strong>XSS:</strong> Sanitização e escaping dinâmico em todas as visualizações.</li>
        <li><strong>SQL Injection:</strong> Prepared Statements PDO em 100% das consultas à base de dados.</li>
        <li><strong>RBAC & IDOR:</strong> Verificação rigorosa de autorização nos controllers antes de servir recursos.</li>
        <li><strong>Auditoria:</strong> Registo imutável de ações críticas (logins, aprovações, notas, mediações).</li>
    </ul>

    <h2>8. Ficha Técnica do Sistema FMD</h2>
    <table>
        <tbody>
            <tr>
                <td width="30%"><strong>Denominação</strong></td>
                <td>Plataforma Académica da Faculdade Moderna de Direito (FMD)</td>
            </tr>
            <tr>
                <td><strong>Arquitetura Tecnológica</strong></td>
                <td>PHP 8.x Nativo (Padrão MVC), MySQL/MariaDB PDO, Bootstrap 5, ECharts</td>
            </tr>
            <tr>
                <td><strong>Versão da Migração</strong></td>
                <td>v1.0 — FMD (Agosto 2026)</td>
            </tr>
            <tr>
                <td><strong>Estado de Conservação</strong></td>
                <td>100% das regras válidas preservadas, rebranding completo efetuado.</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <span>&copy; 2026 Faculdade Moderna de Direito (FMD). Documento Institucional Interno.</span>
        <span>Resumo Executivo v1.0 — FMD</span>
    </div>

</body>
</html>