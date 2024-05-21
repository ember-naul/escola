<?php

$conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id_aluno = $_GET['id'];

$comandoSQL = $conexao->prepare("SELECT * FROM alunos_disciplinas INNER JOIN alunos ON alunos_disciplinas.id_aluno = alunos.id INNER JOIN disciplina ON alunos_disciplinas.id_disciplina = disciplina.id WHERE alunos_disciplinas.id = :id");
$comandoSQL->bindParam(':id', $id_aluno);
$comandoSQL->execute();

if ($comandoSQL->rowCount() > 0) {
    $aluno = $comandoSQL->fetch();
} else {
    echo "Nenhum aluno encontrado com o ID fornecido.";
    exit;
}

?>
<center>
    <h1>EDITAR DISCIPLINA DO ALUNO</h1>
</center>
<link rel="shortcut icon" href="peixe.ico" type="image/x-icon">
<style>
    .ajuste {
        font-family: 'Open Sans', sans-serif;
        font-weight: 500;
        font-size: 0.8vw;
        color: #242424;
        background-color: rgb(250, 250, 250);
        border: none;
        outline: 1px solid rgb(184, 180, 180);
        padding: 0.4vw;
        max-width: 190px;
        transition: 0.4s;
        cursor: pointer;

    }

    .ajuste:hover {
        box-shadow: 0 0 0 0.15vw rgba(135, 207, 235, 0.486);
    }
</style>

<form action="#" method="post">
    <input type="hidden" name="id_aluno" value="<?php echo $id_aluno; ?>">
    <input type="hidden" name="nome" value="<?php echo $aluno['nome']; ?>">
    <input type="hidden" name="rg" value="<?php echo $aluno['rg']; ?>"><br><br>
    <label>Disciplina:</label>
    <select class="ajuste" name="id_disciplina">
        <?php
        $comandoSQL = $conexao->query("SELECT * FROM disciplina");
        while ($linhaBD = $comandoSQL->fetch()) {
            echo '<option value="' . $linhaBD['id'] . '"';
            if ($linhaBD['id'] == $aluno['id_disciplina']) {
                echo ' selected';
            }
            echo '>' . $linhaBD['curso'] . '</option>';
        }
        ?>
    </select><br><br>
    <center><input type="submit" class="ajuste" value="Editar"></center><a href="../cadastro_aluno_e_disciplina.php"><input type="button" class="ajuste" value="Voltar"></a>

</form>

<CENTER><img src="../peixe.jpg" width="200em" height="200em"></CENTER>


<?php
if (isset($_POST['nome']) && isset($_POST['rg']) && isset($_POST['id_disciplina'])) {
    $nome = $_POST['nome'];
    $rg = $_POST['rg'];
    $id_disciplina = $_POST['id_disciplina'];
    $id_aluno = $_POST['id_aluno'];

    $comandoSQL = $conexao->prepare("UPDATE alunos_disciplinas SET id_disciplina = :id_disciplina WHERE id = :id_aluno");
    $comandoSQL->bindParam(':id_disciplina', $id_disciplina);
    $comandoSQL->bindParam(':id_aluno', $id_aluno);
    $comandoSQL->execute();

    echo "Aluno alterado com sucesso!";
    echo "<script>
        setTimeout(function() {
        window.location.href = '../cadastro_aluno_e_disciplina.php';
    }, 100);
    </script>";
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #1f2941;
    }

    form {
        width: 300px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ddd;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        margin-top: 5%;
    }

    h1 {
        color: white;
        margin-top: 10%;
    }
</style>