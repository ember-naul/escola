<?php
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['idPerfil'] != 1) {
    include('../sessao.php');
}
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['idPerfil'])) {
    header('Location:../login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuarios</title>
    <link rel="stylesheet" href="table.css">
    <link rel="shortcut icon" href="peixe.ico" type="image/x-icon">
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
        <form action="#" method="post" onsubmit="validarFormulario()">
            <div class="container">
                <h1>Cadastro de Usuarios</h1>
                <span id="spanD" style=" margin-left:7%;">Nome:</span>
                <input type="text" class="ajuste" id="inputD" name="nomeUsuario" require />

                <span id="spanD">Usuário:</span>
                <input type="text" class="ajuste" id="inputD" name="usuarioUsuario" require />

                <span id="spanD">Senha:</span>
                <input type="password" class="ajuste" id="inputD" name="senhaUsuario" require />


                <span id="spanD">Data de Nascimento:</span>
                <input type="date" class="ajuste" id="inputD" name="dataUsuario" require />

                <span id="spanD">Nível de Acesso: </span>
                <select class="ajuste" name="perfilUsuario" id="idPerfilUsuario">
                    <option value="3">Professor</option>
                    <option value="2">Secretario</option>
                    <option value="1">Administrador</option>
                </select><?php
                            if (isset($_POST["nomeUsuario"])) {
                                $nomeUsuario = $_POST['nomeUsuario'];
                                $usuarioUsuario = $_POST['usuarioUsuario'];
                                $dataUsuario = $_POST['dataUsuario'];
                                if ((!isset($_POST['senhaUsuario']) || $_POST['senhaUsuario'] == "")) {
                                    echo "<script> validarFormulario();</script>";
                                } else {
                                    $senhaUsuario = password_hash($_POST['senhaUsuario'], PASSWORD_DEFAULT);
                                    $perfilUsuario = $_POST['perfilUsuario'];
                                    $conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
                                    $comandoSQL = $conexao->prepare("INSERT INTO usuario(nome, usuario, senha, dataNasc, idPerfil)
                                                            VALUES (:nome, :usuario, :senha, :dataNasc, :idPerfil)");
                                    $comandoSQL->bindParam(':nome', $nomeUsuario);
                                    $comandoSQL->bindParam(':usuario', $usuarioUsuario);
                                    $comandoSQL->bindParam(':senha', $senhaUsuario);
                                    $comandoSQL->bindParam(':dataNasc', $dataUsuario);
                                    $comandoSQL->bindParam(':idPerfil', $perfilUsuario);
                                    $comandoSQL->execute();
                                    echo "<br/>O usuario/a " . $nomeUsuario . " foi cadastrado/a com sucesso!<br/><br/>";
                                    echo "  <script>
                                    setTimeout(function() {
                                        
                                        window.location.href = '../admin.php';
                                        alert('Cadastro do usuário foi realizado com sucesso!');
                                    });
                                    </script>";
                                }
                            }
                            ?>
                <input style="margin-left:35px;" type="submit" class="ajuste" value="Cadastrar" />
            </div>
        </form>
    </div>
</body>

</html>
<script>
    function validarFormulario() {
        var nomeUsuario = document.getElementsByName("nomeUsuario")[0].value;
        var usuarioUsuario = document.getElementsByName("usuarioUsuario")[0].value;
        var senhaUsuario = document.getElementsByName("senhaUsuario")[0].value;
        var dataUsuario = document.getElementsByName("dataUsuario")[0].value;
        var perfilUsuario = document.getElementsByName("perfilUsuario")[0].value;

        if (nomeUsuario == "" || usuarioUsuario == "" || senhaUsuario == "") {
            alert("Preencha todos os campos!");
            return false;
        }

        return true;
    }
</script>