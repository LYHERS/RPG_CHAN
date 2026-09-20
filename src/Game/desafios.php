<?php




$dadoCaverna = new Dado(6);
$desafioCaverna = new Desafio(
    "Atravessar a caverna escura",
    $dadoCaverna,
    4,
    "Piko venceu a melhor de 3 nos dados e atravessou a caverna.",
    "A Sombra da Caverna venceu a melhor de 3 nos dados."
);
$cena6->setDesafio($desafioCaverna);


$dadoPular = new Dado(6);
$desafioPular = new Desafio(
    "Pular sobre a ponte quebrada",
    $dadoPular,
    4,
    "Piko venceu a melhor de 3 nos dados e superou a ponte.",
    "O Guardiao da Ponte venceu a melhor de 3 nos dados."
);
$cena8->setDesafio($desafioPular);


$dadoContorno = new Dado(6);
$desafioContorno = new Desafio(
    "Passar pelo caminho do contorno",
    $dadoContorno,
    4,
    "Piko venceu a batalha de dados e passou pelo contorno.",
    "A Guarda do Contorno venceu a melhor de 3 nos dados."
);
$cena9->setDesafio($desafioContorno);
