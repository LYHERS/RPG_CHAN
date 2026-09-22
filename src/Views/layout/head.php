<?php
$tituloPagina = isset($tituloPagina) ? $tituloPagina : TITULO_JOGO;
$classeBody = isset($classeBody) ? $classeBody : "";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($tituloPagina, ENT_QUOTES, "UTF-8"); ?></title>
    <link rel="stylesheet" href="css/main.css">
</head>

<body class="<?php echo htmlspecialchars($classeBody, ENT_QUOTES, "UTF-8"); ?>">

    <script src="js/app.js" defer></script>
    <script src="js/mapa.js" defer></script>
    <script src="js/mensagens.js" defer></script>

    <audio id="musicaJogo" loop>
        <source src="/RPG_CHAN/audio/musica.mp3" type="audio/mpeg">
    </audio>

    <script>
        const musica = document.getElementById("musicaJogo");

        musica.volume = 0.3;

        const tempoSalvo = localStorage.getItem("tempoMusica");

        musica.addEventListener("loadedmetadata", function () {
            if (tempoSalvo !== null) {
                const tempo = parseFloat(tempoSalvo);

                if (!isNaN(tempo) && tempo < musica.duration) {
                    musica.currentTime = tempo;
                }
            }

            musica.play().catch(function () {
                console.log("Clique na página para iniciar a música.");
            });
        });

        document.addEventListener("click", function iniciarMusica() {
            musica.play().catch(function () {});
        }, { once: true });

        setInterval(function () {
            if (!musica.paused) {
                localStorage.setItem("tempoMusica", musica.currentTime);
            }
        }, 500);

        window.addEventListener("beforeunload", function () {
            localStorage.setItem("tempoMusica", musica.currentTime);
        });
    </script>