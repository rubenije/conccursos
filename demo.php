<?php

phpinfo();
exit;
// Seguridad básica: solo permitir acceso con token
$token = $_GET['token'] ?? '';

if ($token !== 'MI_TOKEN_SUPER_SEGURO_123') {
    http_response_code(403);
    exit('Acceso denegado');
}

// Ruta absoluta del script
$script = '/home/conccursos/public_html/run_task.sh';

// Ejecutar
$output = [];
$returnVar = 0;

exec("bash $script 2>&1", $output, $returnVar);

// Mostrar resultado
echo "<pre>";
echo "Código de salida: $returnVar\n\n";
echo implode("\n", $output);
echo "</pre>";
