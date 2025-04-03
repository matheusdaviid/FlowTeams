-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/04/2025 às 16:19
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
  `senha` varchar(255) NOT NULL,
  `token_reset` varchar(255) DEFAULT NULL,
  `token_expira` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_cadastro`
--

INSERT INTO `tb_cadastro` (`id`, `email`, `senha`, `token_reset`, `token_expira`) VALUES
(18, 'matheus971592191@gmail.com', '43653956M*', NULL, NULL),
(19, 'thiago0100@gmail.com', '123455678A!', 'cf4db6495c2d71737d9baa331527d845dc4b761f6bcd5418fef678d07fb51b1e', '2025-04-03 17:12:19');

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
(3, 19, 'teste', 'fgfg', '12:00', '2025-04-16', 'important');

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
(4, 19, 'gdg', '2025-07-24', '2025-07-24', 'dfdfdf', 'Em andamento', '2025-04-03 14:11:13');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `tb_eventos`
--
ALTER TABLE `tb_eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tb_projetos`
--
ALTER TABLE `tb_projetos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tb_eventos`
--
ALTER TABLE `tb_eventos`
  ADD CONSTRAINT `fk_eventos_cadastro` FOREIGN KEY (`id_usuario`) REFERENCES `tb_cadastro` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_projetos`
--
ALTER TABLE `tb_projetos`
  ADD CONSTRAINT `fk_projetos_cadastro` FOREIGN KEY (`id_usuario`) REFERENCES `tb_cadastro` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
