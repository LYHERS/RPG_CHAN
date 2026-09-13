<?php

class Personagem
{
    private $nome;
    private $vida;
    private $vidaMaxima;
    private $ataque;
    private $imagem;

    function __construct($nome, $vida, $vidaMaxima, $ataque, $imagem = "")
    {
        $this->nome = $nome;
        $this->vida = $vida;
        $this->vidaMaxima = $vidaMaxima;
        $this->ataque = $ataque;
        $this->imagem = $imagem;
    }

    function getNome()
    {
        return $this->nome;
    }

    function getVida()
    {
        return $this->vida;
    }

    function setVida($vida)
    {
        $this->vida = $vida;

        if ($this->vida < 0)
        {
            $this->vida = 0;
        }

        if ($this->vida > $this->vidaMaxima)
        {
            $this->vida = $this->vidaMaxima;
        }
    }

    function getVidaMaxima()
    {
        return $this->vidaMaxima;
    }

    function getAtaque()
    {
        return $this->ataque;
    }

    function getImagem()
    {
        return $this->imagem;
    }

    function receberDano($dano)
    {
        $this->setVida($this->vida - $dano);
    }

    function estaVivo()
    {
        return $this->vida > 0;
    }
}
