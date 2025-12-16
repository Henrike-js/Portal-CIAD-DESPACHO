<?php
include "conexao.php";

$sql = "SELECT 
            id,
            matricula,
            nome_teleatendente,
            data_atendimento,
            hora_atendimento,
            municipio_chamada,
            telefone_chamada,
            nome_solicitante,
            codigo_natureza
        FROM registros_chamadas
        ORDER BY data_atendimento DESC";

$resultado = $conexao->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Chamadas</title>

    <link rel="stylesheet" href="css/styles.css">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
<div class="page">

<header class="topbar">
    <div class="topbar-inner">

        <div class="logo-wrapper">
            <a href="../index.html" class="logo-link">
                <img src="img/sisp-logo.png" alt="Página inicial" class="logo-sisp-img">
            </a>
        </div>

    </div>
</header>

<main class="main">
<div class="main-inner">

<div class="page-header">
    <h1>Atendimentos Registrados</h1>
    <p>Listagem completa de chamadas cadastradas no sistema</p>
</div>

<div class="cards-grid">

<?php if ($resultado && $resultado->num_rows > 0): ?>
<?php while ($linha = $resultado->fetch_assoc()): ?>

<a href="relatorio_detalhe.php?id=<?= (int)$linha['id']; ?>" class="card">

    <div class="card-icon">📞</div>

    <div class="card-body">
        <div class="card-header">
            <h3><?= htmlspecialchars($linha['nome_solicitante']); ?></h3>
            <span class="card-ext">#<?= (int)$linha['id']; ?></span>
        </div>

        <p>
            <strong>Data:</strong>
            <?= date("d/m/Y", strtotime($linha['data_atendimento'])); ?>
            às <?= htmlspecialchars($linha['hora_atendimento']); ?>
        </p>

        <p>
            <strong>Teleatendente:</strong>
            <?= htmlspecialchars($linha['nome_teleatendente']); ?>
        </p>

        <p>
            <strong>Município:</strong>
            <?= htmlspecialchars($linha['municipio_chamada']); ?>
        </p>

        <p>
            <strong>Natureza:</strong>
            <?= htmlspecialchars($linha['codigo_natureza']); ?>
        </p>
    </div>

</a>

<?php endwhile; ?>
<?php else: ?>
    <p>Nenhum registro encontrado.</p>
<?php endif; ?>

</div>
</div>
</main>

<footer class="footer">
    Sistema de Relatórios • <?= date("Y"); ?>
</footer>

</div>
</body>
</html>
