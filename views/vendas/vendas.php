<?php
require_once('controllers/Vendas.php');
$vendas = listarVendas();
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Vendas</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalVenda">+ Nova Venda</button>
    </div>


    <!-- Tabela de vendas -->
    <div class="table-responsive">
        <table class="table table-striped" id="tabelaVendas">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Cliente</th>
                    <th>Pedido</th>
                    <th>Valor Total</th>
                    <th>Forma de Pagamento</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vendas as $venda): ?>
                    <tr>
                        <td><?= date('d/m/Y H:i', strtotime($venda['data_hora'])) ?></td>
                        <td><?= htmlspecialchars($venda['cliente']) ?></td>
                        <td><?= htmlspecialchars($venda['produto']) ?></td>
                        <td>R$ <?= number_format($venda['total'], 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($venda['forma_pagamento']) ?></td>
                        <td><?= ucfirst($venda['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Tabela de reservas -->
    <div class="class mt-5">
        <h4>Reservas</h4>
        <div class="table-responsive">
            <table class="table table-responsive" id="tabelaReservas">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Data/Hora</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dados -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Nova Venda -->
<div class="modal fade" id="modalVenda" tabindex="-1" aria-labelledby="modalVendaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" id="formNovaVenda" method="post" action="controllers/Vendas.php">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVendaLabel">Nova Venda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="cliente" class="form-label">Cliente</label>
                    <input type="text" class="form-control" name="cliente" required>
                </div>
                <div class="mb-3">
                    <label for="produtos" class="form-label">Produtos</label>
                    <input type="text" class="form-control" name="produtos" placeholder="Digite o nome do produto." required>
                </div>
                <div class="mb-3">
                    <label for="valor" class="form-label">Valor Total</label>
                    <input type="number" class="form-control" name="valor" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label for="valor" class="form-label">Forma de Pagamento</label>
                    <input type="text" class="form-control" name="forma_pagamento" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="pago">Pago</option>
                        <option value="pendente">Pendente</option>
                        <option value="reservado">Reservado</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>

</div>

<style>
    #tabelaVendas tbody {
        display: block;
        max-height: 400px;
        /* altura pra caber ~10 linhas, ajuste se quiser */
        overflow-y: auto;
    }

    #tabelaVendas thead,
    #tabelaVendas tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("formNovaVenda");

        if (form) {
            form.addEventListener("submit", function(e) {
                e.preventDefault();

                const formData = new FormData(form);

                fetch("controllers/Vendas.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert("Venda cadastrada com sucesso!");
                            form.reset();
                            carregarVendas(); // Função para atualizar a tabela automaticamente
                        } else {
                            alert("Erro ao cadastrar venda.");
                        }
                    })
                    .catch(err => {
                        console.error("Erro:", err);
                        alert("Erro na requisição.");
                    });
            });
        }
    });
</script>