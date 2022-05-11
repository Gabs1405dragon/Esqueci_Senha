<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar o usuário <?= $dados['nome']?></title>
</head>
<body>

<?php  
    if(isset($_POST['atualizar'])){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['password'];
        $confsenha = $_POST['confSenha'];
        if(empty($email) || empty($senha) || empty($nome)){
            echo '<script>alert("Preenchar o campo email e senha.")</script>';
        }else{
            if(filter_var($email)){
                if(strlen($senha) >= 6){
                    if($senha == $confsenha){
                        
                        $senha = base64_encode($senha);
                        $pdo = MySql::connect();
                        $delete = $pdo->prepare("UPDATE usuarios SET nome = ? , email = ? , senha = ? WHERE id = $dados[id] ");
                        
                        $delete->execute(array($nome,$email,$senha));
                        echo '<script>alert("Atualizado com sucesso!!");location.href="home"</script>';
                    }else{
                        echo '<script>alert("A sua senha tem que ser a mesma.")</script>';   
                    }
                }else{
                    echo '<script>alert("A sua é muito curta.")</script>';
                }
            }else{
                echo '<script>alert("Email inválido.")</script>';
            }
        }
    }
    ?>

<h2>Fazer Alterar</h2>
    <form method="post">
        <input type="text" value="<?= $dados['nome'] ?>" name="nome" placeholder="Seu nome!!" >
        <input type="email" value="<?= $dados['email'] ?>" name="email" placeholder="Seu Email!!">
        <input type="password"   name="password" placeholder="sua senha...">
        <input required type="password" name="confSenha" placeholder="Confirma senha!!">
        <input type="submit" value="Atualizar" name="atualizar">
    </form>
    
</body>
</html>