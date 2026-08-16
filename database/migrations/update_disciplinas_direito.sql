-- =============================================================================
-- Migration: Substituição de Disciplinas de TI por Licenciatura em Direito (FMD)
-- =============================================================================

-- 1. Atualizar Códigos e Nomes de Disciplinas para o Domínio Jurídico (FMD)

UPDATE disciplinas SET codigo = 'IED', nome = 'Introdução ao Estudo do Direito' WHERE codigo IN ('MAT', 'MAT1') OR nome LIKE '%Matem%';
UPDATE disciplinas SET codigo = 'TGC', nome = 'Teoria Geral do Direito Civil' WHERE codigo = 'FIS' OR nome LIKE '%F%sica%';
UPDATE disciplinas SET codigo = 'DCO', nome = 'Direito Constitucional' WHERE codigo = 'ING' OR nome LIKE '%Ingl%s%';
UPDATE disciplinas SET codigo = 'CPO', nome = 'Ciência Política' WHERE codigo = 'APL' OR nome LIKE '%Algoritmo%';
UPDATE disciplinas SET codigo = 'HDC', nome = 'História do Direito' WHERE codigo = 'GDA' OR nome LIKE '%Gest%o%';

UPDATE disciplinas SET codigo = 'DOB', nome = 'Direito das Obrigações' WHERE codigo = 'AED' OR nome LIKE '%Estrutura%';
UPDATE disciplinas SET codigo = 'DPN', nome = 'Direito Penal' WHERE codigo = 'POO' OR nome LIKE '%Programa%';
UPDATE disciplinas SET codigo = 'DAD', nome = 'Direito Administrativo' WHERE codigo = 'ALGA' OR nome LIKE '%Algebra%' OR nome LIKE '%Álgebra%';
UPDATE disciplinas SET codigo = 'DIP', nome = 'Direito Internacional Público' WHERE codigo = 'ECC' OR nome LIKE '%Eletr%nica%';

UPDATE disciplinas SET codigo = 'DRE', nome = 'Direitos Reais' WHERE codigo = 'HM';
UPDATE disciplinas SET codigo = 'DCM', nome = 'Direito Comercial' WHERE codigo = 'FBD' OR nome LIKE '%Banco%' OR nome LIKE '%Base%';
UPDATE disciplinas SET codigo = 'DPC', nome = 'Direito Processual Civil' WHERE codigo = 'TC' OR nome LIKE '%Teoria Computa%';
UPDATE disciplinas SET codigo = 'DPP', nome = 'Direito Processual Penal' WHERE codigo IN ('RD1', 'RD2') OR nome LIKE '%Redes%';
UPDATE disciplinas SET codigo = 'DTR', nome = 'Direito do Trabalho' WHERE codigo = 'CDSI';
UPDATE disciplinas SET codigo = 'DFS', nome = 'Direito Fiscal' WHERE codigo = 'JS' OR nome LIKE '%JavaScript%';
UPDATE disciplinas SET codigo = 'FAM', nome = 'Direito da Família e Sucessões' WHERE codigo = 'SO' OR nome LIKE '%Sistemas Operat%';

UPDATE disciplinas SET codigo = 'PPR', nome = 'Prática Processual' WHERE codigo = 'IA' OR nome LIKE '%Intelig%ncia%';
UPDATE disciplinas SET codigo = 'FDI', nome = 'Filosofia do Direito' WHERE codigo = 'MC' OR nome LIKE '%Modela%';
UPDATE disciplinas SET codigo = 'DIR', nome = 'Direito Internacional Privado' WHERE codigo = 'ES' OR nome LIKE '%Engenharia%';
UPDATE disciplinas SET codigo = 'DPR', nome = 'Direito dos Petróleos e Recursos Naturais' WHERE codigo = 'MCG';
UPDATE disciplinas SET codigo = 'DCS', nome = 'Direito da Comunicação Social' WHERE codigo = 'PI' OR nome LIKE '%Projecto%';
UPDATE disciplinas SET codigo = 'EDJ', nome = 'Ética e Deontologia nas Profissões Jurídicas' WHERE codigo = 'TSI' OR nome LIKE '%T%picos%';
UPDATE disciplinas SET codigo = 'DFU', nome = 'Direitos Fundamentais' WHERE codigo = 'IPM';
UPDATE disciplinas SET codigo = 'ECO', nome = 'Economia Política' WHERE codigo = 'SQL Server' OR nome LIKE '%SQL%';

-- 2. Atualizar Salas dos Horários (Substituir LAB1/LAB3 por Salas de Aula FMD)
UPDATE horarios SET sala = 'S1' WHERE sala LIKE '%LAB1%' OR sala = 'LAB1';
UPDATE horarios SET sala = 'S2' WHERE sala LIKE '%LAB2%' OR sala = 'LAB2';
UPDATE horarios SET sala = 'S3' WHERE sala LIKE '%LAB3%' OR sala = 'LAB3';
UPDATE horarios SET sala = 'S4' WHERE sala LIKE '%BIB%' OR sala = 'BIB';
UPDATE horarios SET sala = 'AULA MAGNA' WHERE sala = 'SR';
