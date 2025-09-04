<?php 
include "../criptografia/conexao.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $conn -> real_escape_string($_POST["email"]);
    $senha = $conn -> real_escape_string($_POST["senha"]);

    $sql = "SELECT id, email, senha FROM usuarios WHERE email = '$email' LIMIT 1";
    $result = $conn -> query($sql);

    if($result -> num_rows > 0){
        $user = $result -> fetch_assoc();
        if(password_verify($senha, $user["senha"])){
            echo "Login bem-sucedido! Bem-vindo, " . $user["email"];
        } else{
            echo "Senha incorreta.";
        }
    } else{
        echo "Usuário não encontrado.";
    }
    


    
}


?>