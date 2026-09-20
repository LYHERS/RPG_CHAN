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
