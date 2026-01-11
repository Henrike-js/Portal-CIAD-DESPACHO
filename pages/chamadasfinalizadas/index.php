<?php
require "conexao.php";

$busca = isset($_GET['q']) ? trim($_GET['q']) : "";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Chamadas Registradas</title>

<link rel="stylesheet" href="chamadas.css">

<style>
.table-wrapper {
  margin-top: 20px;
  background: #ffffff;
  border-radius: 12px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.05);
  overflow: hidden;
}

.search-box {
  margin: 16px 0 10px 0;
  display: flex;
  gap: 10px;
}

.search-box input{
  width: 100%;
  padding: 10px 12px;
  border-radius: 10px;
  border: 1px solid #d1d5db;
  font-size: 14px;
}

.search-box button{
  padding: 10px 18px;
  border-radius: 10px;
  border: none;
  background: #2f5dff;
  color: white;
  font-weight: 600;
  cursor: pointer;
}

.search-box button:hover{
  background:#254bdd;
}

table { width: 100%; border-collapse: collapse; }
thead { background: #f3f4f6; }

th, td {
  padding: 12px 10px;
  border-bottom: 1px solid #e5e7eb;
  font-size: 14px;
}

th {
  text-align: left;
  color: #374151;
  font-weight: 700;
}

tr.row-link {
  cursor: pointer;
}

tr.row-link:hover td {
  background:#eef2ff;
}

@media(max-width: 760px){
  table, thead, tbody, th, td, tr { display:block; }
  thead{ display:none; }

  tr {
    margin-bottom: 10px;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 8px;
  }

  td::before {
    content: attr(data-label);
    display:block;
    color:#6b7280;
    font-size:12px;
    margin-bottom:2px;
  }
}
</style>
</head>

<body>

<div class="page">

<h1>Chamadas Registradas</h1>
<p>Lista geral das chamadas no sistema</p>

<form class="search-box" method="GET">
    <input 
      type="text" 
      name="q" 
      placeholder="Buscar por ID, solicitante, telefone, município ou natureza"
      value="<?= htmlspecialchars($busca) ?>"
    >
    <button type="submit">Buscar</button>
</form>

<div class="table-wrapper">

<?php

$sql = "
SELECT 
    id,
    data_atendimento,
    hora_atendimento,
    nome_solicitante,
    telefone_chamada,
    municipio_chamada,
    codigo_natureza
FROM registros_chamadas
";

if ($busca !== "") {
    $sql .= "
      WHERE 
        id = ? OR
        nome_solicitante LIKE ? OR
        telefone_chamada LIKE ? OR
        municipio_chamada LIKE ? OR
        codigo_natureza LIKE ?
    ";
}

$sql .= " ORDER BY id DESC LIMIT 200";

$stmt = $conexao->prepare($sql);

if ($busca !== "") {
    $idBusca = is_numeric($busca) ? (int)$busca : 0;
    $like = "%$busca%";

    $stmt->bind_param("issss", $idBusca, $like, $like, $like, $like);
}

$stmt->execute();
$resultado = $stmt->get_result();
?>

<table>
<thead>
<tr>
  <th>#</th>
  <th>Solicitante</th>
  <th>Telefone</th>
  <th>Município</th>
  <th>Natureza</th>
  <th>Atendimento</th>
</tr>
</thead>

<tbody>

<?php if ($resultado && $resultado->num_rows > 0): ?>
<?php while ($c = $resultado->fetch_assoc()): ?>

<tr class="row-link"
    onclick="window.location='relatorio.php?id=<?= $c['id'] ?>'">

  <td data-label="#"><?= $c['id'] ?></td>

  <td data-label="Solicitante">
    <?= htmlspecialchars($c['nome_solicitante']) ?>
  </td>

  <td data-label="Telefone">
    <?= htmlspecialchars($c['telefone_chamada']) ?>
  </td>

  <td data-label="Município">
    <?= htmlspecialchars($c['municipio_chamada']) ?>
  </td>

  <td data-label="Natureza">
    <?= htmlspecialchars($c['codigo_natureza']) ?>
  </td>

  <td data-label="Atendimento">
    <?= date("d/m/Y", strtotime($c['data_atendimento'])) ?>
    às <?= substr($c['hora_atendimento'],0,5) ?>
  </td>

</tr>

<?php endwhile; ?>
<?php else: ?>
<tr>
  <td colspan="6">Nenhum registro encontrado.</td>
</tr>
<?php endif; ?>

</tbody>
</table>

</div>

</div>

</body>
</html>
