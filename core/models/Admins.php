<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Admins
{

    //==================================================
    // LOGIN PAINEL ADMINISTRATIVO 
    //==================================================

    public function validar_login($usuario_admin, $senha)
    {
        // verificar se o login é válido 
        $parametros = [
            ":usuario_admin" => $usuario_admin,
        ];
        $db = new Database();
        $resultados = $db->select("SELECT * FROM admins WHERE 
        usuario = :usuario_admin AND deleted_at IS NULL", $parametros);
        // Verificar se o usuario existe 
        if (count($resultados) != 1) {
            return false;
        } else {
            $usuario_admin = $resultados[0];
            // verificar se a Password é válida
            if (!password_verify($senha, $usuario_admin->senha)) {
                // Login é inválido 
                return false;
            } else {
                // Login é válido 
                return $usuario_admin;
            }
        }
    }
    //==========================================================

    // GERENCIAR O MODULO DE ENCOMENDAS PAINEL ADMINISTRATIVO

    //==========================================================

    public function lista_encomendas_pendente() {
    // buscar a lista de encomendas pendente
    $bd = new Database();
    $buscar_encomendas = $bd->select("
    SELECT e.*,c.nome_completo FROM encomendas e LEFT JOIN clientes c ON e.id_cliente
    = c.id_cliente WHERE status = 'PENDENTE'
    ");
    return $buscar_encomendas;

    }
    public function total_encomendas_pendente() {
    $bd = new Database();
    $total_encomendas_pendente = $bd->select("
    SELECT COUNT(*) total FROM encomendas WHERE status = 'PENDENTE'
    ");

    return $total_encomendas_pendente[0]->total;
    }

    public function lista_encomendas_filtro($filtro) {
    $bd = new Database();

    $sql = "SELECT e.*,c.nome_completo FROM encomendas e LEFT JOIN clientes c ON e.id_cliente
    = c.id_cliente
    ";

    if ($filtro != '') {
    $sql .= "WHERE e.status = '$filtro'";
    }
    $sql .= "ORDER BY e.id_encomenda DESC";
    return $bd->select($sql);

    }


    public function detalhes_encomenda_geral($id_encomenda){

         $parametros = [
            ":id_encomenda" => $id_encomenda
          ];
      
          $bd = new Database();
          $dados_encomenda = $bd->select("
          SELECT * FROM encomendas 
          WHERE id_encomenda = :id_encomenda
          ",$parametros)[0];
      
          // Lista dos produtos da encomenda
      
          $bd = new Database();
          $produtos_encomenda = $bd->select("
          SELECT * FROM encomenda_produto 
          WHERE id_encomenda = :id_encomenda
          ",$parametros);
      
          // devolver ao controlador o detalhe da encomenda
      
          return [
            "dados_encomenda" =>$dados_encomenda,
            "produtos_encomenda" =>$produtos_encomenda
          ];
    }

    public function Mudar_Estado_encomenda($novo_estado,$id_encomenda) {
    $parametros = [
    ":novo_estado" => $novo_estado,
    ":id_encomenda" => $id_encomenda
    ];

    $bd = new Database();
    $bd->update("
    UPDATE encomendas set status = :novo_estado
    WHERE id_encomenda = :id_encomenda
    ",$parametros);
    }

    //==========================================================

    // GERENCIAR MODULO DE USUARIOS PAINEL ADMINISTRATIVO

    //==========================================================
    public function lista_clientes_cadastrados() {
        $bd = new Database();
        $resultado = $bd->select("
        SELECT 
        clientes.id_cliente,
        clientes.email,
        clientes.telefone,
        clientes.nome_completo,
        clientes.ativo,
        clientes.morada,
        clientes.created_at,
        COUNT(encomendas.id_encomenda) total_encomendas
        FROM clientes LEFT JOIN encomendas
        ON clientes.id_cliente = encomendas.id_cliente
        GROUP BY clientes.id_cliente
        ORDER BY id_cliente
        ");

        return $resultado;
    }

    public function lista_encomendas_clientes($id_cliente) {
    $bd = new Database();
    $parametros = [
    "id_cliente" => $id_cliente
    ];

    $resultado = $bd->select("SELECT * FROM encomendas WHERE id_cliente = :id_cliente",
    $parametros);

    return $resultado;

    }

    public function detalhes_encomendas_clientes($id_encomenda_detalhe) {
   
     $parametros = [
        ":id_encomenda" => $id_encomenda_detalhe
      ];
  
      $bd = new Database();
      $dados_encomenda = $bd->select("
      SELECT * FROM encomendas 
      WHERE id_encomenda = :id_encomenda
      ",$parametros)[0];
  
      // Lista dos produtos da encomenda
  
      $bd = new Database();
      $produtos_encomenda = $bd->select("
      SELECT * FROM encomenda_produto 
      WHERE id_encomenda = :id_encomenda
      ",$parametros);
  
      // devolver ao controlador o detalhe da encomenda
  
      return [
        "dados_encomenda" =>$dados_encomenda,
        "produtos_encomenda" =>$produtos_encomenda
      ];

    }

     //==========================================================

    // GERENCIAR MODULO DE PRODUTOS PAINEL ADMINISTRATIVO

    //===========================================================
    public function AdicionarProduct($produto,$foto) {
    // Verificar se o preço de Venda é menor que preço de Custo
    if ($produto['precoVenda'] < $produto['precoCusto']) {
    $_SESSION['erro'] = "Preço de Venda inválido";
    Store::redirect('AdicionarProduct',true);
    }
    // Fazer o Upload da imagem do produto 
    $foto_produto = $foto['name'];
    $formatos_permitidos = array("png", "jpg", "gif", "jpeg", "jiff", "JPG");
    $extensao = pathinfo($foto_produto, PATHINFO_EXTENSION);
    // Verificar se o formato da foto existe na coleção 
    if (in_array($extensao,$formatos_permitidos)) {
    // Calcular o lucro desse produto 
    $lucro = $produto['precoVenda'] - $produto['precoCusto'];
    $parametros = [
    ":categoria" => $produto['categoria'],
    ":nome_produto" => $produto['nome'],
    ":descricao" => $produto['descricao'],
    ":imagem" => $foto_produto,
    ":preco_venda" => $produto['precoVenda'],
    ":preco_custo" => $produto['precoCusto'],
    ":lucro" => $lucro,
    ":stock" => $produto['quantidade'],
    ":visivel" => 1
    ];
    
    $bd = new Database();
    $bd->insert("
    INSERT INTO produtos
    VALUES(
    0,
    :categoria,
    :nome_produto,
    :descricao,
    :imagem,
    :preco_venda,
    :preco_custo,
    :lucro,
    :stock,
    :visivel,
    NOW(),
    NOW(),
    NULL
    )
    ",$parametros);
   
    // Recuperar o ultimo ID inserido no Banco de dados na Tabela produto
    $ultimo_id = $bd->select("SELECT MAX(id_produto) id_produto FROM produtos")[0]->id_produto;
    // Diretório onde o Arquivo será salvo
    $diretorio = '../../public/assets/images/placas/' . $ultimo_id . '/';
    // Criar Pasta da foto 
    mkdir($diretorio, 0755);
    // Fazendo o Upload da imagem
    if (move_uploaded_file($foto['tmp_name'], $diretorio . $foto_produto)) {
    $_SESSION['success'] = "Produto Adicionado com Sucesso";
    Store::redirect('AdicionarProduct',true);
    } else {
    $_SESSION['erro'] = "Aconteceu um erro ao fazer o Upload da imagem";
    Store::redirect('AdicionarProduct',true);
    }
    } else {
    $_SESSION['erro'] = "Formato da foto do produto inválido";
    Store::redirect('AdicionarProduct',true);
    }

    }

    public function Buscar_Lista_produtos() {
    $bd = new Database();
    $resultado = $bd->select("
    SELECT * FROM produtos
    ");

    return $resultado;
    }

    public function informacoes_produtos_alteracao($id) {
    $parametros = [
    'id_prod' => $id
    ];
    $bd = new Database();
    $resultado = $bd->select("
    SELECT * FROM produtos
    WHERE id_produto = :id_prod
    ",$parametros)[0];
    
    return $resultado;
    }

    public function Editar_informacao_produto($dados)
    {
        $bd = new Database();

         // Atualizar a quantidade e calcular o lucro 
         $resultado = $bd->select("
         SELECT * FROM produtos WHERE id_produto = '".$dados['id_produto']."'
         ")[0];

         $quantidade = $resultado->stock + $dados['quantidade'];
         
         $lucro = $dados['precoVenda'] - $dados['precoCusto'];

         // Lógica da visibilidade do produto 
         if ($dados['visivel'] == "SIM") {
         $visivel = 0;
         } else if($dados['visivel'] == "Não") {
         $visivel = 1; 
         } else {
         $visivel = 1;
         }

         $parametros = [
            ":id_produto" => $dados['id_produto'],
            ":nome_produto"=> $dados['nome_produto'],
            ":categoria" => $dados['categoria'],
            ":visivel" => $visivel,
            ":quantidade" => $quantidade,
            ":precoCusto" => $dados['precoCusto'],
            ":precoVenda" => $dados['precoVenda'],
            ":lucro" => $lucro
            ];
        
        $bd->update("
        UPDATE produtos SET
        nome_produto = :nome_produto,
        categoria = :categoria,
        visivel = :visivel,
        stock = :quantidade,
        preco_custo = :precoCusto,
        preco_venda = :precoVenda,
        lucro = :lucro
        WHERE id_produto = :id_produto
        ",$parametros);

        Store::redirect("ListarProduct",true);

    }
    
}
