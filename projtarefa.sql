-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29-Out-2021 às 14:18
-- Versão do servidor: 10.4.21-MariaDB
-- versão do PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projtarefa`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `acao`
--

CREATE TABLE `acao` (
  `idAcao` int(11) NOT NULL,
  `nomeAcao` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `acao`
--

INSERT INTO `acao` (`idAcao`, `nomeAcao`) VALUES
(1, 'Criar'),
(2, 'Editar'),
(3, 'Excluir');

-- --------------------------------------------------------

--
-- Estrutura da tabela `equipe`
--

CREATE TABLE `equipe` (
  `idEquipe` int(11) NOT NULL,
  `nomeEquipe` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `especialidade`
--

CREATE TABLE `especialidade` (
  `idEspecialidade` int(11) NOT NULL,
  `nomeEspecialidade` varchar(200) NOT NULL,
  `descricaoEspecialidade` varchar(300) NOT NULL,
  `idUsuarioResponsavel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `especialidade`
--

INSERT INTO `especialidade` (`idEspecialidade`, `nomeEspecialidade`, `descricaoEspecialidade`, `idUsuarioResponsavel`) VALUES
(1, 'PHP', 'PHP', 1),
(2, 'MYSQL', 'MYSQL', 1),
(3, 'Oracle', 'Ter conhecimentos', 1),
(4, 'CSS', 'Ter conhecimentos b?sicos em CSS.', 1),
(5, 'Outra Especialidade', 'Outras especialidades não especializadas.', 1),
(6, 'Marketing', 'Descrição', 1),
(7, 'Workpress', '              Framework', 1),
(8, 'SEO', 'Técnicas de SEO avançadas', 1),
(9, 'Laravel', 'Conhecimentos básicos em Laravel              ', 1),
(10, 'Moodle', 'Conhecimentos básicos em Moodle              ', 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `listaacao`
--

CREATE TABLE `listaacao` (
  `idUsuario` int(11) NOT NULL,
  `idAcao` int(11) NOT NULL,
  `idStatus` int(11) NOT NULL,
  `idTarefa` int(11) NOT NULL,
  `dataInicioAcao` datetime NOT NULL,
  `dataFimAcao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `listaespecialidade`
--

CREATE TABLE `listaespecialidade` (
  `idEspecialidade` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `listaespecialidade`
--

INSERT INTO `listaespecialidade` (`idEspecialidade`, `idUsuario`) VALUES
(2, 1),
(4, 1),
(1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `listausuario`
--

CREATE TABLE `listausuario` (
  `idUsuario` int(11) NOT NULL,
  `idUsuarioFuncionario` int(11) NOT NULL,
  `idEquipe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `status`
--

CREATE TABLE `status` (
  `idStatus` int(11) NOT NULL,
  `nomeStatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `status`
--

INSERT INTO `status` (`idStatus`, `nomeStatus`) VALUES
(1, 'Pendente'),
(2, 'Em andamento'),
(3, 'Concluído'),
(4, 'Lixeira');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tarefa`
--

CREATE TABLE `tarefa` (
  `idTarefa` int(11) NOT NULL,
  `nomeTarefa` varchar(200) NOT NULL,
  `descricaoTarefa` varchar(300) NOT NULL,
  `dataCriacao` datetime NOT NULL,
  `prazoTarefa` datetime DEFAULT NULL,
  `metaHorasMensal` time DEFAULT NULL,
  `progressoTarefa` double DEFAULT NULL,
  `idUsuario` int(11) NOT NULL,
  `idTipoTarefa` int(11) DEFAULT NULL,
  `idStatus` int(11) NOT NULL,
  `FK_idTarefa` int(11) DEFAULT NULL,
  `idEspecialidade` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tarefa`
--

INSERT INTO `tarefa` (`idTarefa`, `nomeTarefa`, `descricaoTarefa`, `dataCriacao`, `prazoTarefa`, `metaHorasMensal`, `progressoTarefa`, `idUsuario`, `idTipoTarefa`, `idStatus`, `FK_idTarefa`, `idEspecialidade`) VALUES
(26, 'Projeto do Jon', '  \r\n    Projeto do Jonathan', '2021-06-15 13:11:10', '2021-06-24 00:00:00', '02:00:00', NULL, 7, 1, 1, NULL, 5),
(28, 'Projeto ', '  \r\n    Descrição', '2021-10-06 12:22:20', '2021-10-03 00:00:00', '20:00:00', NULL, 1, 1, 1, NULL, 1),
(29, 'Teste', '  \r\n    Teste', '2021-10-10 19:40:03', '2021-10-11 00:00:00', '19:19:00', NULL, 1, 1, 3, 28, 6),
(31, 'Tarefas Diárias', '  \r\n    Fazer todas as tarefas diárias', '2021-10-10 23:11:06', '2021-10-10 00:00:00', '20:11:00', NULL, 1, 1, 1, NULL, 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipotarefa`
--

CREATE TABLE `tipotarefa` (
  `idTipoTarefa` int(11) NOT NULL,
  `nomeTipoTarefa` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tipotarefa`
--

INSERT INTO `tipotarefa` (`idTipoTarefa`, `nomeTipoTarefa`) VALUES
(1, 'Importante'),
(2, 'Urgente'),
(3, 'Circunstancial');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipousuario`
--

CREATE TABLE `tipousuario` (
  `idTipoUsauario` int(11) NOT NULL,
  `nomeTipoUsuario` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tipousuario`
--

INSERT INTO `tipousuario` (`idTipoUsauario`, `nomeTipoUsuario`) VALUES
(1, 'Programador');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nomeUsuario` varchar(200) NOT NULL,
  `emailUsuario` varchar(300) NOT NULL,
  `senhaUsuario` varchar(500) NOT NULL,
  `idTipoUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nomeUsuario`, `emailUsuario`, `senhaUsuario`, `idTipoUsuario`) VALUES
(1, 'Henrique Costa', 'h@h.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1),
(6, 'Gustavo', 'gustavo@gmail.com', '51eac6b471a284d3341d8c0c63d0f1a286262a18', 1),
(7, 'jon', 'jon@jon', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1),
(8, 'rai', 'rai@rai.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1),
(9, 'Matheus', 'matheus@gmail.com', '0a9044e7ddbf783111e0ec14b25857c3ba1b0fd8', 1),
(10, 'mauricio goetten', 'mauricio18o@hotmail.com', 'f131e8b662b74cf27f97772499c042e6e96e445a', 1),
(11, 'Eduarda', 'eduardatimoteo7@gmail.com', 'fc1ec67f52e4fcc8b7993a8e4b2e5a3354233aa1', 1),
(12, 'Henrique', 'henriquecosta@gmail.com', '0a9044e7ddbf783111e0ec14b25857c3ba1b0fd8', 1),
(13, 'Duda', 'duda@duda.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `acao`
--
ALTER TABLE `acao`
  ADD PRIMARY KEY (`idAcao`);

--
-- Índices para tabela `equipe`
--
ALTER TABLE `equipe`
  ADD PRIMARY KEY (`idEquipe`);

--
-- Índices para tabela `especialidade`
--
ALTER TABLE `especialidade`
  ADD PRIMARY KEY (`idEspecialidade`);

--
-- Índices para tabela `listaacao`
--
ALTER TABLE `listaacao`
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idAcao` (`idAcao`),
  ADD KEY `idStatus` (`idStatus`),
  ADD KEY `idTarefa` (`idTarefa`);

--
-- Índices para tabela `listaespecialidade`
--
ALTER TABLE `listaespecialidade`
  ADD KEY `idEspecialidade` (`idEspecialidade`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Índices para tabela `listausuario`
--
ALTER TABLE `listausuario`
  ADD PRIMARY KEY (`idUsuario`,`idUsuarioFuncionario`),
  ADD KEY `idUsuarioFuncionario` (`idUsuarioFuncionario`),
  ADD KEY `idEquipe` (`idEquipe`);

--
-- Índices para tabela `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`idStatus`);

--
-- Índices para tabela `tarefa`
--
ALTER TABLE `tarefa`
  ADD PRIMARY KEY (`idTarefa`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idTipoTarefa` (`idTipoTarefa`),
  ADD KEY `idStatus` (`idStatus`),
  ADD KEY `FK_idTarefa` (`FK_idTarefa`),
  ADD KEY `idEspecialidade` (`idEspecialidade`);

--
-- Índices para tabela `tipotarefa`
--
ALTER TABLE `tipotarefa`
  ADD PRIMARY KEY (`idTipoTarefa`);

--
-- Índices para tabela `tipousuario`
--
ALTER TABLE `tipousuario`
  ADD PRIMARY KEY (`idTipoUsauario`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `idTipoUsuario` (`idTipoUsuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `acao`
--
ALTER TABLE `acao`
  MODIFY `idAcao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `especialidade`
--
ALTER TABLE `especialidade`
  MODIFY `idEspecialidade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `status`
--
ALTER TABLE `status`
  MODIFY `idStatus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tarefa`
--
ALTER TABLE `tarefa`
  MODIFY `idTarefa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `tipotarefa`
--
ALTER TABLE `tipotarefa`
  MODIFY `idTipoTarefa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tipousuario`
--
ALTER TABLE `tipousuario`
  MODIFY `idTipoUsauario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `listaacao`
--
ALTER TABLE `listaacao`
  ADD CONSTRAINT `listaacao_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `listaacao_ibfk_2` FOREIGN KEY (`idAcao`) REFERENCES `acao` (`idAcao`),
  ADD CONSTRAINT `listaacao_ibfk_3` FOREIGN KEY (`idStatus`) REFERENCES `status` (`idStatus`),
  ADD CONSTRAINT `listaacao_ibfk_4` FOREIGN KEY (`idTarefa`) REFERENCES `tarefa` (`idTarefa`);

--
-- Limitadores para a tabela `listaespecialidade`
--
ALTER TABLE `listaespecialidade`
  ADD CONSTRAINT `listaespecialidade_ibfk_1` FOREIGN KEY (`idEspecialidade`) REFERENCES `especialidade` (`idEspecialidade`),
  ADD CONSTRAINT `listaespecialidade_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Limitadores para a tabela `listausuario`
--
ALTER TABLE `listausuario`
  ADD CONSTRAINT `listausuario_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `listausuario_ibfk_2` FOREIGN KEY (`idUsuarioFuncionario`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `listausuario_ibfk_3` FOREIGN KEY (`idEquipe`) REFERENCES `equipe` (`idEquipe`);

--
-- Limitadores para a tabela `tarefa`
--
ALTER TABLE `tarefa`
  ADD CONSTRAINT `tarefa_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `tarefa_ibfk_2` FOREIGN KEY (`idTipoTarefa`) REFERENCES `tipotarefa` (`idTipoTarefa`),
  ADD CONSTRAINT `tarefa_ibfk_3` FOREIGN KEY (`idStatus`) REFERENCES `status` (`idStatus`),
  ADD CONSTRAINT `tarefa_ibfk_4` FOREIGN KEY (`FK_idTarefa`) REFERENCES `tarefa` (`idTarefa`) ON DELETE CASCADE,
  ADD CONSTRAINT `tarefa_ibfk_5` FOREIGN KEY (`idEspecialidade`) REFERENCES `especialidade` (`idEspecialidade`);

--
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idTipoUsuario`) REFERENCES `tipousuario` (`idTipoUsauario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
