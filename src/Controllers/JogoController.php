<?php

function processarAcoesDoJogo($cenas)
{
    $mensagensBatalha = array();
    $acabouDeVencer = false;
    $acabouDeFugir = false;

    if (isset($_POST["iniciarJogo"])) {
        iniciarJogo();
    }

    if (isset($_POST["salvarRanking"])) {
        salvarPontuacaoRanking(
            isset($_POST["nomeRanking"]) ? $_POST["nomeRanking"] : "",
            obterPontuacao()
        );
    }

    if (isset($_POST["novoJogo"])) {
        reiniciarJogo();

        return array(
            "mensagensBatalha" => array(),
            "acabouDeVencer" => false,
            "acabouDeFugir" => false
        );
    }

    if (!jogoFoiIniciado()) {
        return array(
            "mensagensBatalha" => $mensagensBatalha,
            "acabouDeVencer" => false,
            "acabouDeFugir" => false
        );
    }

    registrarCenaVisitada($_SESSION["cenaAtual"]);

    if (isset($_POST["destino"])) {
        tentarTrocarCena($_POST["destino"], $cenas);
    }

    $idCenaAtual = $_SESSION["cenaAtual"];
    $cenaAtual = $cenas[$idCenaAtual];

    $desafioPendente = false;

    if ($cenaAtual->temDesafio() && !desafioResolvido($idCenaAtual)) {
        $desafioPendente = true;
        iniciarDueloDados($idCenaAtual);
    }

    if (
        isset($_POST["jogarDado"]) &&
        $desafioPendente &&
        !jogoFoiPerdido()
    ) {
        $resultadoDados = jogarRodadaDados(
            $idCenaAtual,
            $cenas
        );

        if ($resultadoDados["vitoria"]) {
            $desafioPendente = false;
        }
    }

    $temBatalha = cenaTemBatalha($idCenaAtual);

    if (
        $temBatalha &&
        !$desafioPendente &&
        !batalhaEncerrada($idCenaAtual)
    ) {
        iniciarBatalha($idCenaAtual);

        if (isset($_POST["reiniciarBatalha"])) {

            reiniciarBatalha($idCenaAtual);

            $mensagensBatalha[] = "A batalha foi reiniciada.";

        } elseif (
            $idCenaAtual == 11 &&
            isset($_POST["escolhaJokenpo"])
        ) {

            $resultadoAtaque = jogarJokenpo(
                $_POST["escolhaJokenpo"]
            );

            $mensagensBatalha = $resultadoAtaque["mensagens"];

            if ($resultadoAtaque["vitoria"]) {
                $acabouDeVencer = true;
            }

        } elseif (isset($_POST["atacarInimigo"])) {

            $resultadoAtaque = atacarInimigo($idCenaAtual);

            $mensagensBatalha = $resultadoAtaque["mensagens"];

            if ($resultadoAtaque["vitoria"]) {
                $acabouDeVencer = true;
            }

        } elseif (isset($_POST["defenderPiko"])) {

            $resultadoAtaque = defenderPiko($idCenaAtual);

            $mensagensBatalha = $resultadoAtaque["mensagens"];

        } elseif (isset($_POST["usarPocao"])) {

            $resultadoAtaque = usarPocaoVida($idCenaAtual);

            $mensagensBatalha = $resultadoAtaque["mensagens"];

        } elseif (isset($_POST["tentarFugir"])) {

            $resultadoAtaque = tentarFugir($idCenaAtual);

            $mensagensBatalha = $resultadoAtaque["mensagens"];

            if ($resultadoAtaque["fuga"]) {
                $acabouDeFugir = true;
            }

        } else {

            if (!batalhaPerdida($idCenaAtual)) {

                $mensagensBatalha[] =
                    "Um inimigo apareceu: " .
                    $_SESSION["nomeInimigo"] .
                    ".";

                $mensagensBatalha[] =
                    "Escolha sua ação. Depois disso, o inimigo escolherá aleatoriamente ATACAR ou DEFENDER.";

                $mensagensBatalha[] =
                    "FUGIR usa 1d20, funciona somente com 16 ou mais e pode ser tentado uma única vez por batalha.";
            }
        }
    }

    return array(
        "mensagensBatalha" => $mensagensBatalha,
        "acabouDeVencer" => $acabouDeVencer,
        "acabouDeFugir" => $acabouDeFugir
    );
}