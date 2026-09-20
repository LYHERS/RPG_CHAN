<?php

include "Model/Personagem.php";

function listarSpritesMonstros()
{
    return array(
        "Dog.png",
        "Gnome.png",
        "Goblin.png",
        "Nevoa.png",
        "Planta.png",
        "bruxa.png",
        "dragao.png",
        "frieza.png",
        "gosma.png",
        "king von.gif",
        "neggysprites.png",
        "speedsprites3.png",
        "trump.gif",
        "zombie.png"
    );
}

function sortearSpriteMonstro($idCena)
{
    $chave = "spriteMonstro" . $idCena;

    if (isset($_SESSION[$chave]))
    {
        return $_SESSION[$chave];
    }

    $monstros = listarSpritesMonstros();
    $disponiveis = array();

    foreach ($monstros as $monstro)
    {
        $arquivo = dirname(__DIR__) . "/Images/monstros/" . $monstro;

        if (file_exists($arquivo))
        {
            $disponiveis[] = $monstro;
        }
    }

    if (count($disponiveis) == 0)
    {
        return "";
    }

    $posicao = rand(0, count($disponiveis) - 1);
    $_SESSION[$chave] = $disponiveis[$posicao];

    return $_SESSION[$chave];
}

function caminhoSpriteMonstro($idCena)
{
    $arquivo = sortearSpriteMonstro($idCena);

    if ($arquivo == "")
    {
        return "";
    }

    return "../Images/monstros/" . $arquivo;
}

function spriteMonstroEhGif($idCena)
{
    $arquivo = sortearSpriteMonstro($idCena);

    if ($arquivo == "")
    {
        return false;
    }

    return strtolower(substr($arquivo, -4)) == ".gif";
}

function caminhoSpritePiko()
{
    return "../Images/MAIN CHARACTER/PIKO.png";
}

function caminhoSpritePiko2()
{
    return "../Images/MAIN CHARACTER/Piko2.png";
}

function caminhoSpriteVaryn()
{
    return "../Images/monstros/Boss.png";
}

function caminhoPedra()
{
    return "../Images/MAIN CHARACTER/Arkan.png";
}

function caminhoMapaBeta()
{
    return "../Images/MAIN CHARACTER/mapabeta2.png";
}

function obterBatalhas()
{
    return array(
        14 => array("nome" => "Mãe de Piko", "vida" => 55, "ataque" => 14),
        4 => array("nome" => "Inimigo da Floresta", "vida" => 80, "ataque" => 18),
        6 => array("nome" => "Inimigo da Caverna", "vida" => 90, "ataque" => 20),
        8 => array("nome" => "Guardião da Ponte", "vida" => 110, "ataque" => 22),
        11 => array("nome" => "Varyn", "vida" => 120, "ataque" => 18)
    );
}

function cenaTemBatalha($idCena)
{
    $batalhas = obterBatalhas();
    return isset($batalhas[$idCena]);
}

function batalhaVencida($idCena)
{
    $chave = "batalha" . $idCena . "Vencida";
    return isset($_SESSION[$chave]) && $_SESSION[$chave] == true;
}

function batalhaPerdida($idCena)
{
    $chave = "batalha" . $idCena . "Perdida";
    return isset($_SESSION[$chave]) && $_SESSION[$chave] == true;
}

function fugaBemSucedida($idCena)
{
    $chave = "batalha" . $idCena . "Fugiu";
    return isset($_SESSION[$chave]) && $_SESSION[$chave] == true;
}

function batalhaEncerrada($idCena)
{
    return batalhaVencida($idCena) || fugaBemSucedida($idCena);
}

function fugaJaTentada($idCena)
{
    $chave = "batalha" . $idCena . "FugaTentada";
    return isset($_SESSION[$chave]) && $_SESSION[$chave] == true;
}

function obterUltimoDadoFuga($idCena)
{
    $chave = "batalha" . $idCena . "DadoFuga";

    if (isset($_SESSION[$chave]))
    {
        return $_SESSION[$chave];
    }

    return 0;
}

function inimigoEstaDefendendo($idCena)
{
    $chave = "batalha" . $idCena . "InimigoDefendendo";
    return isset($_SESSION[$chave]) && $_SESSION[$chave] == true;
}

function criarPiko()
{
    return new Personagem("Piko", 100, 100, 24, "");
}

function criarInimigo($idCena)
{
    $batalhas = obterBatalhas();

    if (!isset($batalhas[$idCena]))
    {
        return null;
    }

    $dados = $batalhas[$idCena];
    return new Personagem($dados["nome"], $dados["vida"], $dados["vida"], $dados["ataque"], "");
}

function obterQuantidadePocoes()
{
    return $_SESSION["pocoesVida"];
}

