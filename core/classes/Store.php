<?php 

namespace core\classes;

use Exception;

Class Store {
   
    public static function Layout($estruturas, $dados = null) {

         // Verifica se a estrutura é um Array 
         if (!is_array($estruturas)) {
             throw new Exception("Coleção de estruturas inválida");
         }

         // Variáveis  
         if (!empty($dados) && is_array($dados)) {
             extract($dados);
         }
         // Apresentar os Views da aplicação 

         foreach ($estruturas as $estrutura) {
             include_once("../core/views/$estrutura.php");
         }

    }

    public static function Layout_admin($estruturas, $dados = null) {

        // Verifica se a estrutura é um Array 
        if (!is_array($estruturas)) {
            throw new Exception("Coleção de estruturas inválida");
        }

        // Variáveis  
        if (!empty($dados) && is_array($dados)) {
            extract($dados);
        }
        // Apresentar os Views da aplicação 

        foreach ($estruturas as $estrutura) {
            include_once("../../core/views/$estrutura.php");
        }

   }
    //=============================================================
    public static function clienteLogado() {
        // verifica se existe uma sessão 
        return isset($_SESSION['cliente']);
    }
    //=============================================================
    public static function Adminlogado() {
        // verifica se existe uma sessão 
        return isset($_SESSION['admin']);
    }

    //=============================================================
    public static function CriarHash($caracteres = 12) {
      $chars = "0123456789abcdefghijkmlnopqrstuvwyxzabcdefghijkmlnopqrstuvwyxzABCDEFGHIJKMLNOPQRSTUVWYXZABCDEFGHIJKMLNOPQRSTUVWYXZ";
      return substr(str_shuffle($chars) ,0, $caracteres);
    }
    //==============================================================
    public static function redirect($rota = "inicio", $admin = false) {
        if (!$admin) {
        // Faz o Redirecimento para a URL desejada 
        header("location: ".BASE_URL. "?loja=$rota");
        }else {
        header("location: ".BASE_URL. "/admin/?loja=$rota");
        }
    }
    //==============================================================
    public static function Debug($resultado) {
       if (is_array($resultado) || is_object($resultado)) {
        echo "<pre>";
        print_r($resultado);
       } else {
         echo "<pre>";
         echo $resultado;
       }
       die();
    }
    //==============================================================
    public static function gerarCodigoEncomenda() {
       $codigo  = "";
       $chars = "ABCDEFGHIJKMLNOPQRSTUVWYXZABCDEFGHIJKMLNOPQRSTUVWYXZABCDEFGHIJKMLNOPQRSTUVWYXZ";
       $codigo .= substr(str_shuffle($chars) , 0, 2);
       $codigo .= rand(100000, 999999);
       return $codigo;
    }
    //==============================================================
    public static function aesEncriptar($valor) {
      return bin2hex(openssl_encrypt($valor, 'aes-256-cbc', AES_KEY, OPENSSL_RAW_DATA,AES_IV));
    }

    //==============================================================
    public static function aesDescriptar($valor) {
        return openssl_decrypt(hex2bin($valor), 'aes-256-cbc', AES_KEY, OPENSSL_RAW_DATA,AES_IV);
    }

}

?>