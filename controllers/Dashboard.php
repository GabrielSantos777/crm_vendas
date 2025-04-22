<?php

require_once 'models/Venda.php';

class Dashboard {
    public function obterResumo(){
        $venda = new Venda();
        return $venda->ResumoVendas();
    }
}