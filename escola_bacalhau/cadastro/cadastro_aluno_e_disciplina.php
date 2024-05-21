<?php
if (!isset($_SESSION)) {
    session_start();
}

if ($_SESSION['idPerfil'] == 3) {
    include('../sessao.php');
}
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['idPerfil'])) {
    header('Location: ../login.php');
    exit;
}
?>
<html>

<head>
    <title>Cadastro de Aluno na Disciplina</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="table.css">
    <link rel="shortcut icon" href="peixe.ico" type="image/x-icon">
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
    }

    .container {
        max-width: 80%;
        margin: 40px auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .input {
        font-size: 16px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 100%;
    }

    .button {
        font-size: 16px;
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: #337ab7;
        color: #fff;
        cursor: pointer;
    }

    .button:hover {
        background-color: #23527c;
    }
</style>

<BODY>
    <?php
    include('../navbar.php')
    ?>
    <form action="#" method="post">
        <div class="container">
            <H1>Cadastro de Aluno na Disciplina</H1>
            <input type="hidden" name="codigoAluno"> <br>

            <label for="rgAluno" style=" margin-left:27%;">RG do aluno:</label>
            <input type="text" class="ajuste" id="rgAluno" maxlength="9" name="rgAluno" />

            <label for="id_disciplinas" style=" margin-left:3%;">Disciplina:</label>
            <select class="ajuste" id="id_disciplinas" name="id_disciplinas">
                <option value="">Selecione uma disciplina</option>
                <?php
                $conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
                $comandoSQL = $conexao->query("SELECT * FROM disciplina");

                while ($linhaBD = $comandoSQL->fetch()) {
                    echo '<option value="' . $linhaBD["id"] . '"';
                    if (isset($_POST["id_disciplinas"]) && $linhaBD["id"] == $_POST["id_disciplinas"]) {
                        echo 'elected';
                    }
                    echo '>' . $linhaBD["curso"] . '</option>';
                }
                ?>
            </select><br><br>
            <?php
            if (isset($_POST["rgAluno"])) {
                $codigoAluno        = $_POST["codigoAluno"];
                $rgAluno            = $_POST["rgAluno"];
                $disciplinaCurso    = $_POST["id_disciplinas"];

                $conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
                $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                try {
                    $comandoSQL = $conexao->prepare("SELECT * FROM alunos WHERE rg = :rg");
                    $comandoSQL->bindParam(':rg', $rgAluno);
                    $comandoSQL->execute();
                    $aluno = $comandoSQL->fetch();

                    if ($aluno) {
                        $comandoSQL = $conexao->prepare("INSERT INTO alunos_disciplinas (id_aluno, id_disciplina) VALUES (:id_aluno, :id_disciplina)");
                        $comandoSQL->bindParam(':id_aluno', $aluno['id']);
                        $comandoSQL->bindParam(':id_disciplina', $disciplinaCurso);
                        $comandoSQL->execute();

                        echo "<BR/>O aluno " . $aluno['nome'] . " foi cadastrado com sucesso!<BR/><BR/>";
                        echo "<script>
                            setTimeout(function() {
                                window.location.href = 'cadastro_aluno_e_disciplina.php';
                                alert('Aluno cadastrado na disciplina com sucesso!');
                            });
                        </script>";
                    } else {
                        echo "<script>alert('Aluno não encontrado para o RG fornecido.')</script>";
                    }
                } catch (PDOException $e) {
                    echo "Erro: " . $e->getMessage();
                }
            }

            $conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
            $comandoSQL = $conexao->query("SELECT alunos_disciplinas.id as id, alunos.rg as aluno_rg, 
            alunos.nome as aluno_nome, disciplina.curso as disciplina_curso FROM alunos_disciplinas 
            INNER JOIN alunos ON alunos_disciplinas.id_aluno = alunos.id INNER JOIN disciplina ON alunos_disciplinas.id_disciplina = disciplina.id");

            echo "<TABLE style='border: 0;'>";
            echo "<TR><th>Código</th><th>RG</th><th>Nome</th><th>Disciplina</th><th>Editar</th><th>Excluir</th></TR>";

            while ($linhaBD = $comandoSQL->fetch()) {
                echo "<TR>";
                echo "<TD>" . $linhaBD["id"] . "</TD>";
                echo "<TD>" . $linhaBD["aluno_rg"] . "</TD>";
                echo "<TD>" . $linhaBD["aluno_nome"] . "</TD>";
                echo "<TD>" . $linhaBD["disciplina_curso"] . "</TD>";
                echo '<td><a href="UD/alterar_aluno_disciplina.php?id=' . $linhaBD['id'] . '">Editar</a></td>';
                echo '<td><a href="UD/excluir_aluno_disciplina.php?id=' . $linhaBD['id'] . '">Excluir</a></td>';
                echo "</TR>";
            }

            echo "</TABLE>";



            ?>
            <br>

            <INPUT TYPE="submit" class="ajuste" VALUE="Cadastrar" style="margin-bottom:2%;" />
    </FORM>
    </div>
</BODY>

</HTML>