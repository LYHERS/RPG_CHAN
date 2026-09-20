<?php

function obterPontuacao()
{
    if (!isset($_SESSION["pontuacao"]))
    {
        $_SESSION["pontuacao"] = 0;
    }

    return $_SESSION["pontuacao"];
}


function adicionarPontos($quantidade)
{
    $quantidade = (int) $quantidade;

    if ($quantidade > 0)
    {
        $_SESSION["pontuacao"] = obterPontuacao() + $quantidade;
    }

    return obterPontuacao();
}


function removerPontos($quantidade)
{
    $quantidade = (int) $quantidade;

    if ($quantidade > 0)
    {
        $_SESSION["pontuacao"] = obterPontuacao() - $quantidade;

        if ($_SESSION["pontuacao"] < 0)
        {
            $_SESSION["pontuacao"] = 0;
        }
    }

    return obterPontuacao();
}



function pontuarUmaVez($chave, $quantidade)
{
    if (!isset($_SESSION["eventosPontuacao"]) || !is_array($_SESSION["eventosPontuacao"]))
    {
        $_SESSION["eventosPontuacao"] = array();
    }

    if (isset($_SESSION["eventosPontuacao"][$chave]))
    {
        return false;
    }

    $_SESSION["eventosPontuacao"][$chave] = true;
    adicionarPontos($quantidade);

    return true;
}


function penalizarUmaVez($chave, $quantidade)
{
    if (!isset($_SESSION["eventosPontuacao"]) || !is_array($_SESSION["eventosPontuacao"]))
    {
        $_SESSION["eventosPontuacao"] = array();
    }

    if (isset($_SESSION["eventosPontuacao"][$chave]))
    {
        return false;
    }

    $_SESSION["eventosPontuacao"][$chave] = true;
    removerPontos($quantidade);

    return true;
}






