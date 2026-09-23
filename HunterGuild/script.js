const abrirLogin = document.getElementById("abrirLogin");
const fecharLogin = document.getElementById("fecharLogin");
const modalLogin = document.getElementById("modalLogin");


// Abrir o login
abrirLogin.addEventListener("click", function () {

    modalLogin.classList.add("aberto");

});


// Fechar pelo X
fecharLogin.addEventListener("click", function () {

    modalLogin.classList.remove("aberto");

});


// Fechar clicando fora da caixa
modalLogin.addEventListener("click", function (evento) {

    if (evento.target === modalLogin) {

        modalLogin.classList.remove("aberto");

    }

});
