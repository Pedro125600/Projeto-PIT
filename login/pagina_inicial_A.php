
<?php

header('Content-type: text/html;charset=utf-8');

$con = new PDO("mysql:host=localhost;dbname=pit", "root", "root");
// Iniciar a sessão
session_start();

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


if (isset($_POST['logout'])) 
{
  // Destruir a sessão
  session_destroy();
  
  // Redirecionar para a página de login ou outra página de sua escolha
  header("Location:login.html");
  exit();

}


$con = new PDO("mysql:host=localhost;dbname=pit", "root", "root");

$id_usuario = $_SESSION['user_id'];

// Consulta para obter as ideias seguidas pelo usuário
$queryIdeiasSeguidas = "
    SELECT i.id, i.nome_ideia, i.descricao, i.Valor_nin, i.foto, i.tipo_apoiador, i.Tag, i.tipo_ideia, i.Email
    FROM ideia i
    INNER JOIN seguidores s ON i.id = s.id_ideia
    WHERE s.id_usuario = :id_usuario LIMIT 1
";
$stmtIdeiasSeguidas = $con->prepare($queryIdeiasSeguidas);
$stmtIdeiasSeguidas->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
$stmtIdeiasSeguidas->execute();

// Obter os resultados da consulta em forma de array associativo
$ideiasSeguidas = $stmtIdeiasSeguidas->fetchAll(PDO::FETCH_ASSOC);


?>





<!DOCTYPE html>
<html style="font-size: 16px;" lang="pt"><head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="Seu Perfil, Ideias Sequidas">
    <meta name="description" content="">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="assets/css/nicepageA.css" media="screen">
<link rel="stylesheet" href="assets/css/Página-Inicial.css" media="screen">
    <script class="u-script" type="text/javascript" src="jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
    <meta name="generator" content="Nicepage 5.17.1, nicepage.com">
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
    <link id="u-page-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:100,200,300,400,500,600,700,800,900">
    <link rel='stylesheet' type='text/css' media='screen' href='assets/css/landing.css'>
    <!-- biblioteca de ícones -->
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    
    
    <script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": ""
}</script>
    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="Página Inicial">
    <meta property="og:type" content="website">
  <meta data-intl-tel-input-cdn-path="intlTelInput/"></head>
  <body data-home-page="Página-Inicial.html" data-home-page-title="Página Inicial" class="u-body u-xl-mode" data-lang="pt">

  <header>
        <div class="header-container">
            <nav class="desktop-nav">
                <ul>
                    <li><a href="exibir_ideias.php"><i class="fa-regular fa-lightbulb"></i> Ideias</a></li>
                    <li><a href="#"><i class="fa-solid fa-money-bill"></i> Apoiador</a></li>
                </ul>
            </nav>

        <a href="lading.html">    <div class="logo">
                <img alt="Logo" src="assets/img/LOGO.png">
            </div> </a>

            <nav class="desktop-nav">
                <ul>
                    <li><a href="#"><i class="fa-solid fa-magnifying-glass"></i> Pesquisar</a></li>
                    <li><a href="#"><i class="fa-regular fa-user "></i></a></li>
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
<form  method="post">
    <section class="u-clearfix u-gradient u-section-1" id="sec-ec65">
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-container-style u-expanded-width-sm u-expanded-width-xs u-group u-radius-30 u-shape-round u-white u-group-1">
          <div class="u-container-layout u-container-layout-1">
            <img class="u-image u-image-contain u-image-default u-image-1" src="assets/img/ideia2.svg" alt="" data-image-width="346" data-image-height="489">
            <h2 class="u-align-center u-text u-text-1">Seu Perfil</h2>
            <h3 class="u-align-center u-custom-font u-text u-text-2">Usuario</h3>
            <img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-2" src="assets/img/Vector.png" alt="" data-image-width="27" data-image-height="25">
            <img class="u-image u-image-circle u-image-contain u-preserve-proportions u-image-3" src="assets/img/Group18.png" alt="" data-image-width="241" data-image-height="237">
            <h4 class="u-align-left u-text u-text-3">Tipo de conta : <?php echo $_SESSION['tipo']; ?><br>Email:<?php echo $_SESSION['email']; ?><br> Telefone:<?php echo $_SESSION['tel']; ?><br>Descrição:<?php echo $_SESSION['info']; ?><br>
            </h4>
            <h5 class="u-align-center u-text u-text-4">Você já apoiou x ideias!!</h5>
            <h2 class="u-align-center u-text u-text-default u-text-5">Ideias Sequidas</h2>
            <div class="u-container-style u-custom-color-1 u-expanded-width-md u-expanded-width-sm u-expanded-width-xs u-group u-radius-22 u-shape-round u-group-2">
              <div class="u-container-layout u-container-layout-2">
                <div class="u-list u-list-1">
                  <div class="u-repeater u-repeater-1">
                    <div class="u-container-style u-hover-feature u-list-item u-radius-10 u-repeater-item u-shape-rectangle u-white u-list-item-1">
                      <div class="u-container-layout u-similar-container u-valign-middle u-container-layout-3">
                      <?php if (!empty($ideia['foto'])) : ?>
                        <img class="u-image u-image-4" src="data:image/jpeg;base64,<?php echo base64_encode($ideia['foto']); ?>" alt="Foto da Ideia" data-image-width="1280" data-image-height="853">
                        <?php endif; ?>
                      </div>
                    </div>
                    <div class="u-container-style u-hover-feature u-list-item u-radius-10 u-repeater-item u-shape-rectangle u-white u-list-item-2">
                      <div class="u-container-layout u-similar-container u-valign-middle u-container-layout-4">
                        <img class="u-image u-image-5" src="https://pixabay.com/get/gc9b744cf2e4f231a4f50edf67cb7092011bd19e7b14e39326925d3bab37987d9015f5ae4c39eecb775c35a621cbef4f30d3ba18c11d2bdbdfdac45dfe0950ba9_1280.jpg" data-image-width="1280" data-image-height="853">
                      </div>
                    </div>
                    <div class="u-container-style u-hover-feature u-list-item u-radius-10 u-repeater-item u-shape-rectangle u-white u-list-item-3">
                      <div class="u-container-layout u-similar-container u-valign-middle u-container-layout-5">
                        <img class="u-image u-image-6" src="https://pixabay.com/get/gc9b744cf2e4f231a4f50edf67cb7092011bd19e7b14e39326925d3bab37987d9015f5ae4c39eecb775c35a621cbef4f30d3ba18c11d2bdbdfdac45dfe0950ba9_1280.jpg" data-image-width="1280" data-image-height="853">
                      </div>
                    </div>
                    <div class="u-container-style u-hover-feature u-list-item u-radius-10 u-repeater-item u-shape-rectangle u-white u-list-item-4">
                      <div class="u-container-layout u-similar-container u-valign-middle u-container-layout-6">
                        <img class="u-image u-image-7" src="https://pixabay.com/get/gc9b744cf2e4f231a4f50edf67cb7092011bd19e7b14e39326925d3bab37987d9015f5ae4c39eecb775c35a621cbef4f30d3ba18c11d2bdbdfdac45dfe0950ba9_1280.jpg" data-image-width="1280" data-image-height="853">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <input id="logout" name="logout" type="submit"  class="u-border-none u-btn u-btn-round u-button-style u-palette-2-base u-radius-21 u-btn-1" >
          </div>
        </div>
      </div>
      </form>
    </section>
    
    
    
    
   
  
</body></html>