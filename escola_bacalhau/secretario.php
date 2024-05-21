<?php
session_start();

if (session_status() !== PHP_SESSION_ACTIVE) {
    exit('Sessão não iniciada.');
}

$dsn = 'mysql:host=localhost;dbname=diarioClasse';
$username = 'root';
$password = '';
$conn = new PDO($dsn, $username, $password);
if (!isset($_SESSION['id_usuario'])) {
    exit('Usuario não logado.');
    header("Location: login.php");
}

$sql = 'SELECT u.id, u.nome, u.usuario, u.senha, u.idPerfil, p.nome as perfil_nome
        FROM usuario u
        INNER JOIN perfil p ON u.idPerfil = p.id
        WHERE u.id = :id';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $_SESSION['id_usuario'], PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="menu.css">
    <link rel="shortcut icon" href="peixe.ico" type="image/x-icon">
    <title>Sistema Diário</title>

    <style>
                        #icon_1{
                        background-color: #5e9ff5;
                        }
                        .title{
                            position:absolute;
                            left:21.6%;
                            width:60%;
                            text-align:center;
                            align-content:center;
                            font-size:18px;
                            margin-top:8px;
                        }

                        .title span{
                            margin-right: 50px;
                            margin-left:56px;
                            position: relative;
                        }
                        .um{
                            position: absolute; 
                            left:-1.6%;
                        }
                        .dois{
                            position: absolute; 
                            left:2.5%;
                        }
                        .tres{
                            position: absolute; 
                            left:-0.8%;
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
        <a href="logout.php">Deslogar</a>
</div>

        <div class="title">
            <span class="um"> Aluno </span>
            <span class="dois"> Disciplina</span>
            <span class="dois"> Aluno na Disciplina </span>
            <span class="tres"> Chamada e Nota</span>
        </div>
<div class="main">
    <a href="cadastro/cadastro_aluno.php">
        <div class="icon_1">
            <img class="icon_aluno" src="img/3633274.png" alt="Image 1" />
        </div>
    </a>
    
        <div class="icon_2">
            <img class="icon_escola" src="img/escola.png" alt="Image 2" />
        </div>
    
    <a href="cadastro/cadastro_aluno_e_disciplina.php">
        <div class="icon_1">
            <img class="icon_professor" src="img/professor.png" alt="Image 3" />
        </div>
    </a>
    <a href="cadastro/cadastro_nota_falta.php">
        <div class="icon_1">
            <img class="icon_diario" src="img/diario.png" alt="Image 4" />
        </div>
    </a>

</div>
<center><h3>A Escola Bacalhau se destaca na paisagem da pequena cidade com sua arquitetura acolhedora e peculiar. Erguida em meio a jardins bem cuidados e árvores frondosas, a escola emana um charme nostálgico que convida tanto os jovens quanto os mais velhos a explorar seus corredores.</h3>
<br>
<img src="bacalhau.jpg" width="460em" height="370em"></center>
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
 
