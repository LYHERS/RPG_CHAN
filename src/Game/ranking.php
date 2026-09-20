<?php
function salvarPontuacaoRanking($nome, $pontuacao)
{
    if (isset($_SESSION["rankingSalvo"]) && $_SESSION["rankingSalvo"] === true) {
        return true;
    }

    $nome = trim($nome);
    if ($nome === "") {
        return false;
    }

    if (function_exists("mb_substr")) {
        $nome = mb_substr($nome, 0, 45);
    } else {
        $nome = substr($nome, 0, 45);
    }

    include __DIR__ . "/../Config/banco.php";

    if ($conexaoBanco === null) {
        return false;
    }

    $pontuacao = (int) $pontuacao;
    $sql = "INSERT INTO ranking (nome, pontuacao) VALUES (?, ?)";
    $stmt = $conexaoBanco->prepare($sql);

    if (!$stmt) {
        $conexaoBanco->close();
        return false;
    }

    $stmt->bind_param("si", $nome, $pontuacao);
    $ok = $stmt->execute();
    $stmt->close();
    $conexaoBanco->close();

    if ($ok) {
        $_SESSION["rankingSalvo"] = true;
    }

    return $ok;
}

function obterRanking($limite = 20)
{
    include __DIR__ . "/../Config/banco.php";

    if ($conexaoBanco === null) {
        return array();
    }

    $limite = max(1, min(100, (int) $limite));
    $resultado = $conexaoBanco->query("SELECT id, nome, pontuacao FROM ranking ORDER BY pontuacao DESC, id ASC LIMIT " . $limite);
    $ranking = array();

    if ($resultado) {
        while ($linha = $resultado->fetch_assoc()) {
            $ranking[] = $linha;
        }
        $resultado->free();
    }

    $conexaoBanco->close();
    return $ranking;
}
