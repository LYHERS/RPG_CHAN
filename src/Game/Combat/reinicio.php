<?php



function reiniciarBatalha($idCena)
{
    $sufixos = array(
        "Vencida", "Perdida", "Ativa", "Fugiu", "FugaTentada", "DadoFuga",
        "PikoDefendendo", "InimigoDefendendo", "UltimaAcaoPiko", "UltimaAcaoInimigo"
    );

    foreach ($sufixos as $sufixo)
    {
        unset($_SESSION[chaveBatalha($idCena, $sufixo)]);
    }

    
    if (isset($_SESSION["vidaPikoInicioBatalha"]))
    {
        $_SESSION["vidaPiko"] = $_SESSION["vidaPikoInicioBatalha"];
    }

    unset($_SESSION["batalhaAtual"]);

    
    if ($idCena == 11)
    {
        unset($_SESSION["pontosPikoJokenpo"]);
        unset($_SESSION["pontosVarynJokenpo"]);
        unset($_SESSION["ultimaEscolhaPiko"]);
        unset($_SESSION["ultimaEscolhaVaryn"]);
        unset($_SESSION["ultimoResultadoJokenpo"]);
    }

    return iniciarBatalha($idCena);
}

