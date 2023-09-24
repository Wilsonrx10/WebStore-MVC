<?php

namespace core\controller;

use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Clientes;
use core\models\Encomendas;
use core\models\Produtos;

class Main
{


    //=====================================================
    public function Loja()
    {

        $produtos = new Produtos();
        $categoria = "todos";
        if (isset($_GET['c'])) {
            $categoria = $_GET['c'];
        }
        $lista_produtos = $produtos->lista_produtos_disponivel($categoria);

        $dados = [
            "produtos" => $lista_produtos
        ];


        Store::Layout([
            "layouts/html_header",
            "layouts/header",
            "loja",
            "layouts/footer",
            "layouts/html_footer",
        ], $dados);
    }

    //=====================================================
    public function novo_cliente()
    {
        if (Store::clienteLogado()) {
            $this->Loja();
            return;
        }
        Store::Layout([
            "layouts/html_header",
            "layouts/header",
            "criar_cliente",
            "layouts/footer",
            "layouts/html_footer",
        ]);
    }
    //=====================================================
    public function criar_cliente()
    {
        if (Store::clienteLogado()) {
            $this->Loja();
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->Loja();
            return;
        }

        if ($_POST['text_senha_1'] !== $_POST['text_senha_2']) {
            $_SESSION['erro'] = "As senhas não são iguais";
            $this->novo_cliente();
            return;
        }

        $clientes = new Clientes();
        if ($clientes->verificar_email_existe($_POST['text_email'])) {
            $_SESSION['erro'] = "Já existe um usuario cadastrado com esse Email";
            $this->novo_cliente();
            return;
        }

        $purl = $clientes->Criar_Cliente();

        $email = new EnviarEmail();
        $email_cliente = trim(strtolower($_POST['text_email']));
        $resultado = $email->enviar_email_confirmacao_novo_cliente($email_cliente, $purl);
        if ($resultado) {
            Store::Layout([
                "layouts/html_header",
                "layouts/header",
                "mensagem_cliente_sucesso",
                "layouts/footer",
                "layouts/html_footer",
            ]);
        } else {
            $_SESSION['erro'] = "Ocorreu um erro , Tenta novamante mais tarde";
            $this->novo_cliente();
            return;
        }
    }

    //=====================================================
    public function confirmar_email()
    {
        if (Store::clienteLogado()) {
            $this->Loja();
            return;
        }

        if (!isset($_GET['purl'])) {
            $this->Loja();
            return;
        }

        if (strlen($_GET['purl']) != 12) {
            $this->Loja();
            return;
        }

        $purl = $_GET['purl'];

        $cliente = new Clientes();
        $resultado = $cliente->validar_email($purl);

        if ($resultado) {
            Store::Layout([
                "layouts/html_header",
                "layouts/header",
                "mensagem_conta_sucesso",
                "layouts/footer",
                "layouts/html_footer",
            ]);
        } else {
            Store::redirect();
        }
    }

    //=====================================================

