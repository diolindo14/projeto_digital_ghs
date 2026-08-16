<?php
require_once __DIR__ . '/../../core/config.php';
require_once __DIR__ . '/../../core/Database.php';

$db = Database::getInstance();
$db->exec("UPDATE utilizadores SET email = REPLACE(email, '@ghs.school', '@fmd.edu') WHERE email LIKE '%@ghs.school'");
$db->exec("UPDATE utilizadores SET email = 'direcao@fmd.edu', nome_completo = 'Direção FMD' WHERE email LIKE '%diretor_ghs%' OR email = 'diretor@ghs.edu.gw'");
echo "Contas de utilizadores atualizadas para @fmd.edu!\n";
