
<?php
header('Content-type: text/html;charset=utf-8');
$con = new PDO("mysql:host=localhost;dbname=pit", "root", "");

// Consultar todas as ideias
$queryIdeias = "SELECT * FROM ideia";
$stmtIdeias = $con->prepare($queryIdeias);
$stmtIdeias->execute();
$ideias = $stmtIdeias->fetchAll(PDO::FETCH_ASSOC);

session_start();

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
<html lang="Pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assets/styles/styles.css">
    <title>Great Ideia</title>
</head>
<form  method="post">
<body>
    <header>
        <nav class="navigation">
  
            <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="logo"></a>
            <ul class="nav-menu">
                <li class="nav-item"><a href="#">Ideias</a></li>
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

    <!-- Adicione isso acima do seu título "Destaques" -->
    <div class="filter-section">
        <button class="filter-button active" onclick="showAllIdeias()"> Todos</button>
        <button class="filter-button" onclick="filterIdeias('tecnologia')">tecnologia</button>
        <button class="filter-button" onclick="filterIdeias('Programação')">Programação</button>
        <button class="filter-button" onclick="filterIdeias('arte')">Arte</button>
        <button class="filter-button" onclick="filterIdeias('Jogos')">Jogos</button>
        <button class="filter-button" onclick="filterIdeias('educação')">educação</button>
        <button class="filter-button" onclick="filterIdeias('saúde')">saúde</button>
    </div>


    

    <section class="recentes">
        <h2>Recentes</h2>


        <div class="grid-container" id="card">
        <?php foreach ($ideias as $ideia) : ?>
            <div class="ideia-item" data-tipo="<?php echo $ideia['tipo_ideia']; ?>" >
                <div class="item-content">
                <?php if (!empty($ideia['foto'])) : ?>
                    <img class="Imagem" src="data:image/jpeg;base64,<?php echo base64_encode($ideia['foto']); ?>" alt="Foto da Ideia" height="150px" width="100%"><br>
                <?php endif; ?>  
                </div>
                <h3 class="ideia-title">  <a  href="pagina_ideia.php?id=<?php echo $ideia['id']; ?>"><?php echo $ideia['nome_ideia']; ?></a></h3>
            </div>
            <?php endforeach; ?>

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
</form>

    <script src="assets/assets/js/main.js"></script>
    <script>
        function filterIdeias(tipo) {
            const ideiasList = document.getElementById('card');
            const ideias = ideiasList.getElementsByTagName('div');

            for (let i = 0; i < ideias.length; i++) {
                const ideia = ideias[i];
                const tipoIdeia = ideia.getAttribute('data-tipo');
                if (tipoIdeia === tipo) {
                    ideia.style.display = 'block';
                } else {
                    ideia.style.display = 'none';
                }
            }
        }

        function showAllIdeias() {
            const ideiasList = document.getElementById('card');
            const ideias = ideiasList.getElementsByTagName('div');

            for (let i = 0; i < ideias.length; i++) {
                ideias[i].style.display = 'block';
            }
        }
    </script>
</body>

</html>