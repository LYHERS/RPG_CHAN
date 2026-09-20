<?php

session_save_path("/tmp");
session_id("rpgchan-teste-melhor-de-3");
include_once __DIR__ . "/../src/Game/sessao.php";

$_SESSION = array();
$_SESSION["jogoIniciado"] = false;
$_SESSION["jogoPerdido"] = false;
$_SESSION["motivoDerrota"] = "";
$_SESSION["cenaAtual"] = 1;
$_SESSION["cenasVisitadas"] = array();

$falhas = 0;

function testar($condicao, $nome)
{
    global $falhas;

    if ($condicao)
    {
        echo "OK - " . $nome . PHP_EOL;
    }
    else
    {
        echo "FALHOU - " . $nome . PHP_EOL;
        $falhas++;
    }
}

testar(count($cenas) == 14, "Mapa possui 14 cenas");
testar(jogoFoiIniciado() == false, "Jogo comeca na tela inicial");

iniciarJogo();
testar(jogoFoiIniciado() == true, "Botao iniciar ativa o jogo");
testar($_SESSION["cenaAtual"] == 1, "Jogo inicia na Cena 1");
testar(cenaFoiVisitada(1) == true, "Cena 1 aparece no mapa ao iniciar");
testar(obterQuantidadePocoes() == 2, "Piko inicia a jornada com 2 pocoes");
testar(obterPontuacao() == 0, "Placar inicia em zero");


testar(tentarTrocarCena(14, $cenas) == true, "Cena 1 permite seguir para Cena 14");
testar(obterPontuacao() == 10, "Descobrir uma nova cena rende +10 pontos");

reiniciarJogo();
iniciarJogo();
testar(obterPontuacao() == 0, "Recomecar zera a pontuacao");


$_SESSION["cenaAtual"] = 6;
registrarCenaVisitada(6);
iniciarDueloDados(6);
$resultado = jogarRodadaDados(6, $cenas, 6, 2);
testar(obterPontosPikoDados(6) == 1, "Piko marca ponto quando tira dado maior");
testar(obterPontosRivalDados(6) == 0, "Rival nao marca ponto quando tira dado menor");
testar($resultado["encerrado"] == false, "Primeira vitoria ainda nao encerra a melhor de 3");

$resultado = jogarRodadaDados(6, $cenas, 5, 1);
testar(obterPontosPikoDados(6) == 2, "Piko chega a 2 pontos");
testar(desafioResolvido(6) == true, "Piko vence a batalha de dados ao ganhar 2 rodadas");
testar($resultado["vitoria"] == true, "Resultado informa vitoria na melhor de 3");
testar(obterPontuacao() == 40, "Duas rodadas de dados (+20) e bonus do desafio (+20) totalizam 40 pontos");


reiniciarJogo();
iniciarJogo();
$_SESSION["cenaAtual"] = 8;
registrarCenaVisitada(8);
iniciarDueloDados(8);
$resultado = jogarRodadaDados(8, $cenas, 4, 4);
testar($resultado["empate"] == true, "Dados iguais geram empate");
testar(obterPontosPikoDados(8) == 0 && obterPontosRivalDados(8) == 0, "Empate nao marca ponto");


adicionarPontos(30);
$pontosAntesFalhaDado = obterPontuacao();
jogarRodadaDados(8, $cenas, 1, 6);
testar(obterPontuacao() == $pontosAntesFalhaDado - 10, "Falhar uma rodada de dados custa 10 pontos");
$resultado = jogarRodadaDados(8, $cenas, 2, 5);
testar(obterPontuacao() == $pontosAntesFalhaDado - 20, "Cada nova falha nos dados custa mais 10 pontos");
testar(obterPontosRivalDados(8) == 2, "Rival chega a 2 pontos");
testar($resultado["derrota"] == true, "Resultado informa derrota na batalha de dados");
testar(jogoFoiPerdido() == true, "Perder a melhor de 3 nos dados encerra a jornada");


reiniciarJogo();
iniciarJogo();
testar(jogoFoiPerdido() == false, "Recomecar limpa a derrota total");
testar(obterQuantidadePocoes() == 2, "Recomecar devolve as 2 pocoes");


$_SESSION["cenaAtual"] = 14;
registrarCenaVisitada(14);
iniciarBatalha(14);
$vidaAntes = $_SESSION["vidaPiko"];
defenderPiko(14, "atacar");
testar($_SESSION["vidaPiko"] == $vidaAntes - 7, "Defender reduz ataque 14 da Mae para 7");
testar(obterPontuacao() == 5, "Primeira defesa eficiente da batalha rende +5 pontos");


