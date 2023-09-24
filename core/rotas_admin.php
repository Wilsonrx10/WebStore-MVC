<?php

$rotas =  [
    'inicio' => 'admin@inicio',
    'login' => 'admin@login',
    'admin_login_submit' => 'admin@admin_login_submit',
    'logout_admin' => 'admin@logout_admin',
    // Encomendas geral 
    'encomendas' => 'admin@encomendas',
    'detalhes_encomenda_geral' => 'admin@detalhes_encomenda_geral',
    'Mudar_Estado_encomenda' => 'admin@Mudar_Estado_encomenda',
    // Rotas para o usuario 
    'clientes' => 'admin@clientes',
    'buscar_encomendas_usuarios' => 'admin@buscar_encomendas_usuarios',
    'buscar_encomendas_usuarios_detalhada' => 'admin@buscar_encomendas_usuarios_detalhada',
    // Produtos 
    'AdicionarProduct' => 'admin@AdicionarProduct',
    'AdicionarProductSubmit' => 'admin@AdicionarProductSubmit',
    'ListarProduct' => 'admin@ListarProduct',
    'informacoes_produtos_alteracao' => 'admin@informacoes_produtos_alteracao',
    'Editar_informacao_produto' => 'admin@Editar_informacao_produto'
];

// ação por defeito 
$acao = "inicio";

// verifica se existe a ação na query String 
if(isset($_GET['loja'])) {
    // verificar se a ação existe nas rotas
    if (!key_exists($_GET['loja'],$rotas)) {
        $acao = "inicio";
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