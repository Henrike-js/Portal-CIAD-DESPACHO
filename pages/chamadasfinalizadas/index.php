<?php
require "conexao.php";

// valor digitado na busca
$busca = isset($_GET['q']) ? trim($_GET['q']) : "";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Chamadas Finalizadas</title>

<link rel="stylesheet" href="chamadas.css">

<style>
.table-wrapper {
  margin-top: 20px;
  background: #ffffff;
  border-radius: 12px;
  box-shadow: 0 8px 20px rgba(0,0,0,.05);
  overflow: hidden;
}

/* barra de busca */
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

/* tabela */
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

/* responsivo */
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
  <main class="main">
    <div class="main-inner">

      <div class="page-header">
        <h1>Chamadas Finalizadas</h1>
        <p>Relatório geral das chamadas registradas</p>
      </div>

      <!-- 🔎 BUSCA -->
      <form class="search-box" method="GET">
        <input 
          type="text" 
          name="q" 
          placeholder="Buscar por ID, solicitante, telefone, município ou natureza..."
          value="<?= htmlspecialchars($busca) ?>"
        >
        <button type="submit">Buscar</button>
      </form>

      <div class="table-wrapper">

        <?php

        // consulta base
        $sql = "
          SELECT 
            chamada_id,
            data_atendimento,
            hora_atendimento,
            solicitante,
            telefone,
            municipio,
            descricao_natureza_final,
            finalizado_em
          FROM chamadas_finalizadas
        ";

        // adiciona filtros se houver busca
        if ($busca !== "") {
            $sql .= "
              WHERE 
                chamada_id = ? OR
                solicitante LIKE ? OR
                telefone LIKE ? OR
                municipio LIKE ? OR
                descricao_natureza_final LIKE ?
            ";
        }

        $sql .= " ORDER BY finalizado_em DESC LIMIT 200";

        $stmt = $conexao->prepare($sql);

        if ($busca !== "") {
            $idBusca = is_numeric($busca) ? (int)$busca : 0;
            $like = "%$busca%";

            $stmt->bind_param("sssss", $idBusca, $like, $like, $like, $like);
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
              <th>Natureza final</th>
              <th>Atendimento</th>
              <th>Finalizado em</th>
            </tr>
          </thead>

          <tbody>

          <?php if ($resultado && $resultado->num_rows > 0): ?>
            <?php while ($c = $resultado->fetch_assoc()): ?>

              <tr
                class="row-link"
                onclick="window.location='relatorio.php?id=<?= $c['chamada_id'] ?>'"
              >

                <td data-label="#"><?= htmlspecialchars($c['chamada_id']) ?></td>

                <td data-label="Solicitante">
                  <?= htmlspecialchars($c['solicitante']) ?>
                </td>

                <td data-label="Telefone">
                  <?= htmlspecialchars($c['telefone']) ?>
                </td>

                <td data-label="Município">
                  <?= htmlspecialchars($c['municipio']) ?>
                </td>

                <td data-label="Natureza final">
                  <?= nl2br(htmlspecialchars($c['descricao_natureza_final'])) ?>
                </td>

                <td data-label="Atendimento">
                  <?= date("d/m/Y", strtotime($c['data_atendimento'])) ?>
                  às
                  <?= substr($c['hora_atendimento'], 0, 5) ?>
                </td>

                <td data-label="Finalizado em">
                  <?= date("d/m/Y H:i", strtotime($c['finalizado_em'])) ?>
                </td>

              </tr>

            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="7">Nenhum resultado encontrado.</td>
            </tr>
          <?php endif; ?>

          </tbody>

        </table>

      </div>

    </div>
  </main>

  <footer class="footer">
    Sistema de Chamadas — CIAD
  </footer>

</div>

</body>
</html>
