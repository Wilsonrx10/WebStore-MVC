<?php 

namespace core\classes;

use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\SMTP;

use PHPMailer\PHPMailer\Exception;

Class EnviarEmail {

    public function enviar_email_confirmacao_novo_cliente($email_cliente, $purl) {

        // criar o link para enviar para o Cliente 
        $link = BASE_URL."/?loja=confirmar_email&purl=".$purl;

        $mail = new PHPMailer(true);
        
        try {
            //Server settings
            $mail->SMTPDebug = false;
            $mail->isSMTP();
            $mail->CharSet = "UTF-8";
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_USER;
            $mail->Password   = EMAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = EMAIL_PORT;                                   
        
            // Destinatário
            $mail->setFrom('gordolinosamukai@gmail.com', 'Loja Online');
            $mail->addAddress($email_cliente);
        
            //Content
            $mail->isHTML(true);                                  
            $mail->Subject = APP_NAME. 'Confirmação de Email';
            // Mensagem 
            $html = '<p>Seja Bem-Vindo a nossa' .APP_NAME. '</p>';
            $html.= "<p>Para entrar na nossa loja é necessário confirmar o seu Email </p>";
            $html.= "<p>Para confirmar o email click no link a baixo </p>";
            $html.= '<p><a href="'.$link.'">Confirmar email</a></p>';

            $mail->Body  = $html;
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }

    }
    //===========================================================================
    public function enviar_email_confirmacao_encomenda($email_cliente, $dados_encomenda) {

        $mail = new PHPMailer(true);
        
        try {
            //Server settings
            $mail->SMTPDebug = false;
            $mail->isSMTP();
            $mail->CharSet = "UTF-8";
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_USER;
            $mail->Password   = EMAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = EMAIL_PORT;                                   
        
            // Destinatário
            $mail->setFrom('gordolinosamukai@gmail.com', 'Loja Online');
            $mail->addAddress($email_cliente);
        
            //Content
            $mail->isHTML(true);                                  
            $mail->Subject = APP_NAME. ' Confirmação de Encomenda '. $dados_encomenda['dados_pagamento']
            ['codigo_encomenda'];

           // Mensagem  Inicial 

           $html = "<p>Este email serve para confirmar a sua encomenda</p>";
           $html .= "<p>Dados da Encomenda</p>";
           // lista dos produtos 
           
           $html .= "<ul>";
           foreach ($dados_encomenda['produtos_encomenda'] as $produto) {
                $html .= "$produto"."<br>";
           }
           $html .= "</ul>";
           // total da encomenda

           $html .= '<p>Total: <strong>' .$dados_encomenda['total'].'</strong></p>';
           // Dados do pagamento 

           $html .= "<p>DADOS DO PAGAMENTO:</p>";
           $html .= '<p>Número da conta: <strong>'.$dados_encomenda['dados_pagamento']['codigo_encomenda'].'</strong></p>';
           $html .= '<p>Valor a pagar: <strong>'.$dados_encomenda['dados_pagamento']['total'].'</strong></p>';

           // Nota importante 

           $html .= "<p>Nota: Seu pagamento só será processado após o processamento do pagamento";

           $mail->Body  = $html;

           $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }

    }
}
