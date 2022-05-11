
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueci a senha!!</title>
</head>
<body>
    <?php  
    if(isset($_POST['recuperar'])){
        $email = $_POST['email'];
        
        $pdo = MySql::connect();
        $verficar = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $verficar->execute(array($email));
        if($verficar->rowCount() == 1){
            $dados = $verficar->fetch();
            $_SESSION['nome'] = $dados['nome'];
            $_SESSION['email'] = $email;

            header('location: recupera');
    }else{
        echo 'Não existe nenhum usuario com esse email';
    }
    ?>
      
<?
    }else{

    ?>

    

    <?php } ?><form method="post">
        <h2>Mande o seu email</h2>
        <input  type="email" name="email" placeholder="Insirar o seu email!!">
        <input type="submit" name="recuperar" value="Pegar">
    </form>
</body>
</html>