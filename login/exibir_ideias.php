<?php
$con = new PDO("mysql:host=localhost;dbname=pit", "root", "");

// Consultar todas as ideias
$queryIdeias = "SELECT * FROM ideia";
$stmtIdeias = $con->prepare($queryIdeias);
$stmtIdeias->execute();
$ideias = $stmtIdeias->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Todas as Ideias</title>
</head>
<body>
    <h1>Todas as Ideias</h1>

    <!-- Adicione os botões para filtrar as ideias por tipo -->
    <button onclick="filterIdeias('tecnologia')">Tecnologia</button>
    <button onclick="filterIdeias('arte')">Arte</button>
    <button onclick="filterIdeias('educação')">Educação</button>
    <button onclick="filterIdeias('saúde')">Saúde</button>
    <button onclick="showAllIdeias()">Mostrar Todas</button>

    <ul id="ideias-list">
        <?php foreach ($ideias as $ideia) : ?>
            <li data-tipo="<?php echo $ideia['tipo_ideia']; ?>">
                <a href="pagina_ideia.php?id=<?php echo $ideia['id']; ?>"><?php echo $ideia['nome_ideia']; ?></a>
                <!-- Exibir a foto da ideia -->
                <?php if (!empty($ideia['foto'])) : ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($ideia['foto']); ?>" alt="Foto da Ideia" width="200"><br>
                <?php endif; ?>
                <strong>Tipo de Ideia:</strong> <?php echo $ideia['tipo_ideia']; ?><br>
            </li>
            <br>
        <?php endforeach; ?>
    </ul>

    <script>
        function filterIdeias(tipo) {
            const ideiasList = document.getElementById('ideias-list');
            const ideias = ideiasList.getElementsByTagName('li');

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
            const ideiasList = document.getElementById('ideias-list');
            const ideias = ideiasList.getElementsByTagName('li');

            for (let i = 0; i < ideias.length; i++) {
                ideias[i].style.display = 'block';
            }
        }
    </script>

</body>
</html>
