<?php
function classeNoMapa($id, $idAtual)
{
    $classe = "mapa-no visitado";

    if ($id == $idAtual) { $classe .= " atual"; }
    if ($id == 4 || $id == 6 || $id == 8 || $id == 14) { $classe .= " batalha"; }
    if ($id == 11) { $classe .= " boss"; }
    if ($id == 12 || $id == 13) { $classe .= " final"; }

    return $classe;
}

function linhaDescoberta($origem, $destino)
{
    return cenaFoiVisitada($origem) && cenaFoiVisitada($destino);
}
