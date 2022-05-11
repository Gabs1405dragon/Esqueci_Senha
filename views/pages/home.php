
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Gabriel.H assis de souza" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
</head>
<body>
    <?php  
    if(isset($_POST['entrar'])){
        $email = $_POST['email'];
        $senha = $_POST['password'];
        if(empty($email) || empty($senha)){
            echo '<script>alert("Preenchar o campo email e senha.")</script>';
        }else{
            if(filter_var($email)){
                $pdo = MySql::connect();
                $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? AND senha = ?");
                
                $sql->execute(array($email,base64_encode($senha)));
                if($sql->rowCount() == 1){
                    
                    $sql = $sql->fetch();
                    echo '<h2>'.$sql['nome'].'</h2>';
                }else{
                    echo '<script>alert("senha ou email incorretos...")</script>';
                }
            }else{
                echo '<script>alert("Email inválido.")</script>';
            }
        }
    }
    ?>
    <h2>Entrar</h2>
    <form method="post">
        <input value="<?php pegarPost('email'); ?>" type="email" name="email" placeholder="exemple@gmail.com">
        <input type="password" name="password" placeholder="sua senha...">
        <input type="submit" value="Entrar" name="entrar">
    </form>
    <p>Esqueceu a sua senha ?? clique nesse <a href="esqueci">Link</a> para criar uma nova senha!!!</p>
    <hr/>
    <h2>Cadastrar</h2>
    <form method="post">
        <input type="text" value="<?php pegarPost('nome'); ?>" name="nome" placeholder="Seu nome!!" >
        <input type="email" value="<?php pegarPost('email'); ?>" name="email" placeholder="Seu Email!!">
        <input type="password" name="password" placeholder="sua senha...">
        <input required type="password" name="confSenha" placeholder="Confirma senha!!">
        <input type="submit" value="Cadastrar" name="cadastrar">
    </form>
    <hr/>
    <?php  
    if(isset($_POST['cadastrar'])){
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
                        $insert = $pdo->prepare("INSERT INTO usuarios (id,nome,email,senha) VALUES (null,?,?,?)");
                        $insert->execute(array($nome,$email,$senha));
                        echo '<script>alert("cadastrado com sucesso!!");location.href="home"</script>';
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

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>email</th>
                <th>Delete</th>
                <th>Editar</th>
            </tr>
        </thead>
        <tbody>
            
                <?php  
                if(isset($_GET['delete'])){
                    $id = $_GET['delete'];
                    $delete = \MySql::connect()->prepare("DELETE FROM usuarios WHERE id = $id");
                    $delete->execute();
                    echo '<script>location.href="home"</script>';
                }
                $usuario = \MySql::connect()->prepare("SELECT * FROM usuarios ");
                $usuario->execute();
                $usuarios = $usuario->fetchAll();
                foreach($usuarios as $usuario){
                ?>
            <tr>
                <td><?= $usuario['nome']?></td>
                <td><?= $usuario['email']?></td>
                <td><a href="home?delete=<?= $usuario['id']; ?>">Apagar</a></td>
                <td><a href="edit?edit=<?= $usuario['id']; ?>">Atualizar</a></td>
            </tr>    
                <?php } ?>
           
        </tbody>
    </table>
</body>
</html>