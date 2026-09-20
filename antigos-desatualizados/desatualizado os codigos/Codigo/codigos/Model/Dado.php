<?php

class Dado
{
    private $lados;
    private $ultimoResultado;

    function __construct($lados = 6)
    {
        $this->lados = $lados;
        $this->ultimoResultado = 0;
    }

    function rolar()
    {
        $this->ultimoResultado = rand(1, $this->lados);
        return $this->ultimoResultado;
    }

    function getUltimoResultado()
    {
        return $this->ultimoResultado;
    }
}
