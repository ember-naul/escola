DROP DATABASE IF EXISTS diarioClasse;

CREATE DATABASE diarioClasse;

USE diarioClasse;

CREATE TABLE perfil (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nome VARCHAR(50)
);

CREATE TABLE usuario (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nome VARCHAR(50),
    usuario VARCHAR(50),
    senha VARCHAR(255),
    dataNasc DATE,
    idPerfil INT,
    FOREIGN KEY (idPerfil) REFERENCES perfil (id)
);

CREATE TABLE disciplina (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    curso VARCHAR(80),
    num_aulas_dia INT,
    descricao VARCHAR(200)
);

CREATE TABLE alunos (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nome VARCHAR(50),
    maeAluno VARCHAR(50),
    paiAluno VARCHAR(50),
    rg CHAR(9) NOT NULL,
    email VARCHAR(50),
    endereco VARCHAR(50),
    dataNasc DATE
);

CREATE TABLE alunos_disciplinas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_aluno INT,
    id_disciplina INT,
    FOREIGN KEY (id_aluno) REFERENCES alunos (id),
    FOREIGN KEY (id_disciplina) REFERENCES disciplina (id)
);

CREATE TABLE chamada (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_aluno INT,
    id_disciplina INT,
    data_chamada DATE NOT NULL,
    n_aulas INT DEFAULT 0,
    FOREIGN KEY (id_aluno) REFERENCES alunos (id),
    FOREIGN KEY (id_disciplina) REFERENCES disciplina (id)
);

CREATE TABLE notas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_aluno INT,
    id_disciplina INT,
    notas INT,
    FOREIGN KEY (id_aluno) REFERENCES alunos (id),
    FOREIGN KEY (id_disciplina) REFERENCES disciplina (id)
);

SELECT * FROM alunos;

SELECT * FROM disciplina;

SELECT * FROM alunos_disciplinas;

SELECT * FROM chamada;

SELECT * FROM notas;

INSERT INTO
    alunos (
        nome,
        maeAluno,
        paiAluno,
        rg,
        email,
        endereco,
        dataNasc
    )
VALUES (
        'Otavio Gonçalves Silva',
        'Jane McMorris',
        'João Silva Gonzagui',
        '123456789',
        'otaviogoncalves24@yahoo.com',
        '123 Main St',
        '1990-01-01'
    ),
    (
        'Maria Regina Ferreira',
        'Renata Moraes Miguele',
        'Valdemir Henrique Ferreira',
        '111222333',
        'mariacamargo@gmail.com.br',
        '456 Main St',
        '1995-02-02'
    ),
    (
        'Pedro Batista de Souza',
        'Ana Cristina Gomes Salles',
        'Bento Guanabara de Souza',
        '456789123',
        'pedrottv12@gmail.com',
        '789 Main St',
        '2000-03-03'
    ),
    (
        'Laura Camila de Sáh',
        'Clara Camila Oliveira ',
        'Heitor de Sáh',
        '333222111',
        'laura@yahoo.com',
        '321 Main St',
        '2005-04-04'
    );

INSERT INTO
    disciplina (
        curso,
        num_aulas_dia,
        descricao
    )
VALUES (
        'Curso de ingles',
        5,
        'Curso de ingles aprofundado com módulos avançados e temas diversos.'
    ),
    (
        'Curso de fisica',
        3,
        'Curso de fisica quantica com móludos de astronomia.'
    ),
    (
        'Curso de matemática p/engenharia',
        7,
        'Curso de matemática fundamental e superior, com módulos focados em engenharia e arquitetura.'
    ),
    (
        'Curso de matemática base',
        7,
        'Curso de matemática fundamental e superior, com módulos focados para ensino básico da matemática.'
    );

INSERT INTO
    perfil (nome)
VALUES ("Administrador"),
    ("Secretário"),
    ("Professor");

INSERT INTO
    usuario (
        nome,
        usuario,
        senha,
        dataNasc,
        idPerfil
    )
VALUES (
        "Luan Henrique",
        "luan",
        "$2y$10$RpOyLdHJEstJ35PDGXYPoOQS.dceQO6yvnMG44Y7hGDB2O2cnG0V6",
        "2007-03-29",
        1
    );
-- (senha é luan1)
SELECT * FROM usuario;