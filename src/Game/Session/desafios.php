<?php





function desafioResolvido($idCena)
{
    $chave = "desafio" . $idCena . "Resolvido";
    return isset($_SESSION[$chave]) && $_SESSION[$chave] == true;
}


function marcarDesafioResolvido($idCena)
{
    $_SESSION["desafio" . $idCena . "Resolvido"] = true;
}


function iniciarDueloDados($idCena)
{
    $chaveAtiva = "desafio" . $idCena . "DueloAtivo";

    if (isset($_SESSION[$chaveAtiva]) && $_SESSION[$chaveAtiva] == true)
    {
        return true;
    }

    $_SESSION[$chaveAtiva] = true;
    $_SESSION["desafio" . $idCena . "PontosPiko"] = 0;
    $_SESSION["desafio" . $idCena . "PontosRival"] = 0;
    $_SESSION["desafio" . $idCena . "UltimoDadoPiko"] = null;
    $_SESSION["desafio" . $idCena . "UltimoDadoRival"] = null;
    $_SESSION["desafio" . $idCena . "UltimoResultado"] = "Melhor de 3: quem vencer 2 rodadas primeiro supera o desafio.";

    return true;
}


function obterPontosPikoDados($idCena)
{
    $chave = "desafio" . $idCena . "PontosPiko";
    return isset($_SESSION[$chave]) ? $_SESSION[$chave] : 0;
}


function obterPontosRivalDados($idCena)
{
    $chave = "desafio" . $idCena . "PontosRival";
    return isset($_SESSION[$chave]) ? $_SESSION[$chave] : 0;
}


function obterUltimoDadoPiko($idCena)
{
    $chave = "desafio" . $idCena . "UltimoDadoPiko";
    return isset($_SESSION[$chave]) ? $_SESSION[$chave] : null;
}


function obterUltimoDadoRival($idCena)
{
    $chave = "desafio" . $idCena . "UltimoDadoRival";
    return isset($_SESSION[$chave]) ? $_SESSION[$chave] : null;
}


function obterUltimoResultadoDados($idCena)
{
    $chave = "desafio" . $idCena . "UltimoResultado";

    if (isset($_SESSION[$chave]))
    {
        return $_SESSION[$chave];
    }

    return "Melhor de 3: quem vencer 2 rodadas primeiro supera o desafio.";
}


function nomeRivalDados($idCena)
{
    if ($idCena == 6)
    {
        return "Sombra da Caverna";
    }

    if ($idCena == 8)
    {
        return "Guardiao da Ponte";
    }

    if ($idCena == 9)
    {
        return "Guarda do Contorno";
    }

    return "Adversario";
}




function jogarRodadaDados($idCena, $cenas, $dadoPikoForcado = null, $dadoRivalForcado = null)
{
    if (!isset($cenas[$idCena]) || $cenas[$idCena]->temDesafio() == false)
    {
        return array("encerrado" => false, "vitoria" => false, "derrota" => false, "empate" => false);
    }

    if (desafioResolvido($idCena) || jogoFoiPerdido())
    {
        return array(
            "encerrado" => true,
            "vitoria" => desafioResolvido($idCena),
            "derrota" => jogoFoiPerdido(),
            "empate" => false
        );
    }

    iniciarDueloDados($idCena);

    $desafio = $cenas[$idCena]->getDesafio();

    
    if ($dadoPikoForcado !== null && $dadoPikoForcado >= 1 && $dadoPikoForcado <= 6)
    {
        $dadoPiko = (int) $dadoPikoForcado;
    }
    else
    {
        $dadoPiko = $desafio->rolarDado();
    }

    if ($dadoRivalForcado !== null && $dadoRivalForcado >= 1 && $dadoRivalForcado <= 6)
    {
        $dadoRival = (int) $dadoRivalForcado;
    }
    else
    {
        $dadoRival = $desafio->rolarDado();
    }

    
    $_SESSION["desafio" . $idCena . "UltimoDadoPiko"] = $dadoPiko;
    $_SESSION["desafio" . $idCena . "UltimoDadoRival"] = $dadoRival;

    $empate = false;

    
    if ($dadoPiko > $dadoRival)
    {
        $_SESSION["desafio" . $idCena . "PontosPiko"]++;
        adicionarPontos(10);
        $_SESSION["desafio" . $idCena . "UltimoResultado"] = "Piko tirou o maior dado e venceu a rodada. +10 pontos.";
    }
    elseif ($dadoRival > $dadoPiko)
    {
        $_SESSION["desafio" . $idCena . "PontosRival"]++;
        removerPontos(10);
        $_SESSION["desafio" . $idCena . "UltimoResultado"] = nomeRivalDados($idCena) . " tirou o maior dado. Piko falhou na rodada e perdeu -10 pontos.";
    }
    else
    {
        $empate = true;
        $_SESSION["desafio" . $idCena . "UltimoResultado"] = "Empate! Os dois tiraram o mesmo valor. Ninguem marcou ponto.";
    }

    
    if (obterPontosPikoDados($idCena) >= 2)
    {
        marcarDesafioResolvido($idCena);
        pontuarUmaVez("desafioDados" . $idCena . "Vencido", 20);
        $_SESSION["desafio" . $idCena . "UltimoResultado"] = "PIKO VENCEU A MELHOR DE 3! +20 pontos de bonus pelo desafio.";

        return array("encerrado" => true, "vitoria" => true, "derrota" => false, "empate" => $empate);
    }

    
    if (obterPontosRivalDados($idCena) >= 2)
    {
        $_SESSION["desafio" . $idCena . "UltimoResultado"] = nomeRivalDados($idCena) . " venceu a melhor de 3.";
        marcarJogoPerdido("Piko perdeu a batalha de dados em " . $cenas[$idCena]->getTitulo() . ". A aventura precisa recomecar.");

        return array("encerrado" => true, "vitoria" => false, "derrota" => true, "empate" => $empate);
    }

    return array("encerrado" => false, "vitoria" => false, "derrota" => false, "empate" => $empate);
}

