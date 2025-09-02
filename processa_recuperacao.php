<?php
require 'conexao.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);

    $sql = "SELECT id, nome FROM usuarios WHERE email = '$email' LIMIT 1";
    $res = $conn->query($sql);

    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $idUsuario = $row['id'];
        $nome = $row['nome'];

        $novasenha = substr(md5(uniqid(rand(), true)), 0, 8);

        $sqlUpdate = "UPDATE usuarios SET senha = '$novasenha' WHERE id = $idUsuario";

        if ($conn->query($sqlUpdate)) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'exemplo@gmail.com';
                $mail->Password = '';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('exemplo@gmail.com', 'Suporte - Sistema');
                $mail->addAddress($email, $nome);

                $mail->isHTML(true);
                $mail->Subject = 'Senha Nova';
                $mail->Body = "Olá $nome, sua nova senha é: <b>$novasenha</b>";
                $mail->AltBody = "Olá $nome, sua nova senha é: $novasenha";

                $mail->send();
                echo "Uma nova senha foi enviada para seu email.";
            } catch (Exception $e) {
                echo "Erro ao enviar email: {$mail->ErrorInfo}";
            }
        } else {
            echo "Erro ao atualizar a senha no banco.";
        }
    } else {
        echo "Email não cadastrado.";
    }
}
?>