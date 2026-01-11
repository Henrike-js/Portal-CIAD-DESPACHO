<?php
require "conexao.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Chamada inválida.");
}

$id = (int) $_GET['id'];

$stmt = $conexao->prepare("SELECT * FROM registros_chamadas WHERE id = ?");
$stmt->bind_param("i",$id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Registro não encontrado.");
}

$c = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Relatório — Chamada <?= $c['id'] ?></title>

<link rel="stylesheet" href="chamadas.css">

<style>
.report-container{background:#fff;border-radius:18px;padding:24px;box-shadow:var(--shadow-soft)}
.section{margin-top:22px;padding:16px;border:1px solid var(--border-soft);border-radius:14px;background:#fafafa}
.section h2{margin-bottom:10px;font-size:18px;font-weight:700}
.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:12px 18px}
.item{background:#fff;border:1px solid var(--border-soft);border-radius:12px;padding:10px 14px}
.label{font-size:12px;color:var(--text-muted)}
.value{font-weight:700}
</style>
</head>

<body>

<div class="page">

<div class="topbar">
  <div class="topbar-inner">
    <div class="logo-wrapper"><img src="logo.png"></div>
    <div class="clock-wrapper">
      <div class="clock-time" id="clock"></div>
      <div class="clock-date" id="date"></div>
    </div>
  </div>
</div>

<main class="main">
<div class="main-inner">

<div class="page-header">
<h1>ID CHAMADA: <?= $c['id'] ?></h1>
<p>Relatório completo da ocorrência</p>
</div>

<div class="report-container">

<div class="section">
<h2>Dados do Atendimento</h2>
<div class="grid">
<div class="item"><div class="label">Data</div><div class="value"><?= $c['data_atendimento'] ?></div></div>
<div class="item"><div class="label">Hora</div><div class="value"><?= $c['hora_atendimento'] ?></div></div>
<div class="item"><div class="label">Matrícula</div><div class="value"><?= $c['matricula'] ?></div></div>
<div class="item"><div class="label">Teleatendente</div><div class="value"><?= $c['nome_teleatendente'] ?></div></div>
</div>
</div>

<div class="section">
<h2>Solicitante</h2>
<div class="grid">
<div class="item"><div class="label">Nome</div><div class="value"><?= $c['nome_solicitante'] ?></div></div>
<div class="item"><div class="label">Telefone</div><div class="value"><?= $c['telefone_chamada'] ?></div></div>
<div class="item"><div class="label">Endereço</div><div class="value"><?= $c['logradouro_chamada'] ?>, <?= $c['numero_chamada'] ?></div></div>
<div class="item"><div class="label">Bairro</div><div class="value"><?= $c['bairro_chamada'] ?></div></div>
<div class="item"><div class="label">Município</div><div class="value"><?= $c['municipio_chamada'] ?></div></div>
</div>
</div>

<div class="section">
<h2>Natureza</h2>
<div class="grid">
<div class="item"><div class="label">Código</div><div class="value"><?= $c['codigo_natureza'] ?></div></div>
<div class="item"><div class="label">Descrição</div><div class="value"><?= nl2br(htmlspecialchars($c['descricao_natureza'])) ?></div></div>
</div>
</div>

<div class="section">
<h2>Despacho</h2>
<div class="grid">
<div class="item"><div class="label">Despachador</div><div class="value"><?= $c['despachador_nome'] ?></div></div>
<div class="item"><div class="label">Matrícula</div><div class="value"><?= $c['despachador_matricula'] ?></div></div>
<div class="item"><div class="label">Data</div><div class="value"><?= $c['data_despacho'] ?></div></div>
<div class="item"><div class="label">Hora</div><div class="value"><?= $c['hora_despacho'] ?></div></div>
<div class="item"><div class="label">Recurso</div><div class="value"><?= $c['recurso'] ?></div></div>
<div class="item"><div class="label">Unidade</div><div class="value"><?= $c['unidade'] ?></div></div>
<div class="item"><div class="label">Despachada</div><div class="value"><?= $c['hora_despachada'] ?></div></div>
<div class="item"><div class="label">A caminho</div><div class="value"><?= $c['hora_a_caminho'] ?></div></div>
<div class="item"><div class="label">No local</div><div class="value"><?= $c['hora_no_local'] ?></div></div>
<div class="item"><div class="label">Encerramento</div><div class="value"><?= $c['encerramento'] ?></div></div>
<div class="item"><div class="label">Classificação</div><div class="value"><?= $c['classificacao'] ?></div></div>
<div class="item"><div class="label">Natureza Final</div><div class="value"><?= $c['codigo_natureza_final'] ?></div></div>
<div class="item"><div class="label">Descrição Final</div><div class="value"><?= nl2br(htmlspecialchars($c['descricao_natureza_final'])) ?></div></div>
<div class="item"><div class="label">NR PM</div><div class="value"><?= $c['nr_pm'] ?></div></div>
<div class="item"><div class="label">Comentários</div><div class="value"><?= nl2br(htmlspecialchars($c['comentarios'])) ?></div></div>
</div>
</div>

<a href="index.php">← Voltar</a>

</div>
</div>
</main>
</div>
</body>
</html>


