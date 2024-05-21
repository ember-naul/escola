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
<?php
$conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
// Verifica se a variável $_POST["dataChamada"] está definida, se não, define-a como a data atual
$dataChamada = isset($_POST["dataChamada"]) ? $_POST["dataChamada"] : date("Y-m-d");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Registro de Chamada</title>
    <link rel="shortcut icon" href="peixe.ico" type="image/x-icon">
    <link rel="stylesheet" href="table.css">
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
</head>

<?php
include('../navbar.php');

?>

<body>
    <div class="container">
        <h1>Registro de Chamada</h1>
        <a href="cadastro_nota_alunos.php">
            <button class="ajuste" style='position:absolute; left: 45%;'>Ir para cadastro de notas</button>
        </a><br><br>
        <form action="#" method="post">
            <select class="ajuste" id="disciplinaCurso" name="disciplinaCurso" onchange="this.form.submit()">
                <option value="">Selecione uma disciplina</option>
                <?php
                $comandoSQL = $conexao->query("SELECT * FROM disciplina");
                while ($linhaBD = $comandoSQL->fetch()) {
                    echo '<option value="' . $linhaBD["id"] . '"' .
                        (isset($_POST["disciplinaCurso"]) && $linhaBD["id"] == $_POST["disciplinaCurso"] ? " selected" : "") . '>' . $linhaBD["curso"] . '</option>';
                }
                ?>
            </select><br><br>


            <?php

            // Função para calcular o número de aulas que o aluno participou
            function calcularFrequenciaTotal($aluno_id, $conexao)
            {
                $consultaFrequencia = $conexao->prepare("
                    SELECT SUM(n_aulas) AS total_aulas_participadas, 
                           SUM(dis.num_aulas_dia) AS total_aulas_possiveis
                    FROM chamada c
                    JOIN disciplina dis ON c.id_disciplina = dis.id
                    WHERE c.id_aluno = :aluno_id
                ");
                $consultaFrequencia->bindParam(':aluno_id', $aluno_id);
                $consultaFrequencia->execute();

                $resultado = $consultaFrequencia->fetch(PDO::FETCH_ASSOC);
                $total_aulas_participadas = $resultado['total_aulas_participadas'];
                $total_aulas_possiveis = $resultado['total_aulas_possiveis'];

                if ($total_aulas_possiveis > 0) {
                    $frequenciaTotal = ($total_aulas_participadas / $total_aulas_possiveis) * 100;
                    return min($frequenciaTotal, 100);
                } else {
                    return 0;
                }
            }

            if (isset($_POST["disciplinaCurso"])) {
                $disciplinaCurso = $_POST["disciplinaCurso"];
                echo '<input type="date" style="margin-bottom: 15px;" id="presenca" class="ajuste" onchange="this.form.submit()" required name="dataChamada" value="' . $dataChamada . '">';
                echo '<table class="result">';
                echo '<tr><th>Aluno</th><th>Disciplina</th><th>Aulas da Disciplina</th><th>Nº Aulas Participadas</th><th> Presença: </th><th> Editar </th></tr>';

                $consultaAlunos = $conexao->prepare(
                    "SELECT al.id AS aluno_id, al.nome AS aluno_nome, dis.curso AS disciplina_curso, dis.num_aulas_dia AS max_aulas_dia  
                        FROM alunos al 
                        JOIN alunos_disciplinas ald ON al.id = ald.id_aluno 
                        JOIN disciplina dis ON ald.id_disciplina = dis.id 
                        WHERE ald.id_disciplina = :id_disciplina"
                );
                $consultaAlunos->bindParam(':id_disciplina', $disciplinaCurso);
                $consultaAlunos->execute();

                while ($linhaAluno = $consultaAlunos->fetch()) {
                    echo '<tr>';
                    echo '<td>' . $linhaAluno['aluno_nome'] . '</td>';
                    echo '<td>' . $linhaAluno['disciplina_curso'] . '</td>';
                    echo '<td>' . $linhaAluno['max_aulas_dia'] . '</td>';
                    echo '<td><input type="number" class="ajuste" name="presenca[' . $linhaAluno['aluno_id'] . ']" min="0" max="' . $linhaAluno['max_aulas_dia'] . '"></td>';
                    $frequenciaTotal = calcularFrequenciaTotal($linhaAluno['aluno_id'], $conexao);

                    echo '<td>' . ceil($frequenciaTotal) . '%</td>';
                    echo '<td><a href="UD/altera_chamada.php?id_aluno=' . $linhaAluno['aluno_id'] . '&dataChamada=' . $dataChamada . '">Editar</a></td>';
                    echo '</tr>';
                }

                echo '</table>';
                echo '<input type="submit"  id="presenca" class="ajuste" name="registrarChamada" value="Registrar Chamada">';
            }
            ?>
            <?php
            if (isset($_POST["registrarChamada"]) && isset($_POST["disciplinaCurso"])) {
                $dataChamada = isset($_POST["dataChamada"]) ? $_POST["dataChamada"] : "";
                $disciplinaCurso = $_POST["disciplinaCurso"];
                foreach ($_POST["presenca"] as $idAluno => $numAulas) {
                    if ($numAulas > 0) {
                        $comandoSQL = $conexao->prepare("INSERT INTO chamada (id_aluno, id_disciplina, data_chamada, n_aulas) VALUES (:id_aluno, :id_disciplina, :data_chamada, :n_aulas)");
                        $comandoSQL->bindParam(':id_aluno', $idAluno);
                        $comandoSQL->bindParam(':id_disciplina', $disciplinaCurso);
                        $comandoSQL->bindParam(':data_chamada', $dataChamada);
                        $comandoSQL->bindParam(':n_aulas', $numAulas);
                        $comandoSQL->execute();
                    }
                }
                echo "<script>
               setTimeout(function() {
               window.location.href = 'cadastro_nota_falta.php';
               alert('Chamada foi realizada com sucesso!');
            });
            </script>";
            }
            ?>
        </form>
    </div>

</body>

</html>