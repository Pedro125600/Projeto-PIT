<?php
// ideias_seguidas.php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirecionar se o usuário não estiver logado
    exit;
}



$con = new PDO("mysql:host=localhost;dbname=pit", "root", "");

$id_usuario = $_SESSION['user_id'];

// Consulta para obter as ideias seguidas pelo usuário
$queryIdeiasSeguidas = "
    SELECT i.id, i.nome_ideia, i.descricao, i.Valor_nin, i.foto, i.tipo_apoiador, i.Tag, i.tipo_ideia, i.Email
    FROM ideia i
    INNER JOIN seguidores s ON i.id = s.id_ideia
    WHERE s.id_usuario = :id_usuario
";
$stmtIdeiasSeguidas = $con->prepare($queryIdeiasSeguidas);
$stmtIdeiasSeguidas->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
$stmtIdeiasSeguidas->execute();


// Obter os resultados da consulta em forma de array associativo
$ideiasSeguidas = $stmtIdeiasSeguidas->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html>
<head>
    <title>Ideias Seguidas</title>
</head>
<body>

<li>Ideias seguidas: <?php echo count($ideiasSeguidas); ?></li>

    <h1>Ideias Seguidas pelo Usuário</h1>
    <?php if (count($ideiasSeguidas) > 0) { ?>
        <ul>
            <?php foreach ($ideiasSeguidas as $ideia) { ?>
                <li>
                    <h2><?php echo $ideia['nome_ideia']; ?></h2>
                    <p><?php echo $ideia['descricao']; ?></p>
                    <p>Valor NIN: <?php echo $ideia['Valor_nin']; ?></p>
                    <p>Tipo de Apoiador: <?php echo $ideia['tipo_apoiador']; ?></p>
                    <p>Etiqueta: <?php echo $ideia['Tag']; ?></p>
                    <p>Tipo de Ideia: <?php echo $ideia['tipo_ideia']; ?></p>
                    <p>Email: <?php echo $ideia['Email']; ?></p>
                    <?php if (!empty($ideia['foto'])) : ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($ideia['foto']); ?>" alt="Foto da Ideia" width="200"><br>
                <?php endif; ?>
                    <!-- Você pode exibir outras informações da ideia aqui -->
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>Não há ideias seguidas pelo usuário.</p>
    <?php } ?>
</body>
</html>
