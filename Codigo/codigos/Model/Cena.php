<?php

class Cena
{
    private $id;
    private $titulo;
    private $descricao;
    private $imagem;
    private $transicoes = array();
    private $desafio = null;

    function __construct($id, $titulo, $descricao, $imagem = "")
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
        $this->transicoes[] = $destino;
    }

    function getTransicoesPermitidas()
    {
        return $this->transicoes;
    }

    function podeIrPara($destino)
    {
        foreach ($this->transicoes as $transicao)
        {
            if ($transicao == $destino)
            {
                return true;
            }
        }

        return false;
    }

    function setDesafio($desafio)
    {
        $this->desafio = $desafio;
    }

    function getDesafio()
    {
        return $this->desafio;
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
