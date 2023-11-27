<?php
header('Content-type: text/html;charset=utf-8');
session_start(); // Certifique-se de iniciar a sessão antes de verificar a variável $_SESSION

if (!isset($_SESSION['user_id'])) {
 

    echo "<script type='text/javascript'>alert('Doação Feita com sucesso');";
    echo "javascript:window.location='login.html'</script>";

    header("Location:login.html"); // Redirecionar se o usuário não estiver logado
  
exit();

}





$id_usuario = $_SESSION['user_id'];

if (isset($_POST['logout'])) {
    // Destruir a sessão
    session_destroy();

    // Redirecionar para a página de login ou outra página de sua escolha
    header("Location: login.html");
    exit();
}

// Verificar se o parâmetro ID foi passado na URL
if (isset($_GET['id'])) {
    $id_ideia = $_GET['id'];

    // Consultar os detalhes da ideia específica usando o ID
    $con = new PDO("mysql:host=localhost;dbname=pit", "root", "");
    $queryIdeia = "SELECT * FROM ideia WHERE id = :id";
    $stmtIdeia = $con->prepare($queryIdeia);
    $stmtIdeia->bindParam(':id', $id_ideia, PDO::PARAM_INT);
    $stmtIdeia->execute();
    $ideia = $stmtIdeia->fetch(PDO::FETCH_ASSOC);
} else {
    // Redirecionar para a página anterior se o ID não estiver presente na URL
    header("Location:pagina_inicial.php");
    exit;
}

// Verificar se o formulário de doação foi submetido
if (isset($_POST['valor-doacao'])) {
    // Capturar o valor da doação
    $valor_doacao = $_POST['valor-doacao'];

    // Insira a doação no banco de dados
    $queryInserirDoacao = "INSERT INTO doacoes_ideia (id_usuario, id_ideia, valor_doacao) VALUES (:id_usuario, :id_ideia, :valor_doacao)";
    $stmtInserirDoacao = $con->prepare($queryInserirDoacao);
    $stmtInserirDoacao->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT); // Usar o ID do usuário logado
    $stmtInserirDoacao->bindParam(':id_ideia', $id_ideia, PDO::PARAM_INT);
    $stmtInserirDoacao->bindParam(':valor_doacao', $valor_doacao, PDO::PARAM_STR);
    $stmtInserirDoacao->execute();


    echo "<script type='text/javascript'>alert('Doação Feita com sucesso');";
    echo "javascript:window.location='Doar.php'</script>";
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link rel="stylesheet" href="assetsIdeia/styles/parceria.css">
   
    <title>Página de Doação</title>
</head>

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

    <div class="central-div">
        <h1>Faça uma Doação</h1>
        <p>Qual valor você gostaria de doar?</p>
        <form method="POST">
            <input type="hidden" name="id_ideia" value="<?php echo $ideia['id']; ?>">
            <label for="valor-doacao">Valor da Doação (R$):</label>
            <input type="number"  step="0.01" min="0.01" id="valor-doacao" name="valor-doacao" placeholder="Digite o valor da doação" required>
            <button type="submit">Doar</button>
        </form>
    </div>

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

    <script src="assets/assets/js/main.js"></script>
</body>

</html>
