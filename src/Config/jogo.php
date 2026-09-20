<?php
const TITULO_JOGO = "A Relíquia do Reino Perdido";
const GITHUB_CRIADORES = "https://github.com/LYHERS/RPG_CHAN";

function obterImagemPiko()
{
    return "img/protagonistas/piko.png";
}

function obterImagensMonstros()
{
    return array(
        4  => "img/monstros/inimigo_floresta.png",
        6  => "img/monstros/inimigo_caverna.png",
        8  => "img/monstros/guardiao_ponte.png",
        11 => "img/monstros/varyn.png",
        14 => "img/monstros/mae_piko.png"
    );
}

function obterImagemInimigo($idCena)
{
    $imagens = obterImagensMonstros();
    return isset($imagens[$idCena]) ? $imagens[$idCena] : $imagens[4];
}
