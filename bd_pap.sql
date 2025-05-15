-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12-Maio-2025 às 18:12
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_pap`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `id_avaliacao` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `comentario` text NOT NULL,
  `data_avaliacao` date NOT NULL,
  `foto_perfil` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `avaliacoes`
--

INSERT INTO `avaliacoes` (`id_avaliacao`, `nome`, `comentario`, `data_avaliacao`, `foto_perfil`) VALUES
(1, '', 'Adorei a expriencia', '2025-05-12', ''),
(2, 'Admin', 'aaa', '2025-05-12', '1746637989_IMG_3448.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `modulos`
--

CREATE TABLE `modulos` (
  `id_modulo` int(11) NOT NULL,
  `imagem_modulo` varchar(255) NOT NULL,
  `video_modulo` varchar(255) NOT NULL,
  `nome_modulo` varchar(100) NOT NULL,
  `descricao_modulo` text NOT NULL,
  `nivel_modulo` enum('Iniciante','Intermediário','Avançado','') NOT NULL,
  `favorito` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `modulos`
--

INSERT INTO `modulos` (`id_modulo`, `imagem_modulo`, `video_modulo`, `nome_modulo`, `descricao_modulo`, `nivel_modulo`, `favorito`) VALUES
(10, '1746852342_image.png', 'src/videos/1746549274_Snapchat_1806213292.mp4', 'ModuloFudjirazZz', 'aaa', 'Iniciante', 0),
(11, '1746850445_IMG_3448.png', 'src/videos/1746850445_Snapchat_1806213292.mp4', 'Modulo FudjirazZz', 'aa', 'Iniciante', 0),
(12, '1747063026_IMG_3448.png', 'src/videos/1747063026_Snapchat_1806213292.mp4', 'Modulo FudjirazZz', 'AA', 'Intermediário', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `imagem_user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`, `imagem_user`) VALUES
(1, 'Admin', 'luisvardasca19@gmail.com', '$2y$10$Dzq5ZOl0AeFmDHBO9BZB1e.bC/p5lMZNZKR/kVN9VGKN5blPSb7tG', '1746637989_IMG_3448.png'),
(3, 'ramos', 'ramos@gmail.com', '$2y$10$iJVG4pwPNgwprdtZJCSyIeoAQ89pTyDLTzEvKvkJd8NZBCN61Ak9q', ''),
(4, 'privvardasca', 'luisvardasca@gmail.com', '$2y$10$xj.qTy1Hi1QFxuFm5Cfi0.gzIf6zlBdxIOvkHbJuD5XOwfCKNf/k2', 'default_profile.png');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`id_avaliacao`);

--
-- Índices para tabela `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulo`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id_avaliacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
