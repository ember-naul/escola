<?php
if (isset($_GET["id"])) {
    $id_disciplina = $_GET["id"];

    $conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $comandoSQL = $conexao->prepare("SELECT * FROM disciplina WHERE id = :id");
    $comandoSQL->bindParam(':id', $id_disciplina);
    $comandoSQL->execute();

    $disciplina = $comandoSQL->fetch();

    if ($disciplina) {
        $nomeDisciplina = $disciplina["curso"];
        $descricaoDisciplina = $disciplina["descricao"];
        $cargaHoraria = $disciplina["num_aulas_dia"];
    } else {
        echo "Disciplina não encontrada.";
        exit;
    }
} else {
    echo "ID da disciplina não fornecido.";
    exit;
}
?>

<HTML>
<link rel="shortcut icon" href="peixe.ico" type="image/x-icon">

<HEAD>
    <TITLE>Alterar Disciplina</TITLE>
    <META CHARSET="utf-8" />
    <link rel="stylesheet" href="table.css">
    <style>
        #inputD {
            position: relative;
            left: 37%;
            text-align: center;

        }

        #spanD {
            position: absolute;
            left: 42%;
            text-align: center;
        }

        button {
            margin-left: 7%;

        }

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
            margin-top: 1%;
        }

        h1 {
            color: white;
            margin-top: -37%;
        }

        img {
            margin-top: 37%
        }

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
</HEAD>

<BODY>
    <CENTER><img src="../peixe.jpg" width="200em" height="200em"></CENTER>

    <div class="corpo">
        <center>
            <h1>EDITAR DICIPLINA</h1>
        </center>
        <FORM ACTION="#" METHOD="post">
            <div class="container"><br>
                <input type="hidden" name="id_disciplina" value="<?php echo $id_disciplina; ?>">
                <span id="spanD">Disciplina: </span> <INPUT TYPE="text" class="ajuste" id="inputD" NAME="nomeDisciplina" value="<?php echo $nomeDisciplina; ?>" /> <BR />
                <BR>
                <span id="spanD">Descricao: </span> <INPUT TYPE="text" class="ajuste" id="inputD" NAME="descricaoDisciplina" value="<?php echo $descricaoDisciplina; ?>" /> <BR />
                <BR>
                <span id="spanD">N° Aulas: </span> <INPUT TYPE="text" class="ajuste" id="inputD" NAME="cargaHoraria" value="<?php echo $cargaHoraria; ?>" /> <BR />
                <BR>
                <INPUT TYPE="submit" id="inputD" class="ajuste" VALUE="Alterar" /> <a href="../cadastro_disciplina.php">
                    <button style='position: absolute;' class="ajuste">Voltar</button></a><br><br>


                <center><?php
                        if (isset($_POST["id_disciplina"])) {
                            $id_disciplina = $_POST["id_disciplina"];
                            $disciplinaCurso = $_POST["nomeDisciplina"];
                            $descricaoDisciplina = $_POST["descricaoDisciplina"];
                            $cargaHoraria = $_POST["cargaHoraria"];

                            $conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
                            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $comandoSQL = $conexao->prepare("UPDATE disciplina SET curso = :curso, descricao = :descricao, num_aulas_dia = :num_aulas_dia WHERE id = :id");
                            $comandoSQL->bindParam(':id', $id_disciplina);
                            $comandoSQL->bindParam(':curso', $disciplinaCurso);
                            $comandoSQL->bindParam(':descricao', $descricaoDisciplina);
                            $comandoSQL->bindParam(':num_aulas_dia', $cargaHoraria);

                            $comandoSQL->execute();

                            echo "<BR/>A disciplina " . $disciplinaCurso . " foi atualizada com sucesso!<BR/><BR/>";
                            echo "<script>
            setTimeout(function() {
                window.location.href = '../cadastro_disciplina.php';
            }, 100);
        </script>";
                        } else {
                            echo "ID da disciplina não fornecido.";
                            exit;
                        }
                        ?></center>

        </FORM>
    </div>
    </div>


</BODY>

</HTML>

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