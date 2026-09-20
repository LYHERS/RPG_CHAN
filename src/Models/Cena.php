<?php






class Cena
{
    
    private $id;
    
    private $titulo;
    
    private $descricao;
    
    private $imagem;
    
    private $transicoesPermitidas = array();
    
    private $desafio = null;

    
    function __construct($id, $titulo, $descricao, $imagem = '')
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->imagem = $imagem;
    }

    
    function getId()
    {
        return $this->id;
    }

    
    function getTitulo()
    {
        return $this->titulo;
    }

    
    function getDescricao()
    {
        return $this->descricao;
    }

    
    function getImagem()
    {
        return $this->imagem;
    }

    
    function adicionarTransicao($destino)
    {
        $existe = false;

        foreach ($this->transicoesPermitidas as $transicao)
        {
            if ($transicao == $destino)
            {
                $existe = true;
            }
        }

        if ($existe == false)
        {
            $this->transicoesPermitidas[] = $destino;
        }
    }

    
    function podeIrPara($destino)
    {
        foreach ($this->transicoesPermitidas as $transicao)
        {
            if ($transicao == $destino)
            {
                return true;
            }
        }

        return false;
    }

    
    function getTransicoesPermitidas()
    {
        return $this->transicoesPermitidas;
    }

    
    function getDesafio()
    {
        return $this->desafio;
    }

    
    function setDesafio($desafio)
    {
        $this->desafio = $desafio;
    }

    
    function temDesafio()
    {
        if ($this->desafio != null)
        {
            return true;
        }

        return false;
    }
}
