<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pathway+Gothic+One" />
    <link href="cssmenu.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/cssmenu.css">
    <style>
        body {
            margin:0;
            background:#FFFFFF;
        }
        #menuDemo { 
            text-align:center; 
            background-color: black;
         }

    </style>
</head>
<body>
<div class='conteudo'>
    <div id="menuDemo">
<!--start CssMenu-->
        <div id="cssmenu">
            
            <ul>
            <img src="../peixe.jpg" width="60px" height="60px" style="position: absolute; left: 1%; top:4px;" alt="">
            <p style="position: absolute; left: 1%; top:4px;">Escola Bacalhau</p>
                <li>
                    <span>Perfil <i class="arrow"></i></span>
                    <ul class="dropdown">
                        <li><a>Olá <?php print " ".$_SESSION['usuario']."!" ?></a></li>
                        <li> <a href="../logout.php">Deslogar</a></li>
                        <?php
                        if($_SESSION['idPerfil'] == 1){
                        echo"<a href='cadastro_usuario.php'><li> Cadastrar Perfil </li></a>";
                        }
                        ?>
                    </ul>
                </li>
                <li><span>Páginas <i class="arrow"></i></span>
                <ul class="dropdown">
                <li><a href="cadastro_aluno.php">Cadastro de Aluno </a> </li>
                <li><a href="cadastro_disciplina.php">Cadastro de Disciplinas </a> </li>
                <li><a href="cadastro_aluno_e_disciplina.php">Cadastro de Alunos nas Disciplinas </a> </li>
                <li><a href="cadastro_nota_falta.php">Chamada </a> </li>
                <li><a href="cadastro_nota_alunos.php">Notas </a> </li>
                </ul>
            </li>
                <li><?php
                        if($_SESSION['idPerfil'] == 1){
                        echo"<a href = \"../admin.php\"<li>Voltar</li></a>";
                    }elseif($_SESSION['idPerfil'] == 2){
                        echo"<a href = \"../secretario.php\"<li>Voltar</li></a>";
                    }else{
                        echo"<a href = \"../professor.php\"<li>Voltar</li></a>";
                    } ?></li>
                
            </ul>
        </div>
    <!--end CssMenu-->
    </div>
</div>
</body>
</html>