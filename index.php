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
        <h1>Monkys</h1> <!--eu vou editar uma imagem pra por aq-->
        <nav>
            <a href="#" class="butao">Minhas Builds</a>
            <a href="#">      </a>
            <a href="#" class="butao">Comunidade</a>
            <button id="abrirLogin" class="butao">Entrar</button>
        </nav>
    </header>
    <main>
        <h2>Bem-vindo!</h2>
        <h4>Lorem Ipsum blablabla</h4>
        <div id="principal" class="builder">
        	<button type="button" id="head" class="armor">
				<image src="Image/head.png">
        	</button>
        	<button type="button" id="chest" class="armor">
				<image src="Image/chest.png">
        	</button>
        	<button type="button" id="arms" class="armor">
				<image src="Image/arms.png">
        	</button>
        	<button type="button" id="waist" class="armor">
				<image src="Image/waist.png">
        	</button>
        	<button type="button" id="legs" class="armor">
				<image src="Image/legs.png">
        	</button>
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
	            <label for="email">E-mail</label>
    	        <input type="email" class="email" name="email" required>
           		<label for="senha">Senha</label>
            	<input type="password" class="senha" name="senha" required>
            	<button type="submit" class="botao-login">Cadastrar</button>
            </form>
        </div>
	</div>
    <script src="script.js"></script>
</body>
</html>
