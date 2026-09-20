<aside class="painel-mapa" id="painelMapa">
    <div class="titulo-mapa">
        <div><p class="etiqueta">MAPA EM DESCOBERTA</p><h2>Arvandor</h2></div>
        <div class="mapa-progresso"><span class="legenda-atual">● sua posição</span><span><?php echo count($_SESSION["cenasVisitadas"]); ?> / 14 locais vistos</span></div>
    </div>

    <div class="mapa-area">
        <div class="mapa-nevoa"></div>
        <svg class="mapa-linhas" viewBox="0 0 1000 980" preserveAspectRatio="none" aria-hidden="true">
            <?php if (linhaDescoberta(1, 14)) { ?><line x1="500" y1="80" x2="500" y2="160"></line><?php } ?>
            <?php if (linhaDescoberta(14, 2)) { ?><line x1="500" y1="160" x2="500" y2="250"></line><?php } ?>
            <?php if (linhaDescoberta(2, 3)) { ?><line x1="500" y1="250" x2="315" y2="340"></line><?php } ?>
            <?php if (linhaDescoberta(2, 5)) { ?><line x1="500" y1="250" x2="685" y2="340"></line><?php } ?>
            <?php if (linhaDescoberta(3, 4)) { ?><line x1="315" y1="340" x2="315" y2="430"></line><?php } ?>
            <?php if (linhaDescoberta(5, 6)) { ?><line x1="685" y1="340" x2="685" y2="430"></line><?php } ?>
            <?php if (linhaDescoberta(4, 7)) { ?><line x1="315" y1="430" x2="500" y2="525"></line><?php } ?>
            <?php if (linhaDescoberta(6, 7)) { ?><line x1="685" y1="430" x2="500" y2="525"></line><?php } ?>
            <?php if (linhaDescoberta(7, 8)) { ?><line x1="500" y1="525" x2="315" y2="620"></line><?php } ?>
            <?php if (linhaDescoberta(7, 9)) { ?><line x1="500" y1="525" x2="685" y2="620"></line><?php } ?>
            <?php if (linhaDescoberta(8, 10)) { ?><line x1="315" y1="620" x2="500" y2="715"></line><?php } ?>
            <?php if (linhaDescoberta(9, 10)) { ?><line x1="685" y1="620" x2="500" y2="715"></line><?php } ?>
            <?php if (linhaDescoberta(10, 11)) { ?><line x1="500" y1="715" x2="500" y2="805"></line><?php } ?>
            <?php if (linhaDescoberta(11, 12)) { ?><line x1="500" y1="805" x2="350" y2="905"></line><?php } ?>
            <?php if (linhaDescoberta(11, 13)) { ?><line x1="500" y1="805" x2="650" y2="905"></line><?php } ?>
        </svg>

        <?php if (cenaFoiVisitada(1)) { ?><div class="<?php echo classeNoMapa(1, $idCenaAtual); ?>" style="left:50%; top:8%;">Valebrook</div><?php } ?>
        <?php if (cenaFoiVisitada(14)) { ?><div class="<?php echo classeNoMapa(14, $idCenaAtual); ?>" style="left:50%; top:16%;">Mãe</div><?php } ?>
        <?php if (cenaFoiVisitada(2)) { ?><div class="<?php echo classeNoMapa(2, $idCenaAtual); ?>" style="left:50%; top:25%;">Saída</div><?php } ?>
        <?php if (cenaFoiVisitada(3)) { ?><div class="<?php echo classeNoMapa(3, $idCenaAtual); ?>" style="left:31.5%; top:34%;">Floresta Sup.</div><?php } ?>
        <?php if (cenaFoiVisitada(5)) { ?><div class="<?php echo classeNoMapa(5, $idCenaAtual); ?>" style="left:68.5%; top:34%;">Floresta Inf.</div><?php } ?>
        <?php if (cenaFoiVisitada(4)) { ?><div class="<?php echo classeNoMapa(4, $idCenaAtual); ?>" style="left:31.5%; top:43%;">Batalha 1</div><?php } ?>
        <?php if (cenaFoiVisitada(6)) { ?><div class="<?php echo classeNoMapa(6, $idCenaAtual); ?>" style="left:68.5%; top:43%;">Caverna</div><?php } ?>
        <?php if (cenaFoiVisitada(7)) { ?><div class="<?php echo classeNoMapa(7, $idCenaAtual); ?>" style="left:50%; top:52.5%;">Ponte</div><?php } ?>
        <?php if (cenaFoiVisitada(8)) { ?><div class="<?php echo classeNoMapa(8, $idCenaAtual); ?>" style="left:31.5%; top:62%;">Pular</div><?php } ?>
        <?php if (cenaFoiVisitada(9)) { ?><div class="<?php echo classeNoMapa(9, $idCenaAtual); ?>" style="left:68.5%; top:62%;">Contorno</div><?php } ?>
        <?php if (cenaFoiVisitada(10)) { ?><div class="<?php echo classeNoMapa(10, $idCenaAtual); ?>" style="left:50%; top:71.5%;">Castelo</div><?php } ?>
        <?php if (cenaFoiVisitada(11)) { ?><div class="<?php echo classeNoMapa(11, $idCenaAtual); ?>" style="left:50%; top:80.5%;">Varyn</div><?php } ?>
        <?php if (cenaFoiVisitada(12)) { ?><div class="<?php echo classeNoMapa(12, $idCenaAtual); ?>" style="left:35%; top:90.5%;">Fase Secreta</div><?php } ?>
        <?php if (cenaFoiVisitada(13)) { ?><div class="<?php echo classeNoMapa(13, $idCenaAtual); ?>" style="left:65%; top:90.5%;">Pedra</div><?php } ?>
    </div>

    <p class="nota-mapa">O mapa começa quase vazio e revela somente os locais realmente visitados por Piko.</p>
</aside>
