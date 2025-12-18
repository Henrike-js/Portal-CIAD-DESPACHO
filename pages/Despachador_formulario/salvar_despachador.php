<?php
// ================= CONFIGURAÇÃO DO BANCO =================
$host = "localhost";
$db   = "sisp";          // nome do banco
$user = "root";          // usuário
$pass = "";              // senha
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (Exception $e) {
    die("Erro na conexão com o banco.");
}

// ================= RECEBENDO OS DADOS =================
$data = [
    'matricula' => $_POST['matricula'] ?? null,
    'nome' => $_POST['nome'] ?? null,
    'revezador' => $_POST['revezador'] ?? null,
    'data_registro' => $_POST['data'] ?? null,
    'hora_registro' => $_POST['hora'] ?? null,

    'recurso' => $_POST['recurso'] ?? null,
    'unidade' => $_POST['unidade'] ?? null,
    'encerramento' => $_POST['encerramento'] ?? null,

    'hora_despachada' => $_POST['hora_despachada'] ?? null,
    'hora_a_caminho' => $_POST['hora_a_caminho'] ?? null,
    'hora_no_local' => $_POST['hora_no_local'] ?? null,
    'hora_encerramento' => $_POST['hora_encerramento'] ?? null,
    'hora_disponivel' => $_POST['hora_disponivel'] ?? null,
    'hora_indisponivel' => $_POST['hora_indisponivel'] ?? null,
    'hora_suspenso' => $_POST['hora_suspenso'] ?? null,
    'hora_terminado' => $_POST['hora_terminado'] ?? null,

    'classificacao' => $_POST['classificacao'] ?? null,
    'observacao_classificacao' => $_POST['observacao_classificacao'] ?? null,

    'descricao_natureza_final' => $_POST['descricao_natureza_final'] ?? null,
    'codigo_natureza_final' => $_POST['codigo_natureza_final'] ?? null,
    'numero_chamada' => $_POST['numero_chamada'] ?? null,
    'nr_pm' => $_POST['nr_pm'] ?? null,
    'comentarios' => $_POST['comentarios'] ?? null,
];

// ================= INSERT =================
$sql = "
INSERT INTO despachador_registro (
    matricula, nome, revezador, data_registro, hora_registro,
    recurso, unidade, encerramento,
    hora_despachada, hora_a_caminho, hora_no_local, hora_encerramento,
    hora_disponivel, hora_indisponivel, hora_suspenso, hora_terminado,
    classificacao, observacao_classificacao,
    descricao_natureza_final, codigo_natureza_final,
    numero_chamada, nr_pm, comentarios
) VALUES (
    :matricula, :nome, :revezador, :data_registro, :hora_registro,
    :recurso, :unidade, :encerramento,
    :hora_despachada, :hora_a_caminho, :hora_no_local, :hora_encerramento,
    :hora_disponivel, :hora_indisponivel, :hora_suspenso, :hora_terminado,
    :classificacao, :observacao_classificacao,
    :descricao_natureza_final, :codigo_natureza_final,
    :numero_chamada, :nr_pm, :comentarios
)";

$stmt = $pdo->prepare($sql);
$stmt->execute($data);

// ================= REDIRECIONAMENTO =================
header("Location: despachador.php?sucesso=1");
exit;
