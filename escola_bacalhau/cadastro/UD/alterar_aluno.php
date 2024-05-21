<?php
// alterar_aluno.php

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
    $comandoSQL = $conexao->prepare("SELECT * FROM alunos WHERE id = :id");
    $comandoSQL->bindParam(':id', $id);
    $comandoSQL->execute();
    $linhaBD = $comandoSQL->fetch();
    if ($linhaBD) {
?>
        <center>
            <h1>EDITAR INFORMAÇÕES DO ALUNO</h1>
        </center>
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
        <link rel="shortcut icon" href="peixe.ico" type="image/x-icon">
        <form action="alterar_aluno.php" method="post">

            <input type="hidden" class="ajuste" name="id" value="<?php echo $id; ?>">
            <label>Nome:</label>
            <input type="text" class="ajuste" name="nomeAluno" value="<?php echo $linhaBD['nome']; ?>"><br><br>
            <label>Nome da Mãe:</label>
            <input type="text" class="ajuste" name="nomeMae" value="<?php echo $linhaBD['maeAluno']; ?>"><br><br>
            <label>Nome do Pai:</label>
            <input type="text" class="ajuste" name="nomePai" value="<?php echo $linhaBD['paiAluno']; ?>"><br><br>
            <label>RG:</label>
            <input type="text" class="ajuste" name="rgAluno" value="<?php echo $linhaBD['rg']; ?>"><br><br>
            <label>E-mail:</label>
            <input type="text" class="ajuste" name="emailAluno" value="<?php echo $linhaBD['email']; ?>"><br><br>
            <label>Endereço:</label>
            <input type="text" class="ajuste" name="enderecoAluno" value="<?php echo $linhaBD['endereco']; ?>"><br><br>
            <label>Data Nascimento:</label>
            <input type="date" class="ajuste" name="dataAluno" value="<?php echo $linhaBD['dataNasc']; ?>"><br><br>
            <input type="submit" class="ajuste" value="Editar">
            <a href="../cadastro_aluno.php"><button style='margin-left:10px;' class="ajuste">Voltar</button></a>
        </form>

        <CENTER><img src="../peixe.jpg" width="200em" height="200em"></CENTER>

<?php
    } else {
        echo "Aluno não encontrado!";
    }
} else {
    echo "Erro: ID do aluno não informado!";
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $nomeAluno = $_POST['nomeAluno'];
    $nomeMae = $_POST['nomeMae'];
    $nomePai = $_POST['nomePai'];
    $rgAluno = $_POST['rgAluno'];
    $emailAluno = $_POST['emailAluno'];
    $enderecoAluno = $_POST['enderecoAluno'];
    $dataAluno = $_POST['dataAluno'];

    $conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
    $comandoSQL = $conexao->prepare("UPDATE alunos SET nome = :nomeAluno, maeAluno = :nomeMae, paiAluno = :nomePai, rg = :rgAluno, email = :emailAluno, endereco = :enderecoAluno, dataNasc = STR_TO_DATE(:dataAluno,'%Y-%c-%d') WHERE id = :id");
    $comandoSQL->bindParam(':id', $id);
    $comandoSQL->bindParam(':nomeAluno', $nomeAluno);
    $comandoSQL->bindParam(':nomeMae', $nomeMae);
    $comandoSQL->bindParam(':nomePai', $nomePai);
    $comandoSQL->bindParam(':rgAluno', $rgAluno);
    $comandoSQL->bindParam(':emailAluno', $emailAluno);
    $comandoSQL->bindParam(':enderecoAluno', $enderecoAluno);
    $comandoSQL->bindParam(':dataAluno', $dataAluno);
    $comandoSQL->execute();

    echo "Aluno alterado com sucesso!";
    echo "<script>
          setTimeout(function() {
              window.location.href ='../cadastro_aluno.php';
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