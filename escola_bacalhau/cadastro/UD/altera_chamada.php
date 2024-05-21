<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['chamadas'])) {
        $conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
        foreach ($_POST['chamadas'] as $chamada_id => $chamada_data) {
            if (isset($chamada_data['excluir']) && $chamada_data['excluir'] == 'on') {
                $query = $conexao->prepare("DELETE FROM chamada WHERE id = :chamada_id");
                $query->bindParam(':chamada_id', $chamada_id);
                $query->execute();
            } else {
                $n_aulas = isset($chamada_data['n_aulas']) ? $chamada_data['n_aulas'] : 0;
                $query = $conexao->prepare("UPDATE chamada SET n_aulas = :n_aulas WHERE id = :chamada_id");
                $query->bindParam(':n_aulas', $n_aulas);
                $query->bindParam(':chamada_id', $chamada_id);
                $query->execute();
            }
        }
        header("Location: ../cadastro_nota_falta.php");
        exit();
    } else {
        echo "Erro: Nenhum dado recebido do formulário.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Alterar Chamada</title>
    <link rel="stylesheet" href="table.css">
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
</head>

<body>
    <center>
        <h1>EDITAR CHAMADA</h1>
        <a href="../cadastro_nota_falta.php"><button class="ajuste">Voltar</button></a>
        <br><br>
        <?php
        if (isset($_GET['id_aluno']) && isset($_GET['dataChamada'])) {
            $conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
            $id_aluno = $_GET['id_aluno'];
            $dataChamada = $_GET['dataChamada'];

            $consultaChamada = $conexao->prepare("SELECT * FROM chamada WHERE id_aluno = :id_aluno AND data_chamada = :dataChamada");
            $consultaChamada->bindParam(':id_aluno', $id_aluno);
            $consultaChamada->bindParam(':dataChamada', $dataChamada);
            $consultaChamada->execute();

            echo "<h2 style='color: white;'>Alterar Chamada do Aluno $id_aluno em $dataChamada</h2>";
            echo "<form action='#' method='post'>";
            echo "<table>";
            echo "<tr><th>Aulas Participadas</th><th>Excluir</th></tr>";
            while ($linhaChamada = $consultaChamada->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td><input type='number' class='ajuste' name='chamadas[" . $linhaChamada['id'] . "][n_aulas]' style='margin-bottom:15px;' value='" . $linhaChamada['n_aulas'] . "' min='0' max=''></td>";
                echo "<td><input type='checkbox' class='ajuste' style='margin-bottom:15px;' name='chamadas[" . $linhaChamada['id'] . "][excluir]'> Excluir</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<input type='submit'class='ajuste' value='Salvar Alterações'>";
            echo "</form>";
        } else {
            echo "Error: id_aluno or dataChamada not set";
        }
        ?>
    </center>
</body>

</html>

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

<CENTER><img src="../peixe.jpg" width="200em" height="200em"></CENTER>