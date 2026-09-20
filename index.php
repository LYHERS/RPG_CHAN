<?php

include_once __DIR__ . "/src/Config/jogo.php";
include_once __DIR__ . "/src/Game/sessao.php";
include_once __DIR__ . "/src/Helpers/mapa.php";
include_once __DIR__ . "/src/Controllers/JogoController.php";

if (isset($_GET["ranking"])) {
    include __DIR__ . "/src/Views/pages/ranking.php";
    exit;
}

$resultado = processarAcoesDoJogo($cenas);
$mensagensBatalha = $resultado["mensagensBatalha"];
$acabouDeVencer = $resultado["acabouDeVencer"];
$acabouDeFugir = $resultado["acabouDeFugir"];

if (!jogoFoiIniciado()) {
    include __DIR__ . "/src/Views/pages/inicio.php";
    exit;
}

if (jogoFoiPerdido()) {
    include __DIR__ . "/src/Views/pages/derrota.php";
    exit;
}

$idCenaAtual = $_SESSION["cenaAtual"];
$cenaAtual = $cenas[$idCenaAtual];
$imagemPiko = obterImagemPiko();
$imagensMonstros = obterImagensMonstros();
$imagemInimigoAtual = obterImagemInimigo($idCenaAtual);

$desafioPendente = $cenaAtual->temDesafio() && !desafioResolvido($idCenaAtual);
$temBatalha = cenaTemBatalha($idCenaAtual);
$batalhaPendente = $temBatalha && !$desafioPendente && !batalhaEncerrada($idCenaAtual);
$podeMostrarTransicoes = !$desafioPendente && !($temBatalha && !batalhaEncerrada($idCenaAtual));

include __DIR__ . "/src/Views/pages/jogo.php";
