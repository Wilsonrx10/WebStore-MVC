<?php

namespace core\controller;

use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Clientes;
use core\models\Encomendas;
use core\models\Produtos;

class Carrinho
{
    //=====================================================
    public function Carrinho()
    {
        if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {
            $dados = [
                "carrinho" => null
            ];
        } else {
            $ids = [];
            foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
                array_push($ids, $id_produto);
            }
            $ids = implode(",", $ids);
            $produtos = new Produtos();
            $resultados = $produtos->produtos_carrinho_ids($ids);

            $dados_tmp = [];
            foreach ($_SESSION['carrinho'] as $id_produto => $quantidade_carrinho) {
                foreach ($resultados as $produto) {
                    if ($produto->id_produto == $id_produto) {
                        $id_produto = $id_produto;
                        $imagem = $produto->imagem;
                        $titulo = $produto->nome_produto;
                        $quantidade = $quantidade_carrinho;
                        $preco = $produto->preco_venda * $quantidade;
                        // colocar o produto na coleção 
                        array_push($dados_tmp, [
                            "id_produto" => $id_produto,
                            "imagem" => $imagem,
                            "titulo" => $titulo,
                            "quantidade" => $quantidade,
                            "preco" => $preco
                        ]);

                        break;
                    }
                }
            }

            // Calcular o total da encomenda 
            $total_da_encomenda = 0;
            foreach ($dados_tmp as $item) {
                $total_da_encomenda += $item['preco'];
            }

            array_push($dados_tmp, [
                "total" => $total_da_encomenda
            ]);

            // colocar o preço Total na Sessão 
            $_SESSION['total_encomenda'] = $total_da_encomenda;

            $dados = [
                "carrinho" => $dados_tmp
            ];
        }