reiniciarBatalha(14);
$vidaInimigoAntes = $_SESSION["vidaInimigo"];
atacarInimigo(14, "defender");
testar($_SESSION["vidaInimigo"] == $vidaInimigoAntes - 24, "Ataque normal de Piko causa 24");
testar(obterPontuacao() == 6, "Atacar rende +1 ponto");
testar(inimigoEstaDefendendo(14) == true, "Inimigo pode escolher Defender");
$vidaDepoisPrimeiroAtaque = $_SESSION["vidaInimigo"];
atacarInimigo(14, "atacar");
testar($_SESSION["vidaInimigo"] == $vidaDepoisPrimeiroAtaque - 12, "Defesa do inimigo reduz ataque 24 para 12");


reiniciarBatalha(14);
$_SESSION["vidaPiko"] = 50;
$pocoesAntes = obterQuantidadePocoes();
$pontosAntesPocao = obterPontuacao();
usarPocaoVida(14, "defender");
testar($_SESSION["vidaPiko"] == 90, "Pocao recupera 40% da vida maxima");
testar(obterQuantidadePocoes() == $pocoesAntes - 1, "Usar pocao reduz o estoque em 1");
testar(obterPontuacao() == max(0, $pontosAntesPocao - 5), "Usar pocao custa 5 pontos");


reiniciarBatalha(14);
$vidaAntesFuga = $_SESSION["vidaPiko"];
adicionarPontos(20);
$pontosAntesFugaFalha = obterPontuacao();
$resultadoFugaFalha = tentarFugir(14, 15, "atacar");
testar($resultadoFugaFalha["fuga"] == false, "Fuga falha com 15");
testar(fugaJaTentada(14) == true, "Fuga fica marcada como usada");
testar(obterPontuacao() == $pontosAntesFugaFalha - 10, "Falhar o 1d20 da fuga custa 10 pontos");
testar($_SESSION["vidaPiko"] == $vidaAntesFuga - 14, "Fuga falha e inimigo recebe turno");
$resultadoSegundaFuga = tentarFugir(14, 20, "atacar");
testar($resultadoSegundaFuga["fuga"] == false, "Nao existe segunda tentativa de fuga na mesma batalha");

reiniciarBatalha(14);
$pontosAntesFugaSucesso = obterPontuacao();
$resultadoFugaSucesso = tentarFugir(14, 16, "atacar");
testar($resultadoFugaSucesso["fuga"] == true, "Fuga funciona com 16");
testar(batalhaEncerrada(14) == true, "Fuga bem-sucedida encerra batalha");
testar(obterPontuacao() == $pontosAntesFugaSucesso + 10, "Fuga bem-sucedida rende +10 pontos");


reiniciarJogo();
iniciarJogo();
$_SESSION["cenaAtual"] = 7;
registrarCenaVisitada(7);
testar(tentarTrocarCena(9, $cenas) == true, "Cena 7 permite seguir para o Contorno");
testar($cenas[9]->temDesafio() == true, "Contorno possui uma batalha de dados");
testar(nomeRivalDados(9) == "Guarda do Contorno", "Contorno possui rival proprio nos dados");
iniciarDueloDados(9);
jogarRodadaDados(9, $cenas, 6, 1);
jogarRodadaDados(9, $cenas, 5, 2);
testar(desafioResolvido(9) == true, "Contorno aceita vitoria na melhor de 3");


reiniciarJogo();
iniciarJogo();
$_SESSION["cenaAtual"] = 14;
registrarCenaVisitada(14);
iniciarBatalha(14);
$_SESSION["vidaPiko"] = 73;
$_SESSION["batalha14Vencida"] = true;
unset($_SESSION["batalha14Ativa"]);
$_SESSION["cenaAtual"] = 4;
iniciarBatalha(4);
testar($_SESSION["vidaPiko"] == 73, "Vida de Piko continua entre batalhas");


reiniciarJogo();
iniciarJogo();
$_SESSION["cenaAtual"] = 14;
registrarCenaVisitada(14);
iniciarBatalha(14);
$_SESSION["vidaInimigo"] = 1;
$pocoesAntesVitoria = obterQuantidadePocoes();
$resultadoVitoriaPocao = atacarInimigo(14, "defender");
testar($resultadoVitoriaPocao["vitoria"] == true, "Vitoria normal encerra a batalha");
testar(obterQuantidadePocoes() == $pocoesAntesVitoria + 1, "Vitoria concede 1 pocao");
atacarInimigo(14, "defender");
testar(obterQuantidadePocoes() == $pocoesAntesVitoria + 1, "Repetir a vitoria nao duplica a pocao");


