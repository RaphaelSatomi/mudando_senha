<?php
    try{
        $pdo = new PDO("mysql:dbname=projeto_esquecisenha;host=localhost", "root", "");
    }catch(PDOException $e){
        echo "ERRO: ".$e->getMessage();
        exit;
    }    

    //require 'config.php';

?>
    <a href="esqueci.php">Esqueci minha senha</a>