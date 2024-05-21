<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ud.css">
    <link rel="shortcut icon" href="peixe.ico" type="image/x-icon">
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #1f2941;
        margin-top: -30%;
    }

    form {
        width: 300px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ddd;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        margin-top: 1%;
        position: absolute;
        left: 41%;
        top: 28%;
    }

    h2 {
        color: white;
        position: absolute;
        left: 43%;
        top: 20%;
    }

    img {

        margin-top: 60%;
    }
</style>

<body>
    <CENTER><img src="../peixe.jpg" width="200em" height="200em"></CENTER>

    <?php
    // Conexão com o banco de dados
    $conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");

    // Verificar se o ID do aluno foi passado pela URL
    if (isset($_GET['id_aluno'])) {
        $id_aluno = $_GET['id_aluno'];

        // Selecionar as notas do aluno
        $consultaNotas = $conexao->prepare("SELECT * FROM notas WHERE id_aluno = :id_aluno");
        $consultaNotas->bindParam(':id_aluno', $id_aluno);
        $consultaNotas->execute();

        // Exibir as notas do aluno em uma tabela
        echo "<center><h2>Editar Notas do Aluno $id_aluno</h2></center>";
        echo "<form action='alterar_nota.php' method='post'>";
        echo "<table>";
        echo "<tr><th>Nota</th><th>Editar</th><th>Excluir</th></tr>";
        while ($linhaNota = $consultaNotas->fetch()) {
            echo "<tr>";
            echo "<td >$linhaNota[notas]</td>";
            echo "<td><input type='number' style='margin-right:15px; margin-left:25px; margin-bottom: 5px;' class='ajuste' name='nota_$linhaNota[id]' value='$linhaNota[notas]' min='0' max='10'></td>";
            echo "<td><input type='submit' style='margin-right:15px; margin-left:25px; margin-bottom: 5px;' class='ajuste' name='excluir_$linhaNota[id]' value='Excluir'></td>";

            echo "</tr>";
        }
        echo "</table>";

        // Botão para salvar as alterações
        echo "<input type='submit'class='ajuste' style='margin-right:15px; margin-left:25px;' value='Salvar Alterações'>";
        echo "<a href='../cadastro_nota_alunos.php'><input style='margin-left:25px;' type='button'class='ajuste' value='Voltar'></a>";
        echo "</form>";
    }

    // Verificar se o formulário foi submetido
    if (isset($_POST)) {
        foreach ($_POST as $nome_campo => $valor) {
            if (strpos($nome_campo, 'nota_') === 0) {
                $id_nota = str_replace('nota_', '', $nome_campo);
                $comandoSQL = $conexao->prepare("UPDATE notas SET notas = :notas WHERE id = :id_nota");
                $comandoSQL->bindParam(':notas', $valor);
                $comandoSQL->bindParam(':id_nota', $id_nota);
                $comandoSQL->execute();
            } elseif (strpos($nome_campo, 'excluir_') === 0) {
                $id_nota = str_replace('excluir_', '', $nome_campo);
                $comandoSQL = $conexao->prepare("DELETE FROM notas WHERE id = :id_nota");
                $comandoSQL->bindParam(':id_nota', $id_nota);
                $comandoSQL->execute();
            }
            header('Location:../cadastro_nota_alunos.php');
        }


        exit;
    }
    ?>

</body>

</html>