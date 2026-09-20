<?php



function tentarFugir($idCena, $resultadoD20Forcado = null, $acaoInimigoForcada = null)
{
    $mensagens = array();

    if (batalhaEhJokenpo($idCena))
    {
        $mensagens[] = "Nao e possivel fugir da batalha final contra Varyn.";
        return array("vitoria" => false, "derrota" => false, "fuga" => false, "dado" => null, "mensagens" => $mensagens);
    }

    if (batalhaEncerrada($idCena) || batalhaPerdida($idCena))
    {
        $mensagens[] = "Nao e possivel fugir agora.";
        return array("vitoria" => false, "derrota" => batalhaPerdida($idCena), "fuga" => fugaBemSucedida($idCena), "dado" => obterUltimoDadoFuga($idCena), "mensagens" => $mensagens);
    }

    iniciarBatalha($idCena);

    
    if (fugaJaTentada($idCena))
    {
        $mensagens[] = "A tentativa de fuga desta batalha ja foi usada.";
        return array("vitoria" => false, "derrota" => false, "fuga" => false, "dado" => obterUltimoDadoFuga($idCena), "mensagens" => $mensagens);
    }

    $_SESSION[chaveBatalha($idCena, "FugaTentada")] = true;
    $_SESSION[chaveBatalha($idCena, "UltimaAcaoPiko")] = "fugir";

    
    if ($resultadoD20Forcado !== null)
    {
        $dado = (int) $resultadoD20Forcado;
        if ($dado < 1) $dado = 1;
        if ($dado > 20) $dado = 20;
    }
    else
    {
        $dado = rand(1, 20);
    }

    $_SESSION[chaveBatalha($idCena, "DadoFuga")] = $dado;

    $mensagens[] = "Turno de Piko.";
    $mensagens[] = "Piko tentou FUGIR e rolou 1d20: " . $dado . ".";

    
    if ($dado > 15)
    {
        $_SESSION[chaveBatalha($idCena, "Fugiu")] = true;
        unset($_SESSION[chaveBatalha($idCena, "Ativa")]);
        unset($_SESSION[chaveBatalha($idCena, "Perdida")]);

        pontuarUmaVez("fuga" . $idCena . "Sucesso", 10);
        $mensagens[] = "FUGA BEM-SUCEDIDA! Piko tirou 16 ou mais, escapou e ganhou +10 pontos.";
        return array("vitoria" => false, "derrota" => false, "fuga" => true, "dado" => $dado, "mensagens" => $mensagens);
    }

    
    removerPontos(10);
    $mensagens[] = "A fuga falhou. Era necessario tirar 16 ou mais. Como o dado falhou, Piko perdeu -10 pontos e a tentativa nao pode ser repetida nesta batalha.";

    $turnoInimigo = executarTurnoInimigo($idCena, $acaoInimigoForcada);
    $mensagens = array_merge($mensagens, $turnoInimigo["mensagens"]);

    return array("vitoria" => false, "derrota" => $turnoInimigo["derrota"], "fuga" => false, "dado" => $dado, "mensagens" => $mensagens);
}

