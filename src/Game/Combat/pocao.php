<?php


function usarPocaoVida($idCena, $acaoInimigoForcada = null)
{
    $mensagens = array();

    if (batalhaEhJokenpo($idCena) || batalhaEncerrada($idCena) || batalhaPerdida($idCena))
    {
        $mensagens[] = "Nao e possivel usar pocao agora.";
        return array("vitoria" => false, "derrota" => batalhaPerdida($idCena), "fuga" => false, "mensagens" => $mensagens);
    }

    iniciarBatalha($idCena);

    
    if (obterQuantidadePocoes() <= 0)
    {
        $mensagens[] = "Piko nao tem mais pocoes de vida.";
        return array("vitoria" => false, "derrota" => false, "fuga" => false, "mensagens" => $mensagens);
    }

    
    if ($_SESSION["vidaPiko"] >= $_SESSION["vidaPikoMax"])
    {
        $mensagens[] = "A vida de Piko ja esta cheia. A pocao nao foi gasta.";
        return array("vitoria" => false, "derrota" => false, "fuga" => false, "mensagens" => $mensagens);
    }

    $_SESSION[chaveBatalha($idCena, "UltimaAcaoPiko")] = "pocao";

    
    $vidaAntes = $_SESSION["vidaPiko"];
    $cura = (int) ceil($_SESSION["vidaPikoMax"] * 0.40);
    $novaVida = $vidaAntes + $cura;

    if ($novaVida > $_SESSION["vidaPikoMax"])
    {
        $novaVida = $_SESSION["vidaPikoMax"];
    }

    $_SESSION["vidaPiko"] = $novaVida;
    $_SESSION["pocoesVida"]--;
    removerPontos(5);
    $curado = $novaVida - $vidaAntes;

    $mensagens[] = "Turno de Piko.";
    $mensagens[] = "Piko usou uma POCAO DE VIDA, recuperou " . $curado . " HP (40% da vida maxima) e perdeu -5 pontos.";
    $mensagens[] = "Pocoes restantes: " . $_SESSION["pocoesVida"] . ".";

    
    $turnoInimigo = executarTurnoInimigo($idCena, $acaoInimigoForcada);
    $mensagens = array_merge($mensagens, $turnoInimigo["mensagens"]);

    return array("vitoria" => false, "derrota" => $turnoInimigo["derrota"], "fuga" => false, "mensagens" => $mensagens);
}

