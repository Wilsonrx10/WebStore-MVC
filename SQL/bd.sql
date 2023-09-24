-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 31-Ago-2022 às 03:08
-- Versão do servidor: 10.1.36-MariaDB
-- versão do PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webstore`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admins`
--

CREATE TABLE `admins` (
  `id_admin` int(11) NOT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `senha` varchar(1000) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `admins`
--

INSERT INTO `admins` (`id_admin`, `usuario`, `senha`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin@gmail.com', '$2y$10$V1MCfhMQlDVlS0Z6nMrXvu16uluxGTLuu4PeZb3514QctCPKa3ixy', '2022-08-03 16:08:08', '2022-08-03 16:08:08', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(12) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `senha` varchar(150) DEFAULT NULL,
  `nome_completo` varchar(150) DEFAULT NULL,
  `morada` varchar(50) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `purl` varchar(50) DEFAULT NULL,
  `ativo` tinyint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `email`, `senha`, `nome_completo`, `morada`, `cidade`, `telefone`, `purl`, `ativo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'wilson@gmail.com', '$2y$10$4CPQOUACutXcNfh5m.orJO9I4SBFIKUSVwiV1uFHvm/KgFjYYjjJ2', 'Manuel', 'Luanda', 'Luanda', '943891258', 'MEtodjYDLzzr', 1, '2022-07-25 00:01:59', '2022-07-25 00:15:51', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `encomendas`
--

CREATE TABLE `encomendas` (
  `id_encomenda` int(11) UNSIGNED NOT NULL,
  `id_cliente` int(11) UNSIGNED DEFAULT NULL,
  `data_encomenda` datetime DEFAULT NULL,
  `morada` varchar(50) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `codigo_encomenda` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `mensagem` varchar(1000) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `encomendas`
--

INSERT INTO `encomendas` (`id_encomenda`, `id_cliente`, `data_encomenda`, `morada`, `cidade`, `email`, `telefone`, `codigo_encomenda`, `status`, `mensagem`, `created_at`, `updated_at`) VALUES
(1, 1, '2022-07-25 00:53:31', 'Luanda', 'Luanda', '943891258', 'wilson@gmail.com', 'YN331481', 'PENDENTE', '', '2022-07-25 00:53:31', '2022-07-25 00:53:31'),
(2, 1, '2022-08-03 23:22:08', 'Luanda', 'Luanda', '943891258', 'wilson@gmail.com', 'IA471997', 'PENDENTE', '', '2022-08-03 23:22:08', '2022-08-03 23:22:08'),
(3, 1, '2022-08-28 14:51:29', 'Luanda', 'Luanda', '943891258', 'wilson@gmail.com', 'NE120077', 'PENDENTE', '', '2022-08-28 14:51:29', '2022-08-28 14:51:29');

-- --------------------------------------------------------

--
-- Estrutura da tabela `encomenda_produto`
--

CREATE TABLE `encomenda_produto` (
  `id_encomenda_produto` int(12) UNSIGNED NOT NULL,
  `id_encomenda` int(12) UNSIGNED DEFAULT NULL,
  `designacao_produto` varchar(200) DEFAULT NULL,
  `preco_unidade` decimal(6,2) UNSIGNED DEFAULT NULL,
  `quantidade` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `encomenda_produto`
--

INSERT INTO `encomenda_produto` (`id_encomenda_produto`, `id_encomenda`, `designacao_produto`, `preco_unidade`, `quantidade`, `created_at`) VALUES
(1, 1, 'RTX 3060TI', '5000.00', 4, '2022-07-25 00:53:31'),
(2, 1, 'RTX 3060TI', '5000.00', 3, '2022-07-25 00:53:31'),
(3, 2, 'RTX 3060TI', '5000.00', 2, '2022-08-03 23:22:08'),
(4, 3, 'RTX 3060TI', '5000.00', 2, '2022-08-28 14:51:30'),
(5, 3, 'RTX 3060TI', '5000.00', 2, '2022-08-28 14:51:30'),
(6, 3, 'RTX 3060TI', '5000.00', 3, '2022-08-28 14:51:30'),
(7, 3, 'RTX 3060TI', '5000.00', 2, '2022-08-28 14:51:30');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id_produto` int(12) NOT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `nome_produto` varchar(50) DEFAULT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `imagem` varchar(200) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `stock` int(12) DEFAULT NULL,
  `visivel` tinyint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `categoria`, `nome_produto`, `descricao`, `imagem`, `preco`, `stock`, `visivel`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'gpu', 'RTX 3060TI', 'Nvidia GTX placa de qualidade , criada no Japão', 'placa01.jpg', '5000.00', 12, 1, '2022-07-22 13:00:19', '2022-07-22 13:00:18', NULL),
(2, 'gpu', 'RTX 3060TI', 'Nvidia GTX placa de qualidade , criada no Japão', 'placa02.jpg', '5000.00', 12, 1, '2022-07-22 13:00:20', '2022-07-22 13:00:21', NULL),
(3, 'gpu', 'RTX 3060TI', 'Nvidia GTX placa de qualidade , criada no Japão', 'placa03.jpg', '5000.00', 12, 1, '2022-07-22 13:00:22', '2022-07-22 13:00:23', NULL),
(4, 'gpu', 'RTX 3060TI', 'Nvidia GTX placa de qualidade , criada no Japão', 'placa04.jpg', '5000.00', 12, 1, '2022-07-22 13:00:24', '2022-07-22 13:00:24', NULL),
(5, 'gpu', 'RTX 3060TI', 'Nvidia GTX placa de qualidade , criada no Japão', 'placa05.jpg', '5000.00', 12, 1, '2022-07-22 13:00:25', '2022-07-22 13:00:25', NULL),
(6, 'gpu', 'RTX 3060TI', 'Nvidia GTX placa de qualidade , criada no Japão', 'placa06.jpg', '5000.00', 12, 1, '2022-07-22 13:00:26', '2022-07-22 13:00:26', NULL),
(7, 'gpu', 'RTX 3060TI', 'Nvidia GTX placa de qualidade , criada no Japão', 'placa02.jpg', '5000.00', 12, 1, '2022-07-22 13:00:27', '2022-07-22 13:00:27', NULL),
(8, 'gpu', 'RTX 3060TI', 'Nvidia GTX placa de qualidade , criada no Japão', 'placa03.jpg', '5000.00', 12, 1, '2022-07-22 13:00:29', '2022-07-22 13:00:29', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indexes for table `encomendas`
--
ALTER TABLE `encomendas`
  ADD PRIMARY KEY (`id_encomenda`) USING BTREE;

--
-- Indexes for table `encomenda_produto`
--
ALTER TABLE `encomenda_produto`
  ADD PRIMARY KEY (`id_encomenda_produto`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_produto`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `encomendas`
--
ALTER TABLE `encomendas`
  MODIFY `id_encomenda` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `encomenda_produto`
--
ALTER TABLE `encomenda_produto`
  MODIFY `id_encomenda_produto` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_produto` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
