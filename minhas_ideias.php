<?php
header('Content-type: text/html;charset=utf-8');

$con = new PDO("mysql:host=localhost;dbname=pit", "root", "");
session_start();
// Verificar se o usuário está logado
if (!isset($_SESSION['nome'])) {
    // Redirecionar para a página de login se não estiver logado
    header("Location: login.html");
    exit();
}

// Consultar todas as ideias criadas pelo usuário
$queryIdeias = "SELECT i.*, SUM(d.valor_doacao) AS total_arrecadado
               FROM ideia i
               LEFT JOIN doacoes_ideia d ON i.id = d.id_ideia
               WHERE i.Email = :email
               GROUP BY i.id";
$stmtIdeias = $con->prepare($queryIdeias);
$stmtIdeias->bindParam(':email', $_SESSION['email']);
$stmtIdeias->execute();
$ideias = $stmtIdeias->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Minhas Ideias</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
   
    <link rel='stylesheet' type='text/css' media='screen' href='assets/css/m_ideiass.css'>
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <!-- Adicione seus estilos CSS aqui -->

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
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome da Ideia</th>
                    <th>Descrição</th>
                    <th>Valor NIN</th>
                    <th>Total Arrecadado</th>
                    <th>Doadores</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ideias as $index => $ideia) : ?>
                    <tr class="<?php echo ($index % 2 == 0) ? 'odd' : 'even'; ?>">
                        <td><strong><?php echo $index + 1; ?></strong></td>
                        <td><strong><?php echo $ideia['nome_ideia']; ?></strong></td>
                        <td><strong><?php echo $ideia['descricao']; ?></strong></td>
                        <td><strong><?php echo $ideia['Valor_nin']; ?></strong></td>
                        <td><strong>R$ <?php echo number_format($ideia['total_arrecadado'], 2, ',', '.'); ?></strong></td>
                        <td>
                            <ul>
                                <?php
                                // Consultar doadores para esta ideia
                                $queryDoadores = "SELECT c.Nome, c.Sobrenome
                                                  FROM conta c
                                                  INNER JOIN doacoes_ideia d ON c.id = d.id_usuario
                                                  WHERE d.id_ideia = :id_ideia";
                                $stmtDoadores = $con->prepare($queryDoadores);
                                $stmtDoadores->bindParam(':id_ideia', $ideia['id'], PDO::PARAM_INT);
                                $stmtDoadores->execute();
                                $doadores = $stmtDoadores->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($doadores as $doador) {
                                    echo "<li>{$doador['Nome']} {$doador['Sobrenome']}</li>";
                                }
                                ?>
                            </ul>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
    <script src="assets/assets/js/main.js"></script>
</body>
</html>
