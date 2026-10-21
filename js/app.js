// Filtro da tabela de clientes: esconde as linhas que não contêm o texto digitado.
var filtro = document.querySelector("#filtro-clientes");
var linhas = document.querySelectorAll("#tabela-clientes tbody tr");

if (filtro) {
    filtro.addEventListener("input", function () {
        var termo = filtro.value.toLowerCase();
        linhas.forEach(function (linha) {
            linha.style.display = linha.textContent.toLowerCase().indexOf(termo) === -1 ? "none" : "";
        });
    });
}

// Pede confirmação antes de excluir um cliente.
document.querySelectorAll(".form-excluir").forEach(function (form) {
    form.addEventListener("submit", function (evento) {
        if (!confirm("Excluir o cliente " + form.dataset.nome + "?")) {
            evento.preventDefault();
        }
    });
});
