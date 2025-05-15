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

function cadastrarVendas()
{
    $conexao = criarConexao();

    

    $data = isset($_POST['data_hora']) ? $_POST['data_hora'] : date('Y-m-d H:i:s');
    $cliente = trim($_POST['cliente']);
    $produto = trim($_POST['produto']);
    $forma_pagamento = $_POST['forma_pagamento'];
    $quantidade = intval($_POST['quantidade']);
    $preco = floatval(str_replace(',', '.', $_POST['valor']));
    $total = $preco * $quantidade;
    $status = $_POST['status'];


    $stmt = $conexao->prepare("INSERT INTO vendas (cliente, data_hora, forma_pagamento, valor, produto, quantidade, total, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdsids", $cliente, $data, $forma_pagamento, $preco, $produto, $quantidade, $total, $status);


    if ($stmt->execute()) {
        echo json_encode(["status" => "sucesso"]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => $stmt->error]);
    }


    $conexao->close();
}

function listarVendas()
{
    $conexao = criarConexao();

    $sql = "SELECT * FROM vendas ORDER BY data_hora DESC";
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

    $sql = "SELECT SUM(total) AS total FROM vendas";
    $resultado = $conexao->query($sql);

    $total = 0;
    if ($resultado && $row = $resultado->fetch_assoc()) {
        $total = $row['total'];
    }

    $conexao->close();

    return $total;
}

function cadastrarReserva()
{
    $conexao = criarConexao();

    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
        exit;
    }

    $stmt = $conexao->prepare("INSERT INTO reservas (cliente, produto, data_hora, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $data['cliente'], $data['produto'], $data['data_hora'], $data['status']);

    $success = $stmt->execute();


    echo json_encode(['success' => $success]);
}


function listarReservas()
{
    $conexao = criarConexao();
    $sql = "SELECT * FROM reservas ORDER BY data_hora DESC";
    $resultado = $conexao->query($sql);

    $reservas = [];

    if ($resultado) {
        while ($row = $resultado->fetch_assoc()) {
            $reservas[] = $row;
        }
    }

    $conexao->close();
    return $reservas;
}
