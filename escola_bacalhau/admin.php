<?php
session_start();

if (session_status() !== PHP_SESSION_ACTIVE) {
    exit('Sessão não iniciada.');
}

$conexao = new PDO("mysql:host=localhost;dbname=diarioClasse", "root", "");
if (!isset($_SESSION['id_usuario'])) {
    exit('Usuario não logado.');
    header("Location: login.php");
}

$sql = 'SELECT u.id, u.nome, u.usuario, u.senha, u.idPerfil, p.nome as perfil_nome
        FROM usuario u
        INNER JOIN perfil p ON u.idPerfil = p.id
        WHERE u.id = :id';
$cmd = $conexao->prepare($sql);
$cmd->bindParam(':id', $_SESSION['id_usuario'], PDO::PARAM_INT);
$cmd->execute();
$usuario = $cmd->fetch();

?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="menu.css">
    <link rel="shortcut icon" href="peixe.ico" type="image/x-icon">
    <title>Sistema Diário</title>
    <style>
        #icon_1 {
            background-color: #5e9ff5;
        }

        .title {
    display: flex;
    justify-content: space-around;
    align-items: center;
    width: 70%;
    max-width: 100%;
    margin: 2px auto;
    font-size: 18px;
    padding: 2px;
    box-sizing: border-box;
}

.title span {
    flex: 1;
    text-align: center;
    margin: 0 5px;
}

@media (max-width: 768px) {
    .title {
        flex-direction: column;
    }

    .title span {
        margin: 2px 0;
    }
}

    </style>
</head>

<body>
    <div class="navbar">
        <img src="peixe.jpg" width="68em" height="68em">
        <br>
        <h1>Escola Bacalhau</h1>
        <p></p>
        <a href="#"> </a>
        <a style="color: red; font-size: 20px;" href="logout.php">Deslogar</a>
    </div>
    <div class="title">
        <span class="um"> Aluno </span>
        <span class="dois"> Disciplina</span>
        <span class="dois"> Aluno na Disciplina </span>
        <span class="um"> Chamada e Nota</span>
        <span class="tres"> ADMIN: Usuarios </span>
    </div>
    <div class="main">

        <a href="cadastro/cadastro_aluno.php">
            <div class="icon_1">
                <img src="img/3633274.png" alt="Image 1" />
            </div>
        </a>

        <a href="cadastro/cadastro_disciplina.php">
            <div class="icon_1">
                <img src="img/escola.png" alt="Image 2" />
            </div>
        </a>

        <a href="cadastro/cadastro_aluno_e_disciplina.php">
            <div class="icon_1">
                <img src="img/professor.png" alt="Image 3" />
            </div>
        </a>

        <a href="cadastro/cadastro_nota_falta.php">
            <div class="icon_1">
                <img src="img/diario.png" alt="Image 4" />
            </div>
        </a>

        <a href="cadastro/cadastro_usuario.php">

            <div class="icon_1" id="icon_1">
                <img src="img/3633274.png" alt="Image 4" />
            </div>
        </a>

    </div>
    <center>
        <h3>A Escola Bacalhau se destaca na paisagem da pequena cidade com sua arquitetura acolhedora e peculiar. Erguida em meio a jardins bem cuidados e árvores frondosas, a escola emana um charme nostálgico que convida tanto os jovens quanto os mais velhos a explorar seus corredores.</h3>
        <br>
        <img src="bacalhau.jpg" width="460em" height="370em">
    </center>
    <footer>
        <div class="footer-content">
            <div class="social-media">
                <h3>Nos siga:</h3>
                <ul>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">Instagram</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>© 2024 Escola Bacalhau. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>


</html>