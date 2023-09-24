<?php
// coleção de rotas

$rotas =  [
    'loja' => 'main@loja',
    // Cliente
    'novo_cliente' => 'main@novo_cliente',
    'criar_cliente' => 'main@criar_cliente',
    'confirmar_email' => 'main@confirmar_email',
    'login' => 'main@login',
    'login_submit' => 'main@login_submit',
    'logout' => 'main@logout',
    // Perfil do Usuario 
    'minha_conta' => 'main@perfil',
    'alterar_dados_perfil' => 'main@alterar_dados_perfil',
    // Histórico da encomenda 
    'historico_encomendas'=> 'main@historico_encomendas',
    'detalhes_encomenda' => 'main@detalhes_encomenda',
    // Carrinho 
    'apagar_carrinho' => 'Carrinho@apagar_carrinho',
    'carrinho' => 'Carrinho@carrinho',
    'adicionar_carrinho' => 'Carrinho@adicionar_carrinho',
    'eliminar_produto_carrinho' => 'Carrinho@eliminar_produto_carrinho',
    'finalizar_encomenda' => 'Carrinho@finalizar_encomenda',
    'finalizar_encomenda_resumo' => 'Carrinho@finalizar_encomenda_resumo',
    'confirmar_encomenda' => 'Carrinho@confirmar_encomenda',
    'morada_altenativa' => 'Carrinho@morada_altenativa',
    'alterar_quantidade_carrinho' => 'Carrinho@alterar_quantidade_carrinho'

];

// ação por defeito 
$acao = "loja";

// verifica se existe a ação na query String 
if(isset($_GET['loja'])) {
    // verificar se a ação existe nas rotas
    if (!key_exists($_GET['loja'],$rotas)) {
        $acao = "loja";
    } else {
        $acao = $_GET['loja'];
    }
}

// Tratamento da rota 

$partes = explode("@", $rotas[$acao]);
$controlador = 'core\\controller\\'.ucfirst($partes[0]);
$metodo = $partes[1];

$ctr = new $controlador();
$ctr->$metodo();