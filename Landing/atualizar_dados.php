<?php
$con = new PDO("mysql:host=localhost;dbname=pit", "root", "");
// Iniciar a sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['nome'])) {
    // Redirecionar para a página de login se não estiver logado
    header("Location: index.html");
    exit();
}

// Verificar se o formulário de alteração foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar se o botão de exclusão foi acionado
    if (isset($_POST['delete'])) {
        // Deletar os dados da tabela
        $query = "DELETE FROM conta WHERE email = :email";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':email', $_SESSION['email']);
        $stmt->execute();

        echo "<script type='text/javascript'>alert('Conta deletada');</script>";
        echo "<script type='text/javascript'>window.location.href = 'login.html';</script>";
        exit();
    } else {
        // Obter os dados do formulário
        $nome = $_POST['nome'];
        $sobrenome = $_POST['sobrenome'];
        $senha = $_POST['senha'];
        $email = $_POST['email'];
        $informacao = $_POST['informacao'];
        $telefone = $_POST['telefone'];
        $cpf = $_SESSION['cpf'];
        $tipo = $_POST['tipo'];

        // Atualizar os dados na tabela
        $query = "UPDATE conta SET Nome = :nome, Sobrenome = :sobrenome, Senha = :senha, Email = :email, Informacao = :informacao, tel = :telefone, Tipo = :tipo WHERE cpf = :cpf";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':sobrenome', $sobrenome);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':informacao', $informacao);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->execute();

        echo "<script type='text/javascript'>alert('Dados alterados com sucesso');</script>";
        echo "<script type='text/javascript'>window.location.href = 'pagina_inicial.php';</script>";
        exit();
    }
}

// Obter os dados atuais da tabela
$query = "SELECT * FROM conta WHERE email = :email";
$stmt = $con->prepare($query);
$stmt->bindParam(':email', $_SESSION['email']);
$stmt->execute();
$dados = $stmt->fetch(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/alterar.css">
    <script src="assets/js/perfil.js"></script>
    <link rel="stylesheet" href="font awesome/css/all.min.css">
    <!-- biblioteca de ícones -->
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <title>Seu Perfil</title>
</head>

<body>
    <header>
        <div class="header-container">
            <nav class="desktop-nav">
                <ul>
                    <li><a href="Todas_as_ideias.php"><i class="fa-regular fa-lightbulb"></i> Ideias</a></li>
                    <li><a href="#"><i class="fa-solid fa-money-bill"></i> Apoiador</a></li>
                </ul>
            </nav>

            <div class="logo">
                <img alt="Logo" src="assets/img/LOGO.png">
            </div>

            <nav class="desktop-nav">
                <ul>
                    <li><a href="#"><i class="fa-solid fa-magnifying-glass"></i> Pesquisar</a></li>
                    <li><a href="pagina_inicial.php"><i class="fa-regular fa-user "></i></a></li>
                </ul>
            </nav>

            <div class="mobile-nav-icon">
                <i class="fas fa-bars"></i>
            </div>

            <nav class="mobile-nav">
                <ul>
                    <li><a href="#"><i class="fa-regular fa-lightbulb"></i> Ideias</a></li>
                    <li><a href="#"><i class="fa-solid fa-money-bill"></i> Apoiador</a></li>
                    <li><a href="#"><i class="fa-solid fa-magnifying-glass"></i> Pesquisar</a></li>
                    <li><a href="perfil-user.html"><i class="fa-regular fa-user "></i></a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <div class="form">
            <form action="" method="post">
                <div class="form-header">
                    <div class="title">
                        <h1>Seu Perfil</h1>
                    </div>
                    <div class="login-button">
                        <button type="submit" name="delete">Deletar Conta</button>
                    </div>
                </div>

                <div class="input-group">
                    <div class="input-box">
                        <label for="firstname">Alterar Nome</label>
                        <input id="atername" type="text" name="nome" placeholder="Digite seu Nome" value="<?php echo $dados['Nome']; ?>">
                    </div>

                    <div class="input-box">
                        <label for="lastname">Sobrenome</label>
                        <input id="lastname" type="text" name="sobrenome" placeholder="Digite seu Sobrenome" value="<?php echo $dados['Sobrenome']; ?>">
                    </div>

                    <div class="input-box">
                        <label for="email">Senha Nova</label>
                        <input id="email" type="password" name="senha" placeholder="Digite sua Senha" value="<?php echo $dados['Senha']; ?>">
                    </div>

                    <div class="input-box">
                        <label for="number">Alterar Celular</label>
                        <input id="number" type="tel" name="telefone" placeholder="(xx) x xxxx-xxxx" maxlength="15" value="<?php echo $dados['tel']; ?>">
                    </div>

                    <div class="input-box">
                        <label for="password">Alterar Email</label>
                        <input id="password" type="email" name="email" placeholder="Digite seu Email" value="<?php echo $dados['Email']; ?>">
                    </div>

                    <div class="input-box">
                        <label for="descrição">Alterar Descrição</label>
                        <textarea id="descricao" name="informacao" placeholder="Conte um pouco sobre você"><?php echo $dados['Informacao']; ?></textarea>
                    </div>

                    <div class="input-box">
                        <label>Alterar Tipo de Conta</label>
                        <div class="checkbox-group">
                            <div class="checkbox-input">
                                <input type="radio" id="ideias" name="tipo" value="criador_ideias" <?php if ($dados['tipo'] === 'criador_ideias') echo 'checked'; ?>>
                                <label for="ideias">Criador de Ideias</label>
                            </div>
                            <div class="checkbox-input">
                                <input type="radio" id="apoiador" name="tipo" value="apoiador_financiador" <?php if ($dados['tipo'] === 'apoiador_financiador') echo 'checked'; ?>>
                                <label for="apoiador">Apoiador/Financiador</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="continue-button">
                    <button type="submit" value="Alterar Dados">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
