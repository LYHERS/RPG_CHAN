<?php






class Personagem
{
    
    private $nome;
    
    private $vida;
    
    private $vidaMaxima;
    
    private $ataque;
    
    private $imagem;

    
    function __construct($nome, $vida, $vidaMaxima, $ataque, $imagem = '')
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

    
    function setNome($nome)
    {
        $this->nome = $nome;
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

    
    function setVidaMaxima($vidaMaxima)
    {
        $this->vidaMaxima = $vidaMaxima;
    }

    
    function getAtaque()
    {
        return $this->ataque;
    }

    
    function setAtaque($ataque)
    {
        $this->ataque = $ataque;
    }

    
    function getImagem()
    {
        return $this->imagem;
    }

    
    function setImagem($imagem)
    {
        $this->imagem = $imagem;
    }

    
    function receberDano($dano)
    {
        $this->vida = $this->vida - $dano;

        if ($this->vida < 0)
        {
            $this->vida = 0;
        }
    }

    
    function estaVivo()
    {
        if ($this->vida > 0)
        {
            return true;
        }

        return false;
    }
}