function iniciarBatalha($idCena)
{
    if (!cenaTemBatalha($idCena) || batalhaEncerrada($idCena))
    {
        return;
    }

    if ($idCena == 11)
    {
        if (!isset($_SESSION["batalha11Ativa"]))
        {
            $_SESSION["batalha11Ativa"] = true;
            $_SESSION["pontosPikoJokenpo"] = 0;
            $_SESSION["pontosVarynJokenpo"] = 0;
            $_SESSION["ultimaEscolhaPiko"] = "";
            $_SESSION["ultimaEscolhaVaryn"] = "";
            $_SESSION["ultimoResultadoJokenpo"] = "Primeiro a vencer 2 rodadas ganha.";
        }

        return;
    }

    $chaveAtiva = "batalha" . $idCena . "Ativa";

    if (isset($_SESSION[$chaveAtiva]) && $_SESSION[$chaveAtiva] == true)
    {
        return;
    }

    $piko = criarPiko();
    $inimigo = criarInimigo($idCena);

    $_SESSION[$chaveAtiva] = true;
    $_SESSION["vidaPiko"] = $piko->getVida();
    $_SESSION["vidaPikoMax"] = $piko->getVidaMaxima();
    $_SESSION["ataquePiko"] = $piko->getAtaque();
    $_SESSION["vidaInimigo"] = $inimigo->getVida();
    $_SESSION["vidaInimigoMax"] = $inimigo->getVidaMaxima();
    $_SESSION["ataqueInimigo"] = $inimigo->getAtaque();
    $_SESSION["nomeInimigo"] = $inimigo->getNome();
    $_SESSION["batalha" . $idCena . "InimigoDefendendo"] = false;
    $_SESSION["batalha" . $idCena . "FugaTentada"] = false;
    $_SESSION["batalha" . $idCena . "DefesaPontuada"] = false;
}

function sortearAcaoInimigo()
{
    $numero = rand(1, 3);

    if ($numero == 1)
    {
        return "defender";
    }

    return "atacar";
}

function turnoInimigo($idCena, $pikoDefendendo)
{
    $mensagens = array();
    $acao = sortearAcaoInimigo();

    if ($acao == "defender")
    {
        $_SESSION["batalha" . $idCena . "InimigoDefendendo"] = true;
        $mensagens[] = $_SESSION["nomeInimigo"] . " escolheu DEFENDER.";
        return $mensagens;
    }

    $dano = $_SESSION["ataqueInimigo"];

    if ($pikoDefendendo)
    {
        $dano = floor($dano / 2);
        $mensagens[] = "Piko defendeu e recebeu metade do dano.";

        if ($_SESSION["batalha" . $idCena . "DefesaPontuada"] == false)
        {
            $_SESSION["batalha" . $idCena . "DefesaPontuada"] = true;
            adicionarPontos(5);
            $mensagens[] = "Defesa eficiente: +5 pontos.";
        }
    }

    $_SESSION["vidaPiko"] = $_SESSION["vidaPiko"] - $dano;

    if ($_SESSION["vidaPiko"] < 0)
    {
        $_SESSION["vidaPiko"] = 0;
    }

    $mensagens[] = $_SESSION["nomeInimigo"] . " atacou e causou " . $dano . " de dano.";

    if ($_SESSION["vidaPiko"] <= 0)
    {
        $_SESSION["batalha" . $idCena . "Perdida"] = true;
        removerPontos(15);
        $mensagens[] = "Piko foi derrotado e perdeu 15 pontos.";
    }

    return $mensagens;
}

function atacarInimigo($idCena)
{
    $mensagens = array();
    adicionarPontos(1);

    $dano = $_SESSION["ataquePiko"];

    if (inimigoEstaDefendendo($idCena))
    {
        $dano = floor($dano / 2);
        $_SESSION["batalha" . $idCena . "InimigoDefendendo"] = false;
        $mensagens[] = $_SESSION["nomeInimigo"] . " estava defendendo e recebeu metade do dano.";
    }

    $_SESSION["vidaInimigo"] = $_SESSION["vidaInimigo"] - $dano;

    if ($_SESSION["vidaInimigo"] < 0)
    {
        $_SESSION["vidaInimigo"] = 0;
    }

    $mensagens[] = "Piko atacou e causou " . $dano . " de dano. +1 ponto.";

    if ($_SESSION["vidaInimigo"] <= 0)
    {
        $_SESSION["batalha" . $idCena . "Vencida"] = true;
        unset($_SESSION["batalha" . $idCena . "Ativa"]);
        adicionarPontos(20);
        $mensagens[] = "Vitória! +20 pontos.";
        return $mensagens;
    }

    $mensagensInimigo = turnoInimigo($idCena, false);

    foreach ($mensagensInimigo as $mensagem)
    {
        $mensagens[] = $mensagem;
    }

    return $mensagens;
}

function defenderPiko($idCena)
{
    $mensagens = array();
    $mensagens[] = "Piko escolheu DEFENDER.";

    $mensagensInimigo = turnoInimigo($idCena, true);

    foreach ($mensagensInimigo as $mensagem)
    {
        $mensagens[] = $mensagem;
    }

    return $mensagens;
}

