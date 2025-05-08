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


    $data = $_POST['data_hora'];
    $cliente = $_POST['cliente'];
    $forma_pagamento = $_POST['forma_pagamento'];
    $produto = $_POST['produto'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['valor'];
    $total = $_POST['total'];
    $status = $_POST['status'];


    $stmt = $conexao->prepare("INSERT INTO vendas (cliente, data_hora, forma_pagamento, valor, produto, quantidade, total, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssis", $cliente, $data, $forma_pagamento, $preco, $produto, $quantidade, $total, $status);


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
