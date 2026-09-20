<?php
$desafio = $cenaAtual->getDesafio();
$pontosPikoDados = obterPontosPikoDados($idCenaAtual);
$pontosRivalDados = obterPontosRivalDados($idCenaAtual);
$ultimoDadoPiko = obterUltimoDadoPiko($idCenaAtual);
$ultimoDadoRival = obterUltimoDadoRival($idCenaAtual);
?>
<section class="cartao desafio duelo-dados">
    <div class="icone-grande">🎲</div>
    <div class="duelo-dados-conteudo">
        <p class="etiqueta">BATALHA DE DADOS — MELHOR DE 3</p>
        <h3><?php echo $desafio->getDescricao(); ?></h3>
        <p>Piko e <?php echo nomeRivalDados($idCenaAtual); ?> rolam 1d6 ao mesmo tempo. Quem tirar o maior valor vence a rodada.</p>
        <p>O primeiro a vencer <strong>2 rodadas</strong> ganha a melhor de 3. Em caso de empate, ninguém marca ponto e outra rodada é jogada.</p>
        <p class="nota-pontos">Pontuação: +10 por rodada vencida, -10 por rodada perdida e +20 de bônus ao vencer o desafio. Empate nos dados não altera o placar.</p>

        <div class="placar-dados">
            <div><strong>Piko</strong><span><?php echo $pontosPikoDados; ?></span><small>Dado: <?php echo $ultimoDadoPiko === null ? "-" : $ultimoDadoPiko; ?></small></div>
            <b>×</b>
            <div><strong><?php echo nomeRivalDados($idCenaAtual); ?></strong><span><?php echo $pontosRivalDados; ?></span><small>Dado: <?php echo $ultimoDadoRival === null ? "-" : $ultimoDadoRival; ?></small></div>
        </div>

        <div class="resultado-dados"><?php echo obterUltimoResultadoDados($idCenaAtual); ?></div>

        <form method="post" action="index.php">
            <button type="submit" name="jogarDado" value="1" class="botao primario">Rolar dados</button>
        </form>
    </div>
</section>
