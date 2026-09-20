<?php

include "sessao.php";

if (isset($_POST["iniciarJogo"]))
{
    iniciarJogo();
}

if (isset($_POST["novoJogo"]))
{
    reiniciarJogo();
}

if (!jogoFoiIniciado())
{
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>A Relíquia do Reino Perdido</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="inicio">
            <h1>A Relíquia do Reino Perdido</h1>
            <p>Piko sai de Valebrook em busca da Pedra de Arkan.</p>

            <h2>Pontuação</h2>
            <p>Nova cena: +10 | Atacar: +1 | Defesa eficiente: +5</p>
            <p>Poção: -5 | Fuga: +10 se conseguir e -10 se falhar</p>
            <p>Batalha normal: +20 ao vencer e -15 ao perder</p>
            <p>Dados: +10 por rodada vencida, -10 por rodada perdida e +20 ao vencer a melhor de 3</p>
            <p>Varyn: +15 por rodada vencida, -10 por derrota ou empate e +40 ao vencer</p>
            <p>Chegar ao final: +30</p>

            <form method="post" action="index.php">
                <button type="submit" name="iniciarJogo" value="1">INICIAR JOGO</button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}

if (isset($_POST["destino"]))
{
    tentarTrocarCena($_POST["destino"], $cenas);
}

$cenaAtual = $cenas[$_SESSION["cenaAtual"]];
$idCena = $cenaAtual->getId();
registrarCenaVisitada($idCena);

$mensagens = array();
$mensagemExtra = "";

if ($cenaAtual->temDesafio() && !desafioResolvido($idCena))
{
    iniciarDueloDados($idCena);

    if (isset($_POST["jogarDado"]))
    {
        jogarRodadaDados($idCena, $cenas);
        $mensagemExtra = obterMensagemDados($idCena);
    }
}

if (jogoFoiPerdido())
{
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Fim de jogo</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="inicio">
            <h1>Fim de jogo</h1>
            <p><?php echo $_SESSION["motivoDerrota"]; ?></p>
            <p><strong>Pontuação: <?php echo obterPontuacao(); ?></strong></p>

            <form method="post" action="index.php">
                <button type="submit" name="novoJogo" value="1">RECOMEÇAR</button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}

$desafioPendente = $cenaAtual->temDesafio() && !desafioResolvido($idCena);

if (!$desafioPendente && cenaTemBatalha($idCena) && !batalhaEncerrada($idCena))
{
    iniciarBatalha($idCena);

    if (isset($_POST["reiniciarBatalha"]))
    {
        reiniciarBatalha($idCena);
        $mensagens[] = "A batalha foi reiniciada.";
    }
    elseif (!batalhaPerdida($idCena))
    {
        if ($idCena == 11 && isset($_POST["jokenpo"]))
        {
            $mensagens = jogarJokenpo($_POST["jokenpo"]);
        }
        elseif ($idCena != 11 && isset($_POST["atacar"]))
        {
            $mensagens = atacarInimigo($idCena);
        }
        elseif ($idCena != 11 && isset($_POST["defender"]))
        {
            $mensagens = defenderPiko($idCena);
        }
        elseif ($idCena != 11 && isset($_POST["pocao"]))
        {
            $mensagens = usarPocaoVida($idCena);
        }
        elseif ($idCena != 11 && isset($_POST["fugir"]))
        {
            $mensagens = tentarFugir($idCena);
        }
    }
}

if (jogoFoiPerdido())
{
    header("Location: index.php");
    exit;
}

$desafioPendente = $cenaAtual->temDesafio() && !desafioResolvido($idCena);
$batalhaPendente = cenaTemBatalha($idCena) && !$desafioPendente && !batalhaEncerrada($idCena);

$animacaoPiko = "idle";
$animacaoInimigo = "idle";

if (isset($_POST["atacar"]))
{
    $animacaoPiko = "attack";
    $animacaoInimigo = "hurt";
}
elseif (isset($_POST["defender"]))
{
    $animacaoPiko = "idle";
}
elseif (isset($_POST["pocao"]))
{
    $animacaoPiko = "idle";
}
elseif (isset($_POST["fugir"]))
{
    $animacaoPiko = "run";
}
elseif (isset($_POST["jokenpo"]))
{
    $animacaoPiko = "attack";
    $animacaoInimigo = "attack";
}

