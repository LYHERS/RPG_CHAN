<?php

session_start();
include "mapa.php";

if (!isset($_SESSION["jogoIniciado"]))
{
    $_SESSION["jogoIniciado"] = false;
}

if (!isset($_SESSION["cenaAtual"]))
{
    $_SESSION["cenaAtual"] = 1;
}

if (!isset($_SESSION["cenasVisitadas"]))
{
    $_SESSION["cenasVisitadas"] = array();
}

if (!isset($_SESSION["pontuacao"]))
{
    $_SESSION["pontuacao"] = 0;
}

if (!isset($_SESSION["pocoesVida"]))
{
    $_SESSION["pocoesVida"] = 2;
}

if (!isset($_SESSION["jogoPerdido"]))
{
    $_SESSION["jogoPerdido"] = false;
}

if (!isset($_SESSION["motivoDerrota"]))
{
    $_SESSION["motivoDerrota"] = "";
}

function jogoFoiIniciado()
{
    return $_SESSION["jogoIniciado"] == true;
}

function jogoFoiPerdido()
{
    return $_SESSION["jogoPerdido"] == true;
}

function marcarJogoPerdido($motivo)
{
    $_SESSION["jogoPerdido"] = true;
    $_SESSION["motivoDerrota"] = $motivo;
}

function iniciarJogo()
{
    $_SESSION = array();
    $_SESSION["jogoIniciado"] = true;
    $_SESSION["cenaAtual"] = 1;
    $_SESSION["cenasVisitadas"] = array(1);
    $_SESSION["pontuacao"] = 0;
    $_SESSION["pocoesVida"] = 2;
    $_SESSION["jogoPerdido"] = false;
    $_SESSION["motivoDerrota"] = "";
}

function reiniciarJogo()
{
    $_SESSION = array();
    $_SESSION["jogoIniciado"] = false;
    $_SESSION["cenaAtual"] = 1;
    $_SESSION["cenasVisitadas"] = array();
    $_SESSION["pontuacao"] = 0;
    $_SESSION["pocoesVida"] = 2;
    $_SESSION["jogoPerdido"] = false;
    $_SESSION["motivoDerrota"] = "";
}

function adicionarPontos($pontos)
{
    $_SESSION["pontuacao"] = $_SESSION["pontuacao"] + $pontos;
}

function removerPontos($pontos)
{
    $_SESSION["pontuacao"] = $_SESSION["pontuacao"] - $pontos;

    if ($_SESSION["pontuacao"] < 0)
    {
        $_SESSION["pontuacao"] = 0;
    }
}

function obterPontuacao()
{
    return $_SESSION["pontuacao"];
}

function registrarCenaVisitada($idCena)
{
    if (in_array($idCena, $_SESSION["cenasVisitadas"]) == false)
    {
        $_SESSION["cenasVisitadas"][] = $idCena;
    }
}

function cenaFoiVisitada($idCena)
{
    return in_array($idCena, $_SESSION["cenasVisitadas"]);
}

function desafioResolvido($idCena)
{
    $chave = "desafio" . $idCena . "Resolvido";

    if (isset($_SESSION[$chave]) && $_SESSION[$chave] == true)
    {
        return true;
    }

    return false;
}

function iniciarDueloDados($idCena)
{
    $chave = "desafio" . $idCena . "Ativo";

    if (isset($_SESSION[$chave]))
    {
        return;
    }

    $_SESSION[$chave] = true;
    $_SESSION["desafio" . $idCena . "PontosPiko"] = 0;
    $_SESSION["desafio" . $idCena . "PontosRival"] = 0;
    $_SESSION["desafio" . $idCena . "DadoPiko"] = 0;
    $_SESSION["desafio" . $idCena . "DadoRival"] = 0;
    $_SESSION["desafio" . $idCena . "Mensagem"] = "Quem vencer 2 rodadas primeiro ganha a batalha de dados.";
}

function obterPontosPikoDados($idCena)
{
    return $_SESSION["desafio" . $idCena . "PontosPiko"];
}

function obterPontosRivalDados($idCena)
{
    return $_SESSION["desafio" . $idCena . "PontosRival"];
}

function obterDadoPiko($idCena)
{
    return $_SESSION["desafio" . $idCena . "DadoPiko"];
}

function obterDadoRival($idCena)
{
    return $_SESSION["desafio" . $idCena . "DadoRival"];
}

function obterMensagemDados($idCena)
{
    return $_SESSION["desafio" . $idCena . "Mensagem"];
}

function nomeRivalDados($idCena)
{
    if ($idCena == 6)
    {
        return "Sombra da Caverna";
    }

    return "Guardião da Ponte";
}

function jogarRodadaDados($idCena, $cenas)
{
    iniciarDueloDados($idCena);

    $desafio = $cenas[$idCena]->getDesafio();
    $dadoPiko = $desafio->rolarDado();
    $dadoRival = $desafio->rolarDado();

    $_SESSION["desafio" . $idCena . "DadoPiko"] = $dadoPiko;
    $_SESSION["desafio" . $idCena . "DadoRival"] = $dadoRival;

    if ($dadoPiko > $dadoRival)
    {
        $_SESSION["desafio" . $idCena . "PontosPiko"]++;
        adicionarPontos(10);
        $_SESSION["desafio" . $idCena . "Mensagem"] = "Piko venceu a rodada e ganhou 10 pontos.";
    }
    elseif ($dadoRival > $dadoPiko)
    {
        $_SESSION["desafio" . $idCena . "PontosRival"]++;
        removerPontos(10);
        $_SESSION["desafio" . $idCena . "Mensagem"] = nomeRivalDados($idCena) . " venceu a rodada. Piko perdeu 10 pontos.";
    }
    else
    {
        $_SESSION["desafio" . $idCena . "Mensagem"] = "Empate. Ninguém marcou ponto.";
    }

    if ($_SESSION["desafio" . $idCena . "PontosPiko"] >= 2)
    {
        $_SESSION["desafio" . $idCena . "Resolvido"] = true;
        adicionarPontos(20);
        $_SESSION["desafio" . $idCena . "Mensagem"] = "Piko venceu a melhor de 3 e ganhou mais 20 pontos.";
    }

    if ($_SESSION["desafio" . $idCena . "PontosRival"] >= 2)
    {
        marcarJogoPerdido("Piko perdeu a batalha de dados em " . $cenas[$idCena]->getTitulo() . ".");
    }
}

function tentarTrocarCena($destino, $cenas)
{
    if (jogoFoiPerdido())
    {
        return false;
    }

    $destino = (int) $destino;
    $cenaAtual = $cenas[$_SESSION["cenaAtual"]];

    if ($cenaAtual->temDesafio() && desafioResolvido($cenaAtual->getId()) == false)
    {
        return false;
    }

    if (cenaTemBatalha($cenaAtual->getId()) && batalhaEncerrada($cenaAtual->getId()) == false)
    {
        return false;
    }

    if ($cenaAtual->podeIrPara($destino) == false)
    {
        return false;
    }

    if (!isset($cenas[$destino]))
    {
        return false;
    }

    $novaCena = cenaFoiVisitada($destino) == false;

    $_SESSION["cenaAtual"] = $destino;
    registrarCenaVisitada($destino);

    if ($novaCena)
    {
        adicionarPontos(10);
    }

    if (($destino == 12 || $destino == 13) && !isset($_SESSION["finalPontuado"]))
    {
        $_SESSION["finalPontuado"] = true;
        adicionarPontos(30);
    }

    return true;
}

include "combate.php";
