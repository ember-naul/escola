<?php
session_start();

try {
    $conexao = new PDO("mysql:host=localhost;dbname=diarioClasse", 'root', '');
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log($e->getMessage());
    exit('Erro ao conectar com o banco de dados');
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

    .form-container {
        opacity: 0;
        transform: translateY(-20px);
        transition: opacity 0.5s, transform 0.5s;
    }

    .form-container.show {
        opacity: 1;
        transform: translateY(0);
    }
</style>
</head>
<br><br>
<CENTER>
    <h1>BEM VINDO A ESCOLA BACALHAU</h1><img src="peixe.jpg" width="200em" height="200em">
</CENTER>

<body>
    <div class="form-container">
        <link rel="shortcut icon" href="peixe.ico" type="image/x-icon">
        <form action="login.php" method="post">
            <?php
            if (isset($_POST['usuario']) && isset($_POST['senha'])) {
                $usuario = $_POST['usuario'];
                $senha = $_POST['senha'];

                $cmd = $conexao->prepare('SELECT u.id, u.nome, u.usuario, u.senha, u.idPerfil, p.nome as perfil_nome
                                    FROM usuario u
                                    INNER JOIN perfil p ON u.idPerfil = p.id
                                    WHERE u.usuario = :usuario');
                $cmd->bindParam(':usuario', $usuario, PDO::PARAM_STR);
                $cmd->execute();

                $linhaBD = $cmd->fetch(PDO::FETCH_ASSOC);

                if ($linhaBD) {
                    $senhaC = $linhaBD['senha'];

                    if (password_verify($senha, $senhaC)) {
                        $_SESSION['usuario'] = $linhaBD['nome'];
                        $_SESSION['id_usuario'] = $linhaBD['id'];
                        $_SESSION['perfil_nome'] = $linhaBD['perfil_nome'];
                        $_SESSION['idPerfil'] = $linhaBD['idPerfil'];

                        if ($_SESSION['idPerfil'] == 1) {
                            header('Location: admin.php');
                        } else if ($_SESSION['idPerfil'] == 2) {
                            header('Location: secretario.php');
                        } else {
                            header('Location: professor.php');
                        }
                        exit;
                    } else {
                        echo 'Usuario ou senha inválida';
                    }
                } else {
                    echo 'Usuario ou senha inválida';
                }
            }
            ?>
            <label for="usuario">Usuário:</label><br>
            <input type="text" name="usuario" id="usuario" required><br>
            <label for="senha">Senha:</label><br>
            <input type="password" name="senha" id="senha" required><br>
            <button type="submit">Login</button>
            <a href="esqueceu_a_senha.php">Esqueci minha senha.</a>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var formContainer = document.querySelector('.form-container');
            formContainer.classList.add('show');
        });
    </script>
</body>

</html>