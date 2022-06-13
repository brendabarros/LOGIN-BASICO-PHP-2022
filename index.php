<?php
session_start();
ob_start();
include_once 'conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
    <script src="js/ie-emulation-modes-warning.js"></script>
    <!--ICONE DA EMPRESA-->
    <link rel="shortcut icon" href="images/wlan_logo.ico" type="image/x-ico">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estoque - Login</title>
</head>

<body>
    <?php
    //Exemplo criptografar a senha
    //echo password_hash(mudar123, PASSWORD_DEFAULT);
    //Usuário: brendamdrbarros@gmail.com
    //Senha: 123654
    ?>
  <div class="container"class="mx-auto" style="width: 400px;"
  align="center" valign="middle" width="44%" class="scFormToolbarPadding">
    
    <h2 class="text-center">Login Estoque</h2><br><br>
    
       <?php
       $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

     if (!empty($dados['SendLogin'])) {
       // var_dump($dados);
        $query_usuario = "SELECT id, nome, usuario, senha_usuario 
                        FROM usuarios 
                        WHERE usuario =:usuario  
                        LIMIT 1";
        $result_usuario = $conn->prepare($query_usuario);
        $result_usuario->bindParam(':usuario', $dados['usuario'], PDO::PARAM_STR);
        $result_usuario->execute();


        if(($result_usuario) AND ($result_usuario->rowCount() != 0)){
            $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
            //var_dump($row_usuario);
            if(password_verify($dados['senha_usuario'], $row_usuario['senha_usuario'])){
            
                $_SESSION['id'] = $row_usuario['id'];
                $_SESSION['nome'] = $row_usuario['nome'];
                header("Location: dashboard.php");
            }else{
                $_SESSION['msg'] = "<p style='color: #ff0000'>Erro: Usuário ou senha inválida!</p>";
            }
        }else{
            $_SESSION['msg'] = "<p style='color: #ff0000'>Erro: Usuário ou senha inválida!</p>";
        }

         
      }
       if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
      }
      ?>
      
      
        <form method="POST" action="">
        
         <label for="inputEmail" class="sr-only">Usuário:</label>
         <input type="text" name="usuario"class="form-control" placeholder="Digite o seu email" value="<?php if(isset($dados['usuario'])){ echo $dados['usuario']; } ?>"required autofocus><br><br>
        
         <label for="inputPassword" class="sr-only">Senha:</label>
         <input type="password" name="senha_usuario" class="form-control" placeholder="Digite a senha" value="<?php if(isset($dados['senha_usuario'])){ echo $dados['senha_usuario']; } ?>"required><br><br>

         <input align="center" class="btn btn-success" type="submit" value="Acessar" name="SendLogin">
       </form>

       
 </div>
</body>

</html>