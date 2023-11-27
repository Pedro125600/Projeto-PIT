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

// Consultar as ideias em que o usuário doou ou investiu
$queryIdeiasDoacoes = "SELECT DISTINCT i.*, d.valor_doacao, NULL AS porcentagem_retorno, NULL AS valor_investimento
                      FROM ideia i
                      INNER JOIN doacoes_ideia d ON i.id = d.id_ideia
                      WHERE d.id_usuario = :id_usuario
                      UNION
                      SELECT DISTINCT i.*, NULL AS valor_doacao, inv.porcentagem_retorno, inv.valor_investimento
                      FROM ideia i
                      INNER JOIN investimentos inv ON i.id = inv.id_ideia
                      WHERE inv.id_usuario = :id_usuario";
$stmtIdeiasDoacoes = $con->prepare($queryIdeiasDoacoes);
$stmtIdeiasDoacoes->bindParam(':id_usuario', $_SESSION['user_id'], PDO::PARAM_INT);
$stmtIdeiasDoacoes->execute();
$ideiasDoacoes = $stmtIdeiasDoacoes->fetchAll(PDO::FETCH_ASSOC);
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
    <script src='main.js'></script>
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

    <main>
    <div class="container">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome da Ideia</th>
                    <th>Descrição</th>
                    <th>Valor Doado / Investido</th>
                    <th>Porcentagem Adquirida</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($ideiasDoacoes as $index => $ideia) : ?>
                <tr class="<?php echo ($index % 2 == 0) ? 'odd' : 'even'; ?>">
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo $ideia['nome_ideia']; ?></td>
                    <td><?php echo $ideia['descricao']; ?></td>
                    <td>
                        <?php if (!empty($ideia['valor_doacao'])) : ?>
                            <?php echo number_format($ideia['valor_doacao'], 2, ',', '.'); ?> (Doação)<br>
                        <?php endif; ?>
                        <?php if (!empty($ideia['valor_investimento'])) : ?>
                            <?php echo number_format($ideia['valor_investimento'], 2, ',', '.'); ?> (Investimento)<br>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($ideia['porcentagem_retorno'])) : ?>
                            <?php echo $ideia['porcentagem_retorno']; ?>%
                        <?php endif; ?>
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
            <div class "footer-section">
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
