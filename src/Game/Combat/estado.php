<?php



function chaveBatalha($idCena, $sufixo)
{
    return "batalha" . $idCena . $sufixo;
}




function batalhaVencida($idCena)
{
    $chave = chaveBatalha($idCena, "Vencida");
    return isset($_SESSION[$chave]) && $_SESSION[$chave] == true;
}


function batalhaPerdida($idCena)
{
    $chave = chaveBatalha($idCena, "Perdida");
    return isset($_SESSION[$chave]) && $_SESSION[$chave] == true;
}


function fugaBemSucedida($idCena)
{
    $chave = chaveBatalha($idCena, "Fugiu");
    return isset($_SESSION[$chave]) && $_SESSION[$chave] == true;
}


function batalhaEncerrada($idCena)
{
    return batalhaVencida($idCena) || fugaBemSucedida($idCena);
}


function fugaJaTentada($idCena)
{
    $chave = chaveBatalha($idCena, "FugaTentada");
    return isset($_SESSION[$chave]) && $_SESSION[$chave] == true;
}


function obterUltimoDadoFuga($idCena)
{
    $chave = chaveBatalha($idCena, "DadoFuga");

    if (isset($_SESSION[$chave]))
    {
        return $_SESSION[$chave];
    }

    return null;
}


function inimigoEstaDefendendo($idCena)
{
    $chave = chaveBatalha($idCena, "InimigoDefendendo");
    return isset($_SESSION[$chave]) && $_SESSION[$chave] == true;
}

