<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Registro do Despachador</title>

<link href="https://fonts.cdnfonts.com/css/rawline" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Rawline',sans-serif}
body{background:#F4F5F8;color:#16325C}

.gov-header{
    background:white;
    border-bottom:6px solid #C63232;
    padding:20px 0;
}
.gov-header img{height:90px}

.page{max-width:1100px;margin:40px auto;padding:0 40px}

h1{font-size:32px;display:flex;gap:10px;align-items:center}
.sub{margin:10px 0 30px;color:#555}

.card{
    background:white;
    padding:30px;
    border-radius:10px;
    margin-bottom:25px;
    box-shadow:0 2px 10px rgba(0,0,0,.06);
}

fieldset{border:none}
legend{
    font-size:20px;
    font-weight:700;
    display:flex;
    align-items:center;
    gap:8px;
    margin-bottom:20px;
}

label{font-weight:600;margin-bottom:5px;display:block}
input,select,textarea{
    width:100%;
    padding:11px;
    border:1px solid #D0D2D6;
    border-radius:8px;
    font-size:15px;
}
textarea{resize:vertical}

/* Correção radio */
input[type="radio"]{width:auto}

/* Layout */
.row{display:flex;gap:18px;margin-bottom:18px}
.w-100{flex:100%}
.w-50{flex:50%}
.w-33{flex:33%}
.w-25{flex:25%}

/* Classificação em 3 colunas */
.classificacao-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:12px 20px;
}
.classificacao-grid label{
    display:flex;
    align-items:center;
    gap:8px;
    font-weight:400;
}

button{
    background:#16325C;
    color:white;
    padding:14px 30px;
    border:0;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
}
button:hover{background:#0D2345}
</style>
</head>

<body>

<header class="gov-header">
    <div class="page">
        <img src="sisp-logo.png" alt="SISP">
    </div>
</header>

<div class="page">

<h1><span class="material-icons-outlined">badge</span> Registro do Despachador</h1>
<p class="sub">Controle operacional do despachador e encerramento da chamada</p>

<form action="salvar_despachador.php" method="post">

<!-- ================= DADOS DO DESPACHADOR ================= -->
<div class="card">
<fieldset>
<legend><span class="material-icons-outlined">support_agent</span> Dados do Despachador</legend>

<div class="row">
    <div class="w-25"><label>Matrícula</label><input name="matricula" required></div>
    <div class="w-50"><label>Nome</label><input name="nome" required></div>
    <div class="w-25"><label>Revezador</label><input name="revezador"></div>
</div>

<div class="row">
    <div class="w-25"><label>Data</label><input type="date" name="data" id="data" required></div>
    <div class="w-25"><label>Hora do Despacho</label><input type="time" name="hora" id="hora" required></div>
</div>
</fieldset>
</div>

<!-- ================= STATUS DO RECURSO ================= -->
<div class="card">
<fieldset>
<legend><span class="material-icons-outlined">schedule</span> Status do Recurso</legend>

<div class="row">
    <div class="w-33"><label>Recurso</label><input name="recurso"></div>
    <div class="w-33"><label>Unidade</label><input name="unidade"></div>
    <div class="w-25"><label>Despachada</label><input type="time" name="hora_despachada"></div>
    
</div>

<div class="row">
    
    <div class="w-25"><label>A caminho</label><input type="time" name="hora_a_caminho"></div>
    <div class="w-25"><label>No local</label><input type="time" name="hora_no_local"></div>
    <div class="w-33">
        <label>Encerramento</label>
        <select name="encerramento">
            <option value="">Selecione</option>
            <option>Terminado</option>
            <option>Suspenso</option>
            <option>Disponível</option>
            <option>Indisponível</option>
        </select>
    </div>
</div>


</fieldset>
</div>

<!-- ================= CLASSIFICAÇÃO ================= -->
<div class="card">
<fieldset>
<legend><span class="material-icons-outlined">assignment_turned_in</span> Classificação da Chamada</legend>

<div class="classificacao-grid">
<label><input type="radio" name="classificacao" value="Transmitido a rede">Transmitido à rede</label>
<label><input type="radio" name="classificacao" value="Trote W07.000">Trote – W07.000</label>
<label><input type="radio" name="classificacao" value="Emissão de multa">Emissão de multa</label>
<label><input type="radio" name="classificacao" value="Solicitante não encontrado W01.000">Solicitante não encontrado – W01.000</label>
<label><input type="radio" name="classificacao" value="Relatório">Relatório</label>
<label><input type="radio" name="classificacao" value="Cancelada pela coordenação">Cancelada pela coordenação</label>
<label><input type="radio" name="classificacao" value="Boletim de ocorrência">Boletim de ocorrência</label>
<label><input type="radio" name="classificacao" value="Nada constatado W04.000">Nada constatado – W04.000</label>
<label><input type="radio" name="classificacao" value="Atendimento sem BO">Atendimento sem BO</label>
<label><input type="radio" name="classificacao" value="Dispensado pelo solicitante">Dispensado pelo solicitante</label>
<label><input type="radio" name="classificacao" value="Endereço não localizado W02.000">Endereço não localizado – W02.000</label>
<label><input type="radio" name="classificacao" value="Cancelada indisp meios W08.000">Cancelada – Indisp. meios – W08.000</label>
<label><input type="radio" name="classificacao" value="Duplicata">Duplicata</label>
<label><input type="radio" name="classificacao" value="Outros">Outros</label>
</div>

<div class="row" style="margin-top:18px">
    <div class="w-50">
        <label>Observação / Nº da chamada</label>
        <input name="observacao_classificacao">
    </div>
</div>
</fieldset>
</div>

<!-- ================= NATUREZA FINAL ================= -->
<div class="card">
<fieldset>
<legend><span class="material-icons-outlined">fact_check</span> Natureza Final</legend>

<div class="w-100">
    <label>Descrição da Natureza Final</label>
    <textarea name="descricao_natureza_final" rows="4"></textarea>
</div>

<div class="row">
    <div class="w-33"><label>Código Natureza Final</label><input name="codigo_natureza_final"></div>
    <div class="w-33"><label>Número da Chamada</label><input name="numero_chamada"></div>
    <div class="w-33"><label>NR PM</label><input name="nr_pm"></div>
</div>

<div class="w-100">
    <label>Comentários</label>
    <textarea name="comentarios" rows="3"></textarea>
</div>

</fieldset>
</div>

<button type="submit">Salvar Registro</button>

</form>
</div>

<script>
const d=document.getElementById('data');
const h=document.getElementById('hora');
const now=new Date();
d.value=now.toISOString().substring(0,10);
h.value=now.toTimeString().substring(0,5);
</script>

</body>
</html>

