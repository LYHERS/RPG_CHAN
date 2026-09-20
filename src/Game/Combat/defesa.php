<?php


function defenderPiko($idCena, $acaoInimigoForcada = null)
{
    $mensagens = array();

    if (batalhaEhJokenpo($idCena) || batalhaEncerrada($idCena) || batalhaPerdida($idCena))
    {
        $mensagens[] = "Nao e possivel defender agora.";
        return array("vitoria" => false, "derrota" => batalhaPerdida($idCena), "fuga" => false, "mensagens" => $mensagens);
    }

    iniciarBatalha($idCena);

    
    $_SESSION[chaveBatalha($idCena, "UltimaAcaoPiko")] = "defender";
    $_SESSION[chaveBatalha($idCena, "PikoDefendendo")] = true;

    $mensagens[] = "Turno de Piko.";
    $mensagens[] = "Piko escolheu DEFENDER. Se o inimigo atacar agora, o dano sera reduzido pela metade.";

    
    $turnoInimigo = executarTurnoInimigo($idCena, $acaoInimigoForcada);
    $mensagens = array_merge($mensagens, $turnoInimigo["mensagens"]);

    if ($turnoInimigo["derrota"])
    {
        return array("vitoria" => false, "derrota" => true, "fuga" => false, "mensagens" => $mensagens);
    }

    $mensagens[] = "Piko: " . $_SESSION["vidaPiko"] . "/" . $_SESSION["vidaPikoMax"] . " HP.";

    return array("vitoria" => false, "derrota" => false, "fuga" => false, "mensagens" => $mensagens);
}

