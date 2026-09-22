<?php

$servidor = "localhost";
$usuario = "root";
$senha = "service";
$banco = "aw2";
$porta = 3306;

$conexaoBanco = @new mysqli(
    $servidor,
    $usuario,
    $senha,
    $banco,
    $porta
);

if ($conexaoBanco->connect_error) {
    $conexaoBanco = null;
} else {
    $conexaoBanco->set_charset("utf8mb4");
}