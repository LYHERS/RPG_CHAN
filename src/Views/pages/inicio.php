<?php $tituloPagina = TITULO_JOGO; $classeBody = "pagina-inicio"; include __DIR__ . "/../layout/head.php"; ?>
<main class="tela-inicio">
    <section class="inicio-conteudo">
        <p class="inicio-selo">(RPG CHAN WEB)</p>
        <img class="inicio-personagem" src="<?php echo obterImagemPiko(); ?>" alt="Piko, protagonista da aventura">
        <h1><?php echo TITULO_JOGO; ?></h1>
        <p class="inicio-texto">Piko parte de Valebrook em busca da Pedra de Arkan. No caminho, ele enfrentará batalhas, desafios de sorte e escolhas que mudam sua rota.</p>

        <div class="inicio-regras">
            <span>⚔ batalhas por turno</span>
            <span>🧪 Começa com 2 poções + 1 por batalha vencida</span>
            <span>🎲 batalhas de dados em melhor de 3</span>
            <span>🗺 mapa revelado durante a jornada</span>
            <span>🏆 placar acompanha toda a jornada</span>
        </div>

        <div class="regras-pontuacao">
            <strong>PONTUAÇÃO</strong>
            <span>Nova cena: +10</span>
            <span>Atacar: +1</span>
            <span>1ª defesa eficiente por batalha: +5</span>
            <span>Poção: -5</span>
            <span>Fuga no 1d20: +10 se conseguir / -10 se falhar</span>
            <span>Vitória em batalha normal: +20 / derrota: -15</span>
            <span>Dados: +10 por rodada vencida / -10 por rodada perdida / +20 ao vencer o desafio</span>
            <span>Varyn: +15 por vitória / -10 por derrota ou empate / +40 ao derrotá-lo</span>
            <span>Chegar ao final: +30</span>
        </div>

        <form method="post" action="index.php">
            <button type="submit" name="iniciarJogo" value="1" class="botao-iniciar">INICIAR JOGO</button>
        </form>

        <div class="creditos-projeto">
            <p>© 2026 A Relíquia do Reino Perdido</p>
            <p>Criadores: Kamilla • Matheus Fontao • Joao Vitor</p>
            <a href="<?php echo GITHUB_CRIADORES; ?>" target="_blank" rel="noopener noreferrer">GitHub do projeto</a>
        </div>
    </section>
</main>
