<?php
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['idPerfil'] != 1) {
    include('../sessao.php');
}
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['idPerfil'])) {
    header('Location: ../login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Disciplina</title>
    <link rel="shortcut icon" href="peixe.ico" type="image/x-icon">
    <link rel="stylesheet" href="table.css">
    <style>
        #inputD {
            margin-bottom: 1.2%;
            margin-left: 3.5%;
            margin-right: 1.5%;
        }
    </style>
</head>

<body>
    <div class="corpo">
        <?php
        include('../navbar.php')
        ?>
        <form action="#" method="post">
            <div class="container">
                <h1>Cadastro de Disciplina</h1>
                <span id="spanD" style=" margin-left:13%;">Disciplina:</span>
                <input type="text" class="ajuste" id="inputD" name="nomeDisciplina" />

                <span id="spanD">Descrição:</span>
                <input type="text" class="ajuste" id="inputD" name="descricaoDisciplina" />

                <span id="spanD">N° Aulas:</span>
                <input type="text" class="ajuste" id="inputD" name="cargaHoraria" />
                <?php
                if (isset($_POST["nomeDisciplina"])) {
                    $disciplinaCurso     = $_POST["nomeDisciplina"];
                    $descricaoDisciplina = $_POST["descricaoDisciplina"];
                    $cargaHoraria = $_POST["cargaHoraria"];
                    $conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
                    $comandoSQL = $conexao->prepare("INSERT INTO disciplina(curso, descricao, num_aulas_dia)
                                                        VALUES (:curso, :descricao, :num_aulas_dia)");
                    $comandoSQL->bindParam(':curso', $disciplinaCurso);
                    $comandoSQL->bindParam(':descricao', $descricaoDisciplina);
                    $comandoSQL->bindParam(':num_aulas_dia', $cargaHoraria);
                    $comandoSQL->execute();
                    echo "<br/>A disciplina " . $disciplinaCurso . " foi cadastrada com sucesso!<br/><br/>";
                    echo "<script>
                                setTimeout(function() {
                                    window.location.href = 'cadastro_disciplina.php';
                                    alert('Disciplina foi cadastrada com sucesso!');
                                });
                            </script>";
                }
                $conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
                $comandoSQL = $conexao->query("SELECT * FROM disciplina");
                echo "<table class='result' style=border: 0;>";
                echo "<tr><th>Código</th><th>Curso</th><th>Descrição</th><th>Numero de aulas(p/Dia)</th><th>Editar</th><th>Excluir</th></tr>";
                while ($linhaBD = $comandoSQL->fetch()) {
                    echo "<tr><td>" . $linhaBD["id"] . "</td>";
                    echo "<td>" . $linhaBD["curso"] . "</td>";
                    echo "<td>" . $linhaBD["descricao"] . "</td>";
                    echo "<td>" . $linhaBD["num_aulas_dia"] . "</td>";
                    echo '<td><a href="UD/alterar_disciplina.php?id=' . $linhaBD['id'] . '">Alterar</a></td>';
                    echo '<td><a href="UD/excluir_disciplina.php?id=' . $linhaBD['id'] . '">Excluir</a></td>';
                }
                echo "</table>";
                echo "<br>";
                ?>
                <input type="submit" class="ajuste" value="Cadastrar" />
            </div>
        </form>
    </div>
</body>

</html>

<?php


?>