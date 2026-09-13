<?php

class Desafio
{
    private $descricao;
    private $dado;
    private $mensagemSucesso;
    private $mensagemFracasso;

    function __construct($descricao, $dado, $mensagemSucesso, $mensagemFracasso)
    {
        $this->descricao = $descricao;
        $this->dado = $dado;
        $this->mensagemSucesso = $mensagemSucesso;
        $this->mensagemFracasso = $mensagemFracasso;
    }

    function rolarDado()
    {
        return $this->dado->rolar();
    }

    function getDescricao()
    {
        return $this->descricao;
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
