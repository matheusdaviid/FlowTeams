-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01/04/2025 às 16:55
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_flowteams`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_cadastro`
--

CREATE TABLE `tb_cadastro` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_cadastro`
--

INSERT INTO `tb_cadastro` (`id`, `email`, `senha`) VALUES
(1, 'm@gmail.com', '123'),
(2, 'T@gmail.com', '12345678'),
(3, 'damaju@gmail', '123456'),
(4, 'cao@gmail.com', 'hu2008'),
(5, 'A@gail.com', 'f'),
(6, 'A@ail.com', '3'),
(7, 'cavanha@gmail.com', '123456Cavanha'),
(8, 'matheus@gmail.com', 'Cavanha123');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_eventos`
--

CREATE TABLE `tb_eventos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nome_evento` varchar(255) NOT NULL,
  `descricao_evento` text NOT NULL,
  `horario` varchar(5) NOT NULL,
  `data_evento` date NOT NULL,
  `prioridade` varchar(20) NOT NULL DEFAULT 'Média'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_eventos`
--

INSERT INTO `tb_eventos` (`id`, `id_usuario`, `nome_evento`, `descricao_evento`, `horario`, `data_evento`, `prioridade`) VALUES
(1, 1, 'jkgyuk', 'vjkfgjkft', '11:50', '2025-04-22', 'urgent');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_projetos`
--

CREATE TABLE `tb_projetos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_termino` date NOT NULL,
  `descricao` text NOT NULL,
  `status` varchar(50) DEFAULT 'Em andamento',
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_projetos`
--

INSERT INTO `tb_projetos` (`id`, `id_usuario`, `titulo`, `data_inicio`, `data_termino`, `descricao`, `status`, `data_criacao`) VALUES
(1, 8, 'Reunião 01 ', '2025-04-01', '2025-04-10', 'hvuyf', 'Em andamento', '2025-04-01 14:25:46');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tb_cadastro`
--
ALTER TABLE `tb_cadastro`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_eventos`
--
ALTER TABLE `tb_eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `tb_projetos`
--
ALTER TABLE `tb_projetos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_cadastro`
--
ALTER TABLE `tb_cadastro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `tb_eventos`
--
ALTER TABLE `tb_eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_projetos`
--
ALTER TABLE `tb_projetos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tb_eventos`
--
ALTER TABLE `tb_eventos`
  ADD CONSTRAINT `tb_eventos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_cadastro` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_projetos`
--
ALTER TABLE `tb_projetos`
  ADD CONSTRAINT `tb_projetos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_cadastro` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
