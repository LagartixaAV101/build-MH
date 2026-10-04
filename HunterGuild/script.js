//script do login modal
const abrirLogin = document.getElementById("abrirLogin");
const fecharLogin = document.getElementById("fecharLogin");
const modalLogin = document.getElementById("modalLogin");
const abrirCadastro = document.getElementById("abrirCadastro");
const fecharCadastro = document.getElementById("fecharCadastro");
const modalCadastro = document.getElementById("modalCadastro");
const Login2 = document.getElementById("Login");

//abrir login e cadastro
if(abrirLogin && modalLogin){
	abrirLogin.addEventListener("click", function(){
    	modalLogin.classList.add("aberto");
	});
}
if(abrirCadastro && modalCadastro && modalLogin){
	abrirCadastro.addEventListener("click", function(evento){
		evento.preventDefault();
	    modalCadastro.classList.add("aberto");
    	modalLogin.classList.remove("aberto");
	});
}
if(Login2 && modalLogin && modalCadastro){
	Login2.addEventListener("click", function(evento){
		evento.preventDefault();
    	modalLogin.classList.add("aberto");
    	modalCadastro.classList.remove("aberto");
	});
}

//fechar pelo X
fecharLogin.addEventListener("click", function(){
    modalLogin.classList.remove("aberto");
});
fecharCadastro.addEventListener("click", function(){
    modalCadastro.classList.remove("aberto");
});

//fechar clicando fora da caixa
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

//perfil logado
const botaoPerfil = document.getElementById("botaoPerfil");
const menuPerfil = document.getElementById("menuPerfil");

if (botaoPerfil && menuPerfil) {
    botaoPerfil.addEventListener("click", function () {
        menuPerfil.classList.toggle("aberto");
    });
}

//busca armaduras no DB
let armaduras = [];
async function carregarArmaduras() {
    const resposta = await fetch("armor_src.php");
    if (!resposta.ok) {
        throw new Error("Erro ao buscar armaduras");
    }
    armaduras = await resposta.json();
    console.log(armaduras);
}
carregarArmaduras();

const build = {
    head: null,
    chest: null,
    arms: null,
    waist: null,
    legs: null
};
document.querySelectorAll(".armor").forEach(botao => {
    botao.addEventListener("click", () => {
        const tipo = botao.id;
        abrirSelecao(tipo);
    });
});
function abrirSelecao(tipo) {
    const disponiveis = armaduras.filter(
        armadura => armadura.armor_type === tipo
    );
    console.log(disponiveis);
}

//Salva Build
document.getElementById("confirmarSalvarBuild")
.addEventListener("click", async function () {
    const nome = document.getElementById("nomeBuild").value.trim();
    if (nome === "") {
        alert("Digite um nome para a build.");
        return;
    }
    const resposta = await fetch("salvar_build.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            nome: nome,
            equipamentos: build
        })
    });
    const resultado = await resposta.json();
    if (resultado.sucesso) {
        alert("Build salva com sucesso!");
    } else {
        alert(resultado.mensagem);
    }
});

//seletor de build
const selecionarBuild = document.getElementById("selecionarBuild");

if(selecionarBuild){
	selecionarBuild.addEventListener("change", function () {
		const buildId = this.value;
    		if (buildId === "") {
        		return;
        	}
    	window.location.href = "myBuild.php?id=" + buildId;
	});
}
