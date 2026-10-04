<?php 
	session_start(); 
	if (isset($_GET["erro"]) && $_GET["erro"] === "login") {
	    echo '<div class="mensagem-erro">
	    	Você precisa estar logado para acessar suas builds.
	    </div>';
	}
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
        <a href="index.php"><h1>Monkys</h1></a>  <!--eu vou editar uma imagem pra por aq-->
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
        <h2>Bem-vindo!</h2>
        <h4>Este site serve pra montar builds pro Monster Hunter Wilds</h4>
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
	        	<button type="button" id="salvarBuild">Salvar Build</button>
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
            	<input type="username" class="username" name="user" required>
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
    <script src="script.js"></script>
</body>
</html>
