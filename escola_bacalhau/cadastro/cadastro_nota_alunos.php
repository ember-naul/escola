<?php
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['idPerfil'] != 3 && $_SESSION['idPerfil'] != 2 && $_SESSION['idPerfil'] != 1) {
    include('../sessao.php');
}
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['idPerfil'])) {
    header('Location: ../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Registro de Notas</title>
    <link rel="stylesheet" href="table.css">
    <link rel="shortcut icon" href="peixe.ico" type="image/x-icon">
</head>
<?php
include('../navbar.php')
?>

<body>
    <div class="container">
        <h1>Registro de Notas</h1>
        <a href="cadastro_nota_falta.php">
            <button class="ajuste" style='position:absolute; left: 45%;'>Ir para cadastro da chamada</button>
        </a><br><br>
        <form action="#" method="post">
            <select class="ajuste" id="disciplinaNota" name="disciplinaNota" onchange="this.form.submit()">
                <option value="">Selecione uma disciplina</option>
                <?php
                $conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
                $comandoSQL = $conexao->query("SELECT * FROM disciplina");
                while ($linhaBD = $comandoSQL->fetch()) {
                    echo '<option value="' . $linhaBD["id"] . '"' .
                        (isset($_POST["disciplinaNota"]) && $linhaBD["id"] == $_POST["disciplinaNota"] ? " selected" : "") . '>' . $linhaBD["curso"] . '</option>';
                }
                ?>
            </select><br><br>


            <?php
            if (isset($_POST["disciplinaNota"])) {
                $disciplinaNota = $_POST["disciplinaNota"];
                echo '<table class="result">';
                echo '<tr><th>Código Aluno</th><th>Aluno</th><th>Disciplina</th><th>Nota</th><th>Ações</th><th>Visualizar</th><th>Média</th></tr>';
                $consultaAlunos = $conexao->prepare(
                    "SELECT al.id AS aluno_id, al.nome AS aluno_nome, dis.curso AS disciplina_curso  
                FROM alunos al 
                JOIN alunos_disciplinas ald ON al.id = ald.id_aluno 
                JOIN disciplina dis ON ald.id_disciplina = dis.id 
                WHERE ald.id_disciplina = :id_disciplina"
                );
                $consultaAlunos->bindParam(':id_disciplina', $disciplinaNota);
                $consultaAlunos->execute();
                while ($linhaAluno = $consultaAlunos->fetch()) {
                    $notasAluno = array();
                    $consultaNotas = $conexao->prepare("SELECT notas FROM notas WHERE id_aluno = :id_aluno AND id_disciplina = :id_disciplina");
                    $consultaNotas->bindParam(':id_aluno', $linhaAluno['aluno_id']);
                    $consultaNotas->bindParam(':id_disciplina', $disciplinaNota);
                    $consultaNotas->execute();

                    while ($linhaNota = $consultaNotas->fetch()) {
                        $notasAluno[] = $linhaNota['notas'];
                    }

                    echo '<tr>';
                    echo '<td>' . $linhaAluno['aluno_id'] . '</td>';
                    echo '<td>' . $linhaAluno['aluno_nome'] . '</td>';
                    echo '<td>' . $linhaAluno['disciplina_curso'] . '</td>';
                    echo '<td><input type="number" id="input" class="ajuste" name="nota[' . $linhaAluno['aluno_id'] . '][' . $disciplinaNota . ']" min="0" max="10"></td>';
                    echo '<td><a href="UD/alterar_nota.php?id_aluno=' . $linhaAluno['aluno_id'] . '&id_disciplina=' . $disciplinaNota . '">Editar/Excluir</a></td>';
                    echo '<td><a href="UD/visualizar_notas.php?id_aluno=' . $linhaAluno['aluno_id'] . '">Ver Notas</a></td>';
                    echo '<td>';
                    if (!empty($notasAluno)) {
                        $media = array_sum($notasAluno) / count($notasAluno);
                        echo $media;
                    } else {
                        echo '0';
                    }

                    echo '</td>';
                    echo '</tr>';
                }


                echo '</table>';
                echo '<input type="submit"  id="registrarNota" class="ajuste" name="registrarNota" value="Registrar Nota">';
            }
            ?>

        </form>
    </div>
    <?php
    if (isset($_POST["registrarNota"]) && isset($_POST["disciplinaNota"])) {
        $disciplinaNota = $_POST["disciplinaNota"];
        if (isset($_POST['nota'])) {
            foreach ($_POST["nota"] as $idAluno => $nota) {
                if (isset($nota[$disciplinaNota])) {
                    $comandoSQL = $conexao->prepare("INSERT INTO notas (id_aluno, id_disciplina, notas) VALUES (:id_aluno, :id_disciplina, :notas) ON DUPLICATE KEY UPDATE notas = :notas");
                    $comandoSQL->bindParam(':id_aluno', $idAluno);
                    $comandoSQL->bindParam(':id_disciplina', $disciplinaNota);
                    $comandoSQL->bindParam(':notas', $nota[$disciplinaNota]);
                    $comandoSQL->execute();
                }
            }
            echo "<p>Notas registradas com sucesso!</p>";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'cadastro_nota_alunos.php';
                        alert('Notas foram cadastradas com sucesso!');
                    });
                </script>";
        }
    }
    ?>

</body>

</html>