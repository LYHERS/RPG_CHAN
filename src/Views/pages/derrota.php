<?php $tituloPagina = "Fim de jogo - " . TITULO_JOGO; $classeBody = "pagina-derrota"; include __DIR__ . "/../layout/head.php"; ?>
<main class="tela-derrota-jogo">
    <section class="derrota-conteudo">
        <p class="inicio-selo">FIM DE JOGO</p>
        <h1>Piko perdeu a jornada</h1>
        <p><?php echo htmlspecialchars(obterMotivoDerrota(), ENT_QUOTES, "UTF-8"); ?></p>
        <div class="placar-final">Pontuação final: <strong><?php echo obterPontuacao(); ?></strong></div>
        <p class="derrota-aviso">Ao recomeçar, o mapa, os desafios, as batalhas, a pontuação, a vida e as 2 poções voltam ao estado inicial.</p>
        <form method="post" action="index.php">
            <button type="submit" name="novoJogo" value="1" class="botao-iniciar">RECOMEÇAR JOGO</button>
        </form>
    </section>
</main>
