<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
    $comandoSQL = $conexao->prepare("DELETE FROM alunos WHERE id = :id");
    $comandoSQL->bindParam(':id', $id);
    $comandoSQL->execute();

    echo "Aluno excluído com sucesso!";
    echo "<script>
          setTimeout(function() {
              window.location.href = '../cadastro_aluno.php';
          }, 100);
      </script>";
} else {
    echo "Erro: ID do aluno não informado!";
}
