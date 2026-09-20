<?php

function registrarCenaVisitada($idCena)
{
    if (!isset($_SESSION["cenasVisitadas"]) || !is_array($_SESSION["cenasVisitadas"]))
    {
        $_SESSION["cenasVisitadas"] = array();
    }

    if (in_array($idCena, $_SESSION["cenasVisitadas"]) == false)
    {
        $_SESSION["cenasVisitadas"][] = $idCena;
    }
}


function cenaFoiVisitada($idCena)
{
    if (!isset($_SESSION["cenasVisitadas"]) || !is_array($_SESSION["cenasVisitadas"]))
    {
        return false;
    }

    return in_array($idCena, $_SESSION["cenasVisitadas"]);
}





