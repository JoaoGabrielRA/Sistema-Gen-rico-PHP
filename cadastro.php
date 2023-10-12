<?php
require_once('config.php');
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $camposValidos = true;
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    if(empty($nome)){
        $camposValidos = false;
        echo("<script>alert('Preencher o campo nome é obrigatório!')</script>");
    }
    elseif(empty($email)){
        $camposValidos = false;
        echo("<script>alert('Preencher o campo email é obrigatório!')</script>");
    }
    elseif(empty($senha)){
        $camposValidos = false;
        echo("<script>alert('Preencher o campo senha é obrigatório!')</script>");
    }
    
    if($camposValidos){
        $newconexao = novaConexao();
        $verificaExistencia = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
        $stmt = $newconexao->prepare($verificaExistencia);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $existe = $stmt->fetchColumn();
        if ($existe) {
            echo ("<script>alert('O email já está cadastrado.')</script>");
        } else {
            $hashsenha = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (nome, senha, email, tipo) VALUES ('$nome', '$hashsenha', '$email', '2')";   
            if($newconexao->exec($sql)){
                $mensagemSucesso = 'Cadastro realizado com sucesso!';
                // $id = $newconexao->lastInsertId();
                // echo "Novo cadastro com id $id";
            }else{
                echo $newconexao->errorCode() . "<br>";
                print_r($newconexao->errorInfo());
            }
        }
        //print_r(get_class_methods($conexao));
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inc/css/mycss.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Cadastro</title>
</head>
<body class="cadastroPage" style=" display:flex; flex-direction: column; justify-content:center;align-items:center;">
    <div>
    
        <form class="cadastro" action="#" method="POST">
            <h2 class="mb-3">Formulário de cadastro</h2>
            <?php if(isset($mensagemSucesso)){
                    echo ("<h3 style='color: white; font-weight: 600;'>$mensagemSucesso</h3>");
                } 
            ?>
            <div class="mb-3">
                <label for="InputNome" class="form-label">Nome</label>
                <input name="nome" type="text" class="form-control" id="InputNome" placeholder="Digite seu nome">
            </div>
            <div class="mb-3">
                <label for="InputEmail" class="form-label">Email</label>
                <input name="email" type="email" class="form-control" id="InputEmail" placeholder="Digite seu email">
            </div>
            <div class="mb-3">
                <label for="InputPassword" class="form-label">Senha</label>
                <input name="senha" type="password" class="form-control" id="InputPassword" placeholder="Digite sua senha">
            </div>

            <button class="btn btn-primary mt-3" type="submit">Cadastrar-se</button> 
            <a href="login.php" class="btn btn-primary mt-3">Ir para o login</a>                 
        </form>
        <br>
          
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>