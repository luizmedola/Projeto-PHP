<?php 
include "../criptografia/conexao.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome = $conn->real_escape_string($_POST["nome"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $senha = $conn->real_escape_string($_POST["senha"]);

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senhaHash')";

    if($conn->query($sql) === TRUE){
        echo "Usuário cadastrado com sucesso!";
    } else{
        echo "Erro ao cadastrar usuário: " . $conn->error;
    }

    $conn->close();
}

?>