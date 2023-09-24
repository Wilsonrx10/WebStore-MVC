<?php 

namespace  core\models;

use core\classes\Database;
use core\classes\Store;

Class Produtos {
    public function lista_produtos_disponivel($categoria) {
     $bd = new Database();
     $categorias = $this->buscar_categorias();

     $sql = "SELECT * FROM produtos WHERE visivel = 1 ";

     if (in_array($categoria, $categorias)) {
       $sql .= " AND categoria = '$categoria' ";
     }

     $produtos = $bd->select($sql);

     return $produtos;

    } 

    public function buscar_categorias() {

        $bd = new Database();
        $resultados = $bd->select("SELECT DISTINCT categoria FROM produtos");
        $categoria = [];
        foreach ($resultados as $resultado) {
            array_push($categoria, $resultado->categoria);
        }

        return $categoria;

    }

     public function verificar_stock_produto($id_produto) {
        $bd = new Database();
        $parametros = [
            ":id_produto" => $id_produto
        ];
        $consulta = $bd->select("
        SELECT * FROM produtos 
        WHERE id_produto = :id_produto 
        AND visivel = 1 
        AND stock > 0 
        ",$parametros);

        if (count($consulta) !=0) {
            return true;
        } else{
            return false;
        }

    }
    public function produtos_carrinho_ids($ids) {
        $bd = new Database();
        $resultados = $bd->select("SELECT * FROM produtos WHERE id_produto IN ($ids)");

        return $resultados;
    }
}