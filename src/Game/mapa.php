<?php

include_once __DIR__ . "/../Models/Cena.php";
include_once __DIR__ . "/../Models/Dado.php";
include_once __DIR__ . "/../Models/Desafio.php";
include_once __DIR__ . "/cenas.php";
include_once __DIR__ . "/transicoes.php";
include_once __DIR__ . "/desafios.php";

$cenas = array();
for ($id = 1; $id <= 14; $id++) {
    $cenas[$id] = ${"cena" . $id};
}
