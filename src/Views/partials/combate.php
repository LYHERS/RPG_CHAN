<?php
$vidaPiko = $_SESSION["vidaPiko"];
$vidaPikoMax = $_SESSION["vidaPikoMax"];
$vidaInimigo = $_SESSION["vidaInimigo"];
$vidaInimigoMax = $_SESSION["vidaInimigoMax"];
$porcentagemPiko = ($vidaPiko * 100) / $vidaPikoMax;
$porcentagemInimigo = ($vidaInimigo * 100) / $vidaInimigoMax;
$classeHpPiko = $porcentagemPiko <= 25 ? "hp-vermelho" : ($porcentagemPiko <= 50 ? "hp-amarelo" : "hp-verde");
$classeHpInimigo = $porcentagemInimigo <= 25 ? "hp-vermelho" : ($porcentagemInimigo <= 50 ? "hp-amarelo" : "hp-verde");
?>
<section class="tela-combate">
    <div class="status status-inimigo">
        <div class="status-linha"><strong><?php echo $_SESSION["nomeInimigo"]; ?></strong><span>Lv. <?php echo $_SESSION["nivelInimigo"]; ?></span></div>
        <div class="hp-linha"><span>HP</span><div class="barra-hp"><div class="preenchimento-hp <?php echo $classeHpInimigo; ?>" style="width: <?php echo $porcentagemInimigo; ?>%;"></div></div></div>
        <small><?php echo $vidaInimigo; ?> / <?php echo $vidaInimigoMax; ?> | ATQ <?php echo $_SESSION["ataqueInimigo"]; ?></small>
        <?php if (inimigoEstaDefendendo($idCenaAtual)) { ?><span class="estado-defesa">DEFESA ATIVA</span><?php } ?>
    </div>

    <div class="peca peca-inimigo"><img src="<?php echo $imagemInimigoAtual; ?>" alt="<?php echo $_SESSION["nomeInimigo"]; ?>"><span><?php echo $_SESSION["nomeInimigo"]; ?></span></div>
    <div class="peca peca-piko"><img src="<?php echo $imagemPiko; ?>" alt="Piko"><span>Piko</span></div>

    <div class="status status-piko">
        <div class="status-linha"><strong>Piko</strong><span>Lv. <?php echo $_SESSION["nivelPiko"]; ?></span></div>
        <div class="hp-linha"><span>HP</span><div class="barra-hp"><div class="preenchimento-hp <?php echo $classeHpPiko; ?>" style="width: <?php echo $porcentagemPiko; ?>%;"></div></div></div>
        <small><?php echo $vidaPiko; ?> / <?php echo $vidaPikoMax; ?> | ATQ <?php echo $_SESSION["ataquePiko"]; ?> | Poções: <?php echo obterQuantidadePocoes(); ?></small>
    </div>

    <div class="caixa-mensagem" id="mensagemCombate">
        <?php if (batalhaPerdida($idCenaAtual)) { ?>
            <strong>PIKO FOI DERROTADO!</strong><p>Tente novamente para reiniciar somente esta batalha.</p>
        <?php } elseif (count($mensagensBatalha) > 0) { foreach ($mensagensBatalha as $mensagemBatalha) { ?><p><?php echo $mensagemBatalha; ?></p><?php } ?>
        <?php } else { ?><p>A batalha continua.</p><?php } ?>
    </div>

    <div class="menu-combate">
        <?php if (batalhaPerdida($idCenaAtual)) { ?>
            <form method="post" action="index.php" class="form-combate"><button type="submit" name="reiniciarBatalha" value="1" class="acao-combate atacar">Tentar novamente</button></form>
        <?php } else { ?>
            <form method="post" action="index.php" class="form-combate"><button type="submit" name="atacarInimigo" value="1" class="acao-combate atacar">Atacar</button></form>
            <form method="post" action="index.php" class="form-combate"><button type="submit" name="defenderPiko" value="1" class="acao-combate defender">Defender</button></form>
            <?php if (fugaJaTentada($idCenaAtual)) { ?>
                <button type="button" class="acao-combate fugir desativado" disabled>Fugir usado (d20 <?php echo obterUltimoDadoFuga($idCenaAtual); ?>)</button>
            <?php } else { ?>
                <form method="post" action="index.php" class="form-combate"><button type="submit" name="tentarFugir" value="1" class="acao-combate fugir">Fugir (1d20)</button></form>
            <?php } ?>
            <?php if (obterQuantidadePocoes() <= 0) { ?>
                <button type="button" class="acao-combate item desativado" disabled>Poção de Vida (0)</button>
            <?php } elseif ($vidaPiko >= $vidaPikoMax) { ?>
                <button type="button" class="acao-combate item desativado" disabled>Poção x<?php echo obterQuantidadePocoes(); ?> (HP cheio)</button>
            <?php } else { ?>
                <form method="post" action="index.php" class="form-combate"><button type="submit" name="usarPocao" value="1" class="acao-combate item">Poção +40 HP (x<?php echo obterQuantidadePocoes(); ?>)</button></form>
            <?php } ?>
        <?php } ?>
    </div>
</section>
