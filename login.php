<?php
require_once('config.php');
if(isset($_GET['erro'])){
    $erro = '<div class="erroMessage">É preciso logar para acessar o sistema!</div>';
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    // echo($email);
    // echo("<br>");
    // echo($senha);
    $newconexao = novaConexao();
    // echo($senha);
    $verificaExistencia = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $newconexao->prepare($verificaExistencia);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch();
    //var_dump($user);
    if($user){
        if(password_verify($senha,$user['senha'])){
            session_start();
            $_SESSION['usuario'] = $email; 
            header('Location: clientes.php');
            
        }else{
            echo("<script>alert('Email ou Senha inválido!')</script>");
        }   
    }else{
        echo("<script>alert('Email ou Senha inválido!')</script>");
    }
    
    // if ($resultado) {
    //     print_($resultado['senha']);
    // } else {
    //     echo("<script>alert('Usuário ou email incorretos')</script>");
    // }
}
// session_start();
// if(isset($_POST['usuario']) && isset($_POST['senha'])){
//     if($_POST['usuario'] == 'maria' && $_POST['senha'] == 'senha123'){
//         $_SESSION['usuario'] = $_POST['usuario']; 
//         header('Location: clientes.php');
//     }
// }

// if(isset($_GET['erro'])){
//     $erro = 'É preciso logar para acessar o sistema!';
// }

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="inc/css/mycss.css">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body class="loginPage" style=" display:flex; flex-direction: column; justify-content:center;align-items:center;">
    <div><?php echo $erro ?? '' ?> </div>
    <form action="#" method="POST">
        <h2>Bem vindo ao Sistema!</h2>
        <div class="mb-3">
            <label for="inputEmail" class="form-label">Email</label>
            <input name="email" type="email" class="form-control" id="inputEmail">
        </div>
        <div class="mb-3">
            <label for="inputPassword" class="form-label">Senha</label>
            <input name="senha" type="password" class="form-control" id="inputPassword">
        </div>
        <button type="submit" class="btn btn-primary">Fazer Login</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>