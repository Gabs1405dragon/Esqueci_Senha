<h2>Documentação do projeto!!</h2>

<p>O objetivo desse projeto é para o usuário poder fazer a recuperação da senha dele caso ele esqueça.</p>
<h3>Vamos começar fazendo o banco de dados</h3>
<ol>
  <li>Criar o banco de dados.</li>
  <li>Criar uma tabela para poder cadastrar o usuário.</li>
  <li>Irá ter pelo menos 4 campos na tabela os nomes de cada uma delas irá ser <b>(id,nome,email,senha)</b></li>
</ol>
<h3>Próximo passo agora é criar um formulário para cadastrar os dados.</h3>
<p>O formulário precisa ter os mesmos campos da tabela para cadastrar todos os dados corretamente. O unico campo que não vai ser necessário criar é o <b>"Id"</b> porque ele já
é incrementado automáticamente toda vez que é acrescentado um dado novo na tabela.</p>
<p>Agora para recuperar os dados do formulário primeiro terá que altera o método do formulário para ser o metodo "Post" para ser mais seguro a recuperação de dados.</p>
<p>Agora a função necessária para verificar se nós clicamos no submit do formulário é o <a href="https://www.php.net/manual/en/function.isset.php">isset()</a> uma função nativa do <b>PHP</b>,
e para recuperar todos os valores inseridos no formulário vai ser uma <b>superglobal</b> <a href="https://www.php.net/manual/en/reserved.variables.post.php">$_POST[]</a>, dentro vai ser colocado o valor do atributo <a href="https://www.w3schools.com/tags/att_name.asp">name</a> do input
para a assim podê recuperar os valores do formulário.</p>
<h4>Agora fazer todas as verificações necessárias para cadastrar os dados.</h4>
<ol>
  <li>Fazer uma condição com o <a href="https://www.php.net/manual/en/control-structures.if.php">if()</a> e a função <a href="https://www.php.net/manual/en/function.empty.php">empty()</a> Para verificar se os campos estão vázios ,vai aparecer uma mensagem de erro e não vai poder seguir para 
  a próxima verificação, caso ao contrário irá passa para a próxima verificação.</li>
  <li>Verificar se o email é valído com a função <a href="https://www.php.net/manual/en/function.filter-var.php">filter_var()</a> pasando como parâmetro o valor do campo email e em seguinda 
  colocar "FILTER_VALIDATE_EMAIL" como segundo parâmentro.</li>
  <li>Verificar se a senha é maior ou igual a 6 usando a função <a href="https://www.php.net/manual/en/function.strlen.php">strlen()</a> e o valor da senha como parâmetro.</li>
  <li>Verificar se a senha é igual ao campo confimar senha e depois criptografar a senha com a função <a href="https://www.php.net/manual/en/function.base64-encode.php">base64_encode()</a>.</li>
  <li>Inserir todos os dados na tabela com o <a href="https://www.w3schools.com/sql/sql_insert.asp">INSERT</a>.</li>
</ol>

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
            
   <h3>Agora fazer mais uma tela para entrar na tela privada.</h3>
   <p>Fazer mais um formulário só que dessa vez só com os campos (email,senha) e o botão para enviar os valores do campo que no caso é o <a href="">Submit</a>.</p>
   <p>Criando tudo isso e fazendo todas a verificações necessárias. agora é só verificar se já existe o email e a senha do usuário cadastrados na tabela.</p>
   <p>Para isso é só buscar a tabela dos usuários com <a href="https://www.w3schools.com/sql/sql_select.asp">SELECT</a> onde o email e senha são os valores do dados inseridos no formulários .</p>
   <p>Caso já exista os valores inseridos no banco é só fazer um redirect na tela privada que vai entrar com sucesso!! caso ao contrario vai aparece um erro e não vai entrar na tela privada.</p>
   
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
              
<h3>Agora vamos para a parte principal do projeto que é se o usuário esqueceu a senha!</h3> 

<p>Se caso o usuário esqueça a senha nós vamos colocar um link com a tag <b>a</b> do html para redirecionar o usuário para uma tela especificar para ele recuperar a senha.</p>
<p>Primeiro criar um campo para inserir o email do usuário para verificar se existe o email cadastrado na tabela. Se o email existir vai criar três sessões com o valor do <b>(id ,email e nome)</b> na tabela
  que tem o email que foi inserido no campo email! o usuário 
vai ser redirecionado para uma nova tela que nessa tela só pode ser acessada enquanto essas três sessões existir.</p>
<p>E nessa tela irá ter o campo da senha para ser modificada.</p>
<p>Depois que fazer todas as verificações é só fazer o <b>INSERT</b> e os valores será a sessão do <b>(id,nome e o email)</b> e na senha vai ser a senha inserida no campo da senha.</p>
<p>Com isso a sessão vai ser destruida com função <a href="https://www.php.net/manual/en/function.session-destroy.php">session_destroy</a> e depois voltar para a página de login!!</p>

      if(isset($_POST['criar'])){
          $senha = $_POST['senha'];
          $confsenha = $_POST['confSenha'];
          if(empty($senha)){
              echo '<script>alert("Preencha o campo da senha!!");</script>';
          }else{
              if(strlen($senha) >= 6){
                  if($senha == $confsenha){
                      $pdo = \MySql::connect();
                      $insert = $pdo->prepare("INSERT INTO usuarios (id,nome,email,senha) VALUES ($_SESSION[id],?,?,?)");
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
      
<h3>Com isso terminamos a documentação <b style="color:red" >Muito Obrigado</b> por ter lido até aqui :)</h3>      


<p>Minhas redes socias</p>
<ul>
  <li><a href="https://www.instagram.com/gabs1405henrique/">Instagram</a></li>
  <li><a href="https://github.com/Gabs1405dragon">GitHub</a></li>
  <li><a href="https://www.linkedin.com/in/gabriel-h-assis-de-souza-60b496207/">Linkedin</a></li>
</ul>
