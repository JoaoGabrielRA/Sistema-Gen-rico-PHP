<?php

function novaConexao($usuarios = 'test'){
    $servidor = 'localhost';
    $usuario = 'root';
    $senha = '';

    try{
        $conexao = new PDO("mysql:host=$servidor;dbname=$usuarios",
        $usuario,$senha
    );
    }catch(PDOException $e){
        die('Erro: ' . $e->getMessage());
    }
    return $conexao;
}

 ?>

