<?php
if ($acabouDeVencer) { ?><div class="aviso sucesso"><strong>VITÓRIA!</strong><span>A batalha foi vencida. O caminho foi liberado.</span></div><?php } ?>
<?php if ($acabouDeFugir) { ?><div class="aviso fuga-sucesso"><strong>FUGA BEM-SUCEDIDA!</strong><span>Piko tirou mais que 15 no 1d20 e escapou. O caminho foi liberado.</span></div><?php } ?>

<?php if ($podeMostrarTransicoes) { $transicoes = $cenaAtual->getTransicoesPermitidas(); ?>
    <?php if (count($transicoes) > 0) { ?>
        <section class="cartao escolhas">
            <p class="etiqueta">ESCOLHA O PRÓXIMO PASSO</p>
            <form method="post" action="index.php">
                <div class="lista-escolhas">
                    <?php foreach ($transicoes as $destino) { $cenaOpcao = $cenas[$destino]; ?>
                        <label class="opcao-caminho"><input type="radio" name="destino" value="<?php echo $destino; ?>" required><span><strong><?php echo $cenaOpcao->getTitulo(); ?></strong><small>Cena <?php echo $destino; ?></small></span></label>
                    <?php } ?>
                </div>
                <button type="submit" class="botao primario">Continuar</button>
            </form>
        </section>
    <?php } else { ?>
        <section class="cartao final-jogo">
            <p class="etiqueta">JORNADA CONCLUÍDA</p>
            <h3><?php echo $cenaAtual->getTitulo(); ?></h3>
            <p><?php echo $cenaAtual->getDescricao(); ?></p>

            <div class="placar-final">
                <span>PONTUAÇÃO FINAL</span>
                <strong><?php echo obterPontuacao(); ?></strong>
                <small>pontos</small>
            </div>

            <?php if (!isset($_SESSION["rankingSalvo"]) || $_SESSION["rankingSalvo"] !== true) { ?>
                <div class="ranking-cadastro">
                    <div class="ranking-titulo">
                        <span class="ranking-icone">🏆</span>
                        <div>
                            <h4>Entre para o Ranking</h4>
                            <p>Digite seu nome para salvar sua pontuação.</p>
                        </div>
                    </div>
                    <form method="post" action="index.php" class="form-ranking">
                        <label for="nomeRanking">Seu nome</label>
                        <div class="ranking-form-linha">
                            <input id="nomeRanking" type="text" name="nomeRanking" maxlength="45" required placeholder="Digite seu nome" autocomplete="off">
                            <button type="submit" name="salvarRanking" value="1" class="botao primario">Salvar pontuação</button>
                        </div>
                    </form>
                </div>
            <?php } else { ?>
                <div class="ranking-ok"><span>✓</span> Pontuação salva no ranking!</div>
            <?php } ?>

            <div class="ranking-final">
                <div class="ranking-cabecalho">
                    <div>
                        <p class="etiqueta">PLACAR GLOBAL</p>
                        <h4>🏆 Ranking dos aventureiros</h4>
                    </div>
                    <span>TOP 20</span>
                </div>

                <?php $rankingFinal = obterRanking(20); ?>
                <?php if (count($rankingFinal) === 0) { ?>
                    <p class="ranking-vazio">Nenhuma pontuação cadastrada ainda.</p>
                <?php } else { ?>
                    <div class="ranking-tabela-wrap">
                        <table class="tabela-ranking">
                            <thead>
                                <tr><th>Pos.</th><th>Aventureiro</th><th>Pontos</th></tr>
                            </thead>
                            <tbody>
                            <?php foreach ($rankingFinal as $posicao => $jogador) { ?>
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
            </div>

            <div class="acoes-final">
                <a href="index.php?ranking=1" class="botao secundario">Ver ranking completo</a>
                <form method="post" action="index.php"><button type="submit" name="novoJogo" value="1" class="botao primario">Voltar ao início</button></form>
            </div>
        </section>
    <?php } ?>
<?php } ?>
