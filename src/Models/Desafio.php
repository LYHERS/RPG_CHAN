<?php






class Desafio
{
    
    private $descricao;
    
    private $dado;
    
    private $valorMinimoSucesso;
    
    private $mensagemSucesso;
    
    private $mensagemFracasso;

    
    function __construct($descricao, $dado, $valorMinimoSucesso, $mensagemSucesso, $mensagemFracasso)
    {
        $this->descricao = $descricao;
        $this->dado = $dado;
        $this->valorMinimoSucesso = $valorMinimoSucesso;
        $this->mensagemSucesso = $mensagemSucesso;
        $this->mensagemFracasso = $mensagemFracasso;
    }

    
    function rolarDado()
    {
        return $this->dado->rolar();
    }

    
    function resolver()
    {
        $resultado = $this->rolarDado();

        if ($resultado >= $this->valorMinimoSucesso)
        {
            return true;
        }

        return false;
    }

    
    function getDescricao()
    {
        return $this->descricao;
    }

    
    function getUltimoResultado()
    {
        return $this->dado->getUltimoResultado();
    }

    
    function getMensagemSucesso()
    {
        return $this->mensagemSucesso;
    }

    
    function getMensagemFracasso()
    {
        return $this->mensagemFracasso;
    }
}
