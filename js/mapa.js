
document.addEventListener("DOMContentLoaded", function () {
    var botaoMapa = document.getElementById("botaoMapa");
    var painelMapa = document.getElementById("painelMapa");

    if (botaoMapa && painelMapa) {
        botaoMapa.addEventListener("click", function () {
            painelMapa.classList.toggle("escondido");
        });
    }
});
