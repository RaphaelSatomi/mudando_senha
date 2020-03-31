<?php
    require 'config.php';        
    if(isset($_POST['email']) && !empty($_POST['email'])){
        $email = addslashes($_POST['email']);

        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(":email", $email);
        $sql->execute();

        if($sql->rowCount() > 0){
            $sql = $sql->fetch();
            $id = $sql['id'];

            $token = md5(time().rand(0, 99999).rand(0, 99999));

            $sql = "INSERT INTO token_usuarios (id_usuario, hash, expirado_em) VALUES (:id_usuario, :hash, :expirado_em)";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(":id_usuario", $id);
            $sql->bindValue(":hash", $token);
            $sql->bindValue(":expirado_em", date('Y-m-d H:i', strtotime('+2 months')));
            $sql->execute();

            $link = "http://localhost/projeto_esquecisenha/redefinir.php?token=".$token;

            $msg = "Clique no link para redefinir sua senha:</br>".$link;

            $assunto = "Redefinição de senha";

            $headers = 'From: zuhzamv@gmail.com'."\r\n".
                        'X-Mailer: PHP/'.phpversion();
            //mail($email, $assunto, $mensagem, $headers);
            echo $msg;
            exit;
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
    </head>
    <body>
        <form method="POST">
            Digite seu e-mail:<br/>
            <input type="email" name="email"/><br/>
            
            <input type="submit" value="Enviar"/>
        </form>
    </body>
</html>


