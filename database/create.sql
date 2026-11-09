-- =====================================================================
-- Website do ginasio: script sql
-- =====================================================================

PRAGMA foreign_keys = ON;

-- Remover tabelas
DROP TABLE IF EXISTS AvaliacaoFisica;
DROP TABLE IF EXISTS ItemPlano;
DROP TABLE IF EXISTS PlanoTreino;
DROP TABLE IF EXISTS Certificacao;
DROP TABLE IF EXISTS SessaoPT;
DROP TABLE IF EXISTS Inscricao;
DROP TABLE IF EXISTS Aula;
DROP TABLE IF EXISTS Equipamento;
DROP TABLE IF EXISTS Sala;
DROP TABLE IF EXISTS Modalidade;
DROP TABLE IF EXISTS Administrador;
DROP TABLE IF EXISTS Treinador;
DROP TABLE IF EXISTS Membro;
DROP TABLE IF EXISTS Utilizador;


CREATE TABLE Utilizador (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    telemovel TEXT NOT NULL,
    passwordHash TEXT NOT NULL,
    fotografia BLOB,
    biografia TEXT,
    dataRegisto TEXT NOT NULL
);

CREATE TABLE Membro (
    idUtilizador INTEGER PRIMARY KEY,
    dataNascimento TEXT NOT NULL,
    FOREIGN KEY (idUtilizador) REFERENCES Utilizador(id)
);

CREATE TABLE Treinador (
    idUtilizador INTEGER PRIMARY KEY,
    FOREIGN KEY (idUtilizador) REFERENCES Utilizador(id)
);

CREATE TABLE Administrador (
    idUtilizador INTEGER PRIMARY KEY,
    FOREIGN KEY (idUtilizador) REFERENCES Utilizador(id)
);

CREATE TABLE Modalidade (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL UNIQUE,
    descricao TEXT
);

CREATE TABLE Sala (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL UNIQUE,
    capacidade INTEGER NOT NULL CHECK (capacidade > 0)
);

CREATE TABLE Equipamento (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    estado TEXT NOT NULL CHECK (estado IN ('DISPONIVEL', 'EM_USO', 'EM_MANUTENCAO')),
    idSala INTEGER,
    FOREIGN KEY (idSala) REFERENCES Sala(id)
);

CREATE TABLE Aula (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    data TEXT NOT NULL,
    horaInicio TEXT NOT NULL,
    horaFim TEXT NOT NULL,
    nivel TEXT NOT NULL CHECK (nivel IN ('INICIANTE', 'INTERMEDIO', 'AVANCADO')),
    vagas INTEGER NOT NULL CHECK (vagas >= 0),
    idModalidade INTEGER NOT NULL,
    idSala INTEGER NOT NULL,
    idTreinador INTEGER NOT NULL,
    CHECK (horaFim > horaInicio),
    FOREIGN KEY (idModalidade) REFERENCES Modalidade(id),
    FOREIGN KEY (idSala) REFERENCES Sala(id),
    FOREIGN KEY (idTreinador) REFERENCES Treinador(idUtilizador)
);

CREATE TABLE Inscricao (
    idMembro INTEGER NOT NULL,
    idAula INTEGER NOT NULL,
    dataInscricao  TEXT NOT NULL,
    estado TEXT NOT NULL CHECK (estado IN ('ATIVA', 'CANCELADA')),
    notaAula INTEGER CHECK (notaAula >= 1 AND notaAula <= 5),
    notaTreinador INTEGER CHECK (notaTreinador >= 1 AND notaTreinador <= 5),
    comentario TEXT,
    PRIMARY KEY (idMembro, idAula),
    FOREIGN KEY (idMembro) REFERENCES Membro(idUtilizador),
    FOREIGN KEY (idAula) REFERENCES Aula(id)
);

CREATE TABLE SessaoPT (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    data TEXT NOT NULL,
    horaInicio TEXT NOT NULL,
    horaFim TEXT NOT NULL,
    estado TEXT NOT NULL CHECK (estado IN ('PENDENTE', 'CONFIRMADA', 'CANCELADA', 'CONCLUIDA')),
    idMembro INTEGER NOT NULL,
    idTreinador INTEGER NOT NULL,
    CHECK (horaFim > horaInicio),
    FOREIGN KEY (idMembro) REFERENCES Membro(idUtilizador),
    FOREIGN KEY (idTreinador) REFERENCES Treinador(idUtilizador)
);

CREATE TABLE Certificacao (
    idTreinador INTEGER NOT NULL,
    idModalidade INTEGER NOT NULL,
    nome TEXT NOT NULL,
    entidadeEmissora TEXT NOT NULL,
    dataObtencao TEXT NOT NULL,
    validada INTEGER NOT NULL DEFAULT 0 CHECK (validada IN (0, 1)),
    dataValidacao TEXT,
    PRIMARY KEY (idTreinador, idModalidade),
    FOREIGN KEY (idTreinador) REFERENCES Treinador(idUtilizador),
    FOREIGN KEY (idModalidade) REFERENCES Modalidade(id)
);

CREATE TABLE PlanoTreino (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    objetivo TEXT,
    frequenciaSemanal INTEGER NOT NULL CHECK (frequenciaSemanal >= 1 AND frequenciaSemanal <= 7),
    duracaoSemanas INTEGER NOT NULL CHECK (duracaoSemanas > 0)
);

CREATE TABLE ItemPlano (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    idPlanoTreino INTEGER NOT NULL,
    ordem  INTEGER NOT NULL CHECK (ordem > 0),
    exercicio TEXT NOT NULL,
    series INTEGER NOT NULL CHECK (series > 0),
    repeticoes INTEGER NOT NULL CHECK (repeticoes > 0),
    UNIQUE (idPlanoTreino, ordem),
    FOREIGN KEY (idPlanoTreino) REFERENCES PlanoTreino(id)
);

CREATE TABLE AvaliacaoFisica (
    id  INTEGER PRIMARY KEY AUTOINCREMENT,
    data TEXT NOT NULL,
    peso REAL NOT NULL CHECK (peso > 0),
    altura REAL NOT NULL CHECK (altura > 0),
    percentagemGordura REAL CHECK (percentagemGordura >= 0 AND percentagemGordura <= 100),
    perimetroCintura REAL CHECK (perimetroCintura > 0),
    perimetroPeito REAL CHECK (perimetroPeito > 0),
    perimetroBraco REAL CHECK (perimetroBraco > 0),
    perimetroCoxa REAL CHECK (perimetroCoxa > 0),
    idMembro INTEGER NOT NULL,
    idTreinador INTEGER NOT NULL,
    idPlanoTreino INTEGER NOT NULL,
    FOREIGN KEY (idMembro) REFERENCES Membro(idUtilizador),
    FOREIGN KEY (idTreinador) REFERENCES Treinador(idUtilizador),
    FOREIGN KEY (idPlanoTreino) REFERENCES PlanoTreino(id)
);
