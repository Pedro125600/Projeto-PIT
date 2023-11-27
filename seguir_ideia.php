<?php
// seguir_ideia.php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirecionar se o usuário não estiver logado
    exit;
}

$con = new PDO("mysql:host=localhost;dbname=pit", "root", "");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_ideia'])) {
    $id_usuario = $_SESSION['user_id'];
    $id_ideia = $_POST['id_ideia'];

    // Verificar se o usuário já segue essa ideia
    $queryCheckSeguir = "SELECT id_seguidor FROM seguidores WHERE id_usuario = :id_usuario AND id_ideia = :id_ideia";
    $stmtCheckSeguir = $con->prepare($queryCheckSeguir);
    $stmtCheckSeguir->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmtCheckSeguir->bindParam(':id_ideia', $id_ideia, PDO::PARAM_INT);
    $stmtCheckSeguir->execute();

    if ($stmtCheckSeguir->rowCount() == 0) {
        // O usuário não segue essa ideia ainda, então vamos segui-la
        $querySeguir = "INSERT INTO seguidores (id_usuario, id_ideia) VALUES (:id_usuario, :id_ideia)";
        $stmtSeguir = $con->prepare($querySeguir);
        $stmtSeguir->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmtSeguir->bindParam(':id_ideia', $id_ideia, PDO::PARAM_INT);
        $stmtSeguir->execute();
    }
}

// Redirecionar para a página de detalhes da ideia após seguir
header("Location: pagina_ideia.php?id=" . $id_ideia);
exit;
?>
