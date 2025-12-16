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

$d = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Relatório da Chamada Nº <?= (int)$d['id']; ?></title>

<link rel="stylesheet" href="css/styles.css">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
<div class="page">

<header class="topbar">
    <div class="topbar-inner">
        <div class="logo-wrapper">
            <a href="relatorio.php" class="logo-link">
                <img src="img/sisp-logo.png" class="logo-sisp-img" alt="Logo">
            </a>
        </div>
    </div>
</header>

<main class="main">
<div class="main-inner">

<div class="page-header">
    <h1>RELATÓRIO DE CHAMADA</h1>
    <p>Nº <?= (int)$d['id']; ?> • <?= date('d/m/Y', strtotime($d['data_atendimento'])); ?></p>
</div>

<!-- ================= TELEATENDENTE ================= -->
<div class="card">
<div class="card-body">
<h3>1. Dados do Teleatendente</h3>

<p><strong>Matrícula:</strong> <?= htmlspecialchars($d['matricula']); ?></p>
<p><strong>Nome:</strong> <?= htmlspecialchars($d['nome_teleatendente']); ?></p>
<p><strong>Data:</strong> <?= date('d/m/Y', strtotime($d['data_atendimento'])); ?></p>
<p><strong>Hora:</strong> <?= htmlspecialchars($d['hora_atendimento']); ?></p>

<p>
<strong>Iniciativa:</strong> <?= htmlspecialchars($d['iniciativa']); ?><br>
<strong>Viatura:</strong> <?= htmlspecialchars($d['iniciativa_viatura']); ?><br>
<strong>Servidor:</strong> <?= htmlspecialchars($d['iniciativa_servidor']); ?>
</p>
</div>
</div>

<!-- ================= LOCAL DA CHAMADA ================= -->
<div class="card">
<div class="card-body">
<h3>2. Local da Chamada</h3>

<p><strong>Destino do Serviço:</strong> <?= htmlspecialchars($d['destino_servico']); ?></p>

<p>
<strong>Endereço:</strong>
<?= htmlspecialchars($d['logradouro_chamada']); ?>,
Nº <?= htmlspecialchars($d['numero_chamada']); ?>
</p>

<p><strong>Complemento:</strong> <?= htmlspecialchars($d['complemento_chamada']); ?></p>
<p><strong>Bairro:</strong> <?= htmlspecialchars($d['bairro_chamada']); ?></p>
<p><strong>Município:</strong> <?= htmlspecialchars($d['municipio_chamada']); ?></p>
<p><strong>Telefone:</strong> <?= htmlspecialchars($d['telefone_chamada']); ?></p>
</div>
</div>

<!-- ================= SOLICITANTE ================= -->
<div class="card">
<div class="card-body">
<h3>3. Dados do Solicitante</h3>

<p><strong>Nome:</strong> <?= htmlspecialchars($d['nome_solicitante']); ?></p>

<p>
<strong>Endereço:</strong>
<?= htmlspecialchars($d['endereco_solicitante']); ?>,
Nº <?= htmlspecialchars($d['numero_solicitante']); ?>
</p>

<p><strong>Complemento:</strong> <?= htmlspecialchars($d['complemento_solicitante']); ?></p>
<p><strong>Bairro:</strong> <?= htmlspecialchars($d['bairro_solicitante']); ?></p>
<p><strong>Município:</strong> <?= htmlspecialchars($d['municipio_solicitante']); ?></p>
<p><strong>Telefone:</strong> <?= htmlspecialchars($d['telefone_solicitante']); ?></p>
</div>
</div>

<!-- ================= NATUREZA ================= -->
<div class="card">
<div class="card-body">
<h3>4. Natureza da Ocorrência</h3>

<p><strong>Código:</strong> <?= htmlspecialchars($d['codigo_natureza']); ?></p>

<p><strong>Descrição:</strong><br>
<?= nl2br(htmlspecialchars($d['descricao_natureza'])); ?>
</p>
</div>
</div>

</div>
</main>

<footer class="footer">
Relatório da Chamada Nº <?= (int)$d['id']; ?> • Gerado em <?= date('d/m/Y H:i'); ?>
</footer>

</div>
</body>
</html>
