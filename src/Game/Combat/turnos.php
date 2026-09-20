<?php




function sortearAcaoInimigo($acaoForcada = null)
{
    if ($acaoForcada == "atacar" || $acaoForcada == "defender")
    {
        return $acaoForcada;
    }

    $sorteio = rand(1, 3);

    if ($sorteio == 3)
    {
        return "defender";
    }

    return "atacar";
}


function executarTurnoInimigo($idCena, $acaoForcada = null)
{
    $mensagens = array();

    
    if (batalhaEhJokenpo($idCena) || batalhaEncerrada($idCena) || batalhaPerdida($idCena))
    {
        return array("derrota" => batalhaPerdida($idCena), "mensagens" => $mensagens);
    }

    $acao = sortearAcaoInimigo($acaoForcada);
    $_SESSION[chaveBatalha($idCena, "UltimaAcaoInimigo")] = $acao;

    $mensagens[] = "Turno de " . $_SESSION["nomeInimigo"] . ".";

    
    if ($acao == "defender")
    {
        $_SESSION[chaveBatalha($idCena, "InimigoDefendendo")] = true;
        $_SESSION[chaveBatalha($idCena, "PikoDefendendo")] = false;
        $mensagens[] = $_SESSION["nomeInimigo"] . " escolheu DEFENDER. O proximo ataque de Piko causara metade do dano.";

        return array("derrota" => false, "mensagens" => $mensagens);
    }

    
    $piko = criarPiko();
    $piko->setVida($_SESSION["vidaPiko"]);

    $dano = $_SESSION["ataqueInimigo"];
    $pikoDefendendo = isset($_SESSION[chaveBatalha($idCena, "PikoDefendendo")]) && $_SESSION[chaveBatalha($idCena, "PikoDefendendo")] == true;

    
    if ($pikoDefendendo)
    {
        $dano = (int) floor($dano / 2);
        if ($dano < 1) $dano = 1;

        
        if (pontuarUmaVez("defesaEficiente" . $idCena, 5))
        {
            $mensagens[] = "Piko estava DEFENDENDO, recebeu metade do dano e ganhou +5 pontos pela primeira defesa eficiente desta batalha.";
        }
        else
        {
            $mensagens[] = "Piko estava DEFENDENDO e recebeu somente metade do dano.";
        }
    }

    
    $piko->receberDano($dano);
    $_SESSION["vidaPiko"] = $piko->getVida();
    $_SESSION[chaveBatalha($idCena, "PikoDefendendo")] = false;

    $mensagens[] = $_SESSION["nomeInimigo"] . " escolheu ATACAR e causou " . $dano . " de dano.";

    
    if ($piko->estaVivo() == false)
    {
        $_SESSION["vidaPiko"] = 0;
        $_SESSION[chaveBatalha($idCena, "Perdida")] = true;
        penalizarUmaVez("derrotaBatalha" . $idCena, 15);
        $mensagens[] = "PIKO FOI DERROTADO! -15 pontos.";

        return array("derrota" => true, "mensagens" => $mensagens);
    }

    return array("derrota" => false, "mensagens" => $mensagens);
}

