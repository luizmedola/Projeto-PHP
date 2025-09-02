<?php 

$host = "localhost";
$user = "root";
$pass = "";
$db = "sistema";
$conn = new mysqli(hostname: $host, username: $user, password: $pass, database: $db);

if($conn->connect_error){
    die("Conexão falhou: " . $conn->connect_error);
}

else{
     echo "Conexão realizada com sucesso!";
}

?>