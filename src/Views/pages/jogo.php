<?php
$tituloPagina = TITULO_JOGO; $classeBody = "pagina-jogo"; include __DIR__ . "/../layout/head.php";
?>
<header class="topo">
    <div><p class="subtitulo">RPG WEB • CRÔNICAS DE EDERSON</p><h1><?php echo TITULO_JOGO; ?></h1></div>
    <div class="acoes-topo">
        <div class="placar-geral"><span>PONTOS</span><strong><?php echo obterPontuacao(); ?></strong></div>
        <button type="button" id="botaoMapa" class="botao secundario">Mostrar / esconder mapa</button>
        <form method="post" action="index.php"><button type="submit" name="novoJogo" value="1" class="botao perigo">Novo jogo</button></form>
    </div>
</header>

<main class="layout-principal">
    <section class="painel-jogo">
        <div class="cabecalho-cena">
            <span class="numero-cena">Cena <?php echo $idCenaAtual; ?></span>
            <h2><?php echo $cenaAtual->getTitulo(); ?></h2>
            <p><?php echo $cenaAtual->getDescricao(); ?></p>
        </div>

        <?php if ($desafioPendente) { include __DIR__ . "/../partials/desafio.php"; }
        elseif ($batalhaPendente) {
            if ($idCenaAtual == 11) { include __DIR__ . "/../partials/jokenpo.php"; }
            else { include __DIR__ . "/../partials/combate.php"; }
        } else { include __DIR__ . "/../partials/cena.php"; } ?>
    </section>

    <?php include __DIR__ . "/../partials/mapa.php"; ?>
</main>

