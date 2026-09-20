<?php


function atacarInimigo($idCena, $acaoInimigoForcada = null)
{
    $mensagens = array();

    if (batalhaEhJokenpo($idCena))
    {
        $mensagens[] = "Contra Varyn, escolha Pedra, Papel ou Tesoura.";
        return array("vitoria" => false, "derrota" => false, "fuga" => false, "mensagens" => $mensagens);
    }

    if (batalhaEncerrada($idCena))
    {
        $mensagens[] = "Essa batalha ja foi encerrada.";
        return array("vitoria" => batalhaVencida($idCena), "derrota" => false, "fuga" => fugaBemSucedida($idCena), "mensagens" => $mensagens);
    }

    if (batalhaPerdida($idCena))
    {
        $mensagens[] = "Piko foi derrotado. Use Tentar novamente.";
        return array("vitoria" => false, "derrota" => true, "fuga" => false, "mensagens" => $mensagens);
    }

    iniciarBatalha($idCena);
    $_SESSION[chaveBatalha($idCena, "UltimaAcaoPiko")] = "atacar";

    $piko = criarPiko();
    $inimigo = criarInimigo($idCena);
    $piko->setVida($_SESSION["vidaPiko"]);
    $inimigo->setVida($_SESSION["vidaInimigo"]);

    $dano = $piko->getAtaque();

    
    if (inimigoEstaDefendendo($idCena))
    {
        $dano = (int) floor($dano / 2);
        if ($dano < 1) $dano = 1;
        $_SESSION[chaveBatalha($idCena, "InimigoDefendendo")] = false;
        $mensagens[] = $_SESSION["nomeInimigo"] . " estava DEFENDENDO e recebeu somente metade do dano de Piko.";
    }

    
    $inimigo->receberDano($dano);
    $_SESSION["vidaInimigo"] = $inimigo->getVida();
    adicionarPontos(1);

    $mensagens[] = "Turno de Piko.";
    $mensagens[] = "Piko escolheu ATACAR, causou " . $dano . " de dano e ganhou +1 ponto.";

    
    if ($inimigo->estaVivo() == false)
    {
        $_SESSION["vidaInimigo"] = 0;
        $_SESSION[chaveBatalha($idCena, "Vencida")] = true;
        unset($_SESSION[chaveBatalha($idCena, "Perdida")]);
        unset($_SESSION[chaveBatalha($idCena, "Ativa")]);

        pontuarUmaVez("batalha" . $idCena . "Vencida", 20);
        if (ganharPocaoPorBatalha($idCena))
        {
            $mensagens[] = "Recompensa: Piko ganhou +1 POCAO DE VIDA pela vitoria. Total: " . obterQuantidadePocoes() . ".";
        }
        $mensagens[] = "VITORIA! " . $inimigo->getNome() . " foi derrotado. +20 pontos.";
        return array("vitoria" => true, "derrota" => false, "fuga" => false, "mensagens" => $mensagens);
    }

    
    $turnoInimigo = executarTurnoInimigo($idCena, $acaoInimigoForcada);
    $mensagens = array_merge($mensagens, $turnoInimigo["mensagens"]);

    if ($turnoInimigo["derrota"])
    {
        return array("vitoria" => false, "derrota" => true, "fuga" => false, "mensagens" => $mensagens);
    }

    
    $mensagens[] = "Piko: " . $_SESSION["vidaPiko"] . "/" . $_SESSION["vidaPikoMax"] . " HP.";
    $mensagens[] = $_SESSION["nomeInimigo"] . ": " . $_SESSION["vidaInimigo"] . "/" . $_SESSION["vidaInimigoMax"] . " HP.";

    return array("vitoria" => false, "derrota" => false, "fuga" => false, "mensagens" => $mensagens);
}

