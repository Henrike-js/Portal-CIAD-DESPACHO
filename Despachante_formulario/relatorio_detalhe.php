<?php
include "conexao.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die("Chamada inválida.");
}

$sql = "SELECT * FROM registros_chamadas WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("Registro não encontrado.");
}

$dados = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório da Chamada</title>

    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
<div class="page">

<!-- ===== TOPO ===== -->
<header class="topbar">
    <div class="topbar-inner">

        <div class="logo-wrapper">
            <a href="relatorio.php" class="logo-link">
                <img src="img/sisp-logo.png" alt="Página inicial" class="logo-sisp-img">
            </a>
        </div>

    </div>
</header>

<main class="main">
<div class="main-inner">

<div class="page-header">
    <h1>Registro de Chamadas</h1>
    <p>Relatório completo da ocorrência</p>
</div>

<!-- ===== CARD: DADOS DO TELEATENDENTE ===== -->
<div class="card">
<div class="card-body">
<h3>👤 Dados do Teleatendente</h3>

<p><strong>Matrícula:</strong> <?= htmlspecialchars($dados['matricula']); ?></p>
<p><strong>Nome:</strong> <?= htmlspecialchars($dados['nome_teleatendente']); ?></p>
<p><strong>Data:</strong> <?= date('d/m/Y', strtotime($dados['data_atendimento'])); ?></p>
<p><strong>Hora:</strong> <?= htmlspecialchars($dados['hora_atendimento']); ?></p>

<p>
<strong>Iniciativa:</strong> <?= htmlspecialchars($dados['iniciativa']); ?><br>
<strong>Viatura:</strong> <?= htmlspecialchars($dados['iniciativa_viatura']); ?><br>
<strong>Servidor:</strong> <?= htmlspecialchars($dados['iniciativa_servidor']); ?>
</p>
</div>
</div>

<!-- ===== CARD: LOCAL DA CHAMADA ===== -->
<div class="card">
<div class="card-body">
<h3>📍 Local da Chamada</h3>

<p><strong>Destino:</strong> <?= htmlspecialchars($dados['destino_servico']); ?></p>
<p>
<strong>Logradouro:</strong>
<?= htmlspecialchars($dados['logradouro_chamada']); ?>,
Nº <?= htmlspecialchars($dados['numero_chamada']); ?>
</p>
<p><strong>Complemento:</strong> <?= htmlspecialchars($dados['complemento_chamada']); ?></p>
<p><strong>Bairro:</strong> <?= htmlspecialchars($dados['bairro_chamada']); ?></p>
<p><strong>Município:</strong> <?= htmlspecialchars($dados['municipio_chamada']); ?></p>
<p><strong>Telefone:</strong> <?= htmlspecialchars($dados['telefone_chamada']); ?></p>
</div>
</div>

<!-- ===== CARD: SOLICITANTE ===== -->
<div class="card">
<div class="card-body">
<h3>🧑 Dados do Solicitante</h3>

<p><strong>Nome:</strong> <?= htmlspecialchars($dados['nome_solicitante']); ?></p>
<p>
<strong>Endereço:</strong>
<?= htmlspecialchars($dados['endereco_solicitante']); ?>,
Nº <?= htmlspecialchars($dados['numero_solicitante']); ?>
</p>
<p><strong>Complemento:</strong> <?= htmlspecialchars($dados['complemento_solicitante']); ?></p>
<p><strong>Bairro:</strong> <?= htmlspecialchars($dados['bairro_solicitante']); ?></p>
<p><strong>Município:</strong> <?= htmlspecialchars($dados['municipio_solicitante']); ?></p>
<p><strong>Telefone:</strong> <?= htmlspecialchars($dados['telefone_solicitante']); ?></p>
</div>
</div>

<!-- ===== CARD: NATUREZA ===== -->
<div class="card">
<div class="card-body">
<h3>📝 Natureza da Ocorrência</h3>

<p><strong>Código:</strong> <?= htmlspecialchars($dados['codigo_natureza']); ?></p>
<p><?= nl2br(htmlspecialchars($dados['descricao_natureza'])); ?></p>
</div>
</div>

</div>
</main>

<footer class="footer">
    Relatório da Chamada Nº <?= (int)$dados['id']; ?>
</footer>

</div>
</body>
</html>
