<?php




function iniciarJokenpo()
{
    if (isset($_SESSION["batalha11Ativa"]) && $_SESSION["batalha11Ativa"] == true)
    {
        return true;
    }

    $_SESSION["batalha11Ativa"] = true;
    $_SESSION["batalhaAtual"] = 11;
    $_SESSION["pontosPikoJokenpo"] = 0;
    $_SESSION["pontosVarynJokenpo"] = 0;
    $_SESSION["ultimaEscolhaPiko"] = "";
    $_SESSION["ultimaEscolhaVaryn"] = "";
    $_SESSION["ultimoResultadoJokenpo"] = "A batalha final sera decidida no Pedra, Papel e Tesoura. O primeiro a fazer 2 pontos vence.";

    return true;
}


function jogarJokenpo($escolhaPiko, $escolhaVarynForcada = null)
{
    $mensagens = array();
    $opcoes = array("pedra", "papel", "tesoura");

    
    if (batalhaVencida(11))
    {
        $mensagens[] = "Varyn ja foi derrotado.";
        return array("vitoria" => true, "derrota" => false, "mensagens" => $mensagens);
    }

    
    if (batalhaPerdida(11) || jogoFoiPerdido())
    {
        $mensagens[] = "Varyn venceu. A jornada deve recomecar do inicio.";
        return array("vitoria" => false, "derrota" => true, "mensagens" => $mensagens);
    }

    iniciarJokenpo();

    
    if (in_array($escolhaPiko, $opcoes) == false)
    {
        $mensagens[] = "Escolha invalida.";
        return array("vitoria" => false, "derrota" => false, "mensagens" => $mensagens);
    }

    
    if ($escolhaVarynForcada != null && in_array($escolhaVarynForcada, $opcoes))
    {
        $escolhaVaryn = $escolhaVarynForcada;
    }
    else
    {
        $escolhaVaryn = $opcoes[rand(0, 2)];
    }

    $_SESSION["ultimaEscolhaPiko"] = $escolhaPiko;
    $_SESSION["ultimaEscolhaVaryn"] = $escolhaVaryn;

    $resultado = resultadoJokenpo($escolhaPiko, $escolhaVaryn);

    $mensagens[] = "Piko escolheu " . nomeEscolhaJokenpo($escolhaPiko) . ".";
    $mensagens[] = "Varyn escolheu " . nomeEscolhaJokenpo($escolhaVaryn) . ".";

    if ($resultado == "empate")
    {
        removerPontos(10);
        $_SESSION["ultimoResultadoJokenpo"] = "Empate! Ninguem marcou ponto no duelo e Piko perdeu -10 pontos no placar.";
    }
    elseif ($resultado == "piko")
    {
        $_SESSION["pontosPikoJokenpo"]++;
        adicionarPontos(15);
        $_SESSION["ultimoResultadoJokenpo"] = "Piko venceu a rodada, marcou 1 ponto no duelo e ganhou +15 pontos no placar!";
    }
    else
    {
        $_SESSION["pontosVarynJokenpo"]++;
        removerPontos(10);
        $_SESSION["ultimoResultadoJokenpo"] = "Varyn venceu a rodada, marcou 1 ponto e Piko perdeu -10 pontos no placar!";
    }

    $mensagens[] = $_SESSION["ultimoResultadoJokenpo"];

    
    if ($_SESSION["pontosPikoJokenpo"] >= 2)
    {
        $_SESSION["batalha11Vencida"] = true;
        unset($_SESSION["batalha11Perdida"]);
        unset($_SESSION["batalha11Ativa"]);

        pontuarUmaVez("varynVencido", 40);
        if (ganharPocaoPorBatalha(11))
        {
            $mensagens[] = "Recompensa: Piko ganhou +1 POCAO DE VIDA pela vitoria. Total: " . obterQuantidadePocoes() . ".";
        }
        $mensagens[] = "VITORIA! Piko venceu Varyn no Pedra, Papel e Tesoura. +40 pontos de bonus final.";
        return array("vitoria" => true, "derrota" => false, "mensagens" => $mensagens);
    }

    
    if ($_SESSION["pontosVarynJokenpo"] >= 2)
    {
        $_SESSION["batalha11Perdida"] = true;
        unset($_SESSION["batalha11Ativa"]);
        marcarJogoPerdido("Varyn venceu Piko na batalha final. Para tentar novamente, a aventura precisa recomecar desde Valebrook.");
        $mensagens[] = "VARYN VENCEU! A aventura terminou.";
        return array("vitoria" => false, "derrota" => true, "mensagens" => $mensagens);
    }

    $mensagens[] = "Placar: Piko " . $_SESSION["pontosPikoJokenpo"] . " x " . $_SESSION["pontosVarynJokenpo"] . " Varyn.";

    return array("vitoria" => false, "derrota" => false, "mensagens" => $mensagens);
}

