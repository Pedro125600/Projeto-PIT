<?php
header('Content-type: text/html;charset=utf-8');

$con = new PDO("mysql:host=localhost;dbname=pit", "root", "");
// Iniciar a sessão
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirecionar se o usuário não estiver logado
    exit;
}

if (isset($_POST['logout'])) 
{
  // Destruir a sessão
  session_destroy();
  
  // Redirecionar para a página de login ou outra página de sua escolha
  header("Location:index.html");
  exit();

}

$id_usuario = $_SESSION['user_id'];

// Consulta para obter as ideias seguidas pelo usuário
$queryIdeiasSeguidas = "
    SELECT i.id, i.nome_ideia, i.descricao, i.Valor_nin, i.foto, i.tipo_apoiador, i.Tag, i.tipo_ideia, i.Email
    FROM ideia i
    INNER JOIN seguidores s ON i.id = s.id_ideia
    WHERE s.id_usuario = :id_usuario LIMIT 4
";
$stmtIdeiasSeguidas = $con->prepare($queryIdeiasSeguidas);
$stmtIdeiasSeguidas->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
$stmtIdeiasSeguidas->execute();


// Obter os resultados da consulta em forma de array associativo
$ideiasSeguidas = $stmtIdeiasSeguidas->fetchAll(PDO::FETCH_ASSOC);


// Verificar se o usuário está logado
if (!isset($_SESSION['nome'])) {
    // Redirecionar para a página de login se não estiver logado
    header("Location: index.html");
    exit();
}

// Atualizar as informações do usuário na sessão em tempo real
$query = "SELECT * FROM conta WHERE email = :email";
$stmt = $con->prepare($query);
$stmt->bindParam(':email', $_SESSION['email']);
$stmt->execute();
$dados = $stmt->fetch(PDO::FETCH_ASSOC);

// Atualizar as informações na sessão
$_SESSION['nome'] = $dados['Nome'];
$_SESSION['sobrenome'] = $dados['Sobrenome'];
$_SESSION['email'] = $dados['Email'];
$_SESSION['info'] = $dados['Informacao'];
$_SESSION['tel'] = $dados['tel'];
$_SESSION['cpf'] = $dados['cpf'];
$_SESSION['tipo'] = $dados['tipo'];

// Consultar todas as ideias criadas pelo usuário
/*$queryIdeias = "SELECT i.id, i.nome_ideia, i.descricao, i.Valor_nin, i.foto, i.tipo_apoiador, i.Tag, i.tipo_ideia, i.Email
FROM ideia i
INNER JOIN seguidores s ON i.id = s.id_ideia
WHERE s.id_usuario = :id_usuario LIMIT 4"; // Limite de 4 ideias
$stmtIdeias = $con->prepare($queryIdeias);
$stmtIdeias->bindParam(':id_usuario', $_SESSION['id_usuario']); // Assuming you have an 'id_usuario' in your session
$stmtIdeias->execute();
$ideias = $stmtIdeias->fetchAll(PDO::FETCH_ASSOC);
$quantidadeIdeiasSeguidas = count($ideias);*/



?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Perfil de Usuário</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='assets/css/perfil.css'>
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <!-- biblioteca de ícones -->
    
    <script src='main.js'></script>
</head>
<form  method="post">
<body>
    <header>
        <nav class="navigation">
  
            <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="logo"></a>
            <ul class="nav-menu">
                <li class="nav-item"><a href="Todas_as_ideias.php">Ideias</a></li>
                <li class="nav-item"><a href="minhas_doacoes.php">Doações</a></li>
                <li class="nav-item"><a href="minhas_ideias.php">Arrecadações</a></li>
                <i class='bx bx-user'></i>
                <i class='bx bx-search'></i>
            </ul>
            <div class="menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </header>

    <div class="modal" id="userModal">
        <div class="modal-content">
            <i class='bx bx-user' style="color: red;"></i>
            <p>Deslogar do sistema?</p>
            <input type="submit" id="logout" name="logout" class="logout-button" value="deslogar">
            <button class="profile-button"> <a href="pagina_inicial.php"> Meu Perfil</button> </a>
        </div>
    </div>

    <main>
        <div class="container">
            <div class="form-header">
                <div class="usuario">
                    <div class="title">
                        <h1>Seu Perfil</h1>
                    </div>
                    <div class="">
                        <img src="assets/img/avatar.png" alt="Foto do Usuário">
                    </div>
                </div>

                <div class="detalhes-user">
                    <div class="nome-user">
                        <h2><?php echo $_SESSION['nome']; ?> <?php echo $_SESSION['sobrenome']; ?></h2>
                        <a href="atualizar_dados.php"><img src="assets/img/lapis.svg" alt="Foto do Usuário"></a>
                    </div>
                    <div class="dados">
                        <label>Tipo de conta : <?php echo $_SESSION['tipo']; ?></label>
                        <ul>
                            <li>Telefone: <?php echo $_SESSION['tel']; ?></li>
                            <li>Email: <?php echo $_SESSION['email']; ?></li>
                            <li>CPF: <?php echo $_SESSION['cpf']; ?></li>
                            <li>Ideias seguidas: <?php echo count($ideiasSeguidas); ?></li>

                            
                        </ul>
                    </div>
                </div>

                <div class="imagem-idea">
                    <img src="assets/img/ideia 1.svg" alt="bonequinho-lampada">
                </div>
            </div>

            <div class="seus-projetos">
                <div class="titulo">
                    <a href="ideias_seguidas.php"><h1>Ideias Seguidas</h1></a>
                </div>
                
                <div class="container-ideias">
                    <?php foreach ($ideiasSeguidas as $ideia) : ?>
                        <div class="box-ideia">
                        <?php if (!empty($ideia['foto'])) : ?>
                       <img src="data:image/jpeg;base64,<?php echo base64_encode($ideia['foto']); ?>" alt="Foto da Ideia" width="200">
                     <?php endif; ?>
         </div>
                    <?php endforeach; ?>
                </div>
                
            </div>
        </div>
    </main>
    <footer>
        <div class="footer-container">
            <!-- Primeira parte: Logo e direitos autorais -->
            <div class="footer-section">
                <a href="#" class="footer-logo"><img src="assets/img/logo.png" alt=""></a>
                <p>© 2023 Todos os Direitos Reservados.</p>
            </div>

            <!-- Segunda parte: Links de navegação -->
            <div class="footer-section">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Sobre</a></li>
                    <li><a href="#">Serviços</a></li>
                    <li><a href="#">Contato</a></li>
                </ul>
            </div>

            <!-- Terceira parte: Redes sociais -->
            <div class="footer-section">
                <a href="#"><i class='bx bxl-facebook'></i></a>
                <a href="#"><i class='bx bxl-linkedin'></i></a>
                <a href="#"><i class='bx bxl-twitter'></i></a>
                <a href="#"><i class='bx bxl-instagram'></i></a>
            </div>
        </div>
    </footer>
                        </form>

    <script src="assets/assets/js/main.js"></script>

</body>
</html>
