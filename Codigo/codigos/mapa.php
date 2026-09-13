<?php

include "Model/Cena.php";
include "Model/Dado.php";
include "Model/Desafio.php";

$cena1 = new Cena(1, "Valebrook", "Piko recebe a missão de recuperar a Pedra de Arkan.");
$cena2 = new Cena(2, "Saída da Vila", "Piko sai da vila e escolhe um caminho.");
$cena3 = new Cena(3, "Floresta Superior", "Piko segue pelo caminho superior da floresta.");
$cena4 = new Cena(4, "Batalha 1", "Piko encontra um inimigo no caminho superior.");
$cena5 = new Cena(5, "Floresta Inferior", "Piko segue pelo caminho inferior da floresta.");
$cena6 = new Cena(6, "Caverna / Batalha 2", "Piko enfrenta um desafio de dados e depois um inimigo na caverna.");
$cena7 = new Cena(7, "Ponte Quebrada", "Piko precisa escolher como passar pela ponte.");
$cena8 = new Cena(8, "Pular / Batalha", "Piko enfrenta um desafio de dados e depois o Guardião da Ponte.");
$cena9 = new Cena(9, "Contorno", "Piko decide contornar a ponte quebrada.");
$cena10 = new Cena(10, "Castelo", "Piko chega ao Castelo de Drakmor.");
$cena11 = new Cena(11, "Boss Varyn", "Piko enfrenta Varyn em Pedra, Papel e Tesoura.");
$cena12 = new Cena(12, "Fase Secreta", "Piko encontra uma passagem secreta depois de derrotar Varyn.");
$cena13 = new Cena(13, "Recuperar Pedra", "Piko recupera a Pedra de Arkan e conclui a missão.");
$cena14 = new Cena(14, "Batalha contra a Mãe", "A mãe de Piko tenta impedir que ele saia de Valebrook.");

$cena1->adicionarTransicao(14);
$cena14->adicionarTransicao(2);

$cena2->adicionarTransicao(3);
$cena2->adicionarTransicao(5);

$cena3->adicionarTransicao(4);
$cena4->adicionarTransicao(7);

$cena5->adicionarTransicao(6);
$cena6->adicionarTransicao(7);

$cena7->adicionarTransicao(8);
$cena7->adicionarTransicao(9);

$cena8->adicionarTransicao(10);
$cena9->adicionarTransicao(10);

$cena10->adicionarTransicao(11);

$cena11->adicionarTransicao(12);
$cena11->adicionarTransicao(13);

$desafioCaverna = new Desafio(
    "Batalha de dados na caverna",
    new Dado(6),
    "Piko venceu a melhor de 3.",
    "Piko perdeu a melhor de 3."
);
$cena6->setDesafio($desafioCaverna);

$desafioPonte = new Desafio(
    "Batalha de dados na ponte",
    new Dado(6),
    "Piko venceu a melhor de 3.",
    "Piko perdeu a melhor de 3."
);
$cena8->setDesafio($desafioPonte);

$cenas = array();
$cenas[1] = $cena1;
$cenas[2] = $cena2;
$cenas[3] = $cena3;
$cenas[4] = $cena4;
$cenas[5] = $cena5;
$cenas[6] = $cena6;
$cenas[7] = $cena7;
$cenas[8] = $cena8;
$cenas[9] = $cena9;
$cenas[10] = $cena10;
$cenas[11] = $cena11;
$cenas[12] = $cena12;
$cenas[13] = $cena13;
$cenas[14] = $cena14;
