<?php

namespace core\models;
use core\classes\Database;
use core\classes\Store;

class Clientes
{

    public function verificar_email_existe($email)
    {
        // Verifica se já existe um cliente com o mesmo Email 
        $bd = new Database();

        $parametros =  [
            ":email" => strtolower(trim($email))
        ];

        $resultado = $bd->select("SELECT email FROM clientes WHERE email = :email", $parametros);
        if (count($resultado) != 0) {
            return true;
        } else {
            return false;
        }
    }

    public function Criar_Cliente() {
        $bd = new Database();
        // cria um Hash para o registro do cliente 
        $purl = Store::CriarHash();
        // inserir os dados na tabela Clientes 
        $parametros = [
            ':email' => strtolower(trim($_POST['text_email'])),
            ':senha' => password_hash($_POST['text_senha_1'], PASSWORD_DEFAULT),
            ':nome_completo' => trim($_POST['text_nome_completo']),
            ':morada' => trim($_POST['text_morada']),
            ':cidade' => trim($_POST['text_cidade']),
            ':telefone' => trim($_POST['text_telefone']),
            ':purl' => $purl,
            ':ativo' => 0
        ];

    $bd->insert("INSERT INTO clientes VALUES (0,:email,:senha,:nome_completo,:morada,:cidade,:telefone,:purl,:ativo,NOW(),NOW(),NULL)", $parametros);

      // Retorna um PURL criado 
      return $purl;
    }

    public function validar_email($purl) {
        // validar o email do novo cliente 
        $bd = new Database();
        $parametros = [
            ':purl' => $purl
        ];

        $resultado = $bd->select("SELECT * FROM clientes WHERE purl =  :purl", $parametros); 

        if (count($resultado) !=1) {
            return false;
        }
        
        $id_cliente = $resultado[0]->id_cliente;

        
        // Atualizar os dados 
        $parametros = [
            ':id_cliente' => $id_cliente,
        ];

        $bd->update("
        UPDATE clientes SET 
        purl = NULL, 
        ativo = 1, 
        updated_at = NOW()
        WHERE id_cliente = :id_cliente
        ",$parametros);

        return true;

    }

    public function validar_login($usuario,$senha) {
        
        // verificar se o login é válido 
        $parametros = [
            ":usuario" => $usuario,
        ];
        $db = new Database();
        $resultados = $db->select("SELECT * FROM clientes WHERE 
        email = :usuario AND ativo = 1 AND deleted_at IS NULL", $parametros);
        // Verificar se o usuario existe 
        if (count($resultados) !=1) {
           return false;
        } else {
            $usuario = $resultados[0];
            // verificar se a Password é válida
            if (!password_verify($senha, $usuario->senha)) {
                // Login é inválido 
               return false;
            } else {
                // Login é válido 
                return $usuario;
            }
        }

    }
    public function buscar_dados_cliente($id_cliente) {
      $parametros = [
        ":id_cliente" => $id_cliente
      ];
      $bd = new Database();
      $resultados = $bd->select("SELECT 
       email,
       nome_completo,
       morada,
       cidade,
       telefone
       FROM clientes WHERE id_cliente = :id_cliente",$parametros);
      return $resultados[0];
    }
    //=============================================================
    public function atualizar_dados_usuario($dados_atualizar) {
       $parametros = [
        "id_cliente" => $_SESSION['cliente'],
         ":email" => $dados_atualizar['email'], 
         ":nome_completo" => $dados_atualizar['nome_completo'],
         ":morada" => $dados_atualizar['morada'],
         ":cidade" => $dados_atualizar['cidade'],
         ":telefone" => $dados_atualizar['telefone'],
       ];

       $bd = new Database();

       $bd->update("
       UPDATE clientes 
       SET
       email = :email , 
       nome_completo = :nome_completo,
       morada = :morada, 
       cidade = :cidade, 
       telefone = :telefone,
       updated_at = NOW()
       WHERE id_cliente = :id_cliente
       ",$parametros);

       return true;
    }

    //======================================================
    public function verificar_senha_atual($id_cliente, $senha_atual) {
      $parametros = [
        ":id_cliente" => $id_cliente
      ];

      $bd = new Database();

      $senha_bd = $bd->select("
      SELECT senha FROM clientes WHERE id_cliente = :id_cliente
      ",$parametros)[0]->senha;
      // verificar se as senhas do Banco de Dados correspondem 
      return password_verify($senha_atual, $senha_bd);

    }

    //====================================================
    public function Atualizar_senha_cliente($id_cliente, $nova_senha) {
       $parametros = [
        ":id_cliente" => $id_cliente,
        ":nova_senha" => password_hash($nova_senha, PASSWORD_DEFAULT)
       ];
       
       $bd = new Database();
       $bd->update("
       UPDATE clientes SET senha = :nova_senha, 
       updated_at = NOW()
       WHERE id_cliente = :id_cliente
       ", $parametros);

       return true;
    }
}
