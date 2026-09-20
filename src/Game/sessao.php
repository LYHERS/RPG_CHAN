<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . "/mapa.php";
include_once __DIR__ . "/Combat/combate.php";
include_once __DIR__ . "/Session/estado.php";
include_once __DIR__ . "/Session/pontuacao.php";
include_once __DIR__ . "/Session/visitas.php";
include_once __DIR__ . "/Session/inicializacao.php";
include_once __DIR__ . "/Session/desafios.php";
include_once __DIR__ . "/ranking.php";
include_once __DIR__ . "/Session/navegacao.php";