        Store::Layout([
            "layouts/html_header",
            "layouts/header",
            "carrinho",
            "layouts/footer",
            "layouts/html_footer",
        ], $dados);
    }

    //=====================================================
    public function adicionar_carrinho()
    {
        if (!isset($_GET['id_produto'])) {
            echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : " ";
            return;
        }

        $id_produto = $_GET['id_produto'];
        $produtos = new Produtos();
        $resultados = $produtos->verificar_stock_produto($id_produto);
        if ($resultados == false) {
            echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : " ";
            return;
        }
        $carrinho = [];
        if (isset($_SESSION['carrinho'])) {
            $carrinho = $_SESSION['carrinho'];
        }
        if (key_exists($id_produto, $carrinho)) {
            $carrinho[$id_produto]++;
        } else {
            $carrinho[$id_produto] = 1;
        }
        $_SESSION['carrinho'] = $carrinho;
        $total_produtos = 0;
        foreach ($carrinho as $produto_quantidade) {
            $total_produtos += $produto_quantidade;
        }

        echo $total_produtos;
    }
    //=====================================================
    public function apagar_carrinho()
    {
        unset($_SESSION['carrinho']);
        $this->Carrinho();
    }
    //====================================================
    public function eliminar_produto_carrinho()
    {
        $id_produto = $_GET['id_produto'];
        $carrinho = $_SESSION['carrinho'];
        unset($carrinho[$id_produto]);
        $_SESSION['carrinho'] = $carrinho;
        $this->Carrinho();
    }
    //====================================================
    public function morada_altenativa()
    {

        $valor = json_decode(file_get_contents('php://input'), true);

        $_SESSION['valor_altenativo'] = [
            "morada" => $valor['text_morada'],
            "cidade" => $valor['text_cidade'],
            "email" => $valor['text_email'],
            "telefone" => $valor['text_telefone']
        ];
    }
    //====================================================
    public function finalizar_encomenda()
    {
        if (!$_SESSION['cliente']) {
            $_SESSION['tmp_carrinho'] = true;
            Store::redirect("login");
        } else {
            Store::redirect("finalizar_encomenda_resumo");
        }
    }

    //====================================================
    public function finalizar_encomenda_resumo()
    {
        if (!isset($_SESSION['cliente'])) {
            Store::redirect("loja");
        }
        if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {
            Store::redirect("loja");
            return;
        }
        if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {
            $dados = [
                "carrinho" => null
            ];
        } else {
            $ids = [];
            foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
                array_push($ids, $id_produto);
            }
            $ids = implode(",", $ids);
            $produtos = new Produtos();
            $resultados = $produtos->produtos_carrinho_ids($ids);

            $dados_tmp = [];
            foreach ($_SESSION['carrinho'] as $id_produto => $quantidade_carrinho) {
                foreach ($resultados as $produto) {
                    if ($produto->id_produto == $id_produto) {
                        $id_produto = $id_produto;
                        $imagem = $produto->imagem;
                        $titulo = $produto->nome_produto;
                        $quantidade = $quantidade_carrinho;
                        $preco = $produto->preco_venda * $quantidade;

                        array_push($dados_tmp, [
                            "id_produto" => $id_produto,
                            "imagem" => $imagem,
                            "titulo" => $titulo,
                            "quantidade" => $quantidade,
                            "preco" => $preco
                        ]);

                        break;
                    }
                }
            }

            $total_da_encomenda = 0;
            foreach ($dados_tmp as $item) {
                $total_da_encomenda += $item['preco'];
            }

            array_push($dados_tmp, [
                "total" => $total_da_encomenda
            ]);

            $dados = [
                "carrinho" => $dados_tmp

            ];
        }
        $clientes = new Clientes();
        $dados_cliente = $clientes->buscar_dados_cliente($_SESSION['cliente']);
        $dados['cliente'] = $dados_cliente;

        if (!isset($_SESSION['codigo_encomenda'])) {
            $codigo_encomenda = Store::gerarCodigoEncomenda();
            $_SESSION['codigo_encomenda'] = $codigo_encomenda;
        }


        Store::Layout([
            "layouts/html_header",
            "layouts/header",
            "carrinho_resumo",
            "layouts/footer",
            "layouts/html_footer",
        ], $dados);
    }

    //====================================================
    public function confirmar_encomenda()
    {

        if (!isset($_SESSION['cliente'])) {
            Store::redirect("loja");
        }
        if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {
            Store::redirect("loja");
            return;
        }
        $ids = [];
        foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
            array_push($ids, $id_produto);
        }
        $ids = implode(",", $ids);
        $produtos = new Produtos();
        $produtos_encomenda = $produtos->produtos_carrinho_ids($ids);

        $dados_encomenda = [];

        $string_produtos = [];
        foreach ($produtos_encomenda as $resultado) {
            $quantidade = $_SESSION['carrinho'][$resultado->id_produto];
            $string_produtos[] = "$quantidade x $resultado->nome_produto - " .
                number_format($resultado->preco, 2, ",", ".") . " kz / unidade ";
        }
        $dados_encomenda['produtos_encomenda'] = $string_produtos;

        $dados_encomenda['total'] = number_format($_SESSION['total_encomenda'], 2, ",", ".") . "kz";


        $dados_encomenda['dados_pagamento'] = [
            "numero_da_conta" => 1234567890,
            "codigo_encomenda" => $_SESSION['codigo_encomenda'],
            'total' =>   $dados_encomenda['total'] = number_format($_SESSION['total_encomenda'], 2, ",", ".") . "kz"
        ];

        $email = new EnviarEmail();
        $resultado = $email->enviar_email_confirmacao_encomenda($_SESSION['usuario'], $dados_encomenda);
        $dados_encomenda = [];
        $dados_encomenda['id_cliente'] = $_SESSION['cliente'];
        // Morada 
        if (isset($_SESSION['dados_altenativos']['morada']) && !empty($_SESSION['dados_altenativos']['morada'])) {
            $dados_encomenda['morada'] = $_SESSION['dados_altenativos']['morada'];
            $dados_encomenda['cidade'] = $_SESSION['dados_altenativos']['cidade'];
            $dados_encomenda['email'] = $_SESSION['dados_altenativos']['email'];
            $dados_encomenda['telefone'] = $_SESSION['dados_altenativos']['telefone'];
        } else {
            $cliente = new Clientes();
            $dados_cliente = $cliente->buscar_dados_cliente($_SESSION['cliente']);


            $dados_encomenda['morada'] = $dados_cliente->morada;
            $dados_encomenda['cidade'] = $dados_cliente->cidade;
            $dados_encomenda['email'] =  $dados_cliente->email;
            $dados_encomenda['telefone'] = $dados_cliente->telefone;
        }

        $dados_encomenda['codigo_encomenda'] = $_SESSION['codigo_encomenda'];

        $dados_encomenda['status'] = "PENDENTE";
        $dados_encomenda['mensagem'] = "";

        // Dados do produto da encomenda 
        $dados_produtos = [];
        foreach ($produtos_encomenda as $produto) {
            array_push($dados_produtos, [
                "designacao_produto" => $produto->nome_produto,
                "preco_unidade" => $produto->preco,
                "quantidade" => $_SESSION['carrinho'][$produto->id_produto]
            ]);
        }

        $encomendas = new Encomendas();
        $encomendas->guardar_encomenda($dados_produtos, $dados_encomenda);

        unset($_SESSION['valor_altenativo']);
        unset($_SESSION['carrinho']);
        unset($_SESSION['codigo_encomenda']);
        unset($_SESSION['total_encomend']);

        Store::Layout([
            "layouts/html_header",
            "layouts/header",
            "encomenda_confirmada",
            "layouts/footer",
            "layouts/html_footer",
        ]);
    }

    public function alterar_quantidade_carrinho()
    {

        if (!isset($_SESSION['cliente'])) {
            Store::redirect("loja");
        }

        $valor = json_decode(file_get_contents('php://input'), true);

        $id_produto = $valor['id_produto'];

        $acao = $valor['acao'];
        if (isset($acao)) {
            if ($acao == 'reduzir') {
                if (isset($_SESSION['carrinho'])) {
                    $carrinho = $_SESSION['carrinho'];
                }
                if (key_exists($id_produto, $carrinho)) {
                    if ($carrinho[$id_produto] <= 1) {
                        unset($carrinho[$id_produto]);
                    } else {
                        if ($carrinho[$id_produto] == 0) {
                            unset($carrinho[$id_produto]);
                        }
                        $carrinho[$id_produto]--;
                    }
                } else {
                    Store::redirect("carrinho");
                }
            } else if ($acao == 'aumentar') {
                if (isset($_SESSION['carrinho'])) {
                    $carrinho = $_SESSION['carrinho'];
                }
                if (key_exists($id_produto, $carrinho)) {
                    $carrinho[$id_produto]++;
                    $_SESSION['carrinho'] = $carrinho;
                } else {
                    Store::redirect("carrinho");
                }
            } else {
                Store::redirect("carrinho");
            }
        } else {
            Store::redirect("carrinho");
        }

        $_SESSION['carrinho'] = $carrinho;
        Store::redirect("carrinho");
    }
}