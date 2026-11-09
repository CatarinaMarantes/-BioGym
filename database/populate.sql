-- =====================================================================
-- Dados de Teste (Seed Data)
-- =====================================================================

-- Utilizadores (palavra-passe de teste para todos: 'password123')
INSERT INTO Utilizador (id, nome, email, telemovel, passwordHash, fotografia, biografia, dataRegisto) VALUES
(1, 'Rui Almeida', 'admin@biogym.pt', '912345678', '$2y$10$klWSoqUNUOk.KojlN7NXiezoIMHDHD4zV7tcK6EEnmyTy.cEXNAqG', NULL, 'Administrador do sistema BioGym.', '2026-01-01'),
(2, 'Carlos Silva', 'carlos.silva@biogym.pt', '923456789', '$2y$10$klWSoqUNUOk.KojlN7NXiezoIMHDHD4zV7tcK6EEnmyTy.cEXNAqG', NULL, 'Especialista em musculação e treino funcional.', '2026-01-05'),
(3, 'Ana Rocha', 'ana.rocha@biogym.pt', '934567890', '$2y$10$klWSoqUNUOk.KojlN7NXiezoIMHDHD4zV7tcK6EEnmyTy.cEXNAqG', NULL, 'Instrutora de Yoga e Pilates.', '2026-01-06'),
(4, 'João Mendes', 'joao.mendes@gmail.com', '965432109', '$2y$10$klWSoqUNUOk.KojlN7NXiezoIMHDHD4zV7tcK6EEnmyTy.cEXNAqG', NULL, 'Focado em hipertrofia e condicionamento.', '2026-01-10'),
(5, 'Maria Santos', 'maria.santos@gmail.com', '987654321', '$2y$10$klWSoqUNUOk.KojlN7NXiezoIMHDHD4zV7tcK6EEnmyTy.cEXNAqG', NULL, 'Atleta amadora de corrida.', '2026-01-12');

-- Atribuição de Papéis
INSERT INTO Administrador (idUtilizador) VALUES (1);
INSERT INTO Treinador (idUtilizador) VALUES (2), (3);
INSERT INTO Membro (idUtilizador, dataNascimento) VALUES
(3, '1995-03-08'),
(4, '1998-04-15'),
(5, '2001-09-22');

-- Modalidades
INSERT INTO Modalidade (id, nome, descricao) VALUES
(1, 'Musculação', 'Treino de força e hipertrofia muscular.'),
(2, 'Yoga', 'Prática de flexibilidade, postura e controlo respiratório.'),
(3, 'Spinning', 'Treino cardiovascular de alta intensidade sobre bicicleta.');

-- Salas
INSERT INTO Sala (id, nome, capacidade) VALUES
(1, 'Sala Principal de Musculação', 30),
(2, 'Estúdio de Pilates/Yoga', 15),
(3, 'Sala de Cycling', 20);

-- Equipamentos
INSERT INTO Equipamento (id, nome, estado, idSala) VALUES
(1, 'Passadeira Pro 500', 'DISPONIVEL', 1),
(2, 'Bicicleta Spinning X', 'DISPONIVEL', 3),
(3, 'Multipower Squat Rack', 'EM_MANUTENCAO', 1);

-- Certificações
INSERT INTO Certificacao (idTreinador, idModalidade, nome, entidadeEmissora, dataObtencao, validada, dataValidacao) VALUES
(2, 1, 'Certificado de Treinador de Musculação Nível 2', 'IFBB Portugal', '2023-05-10', 1, '2023-05-15'),
(2, 3, 'Instrutor de Indoor Cycling', 'Schwinn Fitness', '2024-02-12', 1, '2024-02-20'),
(3, 2, 'Instrutor Certificado de Hatha Yoga', 'Yoga Alliance', '2022-11-20', 1, '2022-11-25');

-- Aulas
INSERT INTO Aula (id, data, horaInicio, horaFim, nivel, vagas, idModalidade, idSala, idTreinador) VALUES
(1, '2026-11-10', '09:00', '10:00', 'INICIANTE', 15, 2, 2, 3),
(2, '2026-11-11', '18:30', '19:30', 'INTERMEDIO', 20, 3, 3, 2);

-- Inscrições em Aulas
INSERT INTO Inscricao (idMembro, idAula, dataInscricao, estado, notaAula, notaTreinador, comentario) VALUES
(4, 1, '2026-11-07 10:00', 'ATIVA', NULL, NULL, NULL),
(5, 2, '2026-11-08 14:20', 'ATIVA', NULL, NULL, NULL);

-- Planos de Treino e Itens
INSERT INTO PlanoTreino (id, nome, objetivo, frequenciaSemanal, duracaoSemanas) VALUES
(1, 'Hipertrofia 3 Dias', 'Ganho de massa muscular', 3, 8);

INSERT INTO ItemPlano (id, idPlanoTreino, ordem, exercicio, series, repeticoes) VALUES
(1, 1, 1, 'Supino Reto com Barra', 4, 10),
(2, 1, 2, 'Agachamento Livre', 4, 12);

-- Avaliações Físicas
INSERT INTO AvaliacaoFisica (id, data, peso, altura, percentagemGordura, perimetroCintura, perimetroPeito, perimetroBraco, perimetroCoxa, idMembro, idTreinador, idPlanoTreino) VALUES
(1, '2026-01-15', 75.5, 1.78, 16.5, 82.0, 98.0, 34.0, 56.0, 4, 2, 1);

-- Sessões de Personal Training (PT)
INSERT INTO SessaoPT (id, data, horaInicio, horaFim, estado, idMembro, idTreinador) VALUES
(1, '2026-11-12', '11:00', '12:00', 'CONFIRMADA', 4, 2);
