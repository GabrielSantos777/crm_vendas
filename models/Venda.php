<?php 

require_once 'scripts/importar_csv.php';

class Venda {
    private $pdo;

    public function __construct(){
        global $pdo;
        $this->pdo = $pdo;
    }

    public function ResumoVendas(){
        $stmt = $this->pdo->query("SELECT COUNT(*) as quantidade, SUM(valor) as total, AVG(valor) as media FROM vendas");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}