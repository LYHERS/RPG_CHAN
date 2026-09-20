<?php



function tentarTrocarCena($destino, $cenas)
{
    if (jogoFoiPerdido())
    {
        return false;
    }

    $destino = (int) $destino;
    $cenaAtual = $cenas[$_SESSION["cenaAtual"]];

    
    if ($cenaAtual->temDesafio())
    {
        if (desafioResolvido($cenaAtual->getId()) == false)
        {
            return false;
        }
    }

    
    if (cenaTemBatalha($cenaAtual->getId()))
    {
        if (batalhaEncerrada($cenaAtual->getId()) == false)
        {
            return false;
        }
    }

    
    if ($cenaAtual->podeIrPara($destino) == false)
    {
        return false;
    }

    if (isset($cenas[$destino]) == false)
    {
        return false;
    }

    $destinoJaVisitado = cenaFoiVisitada($destino);

    
    $_SESSION["cenaAtual"] = $destino;
    registrarCenaVisitada($destino);

    
    if ($destinoJaVisitado == false)
    {
        adicionarPontos(10);
    }

    
    if ($destino == 12 || $destino == 13)
    {
        pontuarUmaVez("final" . $destino, 30);
    }

    return true;
}


function reiniciarJogo()
{
    $_SESSION = array();
    $_SESSION["jogoIniciado"] = false;
    $_SESSION["jogoPerdido"] = false;
    $_SESSION["motivoDerrota"] = "";
    $_SESSION["cenaAtual"] = 1;
    $_SESSION["cenasVisitadas"] = array();
    $_SESSION["pontuacao"] = 0;
    $_SESSION["rankingSalvo"] = false;
    $_SESSION["eventosPontuacao"] = array();
}

