const abrirLogin = document.getElementById("abrirLogin");
const fecharLogin = document.getElementById("fecharLogin");
const modalLogin = document.getElementById("modalLogin");
const abrirCadastro = document.getElementById("abrirCadastro");
const fecharCadastro = document.getElementById("fecharCadastro");
const modalCadastro = document.getElementById("modalCadastro");

//Abrir login e cadastro
abrirLogin.addEventListener("click", function(){
    modalLogin.classList.add("aberto");
});
abrirCadastro.addEventListener("click", function(){
    modalCadastro.classList.add("aberto");
    modalLogin.classList.remove("aberto");
});

//Fechar pelo X
fecharLogin.addEventListener("click", function(){
    modalLogin.classList.remove("aberto");
});
fecharCadastro.addEventListener("click", function(){
    modalCadastro.classList.remove("aberto");
});

//Fechar clicando fora da caixa
modalLogin.addEventListener("click", function(evento){
    if(evento.target === modalLogin){
        modalLogin.classList.remove("aberto");
    }
});
modalCadastro.addEventListener("click", function(evento){
    if(evento.target === modalCadastro){
        modalCadastro.classList.remove("aberto");
    }
});
