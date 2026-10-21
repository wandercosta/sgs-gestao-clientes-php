<?php
require_once __DIR__ . '/../init.php';

verificarCsrf();

$_SESSION = [];
session_destroy();

redirecionar('../index.php');
