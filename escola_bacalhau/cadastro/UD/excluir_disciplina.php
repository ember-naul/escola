<?php
$conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$id_disciplina = $_GET['id'];

$comandoSQL = $conexao->prepare("DELETE FROM disciplina WHERE id = :id_disciplina");
$comandoSQL->bindParam(':id_disciplina', $id_disciplina);
$comandoSQL->execute();

echo "Matrícula excluída com sucesso!";
echo "<script>
        setTimeout(function() {
        window.location.href = '../cadastro_disciplina.php';
    }, 100);
    </script>";
