<?php

namespace core\controller;

use core\classes\Store;
use core\models\Admins;

class Admin
{
    public function inicio()
    {
        if (!Store::Adminlogado()) {
            $this->login();
            return;
        }
        Store::Layout_admin([
            "Admin/layouts/header",
            "Admin/home",
            "Admin/layouts/footer",

        ]);
    }
    public function login()
    {
        if (Store::Adminlogado()) {
            $this->login();
            return;
        }
        Store::Layout_admin([
            "Admin/layouts/html_header",
            "Admin/login"
        ]);
    }
    public function admin_login_submit()
    {
        if ($_SERVER['REQUEST_METHOD'] != "POST") {
            Store::redirect("", true);
            return;
        }
        if (Store::clienteLogado()) {
            Store::redirect("", true);
            return;
        }

        if (
            !isset($_POST['text_admin']) || !isset($_POST['text_senha']) ||
            !filter_var(trim($_POST['text_admin']), FILTER_VALIDATE_EMAIL)
        ) {
            $_SESSION['erro'] = "Não foi possível autenticar";
            Store::redirect('login', true);
            return;
        }

        $usuario_admin = trim(strtolower($_POST['text_admin']));
        $senha = trim($_POST['text_senha']);
        $admin = new Admins();
        $resultado = $admin->validar_login($usuario_admin, $senha);

        if (is_bool($resultado)) {
            $_SESSION['erro'] = "Não foi possivel autenticar";
            Store::redirect('login', true);
            return;
        } else {

            $_SESSION['admin'] = $resultado->id_admin;
            $_SESSION['admin_usuario'] = $resultado->usuario;
            Store::redirect("", true);
        }
    }
    public function logout_admin()
    {
        unset($_SESSION['admin_usuario']);
        unset($_SESSION['admin']);
        Store::redirect("login", true);
    }
    public function encomendas()
    {
        if (!Store::Adminlogado()) {
            $this->login();
            return;
        }
        $filtros = [
            'pendente' => "PENDENTE",
            'em_processamento' => "EM_PROCESSAMENTO",
            'cancelada' => "CANCELADA",
            'enviada' => "ENVIADA",
            'concluida' => "CONCLUIDA",
        ];

        $filtro = "";
        if (isset($_GET['f'])) {
            if (key_exists($_GET['f'], $filtros)) {
                $filtro = $_GET['f'];
            }
        }
        $admin = new Admins();

        $lista_encomendas_filtro = $admin->lista_encomendas_filtro($filtro);
        $encomendas_pendente = $admin->lista_encomendas_pendente();
        $total_encomenda_pendente = $admin->total_encomendas_pendente();

        $dados = [
            'encomendas_pendente' => $encomendas_pendente,
            'total_encomenda_pendente' => $total_encomenda_pendente,
            'lista_encomendas_filtro' => $lista_encomendas_filtro
        ];
        Store::Layout_admin([
            "Admin/layouts/html_header",
            "Admin/layouts/header",
            "Admin/Encomendas",
            "Admin/layouts/footer",
            "Admin/layouts/html_footer",

        ], $dados);
    }

    public function detalhes_encomenda_geral()
    {
        $admin = new Admins();
        if (isset($_GET['encomenda'])) {
            $id_encomenda = $_GET['encomenda'];
        } else {
            Store::redirect("", true);
        }

        $detalhes_encomenda_geral = $admin->detalhes_encomenda_geral($id_encomenda);
        $total = 0;
        foreach ($detalhes_encomenda_geral['produtos_encomenda'] as $produto) {
            $total += ($produto->quantidade * $produto->preco_unidade);
        }
        $dados = [
            "dados_encomenda" => $detalhes_encomenda_geral['dados_encomenda'],
            "produtos_encomenda" => $detalhes_encomenda_geral['produtos_encomenda'],
            "total_encomenda" => $total
        ];

        Store::Layout_admin([
            "Admin/layouts/html_header",
            "Admin/layouts/header",
            "Admin/Encomendas_detalhes",
            "Admin/layouts/footer",
            "Admin/layouts/html_footer",
        ], $dados);
    }

    public function Mudar_Estado_encomenda()
    {
        $valor = json_decode(file_get_contents('php://input'), true);

        $novo_estado = $valor['estado_atual'];
        $id_encomenda = $valor['id_encomenda'];
        $Admin = new Admins();
        $Admin->Mudar_Estado_encomenda($novo_estado, $id_encomenda);
    }

    //===============================================================
    // USUARIOS
    //===============================================================

