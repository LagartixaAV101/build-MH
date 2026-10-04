<?php
session_start();

	require_once "conexao.php";

//Impede acesso sem login
	if (!isset($_SESSION["usuario_id"])) {
    	header("Location: index.php?erro=login");
    	exit;
	}
	$user_id = $_SESSION["usuario_id"];

// Busca somente as builds pertencentes ao usuário logado
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
    <link rel="icon" type="image/png" href="Image/icon.png">
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
            		<img src="Image/perfil.png" alt="Perfil">
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
                       	<?= htmlspecialchars($build["name"]) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="area-build">
        	<div id="principal" class="builder">
        		<button type="button" id="head" class="armor">
					<image src="Image/head.png" alt="elmo">
        		</button>
        		<button type="button" id="chest" class="armor">
					<image src="Image/chest.png" alt="peitoral">
        		</button>
        		<button type="button" id="arms" class="armor">
					<image src="Image/arms.png" alt="braços">
	        	</button>
        		<button type="button" id="waist" class="armor">
					<image src="Image/waist.png" alt="cintura">
        		</button>
        		<button type="button" id="legs" class="armor">
					<image src="Image/legs.png" alt="calças">
	        	</button>
        	</div>
        	<div class="status">
        	    <h2>Status</h2>
        	    <p>Defesa: <span id="defesa">0</span></p>
        	    <p>Fogo: <span id="fogo">0</span></p>
        	    <p>Água: <span id="agua">0</span></p>
        	    <p>Trovão: <span id="trovao">0</span></p>
        	    <p>Gelo: <span id="gelo">0</span></p>
        	    <p>Dragão: <span id="dragao">0</span></p>
        	    <h3>Habilidades</h3>
        		<div id="skills"></div>
        	</div>
        </div>
    </main>
    <!--Login-->
    <div  id="modalLogin" class="modal">
        <div class="caixa-login">
            <button id="fecharLogin" class="fechar">&times;</button>
            <h2>Entrar</h2>
            <form action="login.php" method="POST">
                <label for="email">E-mail</label>
                <input type="email" class="email" name="email" required>
                <label for="senha">Senha</label>
                <input type="password" class="senha" name="senha" required>
                <button type="submit" class="botao-login">Entrar</button>
            </form>
            <p class="cadastro">
                <a id="abrirCadastro" href="#">Não possuo uma conta</a>
            </p>
        </div>
    </div>
    <!--Cadastro-->
    <div  id="modalCadastro" class="modal">
        <div class="caixa-login">
        	<button id="fecharCadastro" class="fechar">&times;</button>
            <h2>Cadastro</h2>
            <form action="cadastro.php" method="POST">
            	<label for="user">Usuario</label>
            	<input type="username" class="username" name="username" required>
	            <label for="email">E-mail</label>
    	        <input type="email" class="email" name="email" required>
           		<label for="senha">Senha</label>
            	<input type="password" class="senha" name="senha" required>
            	<button type="submit" class="botao-login">Cadastrar</button>
            </form>
            <p class="cadastro">
           		<a id="Login" href="#">Já possuo uma conta</a>
            </p>
        </div>
	</div>
    <script src="script.js"></script>
</body>
</html>
<?php 
	$stmt->close();
	$conn->close();
?>
