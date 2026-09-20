
document.addEventListener("DOMContentLoaded", function () {
    var botoesIndisponiveis = document.querySelectorAll("[data-indisponivel]");

    botoesIndisponiveis.forEach(function (botao) {
        botao.addEventListener("click", function () {
            var antiga = document.querySelector(".mensagem-js");
            if (antiga) { antiga.remove(); }

            var mensagem = document.createElement("div");
            mensagem.className = "mensagem-js";
            mensagem.textContent = botao.getAttribute("data-indisponivel");
            document.body.appendChild(mensagem);

            window.setTimeout(function () {
                if (mensagem.parentNode) { mensagem.remove(); }
            }, 2200);
        });
    });
});