$acoesValidas = true;
for ($i = 0; $i < 60; $i++)
{
    $acao = sortearAcaoInimigo();
    if ($acao != "atacar" && $acao != "defender")
    {
        $acoesValidas = false;
    }
}
testar($acoesValidas, "Inimigo sorteia apenas Atacar ou Defender");


$dadoTeste = new Dado(6);
$dadoValido = true;
$resultados = array();
for ($i = 0; $i < 40; $i++)
{
    $valor = $dadoTeste->rolar();
    $resultados[] = $valor;
    if ($valor < 1 || $valor > 6) $dadoValido = false;
}
testar($dadoValido, "Dado da batalha fica entre 1 e 6");
testar(count(array_unique($resultados)) > 1, "Dado gera resultados variados");


reiniciarJogo();
iniciarJogo();
$_SESSION["cenaAtual"] = 6;
registrarCenaVisitada(6);
jogarRodadaDados(6, $cenas, 6, 1);
jogarRodadaDados(6, $cenas, 5, 2);
testar(desafioResolvido(6) == true, "Cena 6 exige e aceita vitoria melhor de 3 nos dados");
iniciarBatalha(6);
$contador = 0;
while (batalhaEncerrada(6) == false && batalhaPerdida(6) == false && $contador < 10)
{
    atacarInimigo(6, "atacar");
    $contador++;
}
testar(batalhaVencida(6) == true, "Batalha da caverna continua vencivel");
testar(tentarTrocarCena(7, $cenas) == true, "Cena 6 libera Cena 7 apos dados e combate");


reiniciarJogo();
iniciarJogo();
$_SESSION["cenaAtual"] = 11;
registrarCenaVisitada(11);
iniciarBatalha(11);
adicionarPontos(20);
$pontosAntesEmpateVaryn = obterPontuacao();
$resultadoEmpateVaryn = jogarJokenpo("pedra", "pedra");
testar(obterPontuacao() == $pontosAntesEmpateVaryn - 10, "Empatar contra Varyn custa 10 pontos");

$_SESSION["pontuacao"] = 0;
$resultadoVaryn1 = jogarJokenpo("pedra", "tesoura");
testar($_SESSION["pontosPikoJokenpo"] == 1, "Piko marca o primeiro ponto contra Varyn");
testar($resultadoVaryn1["vitoria"] == false, "Uma rodada nao encerra a melhor de 3 contra Varyn");
$resultadoVaryn2 = jogarJokenpo("papel", "pedra");
testar(batalhaVencida(11) == true, "Piko vence Varyn ao ganhar 2 rodadas da melhor de 3");
testar($resultadoVaryn2["vitoria"] == true, "Resultado de Varyn informa vitoria");
testar(obterPontuacao() == 70, "Vencer duas rodadas contra Varyn (+30) e derrota-lo (+40) rende 70 pontos");


reiniciarJogo();
iniciarJogo();
$_SESSION["cenaAtual"] = 11;
registrarCenaVisitada(11);
iniciarBatalha(11);
adicionarPontos(30);
$pontosAntesDerrotaVaryn = obterPontuacao();
jogarJokenpo("pedra", "papel");
testar(obterPontuacao() == $pontosAntesDerrotaVaryn - 10, "Perder uma rodada contra Varyn custa 10 pontos");
$resultadoVarynDerrota = jogarJokenpo("pedra", "papel");
testar(obterPontuacao() == $pontosAntesDerrotaVaryn - 20, "Perder outra rodada contra Varyn custa mais 10 pontos");
testar(batalhaPerdida(11) == true, "Varyn vence ao ganhar 2 rodadas da melhor de 3");
testar($resultadoVarynDerrota["derrota"] == true, "Resultado de Varyn informa derrota de Piko");
testar(jogoFoiPerdido() == true, "Perder para Varyn obriga recomecar o jogo inteiro");

$batalhas = obterBatalhas();
testar($batalhas[14]["ataque"] == 14, "Mae causa 14 de dano");
testar($batalhas[4]["ataque"] == 18, "Inimigo da Floresta causa 18 de dano");
testar($batalhas[6]["ataque"] == 20, "Inimigo da Caverna causa 20 de dano");
testar($batalhas[8]["ataque"] == 22, "Guardiao causa 22 de dano");
testar(criarPiko()->getAtaque() == 24, "Piko causa 24 de dano base");

reiniciarJogo();
testar(jogoFoiIniciado() == false, "Novo jogo volta para a tela inicial");
testar(count($_SESSION["cenasVisitadas"]) == 0, "Novo jogo limpa mapa descoberto");
testar(obterPontuacao() == 0, "Novo jogo limpa a pontuacao");

echo "FALHAS: " . $falhas . PHP_EOL;

session_destroy();
