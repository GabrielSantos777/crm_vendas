<?php
$dsn = 'mysql:host=localhost;dbname=crm_novo;charset=utf8mb4';
$usuario = 'root';
$senha = '1234';

try {
    $pdo = new PDO($dsn, $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $arquivoCSV ='E:\Nova pasta\crm\database/index_2.csv';
    $handle = fopen($arquivoCSV, 'r');

    if ($handle === false) {
        throw new Exception("Não foi possível abrir o arquivo CSV.");
    }
    fgetcsv($handle, 1000, ',');

    $sql = "INSERT INTO vendas (data, data_hora, forma_pagamento, valor, produto) 
            VALUES (:data, :data_hora, :forma_pagamento, :valor, :produto)";
    $stmt = $pdo->prepare($sql);

    while (($linha = fgetcsv($handle, 1000, ',')) !== false) {
        $data           = date('Y-m-d', strtotime($linha[0]));
        $data_hora      = date('Y-m-d H:i:s', strtotime($linha[1]));
        $forma_pagamento= strtolower(trim($linha[2]));
        $valor          = str_replace(',', '.', $linha[3]);
        $produto        = trim($linha[4]);

        $stmt->execute([
            ':data' => $data,
            ':data_hora' => $data_hora,
            ':forma_pagamento' => $forma_pagamento,
            ':valor' => $valor,
            ':produto' => $produto,
        ]);
    }

    fclose($handle);
} catch (PDOException $e) {
    echo "Erro no banco de dados: " . $e->getMessage();
} catch (Exception $e) {
    echo "Erro geral: " . $e->getMessage();
}
?>

