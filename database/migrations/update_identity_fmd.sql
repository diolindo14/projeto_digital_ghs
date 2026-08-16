-- =============================================================================
-- Migration: Adaptação Institucional para Faculdade Moderna de Direito (FMD)
-- Data: Agosto de 2026
-- =============================================================================

-- 1. Atualização das Designações dos Tipos de Avaliação para o Domínio do Direito
UPDATE tipos_avaliacao 
SET nome = 'AC1 — Teoria Geral', 
    codigo = 'ac1' 
WHERE id = 1;

UPDATE tipos_avaliacao 
SET nome = 'AC2 — Casos Práticos', 
    codigo = 'ac2' 
WHERE id = 2;

UPDATE tipos_avaliacao 
SET nome = 'AC3 — Peça Processual / Pesquisa', 
    codigo = 'ac3' 
WHERE id = 3;

UPDATE tipos_avaliacao 
SET nome = 'AC4 — Participação & Simulações', 
    codigo = 'ac4' 
WHERE id = 4;

UPDATE tipos_avaliacao 
SET nome = 'Exame Final', 
    codigo = 'exame' 
WHERE id = 5;

-- 2. Atualização dos Códigos de Turmas (Prefixos Institucionais GHS -> FMD)
UPDATE turmas 
SET codigo = REPLACE(codigo, 'GHS-', 'FMD-') 
WHERE codigo LIKE 'GHS-%';

-- 3. Atualização de Eventos no Calendário Institucional
UPDATE eventos 
SET titulo = REPLACE(titulo, 'AAEGHS', 'FMD') 
WHERE titulo LIKE '%AAEGHS%';

UPDATE eventos 
SET descricao = REPLACE(descricao, 'GHS', 'FMD') 
WHERE descricao LIKE '%GHS%';