if (batalhaPerdida($idCena))
{
    $animacaoPiko = "die";
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>A Relíquia do Reino Perdido</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="topo">
    <div>
        <h1>A Relíquia do Reino Perdido</h1>
        <p>Pontos: <strong><?php echo obterPontuacao(); ?></strong> | Poções: <strong><?php echo obterQuantidadePocoes(); ?></strong></p>
    </div>

    <form method="post" action="index.php">
        <button type="submit" name="novoJogo" value="1">Novo jogo</button>
    </form>
</div>

<div class="pagina">
    <div class="jogo">
        <h2>Cena <?php echo $idCena; ?> - <?php echo $cenaAtual->getTitulo(); ?></h2>
        <p><?php echo $cenaAtual->getDescricao(); ?></p>

        <?php
        if ($idCena == 13 && file_exists(dirname(__DIR__) . "/Images/MAIN CHARACTER/Arkan.png"))
        {
            ?>
            <div class="pedra-area">
                <img src="<?php echo caminhoPedra(); ?>" class="pedra" alt="Pedra de Arkan">
            </div>
            <?php
        }
        ?>

        <?php if ($mensagemExtra != "") { ?>
            <div class="mensagem"><p><?php echo $mensagemExtra; ?></p></div>
        <?php } ?>

        <?php
        if ($desafioPendente)
        {
            ?>
            <div class="caixa">
                <h3>Desafio de dados - melhor de 3</h3>
                <p><?php echo $cenaAtual->getDesafio()->getDescricao(); ?></p>
                <p>Piko: <strong><?php echo obterPontosPikoDados($idCena); ?></strong> x <strong><?php echo obterPontosRivalDados($idCena); ?></strong> <?php echo nomeRivalDados($idCena); ?></p>

                <?php if (obterDadoPiko($idCena) > 0) { ?>
                    <p>Última rodada: Piko tirou <?php echo obterDadoPiko($idCena); ?> e o rival tirou <?php echo obterDadoRival($idCena); ?>.</p>
                <?php } ?>

                <p><?php echo obterMensagemDados($idCena); ?></p>

                <form method="post" action="index.php">
                    <button type="submit" name="jogarDado" value="1">Jogar os dados</button>
                </form>
            </div>
            <?php
        }
        elseif ($batalhaPendente)
        {
            if ($idCena == 11)
            {
                ?>
                <div class="caixa combate">
                    <h3>Varyn - Pedra, Papel e Tesoura</h3>
                    <p>Melhor de 3: o primeiro a chegar em 2 pontos vence.</p>
                    <p><strong>Piko <?php echo $_SESSION["pontosPikoJokenpo"]; ?> x <?php echo $_SESSION["pontosVarynJokenpo"]; ?> Varyn</strong></p>

                    <div class="pecas">
                        <div class="sprite-area">
                            <?php if (file_exists(dirname(__DIR__) . "/Images/MAIN CHARACTER/PIKO.png")) { ?>
                                <div class="sprite sprite-<?php echo $animacaoPiko; ?>" style="background-image: url('<?php echo caminhoSpritePiko(); ?>');"></div>
                            <?php } else { ?>
                                <div class="peca">SPRITE DO PIKO</div>
                            <?php } ?>
                        </div>

                        <div class="sprite-area">
                            <?php if (file_exists(dirname(__DIR__) . "/Images/monstros/Boss.png")) { ?>
                                <div class="sprite sprite-<?php echo $animacaoInimigo; ?>" style="background-image: url('<?php echo caminhoSpriteVaryn(); ?>');"></div>
                            <?php } else { ?>
                                <div class="peca">SPRITE DO VARYN</div>
                            <?php } ?>
                        </div>
                    </div>

                    <?php if (count($mensagens) > 0) { ?>
                        <div class="mensagem">
                            <?php foreach ($mensagens as $mensagem) { ?><p><?php echo $mensagem; ?></p><?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="mensagem"><p><?php echo $_SESSION["ultimoResultadoJokenpo"]; ?></p></div>
                    <?php } ?>

                    <form method="post" action="index.php" class="acoes">
                        <button type="submit" name="jokenpo" value="pedra">Pedra</button>
                        <button type="submit" name="jokenpo" value="papel">Papel</button>
                        <button type="submit" name="jokenpo" value="tesoura">Tesoura</button>
                    </form>
                </div>
                <?php
            }
            else
            {
                $porcentagemPiko = ($_SESSION["vidaPiko"] * 100) / $_SESSION["vidaPikoMax"];
                $porcentagemInimigo = ($_SESSION["vidaInimigo"] * 100) / $_SESSION["vidaInimigoMax"];
                ?>
                <div class="caixa combate">
                    <h3>Batalha</h3>

                    <div class="status">
                        <strong><?php echo $_SESSION["nomeInimigo"]; ?></strong>
                        <p>HP: <?php echo $_SESSION["vidaInimigo"]; ?> / <?php echo $_SESSION["vidaInimigoMax"]; ?></p>
                        <div class="barra"><span style="width: <?php echo $porcentagemInimigo; ?>%"></span></div>
                        <?php if (inimigoEstaDefendendo($idCena)) { ?><p>DEFENDENDO</p><?php } ?>
                    </div>

                    <div class="pecas">
                        <div class="sprite-area">
                            <?php if (file_exists(dirname(__DIR__) . "/Images/MAIN CHARACTER/PIKO.png")) { ?>
                                <div class="sprite sprite-<?php echo $animacaoPiko; ?>" style="background-image: url('<?php echo caminhoSpritePiko(); ?>');"></div>
                            <?php } else { ?>
                                <div class="peca">SPRITE DO PIKO</div>
                            <?php } ?>
                        </div>

                        <div class="sprite-area">
                            <?php $spriteMonstro = caminhoSpriteMonstro($idCena); ?>
                            <?php if ($spriteMonstro != "") { ?>
                                <?php if (spriteMonstroEhGif($idCena)) { ?>
                                    <img src="<?php echo $spriteMonstro; ?>" class="sprite-gif" alt="Inimigo">
                                <?php } else { ?>
                                    <div class="sprite sprite-<?php echo $animacaoInimigo; ?>" style="background-image: url('<?php echo $spriteMonstro; ?>');"></div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="peca">SPRITE DO INIMIGO</div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="status">
                        <strong>Piko</strong>
                        <p>HP: <?php echo $_SESSION["vidaPiko"]; ?> / <?php echo $_SESSION["vidaPikoMax"]; ?></p>
                        <div class="barra"><span style="width: <?php echo $porcentagemPiko; ?>%"></span></div>
                        <p>Poções: <?php echo obterQuantidadePocoes(); ?></p>
                    </div>

                    <div class="mensagem">
                        <?php
                        if (batalhaPerdida($idCena))
                        {
                            ?><p><strong>Piko foi derrotado.</strong></p><?php
                        }
                        elseif (count($mensagens) > 0)
                        {
                            foreach ($mensagens as $mensagem)
                            {
                                ?><p><?php echo $mensagem; ?></p><?php
                            }
                        }
                        else
                        {
                            ?><p>Escolha uma ação. Depois o inimigo escolhe atacar ou defender.</p><?php
                        }
                        ?>
                    </div>

                    <?php if (batalhaPerdida($idCena)) { ?>
                        <form method="post" action="index.php">
                            <button type="submit" name="reiniciarBatalha" value="1">Tentar novamente</button>
                        </form>
                    <?php } else { ?>
                        <div class="acoes">
                            <form method="post" action="index.php"><button type="submit" name="atacar" value="1">Atacar</button></form>
                            <form method="post" action="index.php"><button type="submit" name="defender" value="1">Defender</button></form>

                            <?php if (!fugaJaTentada($idCena)) { ?>
                                <form method="post" action="index.php"><button type="submit" name="fugir" value="1">Fugir (1d20)</button></form>
                            <?php } else { ?>
                                <button disabled>Fuga usada: <?php echo obterUltimoDadoFuga($idCena); ?></button>
                            <?php } ?>

                            <?php if (obterQuantidadePocoes() > 0 && $_SESSION["vidaPiko"] < $_SESSION["vidaPikoMax"]) { ?>
                                <form method="post" action="index.php"><button type="submit" name="pocao" value="1">Poção de Vida</button></form>
                            <?php } else { ?>
                                <button disabled>Poção indisponível</button>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <?php
            }
        }
        else
        {
            if (count($mensagens) > 0)
            {
                ?>
                <div class="mensagem">
                    <?php foreach ($mensagens as $mensagem) { ?><p><?php echo $mensagem; ?></p><?php } ?>
                </div>
                <?php
            }

            $transicoes = $cenaAtual->getTransicoesPermitidas();

            if (count($transicoes) > 0)
            {
                ?>
                <div class="caixa">
                    <h3>Escolha o próximo caminho</h3>
                    <form method="post" action="index.php">
                        <?php foreach ($transicoes as $destino) { ?>
                            <label class="opcao">
                                <input type="radio" name="destino" value="<?php echo $destino; ?>" required>
                                <?php echo $cenas[$destino]->getTitulo(); ?>
                            </label>
                        <?php } ?>
                        <button type="submit">Continuar</button>
                    </form>
                </div>
                <?php
            }
            else
            {
                ?>
                <div class="caixa">
                    <h3>Fim da jornada</h3>
                    <p>Pontuação final: <strong><?php echo obterPontuacao(); ?></strong></p>
                    <form method="post" action="index.php">
                        <button type="submit" name="novoJogo" value="1">Voltar ao início</button>
                    </form>
                </div>
                <?php
            }
        }
        ?>
    </div>

    <div class="mapa">
        <h2>Mapa descoberto</h2>
        <p><?php echo count($_SESSION["cenasVisitadas"]); ?> de 14 cenas encontradas.</p>

        <?php
        foreach ($_SESSION["cenasVisitadas"] as $cenaVisitada)
        {
            $classe = "local";

            if ($cenaVisitada == $idCena)
            {
                $classe = "local atual";
            }
            ?>
            <div class="<?php echo $classe; ?>">
                Cena <?php echo $cenaVisitada; ?> - <?php echo $cenas[$cenaVisitada]->getTitulo(); ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>

</body>
</html>
