<?php




function iniciarJogo()
{
    $_SESSION = array();
    $_SESSION["jogoIniciado"] = true;
    $_SESSION["jogoPerdido"] = false;
    $_SESSION["motivoDerrota"] = "";
    $_SESSION["cenaAtual"] = 1;
    $_SESSION["cenasVisitadas"] = array(1);
    $_SESSION["pocoesVida"] = 2;
    $_SESSION["pontuacao"] = 0;
    $_SESSION["rankingSalvo"] = false;
    $_SESSION["eventosPontuacao"] = array();
}


