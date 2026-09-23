<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nome Site</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <h1>Nome Site</h1>

        <nav>
            <a href="#">label</a>
            <a href="#">label</a>
            <a href="#">label</a>

            <button id="abrirLogin">Entrar</button>
        </nav>
    </header>

    <main>
        <h2>Bem-vindo!</h2>

        <p>
         Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
          Lorem Ipsum has been the industrys standard dummy text ever since  
       </p>

        <p>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
            Lorem Ipsum has been the industrys standard dummy text ever since 
        </p>
    </main>


    <!-- Fundo escuro do modal -->
    <div id="modalLogin" class="modal">

        <!-- Caixa de login -->
        <div class="login-box">

            <button id="fecharLogin" class="fechar">&times;</button>

            <h2>Entrar</h2>

            <form action="login.php" method="POST">

                <label for="email">E-mail</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                >

                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required>
                <button type="submit" class="botao-login">Entrar</button>

            </form>

            <p class="cadastro">
                Ainda não possui uma conta?
                <a href="#">Criar conta</a>
            </p>

        </div>

    </div>


    <script src="script.js"></script>

</body>
</html>
