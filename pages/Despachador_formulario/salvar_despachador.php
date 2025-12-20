<?php
include "../conexao.php";

if (!isset($conexao)) {
    die("Erro de conexão.");
}

$conexao->begin_transaction();

try {

    $chamada_id = (int) $_POST['chamada_id'];

    // ===== BUSCA CHAMADA ORIGINAL =====
    $sql = "SELECT * FROM registros_chamadas WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $chamada_id);
    $stmt->execute();
    $chamada = $stmt->get_result()->fetch_assoc();

    if (!$chamada) {
        throw new Exception("Chamada não encontrada.");
    }

    // ===== DADOS PARA INSERT (ARRAY ÚNICO) =====
    $dados = [
        $chamada_id,
        $chamada['data_atendimento'],
        $chamada['hora_atendimento'],
        $chamada['matricula'],
        $chamada['nome_teleatendente'],
        $chamada['nome_solicitante'],
        $chamada['telefone_chamada'],
        $chamada['logradouro_chamada'],
        $chamada['numero_chamada'],
        $chamada['bairro_chamada'],
        $chamada['municipio_chamada'],
        $chamada['codigo_natureza'],
        $chamada['descricao_natureza'],

        $_POST['matricula'],
        $_POST['nome'],
        $_POST['data'],
        $_POST['hora'],

        $_POST['recurso'],
        $_POST['unidade'],
        $_POST['hora_despachada'],
        $_POST['hora_a_caminho'],
        $_POST['hora_no_local'],

        $_POST['encerramento'],
        $_POST['classificacao'],
        $_POST['observacao_classificacao'],
        $_POST['codigo_natureza_final'],
        $_POST['descricao_natureza_final'],
        $_POST['nr_pm'],
        $_POST['comentarios']
    ];

    // ===== SQL FINAL =====
    $sql = "INSERT INTO chamadas_finalizadas (
        chamada_id,
        data_atendimento,
        hora_atendimento,
        matricula_atendente,
        nome_teleatendente,
        solicitante,
        telefone,
        logradouro,
        numero,
        bairro,
        municipio,
        codigo_natureza_inicial,
        descricao_natureza_inicial,
        matricula_despachador,
        nome_despachador,
        data_despacho,
        hora_despacho,
        recurso,
        unidade,
        hora_despachada,
        hora_a_caminho,
        hora_no_local,
        encerramento,
        classificacao,
        observacao_classificacao,
        codigo_natureza_final,
        descricao_natureza_final,
        nr_pm,
        comentarios
    ) VALUES (" . implode(',', array_fill(0, count($dados), '?')) . ")";

    $stmt = $conexao->prepare($sql);

    // ===== TYPES DINÂMICOS =====
    $types = str_repeat('s', count($dados));
    $types[0] = 'i'; // chamada_id é inteiro

    $stmt->bind_param($types, ...$dados);
    $stmt->execute();

    // ===== DELETE DA CHAMADA ABERTA =====
    $stmt = $conexao->prepare("DELETE FROM registros_chamadas WHERE id = ?");
    $stmt->bind_param("i", $chamada_id);
    $stmt->execute();

    $conexao->commit();

    header("Location: mensagem_finalizacao.php");
exit;

} catch (Exception $e) {
    $conexao->rollback();
    die("Erro ao finalizar chamada: " . $e->getMessage());
}
