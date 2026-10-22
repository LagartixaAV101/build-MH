//script do login modal
const abrirLogin = document.getElementById("abrirLogin");
const fecharLogin = document.getElementById("fecharLogin");
const modalLogin = document.getElementById("modalLogin");
const abrirCadastro = document.getElementById("abrirCadastro");
const fecharCadastro = document.getElementById("fecharCadastro");
const modalCadastro = document.getElementById("modalCadastro");
const Login2 = document.getElementById("Login");

//abre login e cadastro
if(abrirLogin && modalLogin){
    abrirLogin.addEventListener("click", function (){
        modalLogin.classList.add("aberto");
    });
}
if(abrirCadastro && modalCadastro && modalLogin){
    abrirCadastro.addEventListener("click", function (evento){
        evento.preventDefault();
        modalCadastro.classList.add("aberto");
        modalLogin.classList.remove("aberto");
    });
}
if(Login2 && modalLogin && modalCadastro){
    Login2.addEventListener("click", function (evento){
        evento.preventDefault();
        modalLogin.classList.add("aberto");
        modalCadastro.classList.remove("aberto");
    });
}

//fecha o login clicando no X
if(fecharLogin && modalLogin){
    fecharLogin.addEventListener("click", function (){
        modalLogin.classList.remove("aberto");
    });
}
if(fecharCadastro && modalCadastro){
    fecharCadastro.addEventListener("click", function (){
        modalCadastro.classList.remove("aberto");
    });
}

//fecha clicando fora da tela
if(modalLogin){
    modalLogin.addEventListener("click", function (evento){
        if (evento.target === modalLogin){
            modalLogin.classList.remove("aberto");
        }
    });
}
if(modalCadastro){
    modalCadastro.addEventListener("click", function (evento){
        if (evento.target === modalCadastro){
            modalCadastro.classList.remove("aberto");
        }
    });
}



//perfil logado
const botaoPerfil = document.getElementById("botaoPerfil");
const menuPerfil = document.getElementById("menuPerfil");

if(botaoPerfil && menuPerfil){
    botaoPerfil.addEventListener("click", function (){
        menuPerfil.classList.toggle("aberto");
    });
}

//atualiza os status
function atualizarStatus() {
    const atributos = {
        defesa: 0,
        fogo: 0,
        agua: 0,
        trovao: 0,
        gelo: 0,
        dragao: 0
    };

    Object.values(build).forEach(idEquipamento => {
        if (idEquipamento === null) {
            return;
        }

        const equipamento = armaduras.find(
            item => Number(item.id) === Number(idEquipamento)
        );

        if (!equipamento) {
            return;
        }

        atributos.defesa += Number(equipamento.defesa) || 0;
        atributos.fogo += Number(equipamento.fogo) || 0;
        atributos.agua += Number(equipamento.agua) || 0;
        atributos.trovao += Number(equipamento.trovao) || 0;
        atributos.gelo += Number(equipamento.gelo) || 0;
        atributos.dragao += Number(equipamento.dragao) || 0;
    });

    Object.entries(atributos).forEach(([atributo, valor]) => {
        const elemento = document.getElementById(atributo);

        if(elemento){
            elemento.textContent = valor;
        }
    });
}
function atualizarStatusArma(){
    const armaSelec = armas.find(arma => Number(arma.id) === Number(build.weapon));

    const weaponAtaque = document.getElementById("dano");
    const weaponAfinidade = document.getElementById("afinidade");
	

    if (!weaponAtaque || !weaponAfinidade){
        return;
    }

    weaponAtaque.textContent = armaSelec ? armaSelec.ataque : 0;

    weaponAfinidade.textContent = armaSelec ? armaSelec.afinidade : 0;
}

const build = {
	weapon: null,
    head: null,
    chest: null,
    arms: null,
    waist: null,
    legs: null
};
//busca os equipamentos no DB
let armaduras = [];
let armadurasCarregadas = false;
let armas = [];
let armasCarregadas = false;

async function carregarArmas(){
	try{
		const resposta = await fetch("weapon_src.php");
		if(!resposta.ok){
			throw new Error("Erro ao buscar armas");
		}
		armas = await resposta.json();
		armasCarregadas = true;
		atualizarStatusArma();
		console.log(armas);
	}catch(erro){
		console.error("Erro ao carregar armas:", erro);
	}
}

