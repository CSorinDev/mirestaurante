<?php

use App\Kernel;

// 1. Añade esta línea para desactivar la búsqueda del archivo .env
$_SERVER['APP_RUNTIME_OPTIONS'] = [
    'disable_dotenv' => true,
];

// 2. El resto de tu código se mantiene igual
require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};