    public function login()
    {

        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }
        Store::Layout([
            "layouts/html_header",
            "layouts/header",
            "login",
            "layouts/footer",
            "layouts/html_footer",
        ]);
    }
    //=====================================================
    public function login_submit()
    {
        if ($_SERVER['REQUEST_METHOD'] != "POST") {
            Store::redirect();
            return;
        }
        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        if (
            !isset($_POST['text_usuario']) || !isset($_POST['text_senha']) ||
            !filter_var(trim($_POST['text_usuario']), FILTER_VALIDATE_EMAIL)
        ) {
            $_SESSION['erro'] = "Login inválido";
            Store::redirect('login');
            return;
        }

        // Preparar os dados para o MODEL 
        $usuario = trim(strtolower($_POST['text_usuario']));
        $senha = trim($_POST['text_senha']);
        $cliente = new Clientes();
        $resultado = $cliente->validar_login($usuario, $senha);

        if (is_bool($resultado)) {
            $_SESSION['erro'] = "login inválido";
            Store::redirect('login');
            return;
        } else {

            $_SESSION['cliente'] = $resultado->id_cliente;
            $_SESSION['usuario'] = $resultado->email;
            $_SESSION['nome_cliente'] = $resultado->nome_completo;
            if (isset($_SESSION['tmp_carrinho'])) {
                unset($_SESSION['tmp_carrinho']);
                Store::redirect("carrinho");
            } else {
                Store::redirect();
            }
        }
    }

    public function logout()
    {
        unset($_SESSION['cliente']);
        unset($_SESSION['usuario']);
        unset($_SESSION['nome_cliente']);
        Store::redirect();
    }

    public function perfil()
    {

        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        $cliente = new Clientes();
        $dados_cliente =  $cliente->buscar_dados_cliente($_SESSION['cliente']);

        $dados = [
            'dados_cliente' => $dados_cliente
        ];

        Store::Layout([
            "layouts/html_header",
            "layouts/header",
            "perfil",
            "layouts/footer",
            "layouts/html_footer",
        ], $dados);
    }

    //=====================================================
    public function alterar_dados_perfil()
    {
        if ($_SERVER['REQUEST_METHOD'] != "POST") {
            Store::redirect();
            return;
        }
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }
        if (isset($_GET['acao'])  && $_GET['acao'] == "alterar_dados") {
            $dados_recebidos = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $dados_st = array_map('strip_tags', $dados_recebidos);
            $dados = array_map('trim', $dados_st);

            if (in_array("", $dados)) {
                $_SESSION['erro'] = "Por favor preencha todos os campos";
                $this->perfil();
                return false;
            }

            $email = trim(strtolower($dados['email']));
            $nome_completo = trim($dados['nome']);
            $morada = trim($dados['morada']);
            $cidade = trim($dados['cidade']);
            $telefone = trim($dados['telefone']);

            $dados_atualizar = [
                "email" => $email,
                "nome_completo" => $nome_completo,
                "morada" => $morada,
                "cidade" => $cidade,
                "telefone" => $telefone
            ];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['erro'] = "Email inválido , por favor coloque um email correcto";
                $this->perfil();
                return false;
            }

            $cliente = new Clientes();
            $email = $cliente->verificar_email_existe($_POST['email']);
            if ($email == true) {
                $_SESSION['erro'] = "Este endereço email já está sendo usado";
                $this->perfil();
                return false;
            }

            $cliente = new Clientes();
            $atualizar = $cliente->atualizar_dados_usuario($dados_atualizar);

            if ($atualizar == true) {
                $_SESSION['usuario'] = $dados_atualizar['email'];
                $_SESSION['nome_cliente'] = $dados_atualizar['nome_completo'];
                $_SESSION['sucesso'] = "Dados atualizado com Sucesso";
                $this->perfil();
            }
        } else if (isset($_GET['acao']) && $_GET['acao'] == "alterar_senha") {

            $senha_atual = trim(strtolower($_POST['senha_atual']));
            $nova_senha = trim($_POST['nova_senha']);
            $nova_senha_repete = trim($_POST['nova_senha_repete']);

            if (strlen($nova_senha) < 4) {
                $_SESSION['erro'] = "A nova senha deve conter no minimo 4 caracteres";
                $this->perfil();
                return false;
            }

            if ($nova_senha != $nova_senha_repete) {
                $_SESSION['erro'] = "As senhas digitadas não coincidem";
                $this->perfil();
                return false;
            }

            if ($nova_senha == $senha_atual) {
                $_SESSION['erro'] = "A nova senha não pode ser igual com a senha Atual";
                $this->perfil();
                return false;
            }

            $cliente = new Clientes();
            $verificar_senha_atual = $cliente->verificar_senha_atual($_SESSION['cliente'], $senha_atual);
            if (!$verificar_senha_atual) {
                $_SESSION['erro'] = "A Senha Atual é diferente";
                $this->perfil();
                return false;
            }

            $atualizar_senha  = $cliente->Atualizar_senha_cliente($_SESSION['cliente'], $nova_senha);
            if ($atualizar_senha == true) {
                $_SESSION['sucesso'] = "Sua senha foi alterada com Sucesso";
                $this->perfil();
            }
        }
    }


    public function historico_encomendas()
    {

        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        $encomedas = new Encomendas();

        $historico_encomenda = $encomedas->buscar_historico_encomendas($_SESSION['cliente']);

        $dados = [
            'historico_encomenda' => $historico_encomenda
        ];

        Store::Layout([
            "layouts/html_header",
            "layouts/header",
            "historico_encomendas",
            "layouts/footer",
            "layouts/html_footer",
        ], $dados);
    }

    //=========================================================
    public function detalhes_encomenda()
    {

        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        if (!isset($_GET['id'])) {
            Store::redirect();
            return;
        }
        $id_encomenda = null;
        if (strlen($_GET['id']) != 32) {
            Store::redirect();
            return;
        } else {
            $id_encomenda = Store::aesDescriptar($_GET['id']);

            if (empty($id_encomenda)) {
                Store::redirect();
                return;
            }
        }

        $encomedas = new Encomendas();
        $resultado =  $encomedas->verificar_encomenda_cliente($_SESSION['cliente'], $id_encomenda);
        if (!$resultado) {
            Store::redirect();
            return;
        }

        $encomedas = new Encomendas();
        $detalhes_encomenda = $encomedas->detalhes_encomenda($_SESSION['cliente'], $id_encomenda);

        $total = 0;
        foreach ($detalhes_encomenda['produtos_encomenda'] as $produto) {
            $total += ($produto->quantidade * $produto->preco_unidade);
        }

        $dados = [
            "dados_encomenda" => $detalhes_encomenda['dados_encomenda'],
            "produtos_encomenda" => $detalhes_encomenda['produtos_encomenda'],
            "total_encomenda" => $total
        ];
        Store::Layout([
            "layouts/html_header",
            "layouts/header",
            "detalhes_encomenda",
            "layouts/footer",
            "layouts/html_footer",
        ], $dados);
    }
}
