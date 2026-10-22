<?php
session_start();

	require_once "conexao.php";

//Impede acesso sem login
	if (!isset($_SESSION["usuario_id"])) {
    	header("Location: index.php?erro=login");
    	exit;
	}
	$user_id = $_SESSION["usuario_id"];

	$idBuild = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
//Busca somente as builds pertencentes ao usuário logado
	$sql = "SELECT id, nome FROM builds WHERE user_id = ? ORDER BY nome";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("i", $user_id);
	$stmt->execute();

	$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monkys Builder</title> 
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="imagem/icon.png">
</head>
<body>
    <header><!--lembrar de por aspas simples no monkys, nao agr pq fica tudo amarelo editando no micro-->
       <a href="index.php"><h1>Monkys</h1></a> <!--eu vou editar uma imagem pra por aq-->
        <nav>
            <a href="myBuild.php" class="butao">Minhas Builds</a>
            <a href="comunidade.php" class="butao">Comunidade</a>
            <?php if(isset($_SESSION["usuario_id"])): ?>				
            <div class="perfil">
            	<button class="botao-perfil" id="botaoPerfil">
            		<img src="imagem/perfil.png" alt="Perfil">
            	</button>
            	<div class="menu-perfil" id="menuPerfil">
            		<a href="logout.php">Sair</a>
		        	<a href="exclui_conta.php" class="excluir">Excluir conta</a>
           		</div>
            </div>
            <?php else: ?>
            	<button id="abrirLogin" class="butao">Entrar</button>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <h2>Minhas Builds</h2>
        <div class="seletor-build">
        	<select id="selecionarBuild">
            	<option value="">Selecione sua build</option>
            	<?php while ($build = $resultado->fetch_assoc()): ?>
                 	<option value="<?= $build["id"] ?>">
                       	<?= htmlspecialchars($build["nome"]) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
         <div class="area-build">
        	<div id="principal" class="builder">
        		<button type="button" id="weapon" class="weapon">
        			<img src="imagem/greatsword.png" alt="weapon">
        	    </button>
        		<button type="button" id="head" class="armor">
					<img src="imagem/head.png" alt="head">
        		</button>
        		<button type="button" id="chest" class="armor">
					<img src="imagem/chest.png" alt="chest">
        		</button>
        		<button type="button" id="arms" class="armor">
					<img src="imagem/arms.png" alt="arms">
	        	</button>
        		<button type="button" id="waist" class="armor">
					<img src="imagem/waist.png" alt="waist">
        		</button>
        		<button type="button" id="legs" class="armor">
					<img src="imagem/legs.png" alt="legs">
	        	</button>
	        	<button type="button" id="salvarBuild">Salvar Build</button>
        	</div>
        	<div class="status">
        	    <h2>Status</h2>
        	    <p>Dano: <span id="dano">0</span></p>        	
				<p>Afinidade: <span id="afinidade">0</span>%</p>
        	    <p>Defesa: <span id="defesa">0</span></p>
        	    <p>Fogo: <span id="fogo">0</span></p>
        	    <p>Água: <span id="agua">0</span></p>
        	    <p>Trovão: <span id="trovao">0</span></p>
        	    <p>Gelo: <span id="gelo">0</span></p>
        	    <p>Dragão: <span id="dragao">0</span></p>
        	    <h3>Habilidades</h3>
        		<div id="skills"></div>
        	</div>
        	<div class="nome_armor">
        	    <h2>Equipamentos</h2>
        	    <p>Arma: <span id="arma">—</span></p>
        	    <p>Tipo Arma: <span id="tipo_arma">—</span></p>
        	    <p>Head: <span id="cabeca">—</span></p>
        	    <p>Chest: <span id="peito">—</span></p>
        	    <p>Arms: <span id="braco">—</span></p>
        	    <p>Waist: <span id="cinto">—</span></p>
        	    <p>Legs: <span id="perna">—</span></p>
        	</div>
        </div>
    </main>
    <!--Mostra os equipamentos-->
    	<div id="modalArmaduras" class="modal">
    	    <div class="caixa-armaduras">
    	        <button id="fecharArmaduras">&times;</button>
    	        <h2 id="tituloArmaduras">Armaduras</h2>
    	        <div id="listaArmaduras"></div>
    	    </div>
    	</div>
    <!--Salva Build-->
    	<div id="modalSalvarBuild" class="modal">
    	    <div class="caixa-login">
    	        <button id="fecharSalvarBuild" class="fechar">&times;</button>
    	        <h2>Salvar Build</h2>
    	        <label for="nomeBuild">Nome da build</label>
    	        <input type="text" id="nomeBuild" maxlength="100" required>
    	        <button type="button" id="confirmarSalvarBuild">Salvar</button>
    	    </div>
    	</div>
    <script>
        const buildAtual = <?= json_encode($idBuild ?: null) ?>;
    </script>
    <script src="script.js"></script>
</body>
</html>
<?php 
	$stmt->close();
	$conn->close();
?>
