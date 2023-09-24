<?php

use core\classes\Store;
use core\classes\Database;

// Calcular o número de produtos no Carrinho
$total_produtos = 0;
if (isset($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $quantidade) {
        $total_produtos += $quantidade;
    }
}

  // devolver a lista de categorias existente na Base de Dados 
  $bd = new Database();
  $resultados = $bd->select("SELECT DISTINCT categoria FROM produtos");
  $categorias = [];
  foreach ($resultados as $resultado) {
  array_push($categorias, $resultado->categoria);
  }

?>
<header>
    <style>
        .carousel {
            margin-bottom: 4rem;
        }
        .carousel-caption {
            bottom: 3rem;
            z-index: 10;
        }
        .carousel-item {
            height: 32rem;
        }

        .carousel-item>img {
            position: absolute;
            top: 0;
            left: 0;
            min-width: 100%;
            height: 32rem;
        }
    </style>
</header>

<!--------NAVEGAÇÃO 1------->

<div class="container-fluid navegacao">
    <div class="row">
        <div class="col-6 p-3">
            <a href="?loja=inicio">
                <h2><?= APP_NAME ?></h2>
            </a>

            <div style="margin-top:-50px; margin-left:75%;" class="pesquisa">
                <input type="text" name="" id="" placeholder="Faça sua pesquisa aqui">
            </div>
        </div>

        <div class="col-6 text-end p-3">
            <!-- Verifica se existe cliente na Sessão-->
            <?php if (Store::clienteLogado()) { ?>
                <i class="fas fa-user"></i> <a href="?loja=minha_conta"><?= $_SESSION['usuario'] ?></a>
                <a href="?loja=logout"><i class="fas fa-sign-out-alt"></i></a>
            <?php } else { ?>
                <i class="fas fa-user"></i> <a href="?loja=login">Login |</a>
            <?php } ?>

            <a href="?loja=carrinho"><i class="fas fa-shopping-cart"></i></a>
            <span class="badge bg-warning" id="carrinho"><?= $total_produtos ?></span>
        </div>
    </div>
</div>

<!--------NAVEGAÇÃO 2------->

<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">PC Gamer</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Impressoras</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Plasmas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Videogame</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Fale-conosco</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Promoção</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Cupons de Desconto</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categorias
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="?loja=loja&c=todos">Todos</a></li>
                        <?php foreach ($categorias as $categoria) { ?>
                            <li><a class="dropdown-item" href="?loja=loja&c=<?= $categoria ?>"><?= ucfirst(preg_replace("/\_/", "", $categoria)) ?></a></li>
                        <?php } ?>
                    </ul>
                </li>

            </ul>

        </div>
    </div>
</nav>