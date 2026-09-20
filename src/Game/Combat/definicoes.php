<?php




function obterBatalhas()
{
    return array(
        14 => array("nome" => "Mae de Piko", "vida" => 55, "ataque" => 14, "nivel" => 2, "tipo" => "normal"),
        4  => array("nome" => "Inimigo da Floresta", "vida" => 80, "ataque" => 18, "nivel" => 4, "tipo" => "normal"),
        6  => array("nome" => "Inimigo da Caverna", "vida" => 90, "ataque" => 20, "nivel" => 5, "tipo" => "normal"),
        8  => array("nome" => "Guardiao da Ponte", "vida" => 110, "ataque" => 22, "nivel" => 7, "tipo" => "normal"),
        11 => array("nome" => "Varyn", "vida" => 120, "ataque" => 18, "nivel" => 10, "tipo" => "jokenpo")
    );
}


function cenaTemBatalha($idCena)
{
    $batalhas = obterBatalhas();
    return isset($batalhas[$idCena]);
}


function obterDadosInimigo($idCena)
{
    $batalhas = obterBatalhas();

    if (isset($batalhas[$idCena]))
    {
        return $batalhas[$idCena];
    }

    return null;
}


function batalhaEhJokenpo($idCena)
{
    $dados = obterDadosInimigo($idCena);
    return $dados != null && isset($dados["tipo"]) && $dados["tipo"] == "jokenpo";
}

