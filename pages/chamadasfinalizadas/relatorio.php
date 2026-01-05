<?php
require "conexao.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Chamada inválida.");
}

$id = (int) $_GET['id'];

$sql = "SELECT * FROM chamadas_finalizadas WHERE chamada_id = $id LIMIT 1";
$result = $conexao->query($sql);

if (!$result || $result->num_rows === 0) {
    die("Registro não encontrado.");
}

$c = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Relatório — Chamada <?= $c['chamada_id'] ?></title>

<!-- CSS DO SISTEMA -->
<link rel="stylesheet" href="chamadas.css">

<style>
/* ajustes específicos apenas do relatório */

.report-container{
  background:#ffffff;
  border-radius:18px;
  padding:24px 26px;
  box-shadow: var(--shadow-soft);
}

.section{
  margin-top:22px;
  padding:16px;
  border:1px solid var(--border-soft);
  border-radius:14px;
  background:#fafafa;
}

.section h2{
  margin:0 0 10px 0;
  font-size:18px;
  font-weight:700;
}

.grid{
  display:grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap:12px 18px;
}

.item{
  background:#ffffff;
  border:1px solid var(--border-soft);
  border-radius:12px;
  padding:10px 14px;
}

.label{
  font-size:12px;
  color:var(--text-muted);
}

.value{
  font-weight:700;
}

.back-link{
  margin-top:14px;
  display:inline-block;
}
</style>

</head>
<body>

<div class="page">

  <!-- TOPO -->
  <div class="topbar">
    <div class="topbar-inner">
      <div class="logo-wrapper">
        <img src="logo.png" class="logo-sisp-img" alt="Logo">
      </div>

      <div class="clock-wrapper">
        <div class="clock-time" id="clockTime"></div>
        <div class="clock-date" id="clockDate"></div>
      </div>
    </div>
  </div>

  <!-- CONTEÚDO -->
  <main class="main relatorio-detalhe">
    <div class="main-inner">

      <div class="page-header">
        <h1>ID CHAMADA REDS OFFLINE: <?= $c['chamada_id'] ?></h1>
        <p>Relatório completo da ocorrência registrada</p>
      </div>

      <div class="report-container">

        <!-- =========================
             DADOS DO ATENDIMENTO
        ========================== -->
        <div class="section">
          <h2>Dados do atendimento</h2>

          <div class="grid">
            <div class="item"><div class="label">Data do atendimento</div><div class="value"><?= $c['data_atendimento'] ?></div></div>
            <div class="item"><div class="label">Hora do atendimento</div><div class="value"><?= $c['hora_atendimento'] ?></div></div>
            <div class="item"><div class="label">Matrícula do atendente</div><div class="value"><?= $c['matricula_atendente'] ?></div></div>
            <div class="item"><div class="label">Nome do teleatendente</div><div class="value"><?= $c['nome_teleatendente'] ?></div></div>
          </div>
        </div>

        <!-- =========================
             DADOS DO SOLICITANTE
        ========================== -->
        <div class="section">
          <h2>Dados do solicitante</h2>

          <div class="grid">
            <div class="item"><div class="label">Solicitante</div><div class="value"><?= $c['solicitante'] ?></div></div>
            <div class="item"><div class="label">Telefone</div><div class="value"><?= $c['telefone'] ?></div></div>
            <div class="item"><div class="label">Logradouro</div><div class="value"><?= $c['logradouro'] ?></div></div>
            <div class="item"><div class="label">Número</div><div class="value"><?= $c['numero'] ?></div></div>
            <div class="item"><div class="label">Bairro</div><div class="value"><?= $c['bairro'] ?></div></div>
            <div class="item"><div class="label">Município</div><div class="value"><?= $c['municipio'] ?></div></div>
          </div>
        </div>

        <!-- =========================
             NATUREZA
        ========================== -->
        <div class="section">
          <h2>Natureza da chamada</h2>

          <div class="grid">
            <div class="item"><div class="label">Código natureza inicial</div><div class="value"><?= $c['codigo_natureza_inicial'] ?></div></div>
            <div class="item"><div class="label">Descrição natureza inicial</div><div class="value"><?= nl2br(htmlspecialchars($c['descricao_natureza_inicial'])) ?></div></div>
          </div>
        </div>

        <!-- =========================
             DESPACHO
        ========================== -->
        <div class="section">
          <h2>Dados do despacho</h2>

          <div class="grid">

            <div class="item"><div class="label">Matrícula do despachador</div><div class="value"><?= $c['matricula_despachador'] ?></div></div>
            <div class="item"><div class="label">Nome do despachador</div><div class="value"><?= $c['nome_despachador'] ?></div></div>
            <div class="item"><div class="label">Data do despacho</div><div class="value"><?= $c['data_despacho'] ?></div></div>
            <div class="item"><div class="label">Hora do despacho</div><div class="value"><?= $c['hora_despacho'] ?></div></div>

            <div class="item"><div class="label">Recurso</div><div class="value"><?= $c['recurso'] ?></div></div>
            <div class="item"><div class="label">Unidade</div><div class="value"><?= $c['unidade'] ?></div></div>

            <div class="item"><div class="label">Hora despachada</div><div class="value"><?= $c['hora_despachada'] ?></div></div>
            <div class="item"><div class="label">Hora a caminho</div><div class="value"><?= $c['hora_a_caminho'] ?></div></div>
            <div class="item"><div class="label">Hora no local</div><div class="value"><?= $c['hora_no_local'] ?></div></div>

            <div class="item"><div class="label">Encerramento</div><div class="value"><?= $c['encerramento'] ?></div></div>
            <div class="item"><div class="label">Classificação</div><div class="value"><?= $c['classificacao'] ?></div></div>

            <div class="item"><div class="label">Observação classificação</div><div class="value"><?= nl2br(htmlspecialchars($c['observacao_classificacao'])) ?></div></div>

            <div class="item"><div class="label">Código natureza final</div><div class="value"><?= $c['codigo_natureza_final'] ?></div></div>

            <div class="item"><div class="label">Descrição natureza final</div><div class="value"><?= nl2br(htmlspecialchars($c['descricao_natureza_final'])) ?></div></div>

            <div class="item"><div class="label">NR PM</div><div class="value"><?= $c['nr_pm'] ?></div></div>

            <div class="item"><div class="label">Comentários</div><div class="value"><?= nl2br(htmlspecialchars($c['comentarios'])) ?></div></div>

            <div class="item"><div class="label">Finalizado em</div><div class="value"><?= $c['finalizado_em'] ?></div></div>

          </div>
        </div>

        <a class="back-link" href="index.php">← Voltar para a lista</a>

      </div>

    </div>
  </main>

  <footer class="footer">
    Sistema de Chamadas — CIAD
  </footer>

</div>

</body>
</html>


