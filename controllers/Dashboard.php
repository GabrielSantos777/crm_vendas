<?php

require_once 'models/Venda.php';

class Dashboard {

    public function montarFiltro($filtro) {
        switch ($filtro) {
            case 'hoje':
                return "WHERE DATE(data) = CURDATE()";
            case 'semana':
                return "WHERE YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1)";
            case 'mes':
                return "WHERE MONTH(data) = MONTH(CURDATE()) AND YEAR(data) = YEAR(CURDATE())";
            case 'ano':
                return "WHERE YEAR(data) = YEAR(CURDATE())";
            default:
                return "";
        }
    }
    
    public function obterResumo($filtro) {

         global $pdo;

         $where = $this->montarFiltro($filtro);

         $stmt = $pdo->query("SELECT COUNT(*) AS quantidade, SUM(valor) AS total FROM vendas $where");
         $dados = $stmt->fetch(PDO::FETCH_ASSOC);

         $quantidade = $dados['quantidade'] ?? 0;
         $total = $dados['total'] ?? 0;
         $ticket_medio = $quantidade > 0 ? $total / $quantidade : 0;

         return [
            'quantidade' => $quantidade,
            'total' => number_format($total, 2, ',', '.'),
            'ticket_medio' => number_format($ticket_medio, 2, ',', '.'),
         ];
    }

    public function obterVendasPorDia($filtro) {
        global $pdo;
        $where = $this->montarFiltro($filtro);
    
        $stmt = $pdo->query("SELECT DATE(data) AS dia, SUM(valor) AS total FROM vendas $where GROUP BY dia ORDER BY dia ASC");
    
        $dias = [];
        $valores = [];
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dias[] = date('d/m', strtotime($row['dia']));
            $valores[] = floatval($row['total']);
        }
    
        return ['dias' => $dias, 'valores' => $valores];
    }
    
}