async function carregarArmaduras(){
    try{
        const resposta = await fetch("armor_src.php");

        if(!resposta.ok){
            throw new Error("Erro ao buscar armaduras");
        }

        armaduras = await resposta.json();
        armadurasCarregadas = true;
        atualizarStatus();
        console.log(armaduras);
    } catch(erro){
        console.error("Erro ao carregar armaduras:", erro);
    }
}

async function inicializarConstrutor() {
    await Promise.all([
        carregarArmas(),
        carregarArmaduras()
    ]);

    if (buildAtual !== null){
        await carregarBuildSalva(buildAtual);
    }
}

inicializarConstrutor();


//aparece as armaduras pra selecionar
const modalArmor = document.getElementById("modalArmaduras");
document.querySelectorAll(".armor").forEach(botao => {
    botao.addEventListener("click", () => {
        const tipo = botao.id;
        abrirSelecao(tipo);
    });
});
const botaoArma = document.getElementById("weapon");
if (botaoArma) {
    botaoArma.addEventListener("click", abrirSelecaoArmas);
}

function abrirSelecao(tipo){
    if (!armadurasCarregadas){
        alert("As armaduras ainda estão carregando.");
        return;
    }
    const disponiveis = armaduras.filter(
        armadura => armadura.armor_type === tipo
    );
    const lista = document.getElementById("listaArmaduras");

    lista.innerHTML = "";

    disponiveis.forEach(armadura => {
        const botao = document.createElement("button");
        botao.classList.add("opcao-armadura");
        botao.textContent = `${armadura.nome} - Defesa: ${armadura.defesa}`;
        botao.addEventListener("click", () => {
            selecionarArmadura(tipo, armadura);
        });
        lista.appendChild(botao);
    });
    modalArmor.classList.add("aberto");
}
function abrirSelecaoArmas() {
    if (!armasCarregadas) {
        alert("As armas ainda estão carregando.");
        return;
    }
    const titulo = document.getElementById("tituloArmaduras");
    const lista = document.getElementById("listaArmaduras");

    if (!modalArmor || !lista || !titulo) {
        console.error("Elementos do modal não encontrados.");
        return;
    }

    titulo.textContent = "Selecionar arma";
    lista.innerHTML = "";
    armas.forEach(arma => {
        const botao = document.createElement("button");

        botao.type = "button";
        botao.classList.add("opcao-armadura");

        botao.textContent = `${arma.nome} - Ataque: ${arma.ataque}`;

        botao.addEventListener("click", () => {selecionarArmas(arma);});

        lista.appendChild(botao);
    });

    modalArmor.classList.add("aberto");
}

function selecionarArmadura(tipo, armadura){
    build[tipo] = armadura.id;

	const nomes = {
		head: "cabeca",
		chest: "peito",
		arms: "braco",
		waist: "cinto",
		legs: "perna"
	};
	NomeEquip(nomes[tipo], armadura.nome);
    
    atualizarStatus();
    console.log("Armadura selecionada:", armadura);
    console.log("Build:", build);
    modalArmor.classList.remove("aberto");
}
function selecionarArmas(arma){
    build.weapon = arma.id;
	NomeEquip("arma", arma.nome);
	NomeEquip("tipo_arma", arma.tipo_arma);
    atualizarStatusArma();
    console.log("Arma selecionada:", arma);
    console.log("Build:", build);
    modalArmor.classList.remove("aberto");
	
}

const fecharArmadura = document.getElementById("fecharArmaduras");
if(fecharArmadura && modalArmor){
    fecharArmadura.addEventListener("click", function (){
        modalArmor.classList.remove("aberto");
    });
}
if(modalArmor){
    modalArmor.addEventListener("click", function (evento){
        if (evento.target === modalArmor){
            modalArmor.classList.remove("aberto");
        }
    });
}

//atualiza nomes do equipamentos
function NomeEquip(id, nome){
	const nomeEq = document.getElementById(id);
	if(nomeEq){
		nomeEq.textContent = nome;
	}
}

