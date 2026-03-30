<?php
$content = file_get_contents(__DIR__ . '/app/views/admin/dashboard.php');
preg_match_all('/(href|action|fetch)\s*=?\s*["\'](<\?= URL_ROOT \?>)?\/admin\/([^"\'?]+)/i', $content, $matches);
$routes = array_unique($matches[3]);
sort($routes);
echo "Rotas encontradas em admin/dashboard.php:\n";
foreach($routes as $r) {
    echo "- " . $r . "\n";
}
