<?php 
 session_start();
 $carrinho = [];
 $id_produto = 3;
 if (isset($_SESSION['teste'])) {
     $carrinho = $_SESSION['teste'];
 }
 // Adicionar o produto ao carrinho 
 if (key_exists($id_produto, $carrinho)) {
    // Já existe o produto , acrescenta mais uma unidade 
    $carrinho[$id_produto]++;
 } else {
     $carrinho[$id_produto] = 1;
 }
 // Atualiza os dados do carrinho na sessão 
 $_SESSION['teste'] = $carrinho;
 // Mostrar o total de todos os produtos no carrinho 
 $total_produtos = 0;
 foreach ($carrinho as $produto_quantidade) {
     $total_produtos += $produto_quantidade;
 }

 echo "<pre>";
 print_r($_SESSION['teste']);

 echo $total_produtos;