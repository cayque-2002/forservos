<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Config/env.php';

use Src\Database\Connection;

$conn = Connection::getInstance();

echo "Conectado com sucesso 🚀";