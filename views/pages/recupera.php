
<form method="post">
      <?php  
       if(isset($_POST['criar'])){
        $senha = $_POST['senha'];
        $confsenha = $_POST['confSenha'];
        if(empty($senha)){
            echo '<script>alert("Preencha o campo da senha!!");</script>';
        }else{
            if(strlen($senha) >= 6){
                if($senha == $confsenha){
                    $pdo = \MySql::connect();
                    $insert = $pdo->prepare("INSERT INTO usuarios (id,nome,email,senha) VALUES (null,?,?,?)");
                    $insert->execute(array($_SESSION['nome'],$_SESSION['email'],base64_encode($senha)));
                    session_destroy();
                    echo '<script>alert("Senha alterada com sucesso!");location.href="home";</script>';
                    
                }else{
                    echo '<script>alert("A sua senha tem que ser a mesma.")</script>';   
                }
            }else{
                echo '<script>alert("A sua é muito curta.")</script>';
            }
        }
    }
      ?>
<h2>Crie uma nova senha!!</h2>
    <input  type="password" name="senha" placeholder="Crie a sua nova senha">
    <input  type="password" name="confSenha" placeholder="Confirma senha!!">
    <input type="submit" value="Criar" name="criar">
</form>