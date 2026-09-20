<?php



function iniciarBatalha($idCena)
{
    if (cenaTemBatalha($idCena) == false || batalhaEncerrada($idCena))
    {
        return false;
    }

    
    if (batalhaEhJokenpo($idCena))
    {
        return iniciarJokenpo();
    }

    $chaveAtiva = chaveBatalha($idCena, "Ativa");

    
    if (isset($_SESSION[$chaveAtiva]) && $_SESSION[$chaveAtiva] == true)
    {
        return true;
    }

    
    $piko = criarPiko();
    $inimigo = criarInimigo($idCena);
    $dados = obterDadosInimigo($idCena);

    
    $_SESSION[$chaveAtiva] = true;
    $_SESSION["batalhaAtual"] = $idCena;

    
    
    if (!isset($_SESSION["vidaPiko"]) || $_SESSION["vidaPiko"] <= 0)
    {
        $_SESSION["vidaPiko"] = $piko->getVida();
    }
    $_SESSION["vidaPikoMax"] = $piko->getVidaMaxima();
    $_SESSION["vidaPikoInicioBatalha"] = $_SESSION["vidaPiko"];
    $_SESSION["ataquePiko"] = $piko->getAtaque();
    $_SESSION["nivelPiko"] = 10;

    
    $_SESSION["vidaInimigo"] = $inimigo->getVida();
    $_SESSION["vidaInimigoMax"] = $inimigo->getVidaMaxima();
    $_SESSION["ataqueInimigo"] = $inimigo->getAtaque();
    $_SESSION["nomeInimigo"] = $inimigo->getNome();
    $_SESSION["nivelInimigo"] = $dados["nivel"];

    
    $_SESSION[chaveBatalha($idCena, "PikoDefendendo")] = false;
    $_SESSION[chaveBatalha($idCena, "InimigoDefendendo")] = false;
    $_SESSION[chaveBatalha($idCena, "FugaTentada")] = false;
    unset($_SESSION[chaveBatalha($idCena, "DadoFuga")]);
    $_SESSION[chaveBatalha($idCena, "UltimaAcaoPiko")] = "";
    $_SESSION[chaveBatalha($idCena, "UltimaAcaoInimigo")] = "";

    return true;
}

