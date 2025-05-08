<?php
require_once('controllers/Vendas.php')
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
                    <th>Cliente</th>
                    <th>Pedido</th>
                    <th>Valor Total</th>
                    <th>Data</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dados -->
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
        <form class="modal-content" id="formNovaVenda">
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