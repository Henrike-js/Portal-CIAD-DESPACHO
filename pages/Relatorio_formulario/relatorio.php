<?php
include "conexao.php";

$destino = filter_input(INPUT_GET, 'destino', FILTER_SANITIZE_SPECIAL_CHARS);

$sql = "SELECT * FROM registros_chamadas";
$params = [];

if (in_array($destino, ['190', '193', '197'])) {
    $sql .= " WHERE destino_servico = ?";
}

$sql .= " ORDER BY data_atendimento DESC";

$stmt = $conexao->prepare($sql);

if (in_array($destino, ['190', '193', '197'])) {
    $stmt->bind_param("s", $destino);
}

$stmt->execute();
$resultado = $stmt->get_result();
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
<div class="filters-bar">
    <div class="filters-pills">

        <a href="relatorio.php"
           class="pill <?= !$destino ? 'pill-active' : '' ?>">
           Todos
        </a>

        <a href="relatorio.php?destino=190"
           class="pill <?= $destino === '190' ? 'pill-active' : '' ?>">
           190
        </a>

        <a href="relatorio.php?destino=193"
           class="pill <?= $destino === '193' ? 'pill-active' : '' ?>">
           193
        </a>

        <a href="relatorio.php?destino=197"
           class="pill <?= $destino === '197' ? 'pill-active' : '' ?>">
           197
        </a>

    </div>
</div>
<div class="cards-grid">

<?php if ($resultado && $resultado->num_rows > 0): ?>
<?php while ($linha = $resultado->fetch_assoc()): ?>

<a href="relatorio_detalhe.php?id=<?= (int)$linha['id']; ?>" class="card">

    <div class="card-icon">📞</div>

    <div class="card-body">
        <div class="card-header">
            <h3><?= htmlspecialchars($linha['codigo_natureza']); ?></h3>
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
            <?= htmlspecialchars($linha['nome_solicitante']); ?>
        </p>
    </div>

    '

</a>

<?php endwhile; ?>
<?php else: ?>
    <p>Nenhum registro encontrado.</p>
<?php endif; ?>

</div>
</div>

<div style="margin-top:30px; display:flex; justify-content:flex-end;">
    <a href="../Despachador_formulario/Despachador.php" class="btn-despachar">
        <span class="material-icons-outlined">local_police</span>
        Despachar
    </a>
</div>

</main>

<footer class="footer">
    Sistema de Relatórios • <?= date("Y"); ?>
</footer>

</div>
</body>
</html>
