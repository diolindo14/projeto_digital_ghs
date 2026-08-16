# Documentação Completa: Faculdade Moderna de Direito (FMD) v1.0

## 1. Visão Geral
A plataforma da **Faculdade Moderna de Direito (FMD)** é uma solução robusta de gestão académica, pedagógica e financeira. O sistema foi migrado e adaptado a partir da base tecnológica original da Green Hard & Soft (GHS), consolidando o motor de regras do curso de Licenciatura em Direito, o sistema de mediação académica de 8 etapas, os certificados de mérito e elevadas camadas de proteção de dados.

---

## 2. Componentes Estratégicos e Documentos Oficiais

### 2.1 Resumo Executivo (Gestão Institucional) — `export_admin.php`
Focado na governação, controlo institucional e saúde operacional.
- **Visão Geral e Contexto:** Apresentação da FMD e motivação da migração.
- **Estrutura Académica:** Licenciatura em Direito (4 Anos / 8 Semestres).
- **Motor de Avaliação:** Regras oficiais de AC1 a AC4 e Exame Final.
- **Governação & Seguraça:** Matrícula de 48h, Mediação em 8 etapas e RBAC.

### 2.2 Manual do Utilizador (Guia Funcional) — `export_funcional.php`
Experiência de auto-serviço e operacionalização por perfil.
- **Portal do Estudante:** Candidaturas, matrículas, pautas, recursos, mediações e certidões.
- **Portal do Professor:** Pautas docentes (AC1-AC4 + Exame), sumários e assiduidade.
- **Secretaria / Tesouraria:** Validação documental, controlo de propinas e recibos.
- **Painel de Direção:** Convocatórias, gestão de turmas, comunicados e auditoria.

### 2.3 Manual Técnico / Developer Guide — `export_tecnica.php`
Infraestrutura, código e hardening de segurança.
- **Arquitetura MVC Native:** PHP 8.2 sem frameworks, PDO MySQL/MariaDB.
- **Security Hardening:** Proteção ativa contra CSRF, XSS, SQLi, IDOR e Brute Force.
- **Motor de Regras:** Algoritmo centralizado em `Academico.php` e `Nota.php`.

---

## 3. Como Gerar os Manuais Oficiais em PDF

1. Aceda via browser aos ficheiros `docs/export_admin.php`, `docs/export_funcional.php` ou `docs/export_tecnica.php`.
2. Pressione `Ctrl + P` (ou comando equivalente no browser).
3. Selecione "Guardar como PDF" com orientação A4 para obter os documentos impressos profissionais.

---

> [!NOTE]
> **Nota Histórica de Migração:** A referência à instituição de origem (Green Hard & Soft - GHS) é mantida exclusivamente para efeitos de rastreabilidade técnica no historial do projeto, apresentando a plataforma final uma identidade 100% alinhada com a Faculdade Moderna de Direito (FMD).