function usarPocaoVida($idCena)
{
    $mensagens = array();

    if ($_SESSION["pocoesVida"] <= 0)
    {
        $mensagens[] = "Piko não tem mais poções.";
        return $mensagens;
    }

    if ($_SESSION["vidaPiko"] >= $_SESSION["vidaPikoMax"])
    {
        $mensagens[] = "A vida de Piko já está cheia.";
        return $mensagens;
    }

    $_SESSION["pocoesVida"]--;
    $_SESSION["vidaPiko"] = $_SESSION["vidaPiko"] + 40;

    if ($_SESSION["vidaPiko"] > $_SESSION["vidaPikoMax"])
    {
        $_SESSION["vidaPiko"] = $_SESSION["vidaPikoMax"];
    }

    removerPontos(5);
    $mensagens[] = "Piko usou uma Poção de Vida e recuperou até 40 HP. -5 pontos.";

    $mensagensInimigo = turnoInimigo($idCena, false);

    foreach ($mensagensInimigo as $mensagem)
    {
        $mensagens[] = $mensagem;
    }

    return $mensagens;
}

function tentarFugir($idCena)
{
    $mensagens = array();

    if (fugaJaTentada($idCena))
    {
        $mensagens[] = "A fuga já foi tentada nesta batalha.";
        return $mensagens;
    }

    $_SESSION["batalha" . $idCena . "FugaTentada"] = true;
    $dado = rand(1, 20);
    $_SESSION["batalha" . $idCena . "DadoFuga"] = $dado;

    $mensagens[] = "Piko rolou 1d20 e tirou " . $dado . ".";

    if ($dado >= 16)
    {
        $_SESSION["batalha" . $idCena . "Fugiu"] = true;
        unset($_SESSION["batalha" . $idCena . "Ativa"]);
        adicionarPontos(10);
        $mensagens[] = "Piko conseguiu fugir. +10 pontos.";
        return $mensagens;
    }

    removerPontos(10);
    $mensagens[] = "A fuga falhou. -10 pontos.";

    $mensagensInimigo = turnoInimigo($idCena, false);

    foreach ($mensagensInimigo as $mensagem)
    {
        $mensagens[] = $mensagem;
    }

    return $mensagens;
}

function reiniciarBatalha($idCena)
{
    unset($_SESSION["batalha" . $idCena . "Vencida"]);
    unset($_SESSION["batalha" . $idCena . "Perdida"]);
    unset($_SESSION["batalha" . $idCena . "Fugiu"]);
    unset($_SESSION["batalha" . $idCena . "Ativa"]);
    unset($_SESSION["batalha" . $idCena . "FugaTentada"]);
    unset($_SESSION["batalha" . $idCena . "DadoFuga"]);
    unset($_SESSION["batalha" . $idCena . "InimigoDefendendo"]);
    unset($_SESSION["batalha" . $idCena . "DefesaPontuada"]);
    unset($_SESSION["spriteMonstro" . $idCena]);

    iniciarBatalha($idCena);
}

function nomeJokenpo($escolha)
{
    if ($escolha == "pedra") return "Pedra";
    if ($escolha == "papel") return "Papel";
    return "Tesoura";
}

function jogarJokenpo($escolhaPiko)
{
    $opcoes = array("pedra", "papel", "tesoura");
    $mensagens = array();

    if (!in_array($escolhaPiko, $opcoes))
    {
        return $mensagens;
    }

    $escolhaVaryn = $opcoes[rand(0, 2)];
    $_SESSION["ultimaEscolhaPiko"] = $escolhaPiko;
    $_SESSION["ultimaEscolhaVaryn"] = $escolhaVaryn;

    $mensagens[] = "Piko escolheu " . nomeJokenpo($escolhaPiko) . ".";
    $mensagens[] = "Varyn escolheu " . nomeJokenpo($escolhaVaryn) . ".";

    if ($escolhaPiko == $escolhaVaryn)
    {
        removerPontos(10);
        $_SESSION["ultimoResultadoJokenpo"] = "Empate. Piko perdeu 10 pontos.";
    }
    elseif (
        ($escolhaPiko == "pedra" && $escolhaVaryn == "tesoura") ||
        ($escolhaPiko == "papel" && $escolhaVaryn == "pedra") ||
        ($escolhaPiko == "tesoura" && $escolhaVaryn == "papel")
    )
    {
        $_SESSION["pontosPikoJokenpo"]++;
        adicionarPontos(15);
        $_SESSION["ultimoResultadoJokenpo"] = "Piko venceu a rodada. +15 pontos.";
    }
    else
    {
        $_SESSION["pontosVarynJokenpo"]++;
        removerPontos(10);
        $_SESSION["ultimoResultadoJokenpo"] = "Varyn venceu a rodada. Piko perdeu 10 pontos.";
    }

    $mensagens[] = $_SESSION["ultimoResultadoJokenpo"];

    if ($_SESSION["pontosPikoJokenpo"] >= 2)
    {
        $_SESSION["batalha11Vencida"] = true;
        adicionarPontos(40);
        $mensagens[] = "Piko derrotou Varyn. +40 pontos.";
    }

    if ($_SESSION["pontosVarynJokenpo"] >= 2)
    {
        $_SESSION["batalha11Perdida"] = true;
        marcarJogoPerdido("Varyn venceu a melhor de 3. A aventura deve recomeçar desde Valebrook.");
        $mensagens[] = "Varyn venceu a batalha final.";
    }

    return $mensagens;
}
