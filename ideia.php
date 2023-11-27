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

// Verificar se o formulário de criação de ideia foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter os dados do formulário
    $nomeIdeia = $_POST['nome_ideia'];
    $descricao = $_POST['descricao'];
    $valorNin = $_POST['Valor_nin'];
    $foto = $_FILES['foto']['tmp_name']; // Local temporário do arquivo enviado
    $tipoApoiador = $_POST['tipo_apoiador'];
    $tag = $_POST['Tag'];
    $tipoIdeia = $_POST['tipo_ideia'];
    $email = $_SESSION['email']; // Obtém o email do usuário logado

    // Verificar se já existe uma ideia com o mesmo nome no banco de dados
    $queryVerificaNome = "SELECT COUNT(*) AS total FROM ideia WHERE nome_ideia = :nomeIdeia";
    $stmtVerificaNome = $con->prepare($queryVerificaNome);
    $stmtVerificaNome->bindParam(':nomeIdeia', $nomeIdeia);
    $stmtVerificaNome->execute();
    $resultVerificaNome = $stmtVerificaNome->fetch(PDO::FETCH_ASSOC);

    if ($resultVerificaNome['total'] > 0) {
        // Se já existir uma ideia com o mesmo nome, exiba uma mensagem de erro
        echo "<script type='text/javascript'>alert('Já existe uma ideia com o mesmo nome. Por favor, escolha outro nome.');";
        echo "javascript:window.location='ideia.html'</script>";
        exit();
    }

    // Verificar se foi enviado um arquivo de foto
    if (isset($_FILES['foto']) && is_uploaded_file($_FILES['foto']['tmp_name'])) {
        // Lê o conteúdo do arquivo em bytes
        $fotoConteudo = file_get_contents($foto);
    } else {
        $fotoConteudo = null;
    }

    // Inserir os dados na tabela
    $query = "INSERT INTO ideia (nome_ideia, descricao, Valor_nin, foto, tipo_apoiador, Tag, tipo_ideia, Email) VALUES (:nomeIdeia, :descricao, :valorNin, :foto, :tipoApoiador, :tag, :tipoIdeia, :email)";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':nomeIdeia', $nomeIdeia);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':valorNin', $valorNin);
    $stmt->bindParam(':foto', $fotoConteudo, PDO::PARAM_LOB); // Informa que é um parâmetro de objeto LOB
    $stmt->bindParam(':tipoApoiador', $tipoApoiador);
    $stmt->bindParam(':tag', $tag);
    $stmt->bindParam(':tipoIdeia', $tipoIdeia);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    echo "<script type='text/javascript'>alert('Ideia cadastrada');";
    echo " javascript:window.location='pagina_inicial.php'</script>";

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Criar Ideia</title>
</head>
<body>
    <h1>Criar Ideia</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="nome_ideia">Nome da Ideia:</label>
        <input type="text" name="nome_ideia" required><br><br>

        <!-- Restante do formulário -->

        <input type="submit" value="Criar Ideia">
    </form>
    <a href="pagina_inicial.php">Voltar</a>
</body>
</html>
