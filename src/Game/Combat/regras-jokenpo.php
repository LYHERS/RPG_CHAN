<?php


function nomeEscolhaJokenpo($escolha)
{
    if ($escolha == "pedra") return "Pedra";
    if ($escolha == "papel") return "Papel";
    if ($escolha == "tesoura") return "Tesoura";
    return "";
}


function resultadoJokenpo($escolhaPiko, $escolhaVaryn)
{
    if ($escolhaPiko == $escolhaVaryn)
    {
        return "empate";
    }

    
    if (
        ($escolhaPiko == "pedra" && $escolhaVaryn == "tesoura") ||
        ($escolhaPiko == "papel" && $escolhaVaryn == "pedra") ||
        ($escolhaPiko == "tesoura" && $escolhaVaryn == "papel")
    )
    {
        return "piko";
    }

    return "varyn";
}

