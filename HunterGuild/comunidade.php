<?php
session_start();
require_once "conexao.php";

$sql = "
    SELECT
        b.id,
        b.nome,
        b.atualizado_em,
        u.user
    FROM builds b
    INNER JOIN users u ON u.id = b.user_id
    WHERE b.publico = 1
    ORDER BY b.atualizado_em DESC
";

$resultado = $conn->query($sql);

if (!$resultado) {
    die("Erro ao buscar builds: " . $conn->error);
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
            		<a href="excluir_conta.php" class="excluir">Excluir conta</a>
            	</div>
            </div>
            <?php else: ?>
            	<button id="abrirLogin" class="butao">Entrar</button>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <h2>Builds da Comunidade</h2>       
        <div class="lista-builds">      
        	<?php if ($resultado->num_rows > 0): ?>       
            <?php while ($build = $resultado->fetch_assoc()): ?>        
            <div class="card-build">        
            	<h2> <?= htmlspecialchars($build['name']) ?> </h2>        
            	<p class="autor">Criada por:
            		<strong><?= htmlspecialchars($build['username']) ?></strong>
           		</p>        
            	<p class="data">Última alteração:
	            	<?= date("d/m/Y", strtotime($build['updated_at']))?>
            	</p>       
            	<a href="selecionar_build.php?id=<?= $build['id'] ?>" class="botao-selecionar">SELECIONAR</a>        
        	</div>        
        	<?php endwhile; ?>        
            <?php else: ?>        
            	<p class="nenhuma-build">Nenhuma build pública foi encontrada.</p>       
            <?php endif; ?>      
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
