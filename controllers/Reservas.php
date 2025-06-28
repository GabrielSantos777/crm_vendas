<?php

function criarConexao()
{
    $host = "localhost";
    $usuario = "root";
    $senha = "1234";
    $banco = "crm_novo";

    $conexao = new mysqli($host, $usuario, $senha, $banco);

    if ($conexao->connect_error) {
        die("Falha na conexão: " . $conexao->connect_error);
    }

    return $conexao;
}
function cadastrarReservas()
{
    $conexao = criarConexao();

    date_default_timezone_set('America/Sao_Paulo');

    $data = isset($_POST['data_hora']) ? $_POST['data_hora'] : date('Y-m-d H:i:s');
    $cliente = trim($_POST['cliente']);
    $cpf = trim($_POST['cpf']);
    $forma_pagamento = $_POST['forma_pagamento'];
    $status = $_POST['status'];
    $produtos = isset($_POST['produtos']) ? json_decode($_POST['produtos'], true) : [];

    if (empty($produtos)) {
        echo json_encode(["status" => "erro", "mensagem" => "Nenhum produto informado."]);
        $conexao->close();
        return;
    }

    $conexao->begin_transaction();

    try {
        foreach ($produtos as $produto) {
            $nome_produto = trim($produto['nome']);
            $quantidade = intval($produto['quantidade']);
            $preco = floatval($produto['preco']);
            $total = $preco * $quantidade;

            if (empty($nome_produto) || $quantidade <= 0 || $preco <= 0) {
                throw new Exception("Dados inválidos para o produto: " . $nome_produto);
            }

            $stmt = $conexao->prepare(
                "INSERT INTO reservas (cpf, cliente, produto, valor, quantidade, total, data_hora, forma_pagamento, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param(
                "sssdidsss",
                $cpf,
                $cliente,
                $nome_produto,
                $preco,
                $quantidade,
                $total,
                $data,
                $forma_pagamento,
                $status
            );


            if (!$stmt->execute()) {
                throw new Exception("Erro ao inserir reserva: " . $stmt->error);
            }
            $stmt->close();
        }

        $conexao->commit();
    } catch (Exception $e) {
        $conexao->rollback();
        echo json_encode(["status" => "erro", "mensagem" => $e->getMessage()]);
    }

    $conexao->close();
}

function listarReservas()
{
    $conexao = criarConexao();

    $sql = "SELECT * FROM reservas ORDER BY data_hora DESC";
    $resultado = $conexao->query($sql);

    $vendas = [];

    if ($resultado) {
        while ($row = $resultado->fetch_assoc()) {
            $vendas[] = $row;
        }
    }

    $conexao->close();

    return $vendas;
}


function totalVendas()
{
    $conexao = criarConexao();

    $sql = "SELECT SUM(total) AS total FROM reservas";
    $resultado = $conexao->query($sql);

    $total = 0;
    if ($resultado && $row = $resultado->fetch_assoc()) {
        $total = $row['total'];
    }

    $conexao->close();

    return $total;
}
