<?php

include_once __DIR__ . "/../../Models/Personagem.php";



function criarPiko()
{
    return new Personagem("Piko", 100, 100, 24, "");
}


function criarInimigo($idCena)
{
    $dados = obterDadosInimigo($idCena);

    if ($dados == null)
    {
        return null;
    }

    return new Personagem($dados["nome"], $dados["vida"], $dados["vida"], $dados["ataque"], "");
}




function ganharPocaoPorBatalha($idCena)
{
    $chave = chaveBatalha($idCena, "PocaoPremiada");

    if (!isset($_SESSION[$chave]))
    {
        $_SESSION[$chave] = true;
        $_SESSION["pocoesVida"] = obterQuantidadePocoes() + 1;
        return true;
    }

    return false;
}


function obterQuantidadePocoes()
{
    if (!isset($_SESSION["pocoesVida"]))
    {
        $_SESSION["pocoesVida"] = 2;
    }

    return $_SESSION["pocoesVida"];
}