//Salva Build
const salvarBuild = document.getElementById("salvarBuild");
const modalSalvarBuild = document.getElementById("modalSalvarBuild");
const fecharSalvarBuild = document.getElementById("fecharSalvarBuild");
const confirmarSalvarBuild = document.getElementById("confirmarSalvarBuild");

if (salvarBuild && modalSalvarBuild){

    salvarBuild.addEventListener("click", function () {
        modalSalvarBuild.classList.add("aberto");
    });
}
if (fecharSalvarBuild && modalSalvarBuild){

    fecharSalvarBuild.addEventListener("click", function () {
        modalSalvarBuild.classList.remove("aberto");
    });
}

if (modalSalvarBuild){
    modalSalvarBuild.addEventListener("click", function (evento) {
        if (evento.target === modalSalvarBuild) {
            modalSalvarBuild.classList.remove("aberto");
        }

    });
}

if (confirmarSalvarBuild){
    confirmarSalvarBuild.addEventListener("click", async function () {
        const nome = document.getElementById("nomeBuild").value.trim();
        if (nome === ""){
            alert("Digite um nome para a build.");
            return;
        }

		const idBuild = buildAtual;
		if(window.location.pathname.endsWith("/myBuild.php") && !buildAtual){
			alert("Selecione uma build para atualizar");
			return;
		}
        
        try{
            const resposta = await fetch("salvaBuild.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                	id: buildAtual,
                    nome: nome,
                    equipamentos: build
                })
            });
            const resultado = await resposta.json();
            if (!resposta.ok){
                throw new Error(resultado.mensagem || "Erro ao salvar build");
            }       

            if (resultado.sucesso){
                alert(idBuild ? "Build atualizada com sucesso" : "Build salva com sucesso!");
                modalSalvarBuild.classList.remove("aberto");
                document.getElementById("nomeBuild").value = "";
                if(idBuild){
                	location.reload();
                }
            }else{
                alert(resultado.mensagem || "não foi possivel salvar a build");
            }

        }catch(erro){
            console.error("Erro ao salvar build:", erro);
            alert(erro.message || "Erro ao salvar a build.");
        }
    });
}
// Seletor de build
const selecionarBuild = document.getElementById("selecionarBuild");

if (selecionarBuild) {
    selecionarBuild.addEventListener("change", function () {
        const buildId = this.value;

        if (buildId !== "") {
            window.location.href = "myBuild.php?id=" + encodeURIComponent(buildId);
        }
    });
}
//atualiza build

function atualizarNomesEquipamentos() {
    const nomesArmaduras = {
        head: "cabeca",
        chest: "peito",
        arms: "braco",
        waist: "cinto",
        legs: "perna"
    };

    // Atualiza os nomes das armaduras.
    for (const tipo in nomesArmaduras) {
        const armadura = armaduras.find(
            item => Number(item.id) === Number(build[tipo])
        );

        const elemento = document.getElementById(
            nomesArmaduras[tipo]
        );

        if (elemento) {
            elemento.textContent = armadura
                ? armadura.nome
                : "—";
        }
    }

    // Atualiza o nome e o tipo da arma.
    const arma = armas.find(
        item => Number(item.id) === Number(build.weapon)
    );

    const elementoArma = document.getElementById("arma");
    const elementoTipo = document.getElementById("tipo_arma");

    if (elementoArma) {
        elementoArma.textContent = arma ? arma.nome : "—";
    }

    if (elementoTipo) {
        elementoTipo.textContent = arma
            ? arma.tipo_arma
            : "—";
    }
}

async function carregarBuildSalva(id) {
    try {
        const resposta = await fetch(
            "carregaBuild.php?id=" + encodeURIComponent(id)
        );

        const dados = await resposta.json();

        if (!resposta.ok || !dados.sucesso) {
            throw new Error(
                dados.mensagem || "Não foi possível carregar a build."
            );
        }

        // Preenche o objeto usado pelo construtor.
        Object.assign(build, dados.equipamentos);

        // Atualiza os nomes e os status.
        atualizarNomesEquipamentos();
        atualizarStatus();
        atualizarStatusArma();

        console.log("Build carregada:", build);

    } catch (erro) {
        console.error("Erro ao carregar build:", erro);
        alert(erro.message || "Erro ao carregar a build.");
    }
}
