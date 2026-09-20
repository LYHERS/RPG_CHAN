<?php






class Dado
{
    
    private $lados;
    
    private $ultimoResultado = null;

    
    function __construct($lados = 6)
    {
        $this->lados = $lados;
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
