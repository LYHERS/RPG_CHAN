<?php
$pontosPiko = isset($_SESSION["pontosPikoJokenpo"]) ? $_SESSION["pontosPikoJokenpo"] : 0;
$pontosVaryn = isset($_SESSION["pontosVarynJokenpo"]) ? $_SESSION["pontosVarynJokenpo"] : 0;
?>
<section class="tela-jokenpo">
    <div class="jokenpo-cabecalho">
        <p class="etiqueta">BATALHA FINAL</p>
        <h3>Piko vs Varyn — Pedra, Papel e Tesoura</h3>
        <p>Melhor de 3: o primeiro a vencer 2 rodadas ganha a batalha final.</p>
        <p class="nota-pontos">Pontuação: +15 por rodada vencida, -10 se perder ou empatar uma rodada e +40 de bônus ao derrotar Varyn.</p>
    </div>

    <div class="jokenpo-campo">
        <div class="jokenpo-lutador"><div class="peca-jokenpo"><img src="<?php echo $imagemPiko; ?>" alt="Piko"></div><strong>Piko</strong><span class="pontuacao-jokenpo"><?php echo $pontosPiko; ?></span></div>
        <div class="jokenpo-versus">VS</div>
        <div class="jokenpo-lutador"><div class="peca-jokenpo"><img src="<?php echo $imagensMonstros[11]; ?>" alt="Varyn"></div><strong>Varyn</strong><span class="pontuacao-jokenpo"><?php echo $pontosVaryn; ?></span></div>
    </div>

    <?php if (isset($_SESSION["ultimaEscolhaPiko"]) && $_SESSION["ultimaEscolhaPiko"] != "") { ?>
        <div class="jokenpo-escolhas-anteriores">
            <span>Piko: <strong><?php echo nomeEscolhaJokenpo($_SESSION["ultimaEscolhaPiko"]); ?></strong></span>
            <span>Varyn: <strong><?php echo nomeEscolhaJokenpo($_SESSION["ultimaEscolhaVaryn"]); ?></strong></span>
        </div>
    <?php } ?>

    <div class="caixa-jokenpo-mensagem">
        <?php if (batalhaPerdida(11)) { ?>
            <strong>VARYN VENCEU!</strong><p>Varyn venceu a melhor de 3. A jornada precisa recomeçar desde Valebrook.</p>
        <?php } elseif (count($mensagensBatalha) > 0) { foreach ($mensagensBatalha as $mensagemBatalha) { ?><p><?php echo $mensagemBatalha; ?></p><?php } ?>
        <?php } elseif (isset($_SESSION["ultimoResultadoJokenpo"])) { ?><p><?php echo $_SESSION["ultimoResultadoJokenpo"]; ?></p><?php } ?>
    </div>

    <div class="menu-jokenpo">
        <?php if (batalhaPerdida(11)) { ?>
            <form method="post" action="index.php"><button type="submit" name="novoJogo" value="1" class="acao-jokenpo tentar">Recomeçar jogo</button></form>
        <?php } else { ?>
            <form method="post" action="index.php" class="opcoes-jokenpo">
                <button type="submit" name="escolhaJokenpo" value="pedra" class="acao-jokenpo"><span class="simbolo-jokenpo">✊</span>Pedra</button>
                <button type="submit" name="escolhaJokenpo" value="papel" class="acao-jokenpo"><span class="simbolo-jokenpo">✋</span>Papel</button>
                <button type="submit" name="escolhaJokenpo" value="tesoura" class="acao-jokenpo"><span class="simbolo-jokenpo">✌</span>Tesoura</button>
            </form>
        <?php } ?>
    </div>
</section>
