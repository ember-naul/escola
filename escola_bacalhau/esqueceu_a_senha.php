<html>
<form action="#" method="post">
    <link rel="shortcut icon" href="peixe.ico" type="image/x-icon">
    <label>Usuario:</label>
    <input type="text" name="usuario"><br>
    <input type="submit" value="Procurar">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        form {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            display: block;
            margin-top: 10px;
            text-align: center;
            font-size: 14px;
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        h1 {
            color: white;
        }
    </style>
</form>

<?php
if (isset($_POST['usuario'])) {
    $conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $usuario = $_POST['usuario'];
    $comandoSQL = $conexao->prepare("SELECT * FROM usuario WHERE usuario = :usuario");
    $comandoSQL->bindParam(':usuario', $usuario);
    $comandoSQL->execute();

    if ($comandoSQL->rowCount() > 0) {
        $linhaBD = $comandoSQL->fetch(PDO::FETCH_ASSOC);
?>
        <form action="#" method="post">
            <label>Nova Senha:</label>
            <input type="password" name="senha"><br><br>
            <input type="hidden" name="usuario" value="<?php echo $usuario; ?>">
            <label> Data de Nascimento</label>
            <input type="date" name="confirmarData" value="">
            <input type="submit" value="Alterar">
        </form>
<?php
    } else {
        echo " <br>Ninguem encontrado com o usuário fornecido.";
    }
}

if (isset($_POST['senha']) && isset($_POST['confirmarData'])) {
    $conexao = new PDO("mysql:host=127.0.0.1;dbname=diarioClasse", "root", "");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($_POST['confirmarData'] != $linhaBD['dataNasc']) {
        echo "<script> alert('Data incorreta');</script>";
    } else {
        $usuario = $_POST['usuario'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $comandoSQL = $conexao->prepare("UPDATE usuario SET senha = :senha WHERE usuario = :usuario");
        $comandoSQL->bindParam(':senha', $senha);
        $comandoSQL->bindParam(':usuario', $usuario);
        try {
            if ($comandoSQL->execute()) {
                echo "<br>Senha atualizada com sucesso.";
                header('Location: login.php');
            } else {
                echo "Erro ao atualizar a senha.";
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }
}
?>