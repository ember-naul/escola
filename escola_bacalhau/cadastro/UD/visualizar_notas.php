<?php
$conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
$idAluno = $_GET['id_aluno'];

$consultaNome = $conexao->prepare(
    "SELECT nome 
     FROM alunos
     WHERE id = :id_aluno"
);

$consultaNome->bindParam(':id_aluno', $idAluno);
$consultaNome->execute();
$linhaAluno = $consultaNome->fetch();
$nomeAluno = $linhaAluno['nome'];
$consultaNotas = $conexao->prepare(
    "SELECT n.notas, d.curso 
     FROM notas n
     JOIN disciplina d ON n.id_disciplina = d.id
     WHERE n.id_aluno = :id_aluno"
);
$consultaNotas->bindParam(':id_aluno', $idAluno);
$consultaNotas->execute();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Notas de <?php echo $nomeAluno; ?></title>
    <link rel="stylesheet" href="ud.css">
    <link rel="shortcut icon" href="peixe.ico" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1f2941;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        a {
            display: block;
            margin-bottom: 20px;
            text-align: center;
            color: #337ab7;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="../cadastro_nota_alunos.php"><button class='ajuste'>Voltar</button></a>
        <h1>Notas de <?php echo $nomeAluno; ?></h1>
        <table>
            <tr>
                <th>Disciplina</th>
                <th>Nota</th>
            </tr>
            <?php
            while ($linhaNota = $consultaNotas->fetch()) {
                echo '<tr>';
                echo '<td>' . $linhaNota['curso'] . '</td>';
                echo '<td>' . $linhaNota['notas'] . '</td>';
                echo '</tr>';
            }
            ?>
        </table>
    </div>
</body>
</html>
