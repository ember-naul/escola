<?php
$conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$id_matricula = $_GET['id'];

$comandoSQL = $conexao->prepare("DELETE FROM alunos_disciplinas WHERE id = :id_matricula");
$comandoSQL->bindParam(':id_matricula', $id_matricula);
$comandoSQL->execute();

echo "Matrícula excluída com sucesso!";
echo "<script>
        setTimeout(function() {
        window.location.href = '../cadastro_aluno_e_disciplina.php';
    }, 100);
    </script>";
