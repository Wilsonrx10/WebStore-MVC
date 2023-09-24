<?php 

namespace core\models;

use core\classes\Database;
use core\classes\Store;

Class Encomendas {

  public function guardar_encomenda($dados_produtos, $dados_encomenda) {

    $bd = new Database();

    $parametros = [
	    ':id_cliente'=> $_SESSION['cliente'],
	    ':morada'=> $dados_encomenda['morada'],
	    ':cidade'=> $dados_encomenda['cidade'],
	    ':telefone'=> $dados_encomenda['telefone'],
	    ':email'=> $dados_encomenda['email'],
	    ':codigo_encomenda'=> $dados_encomenda['codigo_encomenda'],
	    ':status'=> $dados_encomenda['status'],
	    ':mensagem'=> $dados_encomenda['mensagem'],
    ];

    $bd->insert("

    INSERT INTO encomendas VALUES(
      0,
      :id_cliente,
      NOW(),
      :morada,
	    :cidade,
	    :telefone,
	    :email,
	    :codigo_encomenda,
	    :status,
	    :mensagem,
      NOW(),
      NOW()
    )
    ",$parametros);

    // Buscar o id da encomenda 
    $id_encomenda = $bd->select(
    "SELECT MAX(id_encomenda) 
    id_encomenda FROM encomendas")[0]->id_encomenda;

    // Guardar dados dos Produtos 
    foreach ($dados_produtos as $produtos_dados) {
      $parametros = [
        ':id_encomenda'=> $id_encomenda ,
        ':designacao_produto'=> $produtos_dados['designacao_produto'],
        ':preco_unidade'=> $produtos_dados['preco_unidade'],
        ':quantidade'=> $produtos_dados['quantidade']
      ];
  
      $bd->insert("
         INSERT INTO encomenda_produto VALUES(
         0,
        :id_encomenda,
        :designacao_produto,
        :preco_unidade,
        :quantidade,
        NOW()
        )",$parametros);
    }
     
  }

  //===========================================================
  public function buscar_historico_encomendas($id_cliente) {
      $parametros = [
        "id_cliente" => $id_cliente
      ];

      $bd = new Database();
      $resultado = $bd->select("
      SELECT id_encomenda,data_encomenda,codigo_encomenda,status
      FROM encomendas
      WHERE id_cliente = :id_cliente 
      ORDER BY data_encomenda DESC
      ",$parametros);

      return $resultado;
  }
  //===========================================================
  public function verificar_encomenda_cliente($id_cliente, $id_encomenda) {

    $parametros = [
      ":id_cliente" => $id_cliente,
      ":id_encomenda" => $id_encomenda
    ];

    $bd = new Database();
    $resultado = $bd->select("
    SELECT id_encomenda
    FROM encomendas
    WHERE id_encomenda = :id_encomenda
    AND id_cliente = :id_cliente",$parametros);

    return count($resultado) == 0 ? false : true;
    

  }

  //================================================================
  public function detalhes_encomenda($id_cliente, $id_encomenda) {

    // Dados da encomenda
    $parametros = [
      ":id_cliente" => $id_cliente,
      ":id_encomenda" => $id_encomenda
    ];

    $bd = new Database();
    $dados_encomenda = $bd->select("
    SELECT * FROM encomendas 
    WHERE id_cliente = :id_cliente
    AND id_encomenda = :id_encomenda
    ",$parametros)[0];

    // Lista dos produtos da encomenda

    $parametros = [
      ":id_encomenda" => $id_encomenda
    ];

    $bd = new Database();
    $produtos_encomenda = $bd->select("
    SELECT * FROM encomenda_produto 
    WHERE id_encomenda = :id_encomenda
    ",$parametros);

    return [
      "dados_encomenda" =>$dados_encomenda,
      "produtos_encomenda" =>$produtos_encomenda
    ];

  }

}



?>