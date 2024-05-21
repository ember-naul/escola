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
<HTML>

<HEAD>
    <TITLE>Cadastro de Aluno</TITLE>
    <META CHARSET="utf-8" />
    <link rel="stylesheet" href="table.css">
    <link rel="shortcut icon" href="peixe.ico" type="image/x-icon">
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(2, 1fr);
            gap: 10px;
        }

        .input-item {
            margin-bottom: 10px;
        }
    </style>
    </style>
</HEAD>

<BODY>
    <div class="corpo">
        <?php
        include('../navbar.php')
        ?>
        <FORM ACTION="#" METHOD="post" id="formCadastro" onsubmit="return validarFormulario()">
            <div class="container">
                <h1>Cadastro de Aluno</h1>
                <div class="grid-container">
                    <div class="input-item">
                        <span id="spanD">Nome:</span>
                        <input type="text" class="ajuste" name="nomeAluno" />
                    </div>
                    <div class="input-item">
                        <span id="spanD">Nome da mãe:</span>
                        <input type="text" class="ajuste" name="nomeMae" />
                    </div>
                    <div class="input-item">
                        <span id="spanD">Nome do pai:</span>
                        <input type="text" class="ajuste" name="nomePai" />
                    </div>
                    <div class="input-item">
                        <span id="spanD">RG:</span>
                        <input type="text" class="ajuste" id="myInput" name="rgAluno" maxlength="9" onkeypress="limitarDigitos(event)">
                    </div>
                    <div class="input-item">
                        <span id="spanD">E-mail:</span>
                        <input type="text" class="ajuste" name="emailAluno" />
                    </div>
                    <div class="input-item">
                        <span id="spanD">Endereço:</span>
                        <input type="text" class="ajuste" name="enderecoAluno" />
                    </div>
                    <div class="input-item">
                        <span id="spanD">Data Nascimento:</span>
                        <input type="date" class="ajuste" name="dataAluno" />
                    </div>
                </div>


                <?php

                if (isset($_POST["rgAluno"])) {
                    $nomeAluno      = $_POST["nomeAluno"];
                    $nomeMae        = $_POST["nomeMae"];
                    $nomePai        = $_POST["nomePai"];
                    $rgAluno        = $_POST["rgAluno"];
                    $emailAluno     = $_POST["emailAluno"];
                    $enderecoAluno  = $_POST["enderecoAluno"];
                    $dataAluno      = $_POST["dataAluno"];


                    $conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");

                    $comandoSQL = $conexao->prepare("INSERT INTO alunos(nome, maeAluno, paiAluno, rg, email, endereco, dataNasc) " .
                        "VALUES (:nomeAluno, :nomeMae, :nomePai, :rgAluno, :emailAluno, :enderecoAluno, STR_TO_DATE(:dataAluno,'%Y-%c-%d'))");

                    $comandoSQL->bindParam(':nomeAluno', $nomeAluno);
                    $comandoSQL->bindParam(':nomeMae', $nomeMae);
                    $comandoSQL->bindParam(':nomePai', $nomePai);
                    $comandoSQL->bindParam(':rgAluno', $rgAluno);
                    $comandoSQL->bindParam(':emailAluno', $emailAluno);
                    $comandoSQL->bindParam(':enderecoAluno', $enderecoAluno);
                    $comandoSQL->bindParam(':dataAluno', $dataAluno);


                    $comandoSQL->execute();

                    echo "<BR/>O aluno " . $nomeAluno . " foi cadastrado com sucesso!<BR/><BR/>";
                    echo "<script>
                    setTimeout(function() {
                        window.location.href = 'cadastro_aluno.php';
                        alert('Cadastro foi realizado com sucesso!');
                    });
                    </script>";
                }



                $conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
                $comandoSQL = $conexao->query("SELECT * FROM alunos");

                echo "<TABLE style=border: 0;'>";
                echo "<TR><TH>Código</TH><TH>Nome</TH><TH>Nome da Mãe</TH><TH>Nome do Pai</TH><TH>RG</TH><TH>E-mail</TH><TH>Endereço</TH><TH>Data Nascimento</TH><TH>Editar</TH><th>Excluir</th></TR>";
                while ($linhaBD = $comandoSQL->fetch()) {
                    echo "<TR><TD>" . $linhaBD["id"] . "</TD>";
                    echo     "<TD>" . $linhaBD["nome"] . "</TD>";
                    echo     "<TD>" . $linhaBD["maeAluno"] . "</TD>";
                    echo     "<TD>" . $linhaBD["paiAluno"] . "</TD>";
                    echo     "<TD>" . $linhaBD["rg"] . "</TD>";
                    echo     "<TD>" . $linhaBD["email"] . "</TD>";
                    echo     "<TD>" . $linhaBD["endereco"] . "</TD>";
                    echo     "<TD>" . $linhaBD["dataNasc"] . "</TD>";
                    echo     '<td><a href="UD/alterar_aluno.php?id=' . $linhaBD['id'] . '">Alterar</a></td>';
                    echo     '<td><a href="UD/excluir_aluno.php?id=' . $linhaBD['id'] . '">Excluir</a></td>';
                }
                echo "</TABLE>";

                ?>
                <br>
                <input type="submit" class="ajuste" id="inputD" value="Cadastrar" />
        </FORM>
    </div>
    </div>
</BODY>

</HTML>
<script>
    function validarFormulario() {
        var nomeAluno = document.getElementsByName("nomeAluno")[0].value;
        var nomeMae = document.getElementsByName("nomeMae")[0].value;
        var nomePai = document.getElementsByName("nomePai")[0].value;
        var rgAluno = document.getElementsByName("rgAluno")[0].value;
        var emailAluno = document.getElementsByName("emailAluno")[0].value;
        var enderecoAluno = document.getElementsByName("enderecoAluno")[0].value;
        var dataAluno = document.getElementsByName("dataAluno")[0].value;

        if (nomeAluno === '' || nomeMae === '' || nomePai === '' || rgAluno === '' || emailAluno === '' || enderecoAluno === '' || dataAluno === '') {
            alert("Por favor, preencha todos os campos.");
            return false;
        }

        return true;


        var rgAluno = document.getElementsByName("rgAluno")[0].value;

        // Verifica se o RG tem exatamente 9 dígitos
        if (rgAluno.length !== 9) {
            alert("O RG deve ter exatamente 9 dígitos.");
            return false;
        }



    }

    function limitarDigitos(event) {
        var input = event.target;
        var valor = input.value;

        if (valor.length >= 9 && event.keyCode !== 8 && event.keyCode !== 46) {
            event.preventDefault();
        }
    }
</script>