    public function clientes()
    {
        if (!Store::Adminlogado()) {
            $this->login();
            return;
        }
        $admin = new Admins();
        $cliente = $admin->lista_clientes_cadastrados();

        $dados = [
            "clientes" => $cliente
        ];

        Store::Layout_admin([
            "Admin/layouts/html_header",
            "Admin/layouts/header",
            "Admin/clientes",
            "Admin/layouts/footer",
            "Admin/layouts/html_footer",

        ], $dados);
    }
    public function buscar_encomendas_usuarios()
    {
        if (!Store::Adminlogado()) {
            $this->login();
            return;
        }
        $admin = new Admins();
        if (isset($_GET['cliente'])) {
            $id_cliente = $_GET['cliente'];
        } else {
            Store::redirect("", true);
        }

        $encomendas_cliente = $admin->lista_encomendas_clientes($id_cliente);

        $dados = [
            "encomendas_cliente" => $encomendas_cliente
        ];

        Store::Layout_admin([
            "Admin/layouts/html_header",
            "Admin/layouts/header",
            "Admin/Encomendas_usuario",
            "Admin/layouts/footer",
            "Admin/layouts/html_footer",
        ], $dados);
    }

    public function buscar_encomendas_usuarios_detalhada()
    {

        unset($_SESSION['detalhe_encomenda_usuario']);
        unset($_SESSION['dados_encomenda']);
        unset($_SESSION['total_encomenda_detalhe']);

        if (!Store::Adminlogado()) {
            $this->login();
            return;
        }

        $admin = new Admins();

        $valor = json_decode(file_get_contents('php://input'), true);
        if (isset($valor['id_encomenda_detalhe'])) {
            $id_encomenda_detalhe = $valor['id_encomenda_detalhe'];
            if ($id_encomenda_detalhe != "") {
                $detalhes_encomenda_cliente = $admin->detalhes_encomendas_clientes($id_encomenda_detalhe);
                $total = 0;
                foreach ($detalhes_encomenda_cliente['produtos_encomenda'] as $produto) {
                    $total += ($produto->quantidade * $produto->preco_unidade);
                }
                $_SESSION['detalhe_encomenda_usuario'] = $detalhes_encomenda_cliente['produtos_encomenda'];
                $_SESSION['dados_encomenda'] = $detalhes_encomenda_cliente['dados_encomenda'];
                $_SESSION['total_encomenda_detalhe'] = $total;
            }
        }
    }
    //===========================================================
    // PRODUTOS 
    //===========================================================
    public function AdicionarProduct()
    {
        if (!Store::Adminlogado()) {
            $this->login();
            return;
        }

        Store::Layout_admin([
            "Admin/layouts/html_header",
            "Admin/layouts/header",
            "Admin/AddProduct",
            "Admin/layouts/footer",
            "Admin/layouts/html_footer",
        ]);
    }

    public function AdicionarProductSubmit()
    {
        if (!Store::Adminlogado()) {
            $this->login();
            return;
        }
        $admin = new Admins();
        $produto = [
            "nome" => $_POST['product_nome'],
            "precoVenda" => $_POST['product_precoVenda'],
            "precoCusto" => $_POST['product_precoCusto'],
            "desconto" => $_POST['product_desconto'],
            "quantidade" => $_POST['product_quantidade'],
            "categoria" => $_POST['TipoProduct'],
            'descricao' => "Teste"
        ];

        $imagem = $_FILES['foto'];

        $admin->AdicionarProduct($produto, $imagem);
    }

    public function ListarProduct()
    {

        if (!Store::Adminlogado()) {
            $this->login();
            return;
        }

        $admin = new Admins();
        $buscar_produtos = $admin->Buscar_Lista_produtos();

        $dados = [
            "produtos" => $buscar_produtos
        ];

        Store::Layout_admin([
            "Admin/layouts/html_header",
            "Admin/layouts/header",
            "Admin/ListarProduct",
            "Admin/layouts/footer",
            "Admin/layouts/html_footer",
        ], $dados);
    }

    public function informacoes_produtos_alteracao()
    {
        $valor = json_decode(file_get_contents('php://input'), true);
        $admin = new Admins();
        $produtos_alteracao = $admin->informacoes_produtos_alteracao($valor['id_produto']);

        $dados = [
            "produtos_alteracao" => $produtos_alteracao
        ];

        Store::Layout_admin([
            "Admin/ListaProductDetalhe"
        ], $dados);
    }

    public function Editar_informacao_produto()
    {

        $valor = json_decode(file_get_contents('php://input'), true);

        $dados = [
            "id_produto" => $valor['id'],
            "nome_produto" => $valor['nome'],
            "categoria" => $valor['categoria'],
            "visivel" => $valor['visibilidade'],
            "quantidade" => $valor['quantidade'],
            "precoCusto" => $valor['precoCusto'],
            "precoVenda" => $valor['precoVenda'],
        ];

        $admin = new Admins();
        $produtos_alteracao = $admin->Editar_informacao_produto($dados);
    }
}
