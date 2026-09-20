<?php




if (!isset($_SESSION["jogoIniciado"]))
{
    $_SESSION["jogoIniciado"] = false;
}

if (!isset($_SESSION["cenaAtual"]) || !isset($cenas[$_SESSION["cenaAtual"]]))
{
    $_SESSION["cenaAtual"] = 1;
}

if (!isset($_SESSION["cenasVisitadas"]) || !is_array($_SESSION["cenasVisitadas"]))
{
    $_SESSION["cenasVisitadas"] = array();
}


if ($_SESSION["jogoIniciado"] == true && !isset($_SESSION["pocoesVida"]))
{
    $_SESSION["pocoesVida"] = 2;
}

if (!isset($_SESSION["jogoPerdido"]))
{
    $_SESSION["jogoPerdido"] = false;
}

if (!isset($_SESSION["motivoDerrota"]))
{
    $_SESSION["motivoDerrota"] = "";
}

if (!isset($_SESSION["pontuacao"]))
{
    $_SESSION["pontuacao"] = 0;
    $_SESSION["rankingSalvo"] = false;
}

if (!isset($_SESSION["eventosPontuacao"]) || !is_array($_SESSION["eventosPontuacao"]))
{
    $_SESSION["eventosPontuacao"] = array();
}




function jogoFoiIniciado()
{
    return isset($_SESSION["jogoIniciado"]) && $_SESSION["jogoIniciado"] == true;
}


function jogoFoiPerdido()
{
    return isset($_SESSION["jogoPerdido"]) && $_SESSION["jogoPerdido"] == true;
}


function marcarJogoPerdido($motivo)
{
    $_SESSION["jogoPerdido"] = true;
    $_SESSION["motivoDerrota"] = $motivo;
}


function obterMotivoDerrota()
{
    if (isset($_SESSION["motivoDerrota"]))
    {
        return $_SESSION["motivoDerrota"];
    }

    return "Piko perdeu a jornada.";
}





