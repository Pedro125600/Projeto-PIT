<?php
header('Content-type: text/html;charset=utf-8');
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
    header("Location: todas_ideias.php");
    exit;
}

session_start(); // Certifique-se de iniciar a sessão antes de verificar a variável $_SESSION




if (isset($_POST['logout'])) 
{
  // Destruir a sessão
  session_destroy();
  
  // Redirecionar para a página de login ou outra página de sua escolha
  header("Location:login.html");
  exit();

}


?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assetsIdeia/styles/pagina-ideia.css">
    <title>Great Ideia</title>
</head>

<body>
<header>
    <form method="post">
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
</form>
    <section>

        <div class="central-section">
            <div class="idea-card">
                <img class="profile-photo" src="assets/img/avatar.png" alt="Sua Foto de Perfil">
                <div class="left-content">
                    <!-- Imagem à esquerda (30% da largura) -->
                    <?php if (!empty($ideia['foto'])) : ?>
        <img src="data:image/jpeg;base64,<?php echo base64_encode($ideia['foto']); ?>" alt="Foto da Ideia" width="200"><br>
    <?php endif; ?>
                </div>
                <div class="right-content">
                    <!-- Nome da ideia em destaque -->
                    <h1><?php echo $ideia['nome_ideia']; ?></h1>
                    <!-- Tipo de apoiador -->
                    <p>Tipo de Apoiador :<?php echo $ideia['tipo_apoiador']; ?></p>
                    <!-- Tags -->
                <br>    <div class="tags">
                        <span>Tag:<?php echo $ideia['Tag']; ?></span> 
                        <span>Tipo:<?php echo $ideia['tipo_ideia']; ?></span>
                    </div> <br>
                    <!-- Descrição -->
                    <p>Descrição da ideia:<?php echo $ideia['descricao']; ?></ </p>
                    <!-- Valor Mínimo -->
                    <p> Criador:<?php echo $ideia['Email']; ?></p>
                    <!-- Botões de Ação com Ícones da Boxicons --><br>
                    <div class="action-buttons">
                    <a href="Doar.php?id=<?php echo $ideia['id']; ?>">
                            <button><i class='bx bx-like'></i> Doar</button>
                        </a>

                       <?php if (isset($_SESSION['user_id'])) : ?>
        <?php
        // Verificar se o usuário já segue essa ideia
        $queryCheckSeguir = "SELECT id_seguidor FROM seguidores WHERE id_usuario = :id_usuario AND id_ideia = :id_ideia";
        $stmtCheckSeguir = $con->prepare($queryCheckSeguir);
        $stmtCheckSeguir->bindParam(':id_usuario', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmtCheckSeguir->bindParam(':id_ideia', $id_ideia, PDO::PARAM_INT);
        $stmtCheckSeguir->execute();
        $seguindo = $stmtCheckSeguir->rowCount() > 0;
        ?>

        <form action="seguir_ideia.php" method="post">
            <input type="hidden" name="id_ideia" value="<?php echo $id_ideia; ?>">
            <?php if (!$seguindo) : ?>
              <br>  <button type="submit">Seguir</button>
            <?php else : ?>
             <br>   <button type="submit" disabled>Você está seguindo esta ideia</button>
            <?php endif; ?>
        </form>
    <?php else: ?>
        <p>Faça o login para seguir esta ideia.</p>
    <?php endif; ?>
        <br>

                        <a href="Investir.php?id=<?php echo $ideia['id']; ?>">
                            <button><i class='bx bx-color'></i> Parceria</button>
                        </a>

                    </div>
                    
                </div>
            </div>
        </div>
    </section>

      

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