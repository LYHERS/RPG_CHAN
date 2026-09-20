<?php
$tituloPagina = "Ranking";
$classeBody = "pagina-ranking";
include __DIR__ . "/../layout/head.php";
$ranking = obterRanking(20);
?>
<header class="topo">
    <div><p class="subtitulo">RPG WEB • CRÔNICAS DE EDERSON</p><h1>🏆 Ranking dos aventureiros</h1></div>
</header>
<main class="painel-ranking">
    <section class="cartao ranking-final">
        <div class="ranking-cabecalho">
            <div><p class="etiqueta">PLACAR GLOBAL</p><h4>As maiores pontuações</h4></div>
            <span>TOP 20</span>
        </div>
        <?php if (count($ranking) === 0) { ?>
            <p class="ranking-vazio">Nenhuma pontuação cadastrada ainda. Finalize uma jornada para entrar no ranking.</p>
        <?php } else { ?>
            <div class="ranking-tabela-wrap">
                <table class="tabela-ranking">
                    <thead><tr><th>Pos.</th><th>Aventureiro</th><th>Pontos</th></tr></thead>
                    <tbody>
                    <?php foreach ($ranking as $posicao => $jogador) { ?>
                        <tr class="<?php echo $posicao < 3 ? 'ranking-destaque' : ''; ?>">
                            <td><span class="ranking-posicao"><?php echo $posicao + 1; ?></span></td>
                            <td><?php echo htmlspecialchars($jogador["nome"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td><strong><?php echo (int) $jogador["pontuacao"]; ?></strong> pts</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
        <div class="acoes-final"><a href="index.php" class="botao primario">Voltar ao jogo</a></div>
    </section>
</main>
