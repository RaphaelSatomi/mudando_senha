<?php
    require 'config.php';

    if(!empty($_GET['token'])){
        $token = $_GET['token'];

        $sql = "SELECT * FROM token_usuarios WHERE hash = :hash AND used = 0 AND expirado_em > NOW()";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(":hash", $token);
        $sql->execute();

        if($sql->rowCount() > 0){
            $sql = $sql->fetch();
            $id = $sql['id_usuario'];
            if(!empty($_POST['senha'])){
                $senha = $_POST['senha'];
                $sql = "UPDATE usuarios SET senha = :senha WHERE id = : id";
                $sql = $pdo->prepare($sql);
                $sql->bindValue(":senha", md5($senha));
                $sql->bindValue(":id", $id);
                $sql->execute();

                $sql = "UPDATE token_usuarios SET used = 1 WHERE hash = :hash";
                $sql = $pdo->prepare($sql);
                $sql->bindValue(":hash", $token);
                $sql->execute();

                echo "Senha alterada com sucesso";
                exit; 
            }
            ?>                
                <form method="POST">
                    Digite a nova senha:<br/>
                    <input type="password" name="senha"/><br/>
                    <input type="submit" value="Alterar"/>
                </form>
            <?php
        }else{
            echo "Token inválido ou usado!";
            exit;
        }
    }
?>