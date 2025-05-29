-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29/05/2025 às 16:22
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bdcursei`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0000_00_00_000000_create_websockets_statistics_entries_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2025_04_19_172201_create_tb_admin_table', 1),
(4, '2025_04_19_172605_create_tb_user_table', 1),
(5, '2025_04_19_172606_create_tb_instituicao_table', 1),
(6, '2025_04_19_172911_create_tb_preferencia_table', 1),
(7, '2025_04_19_173053_create_tb_user_preferencia_table', 1),
(8, '2025_04_19_185734_create_tb_chat_table', 1),
(9, '2025_04_19_185735_create_tb_mensagem_table', 1),
(10, '2025_04_19_194332_create_tb_conteudo_curtei_table', 1),
(11, '2025_04_19_194333_create_tb_curtei_table', 1),
(12, '2025_04_19_194334_create_tb_post_table', 1),
(13, '2025_04_19_194335_create_tb_comentario_table', 1),
(14, '2025_04_19_195005_create_tb_resposta_comentario_table', 1),
(15, '2025_04_19_195149_create_tb_destaques_table', 1),
(16, '2025_04_19_195409_create_tb_storyes_table', 1),
(17, '2025_04_19_195626_create_tb_mencao_storyes_table', 1),
(18, '2025_04_19_195944_create_tb_planejamento_table', 1),
(19, '2025_04_19_200951_create_tb_denuncia_table', 1),
(20, '2025_04_19_201516_create_tb_curtida_table', 1),
(21, '2025_04_19_211801_create_tb_seguidores_table', 1),
(22, '2025_05_06_021214_create_tb_hashtag_table', 1),
(23, '2025_05_06_021343_create_tb_post_hashtag_table', 1),
(24, '2025_05_06_021604_create_tb_curtei_hashtag_table', 1),
(25, '2025_05_06_021743_create_tb_nao_interessado_post_table', 1),
(26, '2025_05_06_021847_create_tb_nao_interessado_curtei_table', 1),
(27, '2025_05_06_022041_create_tb_repostar_table', 1),
(28, '2025_05_06_022348_create_tb_visualizacao_curtei_table', 1),
(29, '2025_05_06_022530_create_tb_visualizacao_storyes_table', 1),
(30, '2025_05_06_022734_create_tb_visualizacao_post_table', 1),
(31, '2025_05_06_023730_create_tb_bloqueado_table', 1),
(32, '2025_05_06_023828_create_tb_compartilhar_post_table', 1),
(33, '2025_05_06_024110_create_tb_compartilhar_curtei_table', 1),
(34, '2025_05_06_024415_create_tb_grupo_table', 1),
(35, '2025_05_06_025035_create_tb_visualizacao_grupo_table', 1),
(36, '2025_05_06_025340_create_tb_notificacoes_table', 1),
(37, '2025_05_19_145244_create_tb_curtida_comentario', 1),
(38, '2025_05_21_170940_create_tb_canal_table', 1),
(39, '2025_05_21_171009_create_tb_membros_canal_table', 1),
(40, '2025_05_21_171016_create_tb_mensagem_canal_table', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome_admin` varchar(100) NOT NULL,
  `email_admin` varchar(100) NOT NULL,
  `password` varchar(300) NOT NULL,
  `token_admin` varchar(300) NOT NULL,
  `img_admin` varchar(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_bloqueado`
--

CREATE TABLE `tb_bloqueado` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user_bloqueado` bigint(20) UNSIGNED NOT NULL,
  `id_user_bloqueando` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_canal`
--

CREATE TABLE `tb_canal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome_canal` varchar(100) NOT NULL,
  `descricao_canal` longtext NOT NULL,
  `imagem_canal` varchar(300) NOT NULL,
  `user_criador_canal` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_chat`
--

CREATE TABLE `tb_chat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user1` bigint(20) UNSIGNED NOT NULL,
  `id_user2` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_comentario`
--

CREATE TABLE `tb_comentario` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `comentario` varchar(255) NOT NULL,
  `status_comentario` tinyint(1) NOT NULL,
  `id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `id_post` bigint(20) UNSIGNED DEFAULT NULL,
  `id_curtei` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_comentario`
--

INSERT INTO `tb_comentario` (`id`, `comentario`, `status_comentario`, `id_user`, `id_post`, `id_curtei`, `created_at`, `updated_at`) VALUES
(1, 'Mano tava numa situação parecida contigo faz um tempinho. Mas seguinte, pega algo pra focar e se esforçar naquilo. Estuda prum vestibular ou pra faculdade, mas pega algo pra fazer seu tempo valer mano, melhor dica é cê não ficar parado.', 1, 4, 84, NULL, '2025-05-29 13:33:48', '2025-05-29 13:33:48');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_compartilhar_curtei`
--

CREATE TABLE `tb_compartilhar_curtei` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_mensagem` bigint(20) UNSIGNED NOT NULL,
  `id_curtei` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_compartilhar_post`
--

CREATE TABLE `tb_compartilhar_post` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_mensagem` bigint(20) UNSIGNED NOT NULL,
  `id_post` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_conteudo_curtei`
--

CREATE TABLE `tb_conteudo_curtei` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `conteudo_curtei_1` varchar(255) DEFAULT NULL,
  `conteudo_curtei_2` varchar(255) DEFAULT NULL,
  `conteudo_curtei_3` varchar(255) DEFAULT NULL,
  `conteudo_curtei_4` varchar(255) DEFAULT NULL,
  `conteudo_curtei_5` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_curtei`
--

CREATE TABLE `tb_curtei` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `caminho_curtei` varchar(255) NOT NULL,
  `caminho_curtei_thumb` varchar(255) NOT NULL,
  `legenda_curtei` varchar(220) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_curtei_hashtag`
--

CREATE TABLE `tb_curtei_hashtag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_hashtag` bigint(20) UNSIGNED NOT NULL,
  `id_curtei` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_curtida`
--

CREATE TABLE `tb_curtida` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status_curtida` tinyint(1) NOT NULL,
  `id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `id_post` bigint(20) UNSIGNED DEFAULT NULL,
  `id_storyes` bigint(20) UNSIGNED DEFAULT NULL,
  `id_curtei` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_curtida`
--

INSERT INTO `tb_curtida` (`id`, `status_curtida`, `id_user`, `id_post`, `id_storyes`, `id_curtei`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 31, NULL, NULL, '2025-05-29 13:56:31', '2025-05-29 13:56:31'),
(2, 1, 3, 31, NULL, NULL, '2025-05-29 13:56:31', '2025-05-29 13:56:31'),
(3, 1, 5, 31, NULL, NULL, '2025-05-29 13:56:31', '2025-05-29 13:56:31'),
(4, 1, 7, 31, NULL, NULL, '2025-05-29 13:56:31', '2025-05-29 13:56:31'),
(5, 1, 1, 32, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(6, 1, 4, 32, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(7, 1, 6, 32, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(8, 1, 8, 32, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(9, 1, 10, 32, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(10, 1, 2, 33, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(11, 1, 9, 33, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(12, 1, 1, 34, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(13, 1, 3, 34, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(14, 1, 5, 34, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(15, 1, 6, 34, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(16, 1, 7, 34, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(17, 1, 8, 34, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(18, 1, 10, 34, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(19, 1, 2, 35, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(20, 1, 4, 35, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(21, 1, 9, 35, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(22, 1, 1, 36, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(23, 1, 3, 36, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(24, 1, 5, 36, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(25, 1, 7, 36, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(26, 1, 2, 37, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(27, 1, 4, 37, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(28, 1, 6, 37, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(29, 1, 8, 37, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(30, 1, 10, 37, NULL, NULL, '2025-05-29 13:56:32', '2025-05-29 13:56:32'),
(31, 1, 1, 38, NULL, NULL, '2025-05-29 13:56:33', '2025-05-29 13:56:33'),
(32, 1, 3, 38, NULL, NULL, '2025-05-29 13:56:33', '2025-05-29 13:56:33'),
(33, 1, 5, 38, NULL, NULL, '2025-05-29 13:56:33', '2025-05-29 13:56:33'),
(34, 1, 7, 38, NULL, NULL, '2025-05-29 13:56:33', '2025-05-29 13:56:33'),
(35, 1, 9, 38, NULL, NULL, '2025-05-29 13:56:33', '2025-05-29 13:56:33'),
(36, 1, 2, 39, NULL, NULL, '2025-05-29 13:56:33', '2025-05-29 13:56:33'),
(37, 1, 4, 39, NULL, NULL, '2025-05-29 13:56:33', '2025-05-29 13:56:33'),
(38, 1, 6, 39, NULL, NULL, '2025-05-29 13:56:33', '2025-05-29 13:56:33'),
(39, 1, 8, 39, NULL, NULL, '2025-05-29 13:56:33', '2025-05-29 13:56:33'),
(40, 1, 1, 40, NULL, NULL, '2025-05-29 13:56:33', '2025-05-29 13:56:33'),
(41, 1, 3, 40, NULL, NULL, '2025-05-29 13:56:33', '2025-05-29 13:56:33'),
(42, 1, 5, 40, NULL, NULL, '2025-05-29 13:56:33', '2025-05-29 13:56:33'),
(43, 1, 7, 40, NULL, NULL, '2025-05-29 13:56:33', '2025-05-29 13:56:33'),
(44, 1, 9, 40, NULL, NULL, '2025-05-29 13:56:33', '2025-05-29 13:56:33'),
(45, 1, 1, 41, NULL, NULL, '2025-05-29 13:56:33', '2025-05-29 13:56:33'),
(46, 1, 6, 42, NULL, NULL, '2025-05-29 13:56:33', '2025-05-29 13:56:33'),
(47, 1, 8, 43, NULL, NULL, '2025-05-29 13:56:33', '2025-05-29 13:56:33'),
(48, 1, 3, 44, NULL, NULL, '2025-05-29 13:56:33', '2025-05-29 13:56:33'),
(49, 1, 5, 45, NULL, NULL, '2025-05-29 13:56:33', '2025-05-29 13:56:33'),
(50, 1, 4, 84, NULL, NULL, '2025-05-29 13:56:48', '2025-05-29 13:56:48'),
(51, 1, 2, 34, NULL, NULL, '2025-05-29 14:05:19', '2025-05-29 14:05:19'),
(52, 1, 1, 21, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(53, 1, 2, 21, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(54, 1, 3, 21, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(55, 1, 4, 21, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(56, 1, 5, 21, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(57, 1, 6, 21, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(58, 1, 7, 21, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(59, 1, 8, 21, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(60, 1, 9, 21, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(61, 1, 10, 21, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(62, 1, 11, 21, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(63, 1, 1, 22, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(64, 1, 2, 22, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(65, 1, 3, 22, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(66, 1, 4, 22, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(67, 1, 5, 22, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(68, 1, 6, 22, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(69, 1, 7, 22, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(70, 1, 8, 22, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(71, 1, 9, 22, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(72, 1, 10, 22, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(73, 1, 1, 23, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(74, 1, 2, 23, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(75, 1, 3, 23, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(76, 1, 4, 23, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(77, 1, 5, 23, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(78, 1, 6, 23, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(79, 1, 7, 23, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(80, 1, 8, 23, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(81, 1, 9, 23, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(82, 1, 10, 23, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(83, 1, 11, 23, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(84, 1, 1, 24, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(85, 1, 2, 24, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(86, 1, 3, 24, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(87, 1, 4, 24, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(88, 1, 5, 24, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(89, 1, 6, 24, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(90, 1, 7, 24, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(91, 1, 8, 24, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(92, 1, 9, 24, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(93, 1, 1, 25, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(94, 1, 2, 25, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(95, 1, 3, 25, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(96, 1, 4, 25, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(97, 1, 5, 25, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(98, 1, 6, 25, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(99, 1, 7, 25, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(100, 1, 8, 25, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(101, 1, 9, 25, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(102, 1, 1, 26, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(103, 1, 2, 26, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(104, 1, 3, 26, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(105, 1, 4, 26, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(106, 1, 5, 26, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(107, 1, 6, 26, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(108, 1, 7, 26, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(109, 1, 8, 26, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(110, 1, 9, 26, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(111, 1, 10, 26, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(112, 1, 11, 26, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(113, 1, 1, 27, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(114, 1, 2, 27, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(115, 1, 3, 27, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(116, 1, 4, 27, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(117, 1, 5, 27, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(118, 1, 6, 27, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(119, 1, 7, 27, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(120, 1, 8, 27, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(121, 1, 9, 27, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(122, 1, 10, 27, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(123, 1, 1, 28, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(124, 1, 2, 28, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(125, 1, 3, 28, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(126, 1, 4, 28, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(127, 1, 5, 28, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(128, 1, 6, 28, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(129, 1, 7, 28, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(130, 1, 8, 28, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(131, 1, 9, 28, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(132, 1, 10, 28, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(133, 1, 11, 28, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(134, 1, 1, 29, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(135, 1, 2, 29, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(136, 1, 3, 29, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(137, 1, 4, 29, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(138, 1, 5, 29, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(139, 1, 6, 29, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(140, 1, 7, 29, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(141, 1, 8, 29, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(142, 1, 9, 29, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(143, 1, 10, 29, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(144, 1, 11, 29, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(145, 1, 1, 30, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(146, 1, 2, 30, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(147, 1, 3, 30, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(148, 1, 4, 30, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(149, 1, 5, 30, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(150, 1, 6, 30, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(151, 1, 7, 30, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(152, 1, 8, 30, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(153, 1, 9, 30, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(154, 1, 10, 30, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31'),
(155, 1, 11, 30, NULL, NULL, '2025-05-29 14:15:31', '2025-05-29 14:15:31');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_curtida_comentario`
--

CREATE TABLE `tb_curtida_comentario` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_comentario` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_curtida_comentario`
--

INSERT INTO `tb_curtida_comentario` (`id`, `id_user`, `id_comentario`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2025-05-29 13:38:14', '2025-05-29 13:38:14');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_denuncia`
--

CREATE TABLE `tb_denuncia` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `motivo_denuncia` varchar(255) NOT NULL,
  `descricao_denuncia` longtext DEFAULT NULL,
  `id_user_denunciador` bigint(20) UNSIGNED DEFAULT NULL,
  `id_user_denunciado` bigint(20) UNSIGNED DEFAULT NULL,
  `id_post_denunciado` bigint(20) UNSIGNED DEFAULT NULL,
  `id_storyes_denunciado` bigint(20) UNSIGNED DEFAULT NULL,
  `id_curtei_denunciado` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_destaques`
--

CREATE TABLE `tb_destaques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `data_destaques` date NOT NULL,
  `status_destaques` tinyint(1) NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_grupo`
--

CREATE TABLE `tb_grupo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome_grupo` varchar(100) NOT NULL,
  `descricao_grupo` longtext DEFAULT NULL,
  `imagem_grupo` varchar(300) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_hashtag`
--

CREATE TABLE `tb_hashtag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomeHashtag` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_hashtag`
--

INSERT INTO `tb_hashtag` (`id`, `nomeHashtag`, `created_at`, `updated_at`) VALUES
(1, '#inscricoesabertas', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(2, '#fatec2025', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(3, '#vestibular', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(4, '#graduacao', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(5, '#oportunidade', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(6, '#fatec', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(7, '#isenção', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(8, '#naodeixepradepois', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(9, '#senai', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(10, '#cursosgratuitos', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(11, '#profissionalizante', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(12, '#curso', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(13, '#carreira', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(14, '#tecnico', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(15, '#aprendizagem', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(16, '#sesi', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(17, '#educacao', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(18, '#formacaoprofissional', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(19, '#enap', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(20, '#inovacao', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(21, '#evento', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(22, '#capacitacao', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(23, '#gestaopublica', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(24, '#bolsadeestudos', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(25, '#etec', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(26, '#tecnologia', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(27, '#vestibulinho', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(28, '#cursostecnicos', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(29, '#ensinomedio', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(30, '#dicas', '2025-05-29 12:41:00', '2025-05-29 12:41:00'),
(31, '#perdido', '2025-05-29 12:56:37', '2025-05-29 12:56:37'),
(32, '#dica', '2025-05-29 12:56:37', '2025-05-29 12:56:37'),
(33, '#duvida', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(34, '#cursostecnicos', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(35, '#senai', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(36, '#dica', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(37, '#processoseletivo', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(38, '#vestibular', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(39, '#ajuda', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(40, '#programacao', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(41, '#java', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(42, '#autodidata', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(43, '#estudo', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(44, '#vestibulinho', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(45, '#nota', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(46, '#mecatronica', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(47, '#redacao', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(48, '#frontend', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(49, '#webdev', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(50, '#htmlcss', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(51, '#iot', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(52, '#tecnologia', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(53, '#workshop', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(54, '#carreira', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(55, '#ti', '2025-05-29 13:20:23', '2025-05-29 13:20:23'),
(56, '#estagio', '2025-05-29 13:20:23', '2025-05-29 13:20:23');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_instituicao`
--

CREATE TABLE `tb_instituicao` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome_representante` varchar(100) DEFAULT NULL,
  `telefone` varchar(25) DEFAULT NULL,
  `documentos_representante` varchar(25) DEFAULT NULL,
  `cnpj_instituicao` varchar(18) NOT NULL,
  `verificado_instituicao` tinyint(1) NOT NULL,
  `logradouro_instituicao` varchar(255) NOT NULL,
  `num_logradouro_instituicao` varchar(50) NOT NULL,
  `bairro_instituicao` varchar(255) NOT NULL,
  `cidade_instituicao` varchar(255) NOT NULL,
  `estado_instituicao` varchar(2) NOT NULL,
  `cep_instituicao` varchar(9) NOT NULL,
  `complemento_instituicao` varchar(255) DEFAULT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_instituicao`
--

INSERT INTO `tb_instituicao` (`id`, `nome_representante`, `telefone`, `documentos_representante`, `cnpj_instituicao`, `verificado_instituicao`, `logradouro_instituicao`, `num_logradouro_instituicao`, `bairro_instituicao`, `cidade_instituicao`, `estado_instituicao`, `cep_instituicao`, `complemento_instituicao`, `id_user`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, '12.345.678/0001-90', 1, 'Rua das Flores', '123', 'Centro', 'São Paulo', 'SP', '01001-000', 'Próximo à praça', 21, '2025-04-27 03:39:15', '2025-04-27 03:39:15'),
(2, NULL, NULL, NULL, '98.765.432/0001-11', 1, 'Avenida Principal', '456', 'Jardim das Palmeiras', 'Rio de Janeiro', 'RJ', '20000-000', 'Sala 101', 22, '2025-04-27 03:39:15', '2025-04-27 03:39:15'),
(3, NULL, NULL, NULL, '11.222.333/0001-44', 1, 'Travessa das Oliveiras', '789', 'Bela Vista', 'Belo Horizonte', 'MG', '30000-000', 'Fundos', 23, '2025-04-27 03:39:15', '2025-04-27 03:39:15'),
(4, NULL, NULL, NULL, '55.666.777/0001-22', 1, 'Alameda dos Anjos', '101', 'Vila Nova', 'Curitiba', 'PR', '80000-000', 'Casa 2', 24, '2025-04-27 03:39:15', '2025-04-27 03:39:15'),
(5, NULL, NULL, NULL, '88.999.000/0001-55', 1, 'R. Feliciano de Mendonça, 290 ', '321', 'Guaianases', 'São Paulo', 'SP', '40000-000', 'Próximo a praça da glória', 25, '2025-04-27 03:39:15', '2025-04-27 03:39:15');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_membros_canal`
--

CREATE TABLE `tb_membros_canal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_canal` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_mencao_storyes`
--

CREATE TABLE `tb_mencao_storyes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user_mencionado` bigint(20) UNSIGNED NOT NULL,
  `id_storyes` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_mensagem`
--

CREATE TABLE `tb_mensagem` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `conteudo_mensagem` longtext DEFAULT NULL,
  `status_mensagem` tinyint(1) NOT NULL,
  `img_mensagem` varchar(300) DEFAULT NULL,
  `id_user_enviador` bigint(20) UNSIGNED NOT NULL,
  `id_chat` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_mensagem_canal`
--

CREATE TABLE `tb_mensagem_canal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `conteudo_mensagem_canal` longtext NOT NULL,
  `img_mensagem_canal` varchar(300) NOT NULL,
  `id_user_enviador` bigint(20) UNSIGNED NOT NULL,
  `id_canal` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_nao_interessado_curtei`
--

CREATE TABLE `tb_nao_interessado_curtei` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_curtei` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_nao_interessado_post`
--

CREATE TABLE `tb_nao_interessado_post` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_post` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_notificacoes`
--

CREATE TABLE `tb_notificacoes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descricao_notificacao` varchar(200) NOT NULL,
  `titulo_notificacao` varchar(100) NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_planejamento`
--

CREATE TABLE `tb_planejamento` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome_planejamento` varchar(100) NOT NULL,
  `data_inicio_planejamento` date NOT NULL,
  `data_fim_planejamento` date NOT NULL,
  `status_planejamento` tinyint(1) NOT NULL,
  `id_post` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_post`
--

CREATE TABLE `tb_post` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status_post` tinyint(1) NOT NULL,
  `titulo_post` varchar(150) DEFAULT NULL,
  `conteudo_post` varchar(36) DEFAULT NULL,
  `descricao_post` varchar(255) DEFAULT NULL,
  `area_post` enum('Tecnologia','Saúde','Design','Artes','Engenharia','Esportes','Ciências','Línguas','Administração','Marketing','Nutrição','indefinido') NOT NULL DEFAULT 'indefinido',
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `repost_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_post`
--

INSERT INTO `tb_post` (`id`, `status_post`, `titulo_post`, `conteudo_post`, `descricao_post`, `area_post`, `id_user`, `repost_id`, `created_at`, `updated_at`) VALUES
(21, 1, 'Inscrições abertas para a Fatec!', 'FatecInscricoes.jpg', 'Inscrições abertas para a Fatec. Veja o calendário e se prepare para ingressar no ensino superior! #inscricoesabertas #fatec2025 #vestibular #graduacao #oportunidade', 'Ciências', 21, NULL, '2025-04-27 01:42:29', '2025-04-27 01:42:29'),
(22, 1, 'Período de isenção da FATEC', 'FatecIsencao.png', 'Aproveite o período de isenção antes que acabe! #fatec #fatec2025 #isencao #vestibular #inscricoesabertas #naodeixepradepois #oportunidade', 'indefinido', 21, NULL, '2025-04-27 01:48:59', '2025-04-27 01:48:59'),
(23, 1, 'Inscrições abertas pro SENAI!', 'SenaiInscricoes.jpeg', 'Inscrições abertas para os cursos gratuitos do Senai! Comece o ano investindo no seu crescimento. #senai #cursosgratuitos #inscricoesabertas #profissionalizante #oportunidade', 'Tecnologia', 22, NULL, '2025-04-27 01:57:02', '2025-04-27 01:57:02'),
(24, 1, 'Dicas para o processo seletivo do SENAI', 'SenaiDica.png', 'Faça uma formação profissionalizante de qualidade e garanta seu futuro! #senai #curso #carreira #tecnico #oportunidade #aprendizagem', 'indefinido', 22, NULL, '2025-04-27 02:03:17', '2025-04-27 02:03:17'),
(25, 1, 'Inscrições do SESI abertas!', 'SesiInscricoes.png', 'Acesse o SESI e confira a disponibilidade de vagas para cursos técnicos e profissionalizantes. #sesi #inscricoesabertas #curso #educacao #profissionalizante #formacaoprofissional', 'Esportes', 23, NULL, '2025-04-27 02:12:55', '2025-04-27 02:12:55'),
(26, 1, 'Não perca o prazo do SESI!', 'SesiNaoEsqueca.jpg', 'As inscrições de 2025 ainda estão abertas. Garanta sua vaga! #sesi #curso #inscricoesabertas #naodeixepradepois #oportunidade', 'indefinido', 23, NULL, '2025-04-27 02:16:45', '2025-04-27 02:16:45'),
(27, 1, 'Semana de Inovação da ENAP', 'EnapSemanaInovacao.png', 'As inscrições estão abertas para a Semana de Inovação! Participe desse grande evento. #enap #inscricoesabertas #inovacao #evento #capacitacao #gestaopublica', 'Tecnologia', 24, NULL, '2025-04-27 02:20:30', '2025-04-27 02:20:30'),
(28, 1, 'Bolsa de Estudos na ENAP', 'EnapBolsaEstudo.png', 'A seleção para bolsa de estudos começou. Não perca essa chance! #enap #bolsadeestudos #capacitacao #oportunidade #gestaopublica', 'indefinido', 24, NULL, '2025-04-27 02:32:46', '2025-04-27 02:32:46'),
(29, 1, 'Inscrições abertas na ETEC!', 'EtecInscricoes.jpg', 'Atenção candidatos do Vestibulinho! Inscrições abertas para cursos técnicos e ensino médio. #etec #inscricoesabertas #tecnologia #vestibular #vestibulinho #cursostecnicos #ensinomedio #oportunidade', 'Tecnologia', 25, NULL, '2025-04-27 00:58:29', '2025-04-27 00:58:29'),
(30, 1, 'Manual do Candidato ETEC', 'EtecManual.png', 'Leia o manual do candidato e evite erros na sua inscrição! #etec #vestibulinho #dicas #vestibulinho  #inscricoesabertas #naodeixepradepois', 'indefinido', 25, NULL, '2025-04-27 01:39:34', '2025-04-27 01:39:34'),
(31, 1, NULL, NULL, 'Galera, tô em dúvida entre ADS e Desenvolvimento de Sistemas na ETEC. Alguém que já fez pode me dizer as diferenças? #duvida #cursostecnicos', 'Tecnologia', 1, NULL, '2025-05-29 13:10:35', '2025-05-29 13:10:35'),
(32, 0, NULL, NULL, 'Quem vai fazer prova pro SENAI: não subestimem a parte de raciocínio lógico! Treinem com provas antigas #senai #dica #processoseletivo', 'Engenharia', 2, NULL, '2025-05-29 13:10:35', '2025-05-29 13:22:26'),
(33, 1, NULL, NULL, 'Gente, esqueci de pedir isenção pro vestibulinho 😭 Alguém sabe se tem segunda chamada ou outro jeito? #fatec #vestibular #ajuda', 'indefinido', 3, NULL, '2025-05-29 13:10:36', '2025-05-29 13:10:36'),
(34, 1, NULL, '1748525384_683861485009d.jpg', 'Depois de 3 meses estudando todo dia, consegui fazer meu primeiro projeto completo em Java! Quem quiser dicas de onde começar, me chama na DM #programacao #python #autodidata #estudo', 'Engenharia', 4, NULL, '2025-05-29 13:10:36', '2025-05-29 13:29:44'),
(35, 1, NULL, NULL, 'Alguém tem ideia de qual costuma ser a nota de corte pra ADS na FATEC de Ferraz? #vestibulinho #etec #duvida #nota', 'Tecnologia', 5, NULL, '2025-05-29 13:10:36', '2025-05-29 13:10:36'),
(36, 1, NULL, NULL, 'To querendo me preparar pro curso de Mecatrônica no SENAI. Alguém indica livros bons de elétrica básica? #senai #mecatronica #estudo', 'Engenharia', 6, NULL, '2025-05-29 13:10:36', '2025-05-29 13:10:36'),
(37, 1, NULL, NULL, 'Quem vai fazer a FATEC: na redação foquem em temas atuais de tecnologia e sociedade! Caíram nos últimos 3 anos #fatec #vestibular #dica #redacao', 'Tecnologia', 7, NULL, '2025-05-29 13:10:36', '2025-05-29 13:10:36'),
(38, 1, NULL, NULL, 'Depois de tanto sofrer, finalmente consegui fazer meu primeiro site que funciona bem no celular! CSS é magia pura 😅 #frontend #webdev #htmlcss #programacao', 'Tecnologia', 8, NULL, '2025-05-29 13:10:36', '2025-05-29 13:10:36'),
(39, 1, NULL, NULL, 'Tem um workshop gratuito de Internet das Coisas no SESI semana que vem! Já me inscrevi, quem mais vai? #sesi #iot #tecnologia #workshop', 'Tecnologia', 9, NULL, '2025-05-29 13:10:36', '2025-05-29 13:10:36'),
(40, 1, NULL, NULL, 'Galera do TI: vale mais a pena fazer estágio durante o técnico ou esperar entrar na facul? #carreira #ti #duvida #estagio', 'Administração', 10, NULL, '2025-05-29 13:10:36', '2025-05-29 13:10:36'),
(41, 1, NULL, NULL, '🔥 GANHE R$10.000 EM 7 DIAS! Curso exclusivo revela o segredo que as faculdades não ensinam! Garanta já seu link na bio! #dinheirorapido #fiqueRICO #oportunidade', 'indefinido', 11, NULL, '2025-05-29 13:44:50', '2025-05-29 13:44:50'),
(42, 1, NULL, NULL, '📜 EMITA SEU DIPLOMA EM 24H! Sem estudo, sem prova! Valido em todo Brasil. Chama no WhatsApp: (11) 98765-4321 #facil #diploma #sucesso', 'indefinido', 11, NULL, '2025-05-29 13:44:50', '2025-05-29 13:44:50'),
(43, 0, NULL, NULL, '👨‍💻 APRENDA HACKING EM 3 DIAS! Acesse qualquer rede social, descubra senhas e domine sistemas! Promoção por tempo limitado! #hacker #cursoexplosivo #tecnologia', 'Tecnologia', 11, NULL, '2025-05-29 13:44:50', '2025-05-29 13:44:50'),
(44, 0, NULL, NULL, '💊 PÍLULA DO APRENDIZADO! Memorize tudo em 1 semana! Compre agora e ganhe certificado grátis! #estudo #aprendizado #produtomilagroso', 'Saúde', 11, NULL, '2025-05-29 13:44:50', '2025-05-29 13:50:10'),
(45, 1, NULL, NULL, '🎓 PULE A FACULDADE! Tenha acesso a todos os certificados ETEC/FATEC por apenas R$99,90! Aprovação 100% garantida! #faculdade #certificado #atalho', 'indefinido', 11, NULL, '2025-05-29 13:44:50', '2025-05-29 13:44:50'),
(84, 1, NULL, NULL, 'Bom, terminei o ensino médio agora e tô perdido. Alguém q já passou por isso ou sla, sabe como é isso, tem alguma dica ou conselho doq eu possa fazer? #perdido #dica', 'indefinido', 2, NULL, '2025-05-29 12:56:37', '2025-05-29 12:56:37'),
(88, 1, NULL, NULL, 'Orgulho desse mano, cara é mto focado e responsa pprt', 'indefinido', 2, 34, '2025-05-29 14:10:22', '2025-05-29 14:10:22');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_post_hashtag`
--

CREATE TABLE `tb_post_hashtag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_hashtag` bigint(20) UNSIGNED NOT NULL,
  `id_post` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_post_hashtag`
--

INSERT INTO `tb_post_hashtag` (`id`, `id_hashtag`, `id_post`, `created_at`, `updated_at`) VALUES
(1, 1, 21, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(2, 2, 21, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(3, 3, 21, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(4, 4, 21, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(5, 5, 21, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(6, 6, 22, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(7, 2, 22, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(8, 7, 22, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(9, 3, 22, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(10, 1, 22, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(11, 8, 22, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(12, 5, 22, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(13, 9, 23, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(14, 10, 23, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(15, 1, 23, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(16, 11, 23, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(17, 5, 23, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(18, 9, 24, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(19, 12, 24, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(20, 13, 24, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(21, 14, 24, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(22, 5, 24, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(23, 15, 24, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(24, 16, 25, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(25, 1, 25, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(26, 12, 25, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(27, 17, 25, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(28, 11, 25, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(29, 18, 25, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(30, 16, 26, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(31, 12, 26, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(32, 1, 26, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(33, 8, 26, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(34, 5, 26, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(35, 19, 27, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(36, 1, 27, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(37, 20, 27, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(38, 21, 27, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(39, 22, 27, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(40, 23, 27, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(41, 19, 28, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(42, 24, 28, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(43, 22, 28, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(44, 5, 28, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(45, 23, 28, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(46, 25, 29, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(47, 1, 29, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(48, 26, 29, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(49, 3, 29, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(50, 27, 29, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(51, 28, 29, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(52, 29, 29, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(53, 5, 29, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(54, 25, 30, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(55, 27, 30, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(56, 30, 30, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(57, 27, 30, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(58, 1, 30, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(59, 8, 30, '2025-05-29 12:44:18', '2025-05-29 12:44:18'),
(60, 31, 84, '2025-05-29 12:56:37', '2025-05-29 12:56:37'),
(61, 32, 84, '2025-05-29 12:56:37', '2025-05-29 12:56:37'),
(62, 33, 31, '2025-05-29 13:21:23', '2025-05-29 13:21:23'),
(63, 34, 31, '2025-05-29 13:21:23', '2025-05-29 13:21:23'),
(64, 35, 32, '2025-05-29 13:21:23', '2025-05-29 13:21:23'),
(65, 36, 32, '2025-05-29 13:21:23', '2025-05-29 13:21:23'),
(66, 37, 32, '2025-05-29 13:21:23', '2025-05-29 13:21:23'),
(67, 38, 33, '2025-05-29 13:21:24', '2025-05-29 13:21:24'),
(68, 39, 33, '2025-05-29 13:21:24', '2025-05-29 13:21:24'),
(69, 40, 34, '2025-05-29 13:21:24', '2025-05-29 13:21:24'),
(70, 41, 34, '2025-05-29 13:21:24', '2025-05-29 13:21:24'),
(71, 42, 34, '2025-05-29 13:21:24', '2025-05-29 13:21:24'),
(72, 43, 34, '2025-05-29 13:21:24', '2025-05-29 13:21:24'),
(73, 33, 35, '2025-05-29 13:21:24', '2025-05-29 13:21:24'),
(74, 44, 35, '2025-05-29 13:21:24', '2025-05-29 13:21:24'),
(75, 45, 35, '2025-05-29 13:21:24', '2025-05-29 13:21:24'),
(76, 35, 36, '2025-05-29 13:21:24', '2025-05-29 13:21:24'),
(77, 46, 36, '2025-05-29 13:21:24', '2025-05-29 13:21:24'),
(78, 43, 36, '2025-05-29 13:21:24', '2025-05-29 13:21:24'),
(79, 38, 37, '2025-05-29 13:21:24', '2025-05-29 13:21:24'),
(80, 36, 37, '2025-05-29 13:21:24', '2025-05-29 13:21:24'),
(81, 47, 37, '2025-05-29 13:21:24', '2025-05-29 13:21:24'),
(82, 48, 38, '2025-05-29 13:21:25', '2025-05-29 13:21:25'),
(83, 49, 38, '2025-05-29 13:21:25', '2025-05-29 13:21:25'),
(84, 50, 38, '2025-05-29 13:21:25', '2025-05-29 13:21:25'),
(85, 40, 38, '2025-05-29 13:21:25', '2025-05-29 13:21:25'),
(86, 51, 39, '2025-05-29 13:21:25', '2025-05-29 13:21:25'),
(87, 52, 39, '2025-05-29 13:21:25', '2025-05-29 13:21:25'),
(88, 53, 39, '2025-05-29 13:21:25', '2025-05-29 13:21:25'),
(89, 33, 40, '2025-05-29 13:21:25', '2025-05-29 13:21:25'),
(90, 54, 40, '2025-05-29 13:21:25', '2025-05-29 13:21:25'),
(91, 55, 40, '2025-05-29 13:21:25', '2025-05-29 13:21:25'),
(92, 56, 40, '2025-05-29 13:21:25', '2025-05-29 13:21:25');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_preferencia`
--

CREATE TABLE `tb_preferencia` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome_preferencia` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_repostar`
--

CREATE TABLE `tb_repostar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `desc_repostar` varchar(500) NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_post` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_resposta_comentario`
--

CREATE TABLE `tb_resposta_comentario` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `resposta_comentario` varchar(255) NOT NULL,
  `status_resposta_comentario` tinyint(1) NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_comentario` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_seguidores`
--

CREATE TABLE `tb_seguidores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user_seguido` bigint(20) UNSIGNED NOT NULL,
  `id_user_seguidor` bigint(20) UNSIGNED NOT NULL,
  `status_seguidores` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_storyes`
--

CREATE TABLE `tb_storyes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `conteudo_storyes` varchar(255) NOT NULL,
  `data_inicio` date NOT NULL,
  `status_storyes` tinyint(1) NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_user`
--

CREATE TABLE `tb_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome_user` varchar(100) NOT NULL,
  `email_user` varchar(100) NOT NULL,
  `senha_user` varchar(100) NOT NULL,
  `img_user` varchar(300) DEFAULT NULL,
  `banner_user` varchar(300) DEFAULT NULL,
  `token_user` varchar(300) DEFAULT NULL,
  `status_user` tinyint(1) NOT NULL,
  `bio_user` longtext DEFAULT NULL,
  `arroba_user` varchar(30) NOT NULL,
  `dois_fatores_user` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_user`
--

INSERT INTO `tb_user` (`id`, `nome_user`, `email_user`, `senha_user`, `img_user`, `banner_user`, `token_user`, `status_user`, `bio_user`, `arroba_user`, `dois_fatores_user`, `created_at`, `updated_at`) VALUES
(1, 'Guilherme', 'guilherme0@gmail.com', '$2y$10$QuKXZEcWqvfoxIWUbPf9x.v1yMIdMnnSi9ZbfY4etYCrC9dmgDxj2', 'default1.png', 'default_banner1.png', 'SkCVnCBnM0yup9rS7y1scPyZx49Q43dWIEhNS39Q', 1, 'Olá, eu sou Guilherme!', 'guilherme0', 0, '2025-04-27 03:39:14', '2025-04-27 03:39:14'),
(2, 'Rian', 'rian1@gmail.com', '$2y$10$FWW7MJ3g09OveKUrEHgDn.i8DQiobzqyqw7Veso56/sC4BSdDQ0H.', 'default2.jpg', 'banner_1748525923.jpeg', 'SAaBtQYHK2Xm4pjynXBSQrDWr9KpSkXLrdQerf0I', 1, 'Olá, eu sou Rian!', 'rian1', 0, '2025-04-27 03:39:14', '2025-05-29 13:38:43'),
(3, 'Breno', 'breno2@gmail.com', '$2y$10$jLio6rij5QMXz7qEIzbpDe7KykThM5sYtd969MOODNmGGLOTN.hf.', 'default3.png', 'default_banner3.png', '1DgMWJ6AP9LbSTwzrv54oiDmEUHzbk5mrYc5BmAK', 1, 'Olá, eu sou Breno!', 'breno2', 0, '2025-04-27 03:39:14', '2025-04-27 03:39:14'),
(4, 'Hugo', 'hugo3@gmail.com', '$2y$10$5LtYPZETzoM0vtcfKff3q.0VRs7vqSHlVVMlOJxKCMGMwQ0/bjKiG', 'default4.png', 'banner_1748525480.jpg', 'pBmW8f6hndPBAX9vZabMRrDrg7d0E60WFdukYVO9', 1, 'Olá, eu sou Hugo!', 'hugo3', 0, '2025-04-27 03:39:14', '2025-05-29 13:31:20'),
(5, 'Victor', 'victor4@gmail.com', '$2y$10$rDt8NODvpWvYLL5t9NlXH.fxwf7sX5.nDeIFJD2eonH/KRBa2KM76', 'default5.png', 'default_banner5.png', 'lVzijXWwfTKz2rln1iwm0eDGNzSAgDT6shcwCOuB', 1, 'Olá, eu sou Victor!', 'victor4', 0, '2025-04-27 03:39:14', '2025-04-27 03:39:14'),
(6, 'Eduardo', 'eduardo5@gmail.com', '$2y$10$LhyN3LyMqrKvl4C83A2dCu1aSa8BOsGXOXswyOvB18NoMA1GNu312', 'default6.png', 'default_banner6.png', 'uf8ZdikVTQ6OoW4FZOBW72M6EgvHKO1XjcJbojCn', 1, 'Olá, eu sou Eduardo!', 'eduardo5', 0, '2025-04-27 03:39:14', '2025-04-27 03:39:14'),
(7, 'Ellen', 'ellen6@gmail.com', '$2y$10$iA.86SSSxW2ZIYrSpJb2VuFF9lLqIrR7RhEzmTBasFYqJoRsQ0fpa', 'default7.png', 'default_banner7.png', '0a5cVMXdoKa65VRtKizfWu0iLFkhemJOa9OgA7Hx', 1, 'Olá, eu sou Ellen!', 'ellen6', 0, '2025-04-27 03:39:14', '2025-04-27 03:39:14'),
(8, 'Caroline', 'caroline7@gmail.com', '$2y$10$N856YVxUt8zvLgnBDPaZgeHHr9PYkUZjaOmvmhIBHoFNCTAaJLWFO', 'default8.png', 'default_banner8.png', 'FgOU9SCpPHazg7KiWIzuOnr40oRtQ1Uort0fLZH8', 1, 'Olá, eu sou Caroline!', 'caroline7', 0, '2025-04-27 03:39:14', '2025-04-27 03:39:14'),
(9, 'Felipe', 'felipe8@gmail.com', '$2y$10$81oECzcI34ceVRRrRuFRW.dwe5PQob4GNxzSlbgYfBpY093l7ys6S', 'default9.png', 'default_banner9.png', 'zyOLALXbxAwhmE8skNxQeTU8FbeViJm454lEMKlx', 1, 'Olá, eu sou Felipe!', 'felipe8', 0, '2025-04-27 03:39:14', '2025-04-27 03:39:14'),
(10, 'Klayver', 'klayver9@gmail.com', '$2y$10$aCMItXkvqkJ8QX3XGOJmp.fpCxsWyWs7g8Qfl/7IF9uq09RUovyZC', 'default10.png', 'default_banner10.png', 'kYptLDV0MbWZH3AIYYC51o5xVW4TKg5bJpmsfupn', 1, 'Olá, eu sou Klayver!', 'klayver9', 0, '2025-04-27 03:39:14', '2025-04-27 03:39:14'),
(11, 'Dr. Cursos Express', 'doutorcursos@gmail.com', '$2y$10$TRQajfJ7Fn/usOPGl/ikq.HrO1G8YpW5EmHDKCUjArCqawZ3/hvgu', 'profile_1748526105.jpeg', 'banner_1748526105.jpeg', '6W6Vz1tMkoLKtETYWoo9fL7K2pXgsz4YSAXDZXzK', 1, '🤑 Empreendedor Digital | Mentor de Riqueza Express | Ajudo você a ganhar dinheiro sem esforço! Cursos Exclusivos | Diplomas Rápidos | Métodos Não-Convencionais 🚀 DM aberta para parcerias!', 'o alencar10', 0, '2025-04-27 03:39:14', '2025-05-29 13:41:45'),
(21, 'Fatec', 'fatec20@gmail.com', '$2y$10$CncHu.zPR849kljwQHqMBupzQGTidosJncQcHlJ3nO3J2d4tkITLS', 'default21.png', 'default_banner21.png', 'nmU8Q8WKO4pbObkt2jtSmIq0FrLJLpgcBGIU3SWc', 1, 'Olá, eu sou Fatec!', 'fatec20', 0, '2025-04-27 03:39:15', '2025-04-27 03:39:15'),
(22, 'Senai', 'senai21@gmail.com', '$2y$10$rEJFGUb02SF4TOoNv5nM/eFBMPLYmxFKOFbTwtlsZwZu.BD1SUruu', 'default22.png', 'default_banner22.png', '3UORPsl5uQwWDD6ZlrIsS7SWB0DDqJVOjTzxKfLy', 1, 'Olá, eu sou Senai!', 'senai21', 0, '2025-04-27 03:39:15', '2025-04-27 03:39:15'),
(23, 'SESI', 'sesi22@gmail.com', '$2y$10$m9kCTRNcbd81cBZeghC1oe3uK6x4EMcCXVl1Di6VcGmq/pIt1Zwq.', 'default23.png', 'default_banner23.png', 'zeoibH0KLG5ZUJ5CCHkdW081vzRabdHt5rllJXlS', 1, 'Olá, eu sou SESI!', 'sesi22', 0, '2025-04-27 03:39:15', '2025-04-27 04:21:34'),
(24, 'Enap', 'enap23@gmail.com', '$2y$10$KTe1UtIvBkhjYBrsYrGsm.eIW8CkcNWFHH7gmKg9YBFQLQa9eo8N2', 'default24.png', 'default_banner24.png', 'OXNJMObSYYYt8oEH3xJcIqdvaGmJctqsdrKeNd3m', 1, 'Olá, eu sou Enap!', 'enap23', 0, '2025-04-27 03:39:15', '2025-04-27 03:39:15'),
(25, 'Etec de Guaianases', 'etec24@gmail.com', '$2y$10$KqQsEWB95xVgc1ceTK9lb.GyP3LTqle/o7kxGUahrt0lmrA9beqRO', '8531b4d9bc66e09526e17fbab01db96e', '131fa96e50395bd674dc7d2ba0c5239e', 'mllvEOnmFhziRy0pXW94u9NoiY7opECtNTapC5tv', 1, 'Olá, eu sou Etec!', 'etec24', 0, '2025-04-27 03:39:15', '2025-04-27 03:57:16');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_user_preferencia`
--

CREATE TABLE `tb_user_preferencia` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `preferencia` enum('Tecnologia','Saúde','Design','Artes','Engenharia','Esportes','Ciências','Línguas','Administração','Marketing','Nutrição','indefinido') NOT NULL DEFAULT 'indefinido',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_user_preferencia`
--

INSERT INTO `tb_user_preferencia` (`id`, `id_user`, `preferencia`, `created_at`, `updated_at`) VALUES
(5, 2, 'Tecnologia', '2025-05-29 02:41:15', '2025-05-29 02:41:15'),
(6, 4, 'Tecnologia', '2025-05-29 13:29:31', '2025-05-29 13:29:31'),
(7, 4, 'Esportes', '2025-05-29 13:29:31', '2025-05-29 13:29:31'),
(8, 4, 'Ciências', '2025-05-29 13:29:31', '2025-05-29 13:29:31'),
(9, 4, 'Administração', '2025-05-29 13:29:31', '2025-05-29 13:29:31'),
(10, 11, 'Esportes', '2025-05-29 13:40:01', '2025-05-29 13:40:01'),
(11, 11, 'Marketing', '2025-05-29 13:40:01', '2025-05-29 13:40:01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_visualizacao_curtei`
--

CREATE TABLE `tb_visualizacao_curtei` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `qtd_visualizacao_curtei` int(11) NOT NULL DEFAULT 0,
  `id_curtei` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_visualizacao_grupo`
--

CREATE TABLE `tb_visualizacao_grupo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status_visualizacao_grupo` tinyint(1) NOT NULL DEFAULT 0,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_visualizacao_post`
--

CREATE TABLE `tb_visualizacao_post` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `qtd_visualizacao_post` int(11) NOT NULL DEFAULT 0,
  `id_post` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_visualizacao_storyes`
--

CREATE TABLE `tb_visualizacao_storyes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `qtd_visualizacao_storyes` int(11) NOT NULL DEFAULT 0,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_storyes` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `websockets_statistics_entries`
--

CREATE TABLE `websockets_statistics_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` varchar(255) NOT NULL,
  `peak_connection_count` int(11) NOT NULL,
  `websocket_message_count` int(11) NOT NULL,
  `api_message_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Índices de tabela `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tb_admin_email_admin_unique` (`email_admin`),
  ADD UNIQUE KEY `tb_admin_token_admin_unique` (`token_admin`);

--
-- Índices de tabela `tb_bloqueado`
--
ALTER TABLE `tb_bloqueado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_bloqueado_id_user_bloqueado_foreign` (`id_user_bloqueado`),
  ADD KEY `tb_bloqueado_id_user_bloqueando_foreign` (`id_user_bloqueando`);

--
-- Índices de tabela `tb_canal`
--
ALTER TABLE `tb_canal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_canal_user_criador_canal_foreign` (`user_criador_canal`);

--
-- Índices de tabela `tb_chat`
--
ALTER TABLE `tb_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_chat_id_user1_foreign` (`id_user1`),
  ADD KEY `tb_chat_id_user2_foreign` (`id_user2`);

--
-- Índices de tabela `tb_comentario`
--
ALTER TABLE `tb_comentario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_comentario_id_user_foreign` (`id_user`),
  ADD KEY `tb_comentario_id_post_foreign` (`id_post`),
  ADD KEY `tb_comentario_id_curtei_foreign` (`id_curtei`);

--
-- Índices de tabela `tb_compartilhar_curtei`
--
ALTER TABLE `tb_compartilhar_curtei`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_compartilhar_curtei_id_mensagem_foreign` (`id_mensagem`),
  ADD KEY `tb_compartilhar_curtei_id_curtei_foreign` (`id_curtei`);

--
-- Índices de tabela `tb_compartilhar_post`
--
ALTER TABLE `tb_compartilhar_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_compartilhar_post_id_mensagem_foreign` (`id_mensagem`),
  ADD KEY `tb_compartilhar_post_id_post_foreign` (`id_post`);

--
-- Índices de tabela `tb_conteudo_curtei`
--
ALTER TABLE `tb_conteudo_curtei`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_curtei`
--
ALTER TABLE `tb_curtei`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_curtei_id_user_foreign` (`id_user`);

--
-- Índices de tabela `tb_curtei_hashtag`
--
ALTER TABLE `tb_curtei_hashtag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_curtei_hashtag_id_hashtag_foreign` (`id_hashtag`),
  ADD KEY `tb_curtei_hashtag_id_curtei_foreign` (`id_curtei`);

--
-- Índices de tabela `tb_curtida`
--
ALTER TABLE `tb_curtida`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_curtida_id_user_foreign` (`id_user`),
  ADD KEY `tb_curtida_id_post_foreign` (`id_post`),
  ADD KEY `tb_curtida_id_storyes_foreign` (`id_storyes`),
  ADD KEY `tb_curtida_id_curtei_foreign` (`id_curtei`);

--
-- Índices de tabela `tb_curtida_comentario`
--
ALTER TABLE `tb_curtida_comentario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_curtida_comentario_id_user_foreign` (`id_user`),
  ADD KEY `tb_curtida_comentario_id_comentario_foreign` (`id_comentario`);

--
-- Índices de tabela `tb_denuncia`
--
ALTER TABLE `tb_denuncia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_denuncia_id_user_denunciador_foreign` (`id_user_denunciador`),
  ADD KEY `tb_denuncia_id_user_denunciado_foreign` (`id_user_denunciado`),
  ADD KEY `tb_denuncia_id_post_denunciado_foreign` (`id_post_denunciado`),
  ADD KEY `tb_denuncia_id_storyes_denunciado_foreign` (`id_storyes_denunciado`),
  ADD KEY `tb_denuncia_id_curtei_denunciado_foreign` (`id_curtei_denunciado`);

--
-- Índices de tabela `tb_destaques`
--
ALTER TABLE `tb_destaques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_destaques_id_user_foreign` (`id_user`);

--
-- Índices de tabela `tb_grupo`
--
ALTER TABLE `tb_grupo`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_hashtag`
--
ALTER TABLE `tb_hashtag`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_instituicao`
--
ALTER TABLE `tb_instituicao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_instituicao_id_user_foreign` (`id_user`);

--
-- Índices de tabela `tb_membros_canal`
--
ALTER TABLE `tb_membros_canal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_membros_canal_id_canal_foreign` (`id_canal`),
  ADD KEY `tb_membros_canal_id_user_foreign` (`id_user`);

--
-- Índices de tabela `tb_mencao_storyes`
--
ALTER TABLE `tb_mencao_storyes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_mencao_storyes_id_user_mencionado_foreign` (`id_user_mencionado`),
  ADD KEY `tb_mencao_storyes_id_storyes_foreign` (`id_storyes`);

--
-- Índices de tabela `tb_mensagem`
--
ALTER TABLE `tb_mensagem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_mensagem_id_chat_foreign` (`id_chat`),
  ADD KEY `tb_mensagem_id_user_enviador_foreign` (`id_user_enviador`);

--
-- Índices de tabela `tb_mensagem_canal`
--
ALTER TABLE `tb_mensagem_canal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_mensagem_canal_id_user_enviador_foreign` (`id_user_enviador`),
  ADD KEY `tb_mensagem_canal_id_canal_foreign` (`id_canal`);

--
-- Índices de tabela `tb_nao_interessado_curtei`
--
ALTER TABLE `tb_nao_interessado_curtei`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_nao_interessado_curtei_id_user_foreign` (`id_user`),
  ADD KEY `tb_nao_interessado_curtei_id_curtei_foreign` (`id_curtei`);

--
-- Índices de tabela `tb_nao_interessado_post`
--
ALTER TABLE `tb_nao_interessado_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_nao_interessado_post_id_user_foreign` (`id_user`),
  ADD KEY `tb_nao_interessado_post_id_post_foreign` (`id_post`);

--
-- Índices de tabela `tb_notificacoes`
--
ALTER TABLE `tb_notificacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_notificacoes_id_user_foreign` (`id_user`);

--
-- Índices de tabela `tb_planejamento`
--
ALTER TABLE `tb_planejamento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_planejamento_id_post_foreign` (`id_post`);

--
-- Índices de tabela `tb_post`
--
ALTER TABLE `tb_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_post_id_user_foreign` (`id_user`),
  ADD KEY `tb_post_repost_id_foreign` (`repost_id`);

--
-- Índices de tabela `tb_post_hashtag`
--
ALTER TABLE `tb_post_hashtag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_post_hashtag_id_hashtag_foreign` (`id_hashtag`),
  ADD KEY `tb_post_hashtag_id_post_foreign` (`id_post`);

--
-- Índices de tabela `tb_preferencia`
--
ALTER TABLE `tb_preferencia`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_repostar`
--
ALTER TABLE `tb_repostar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_repostar_id_user_foreign` (`id_user`),
  ADD KEY `tb_repostar_id_post_foreign` (`id_post`);

--
-- Índices de tabela `tb_resposta_comentario`
--
ALTER TABLE `tb_resposta_comentario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_resposta_comentario_id_user_foreign` (`id_user`),
  ADD KEY `tb_resposta_comentario_id_comentario_foreign` (`id_comentario`);

--
-- Índices de tabela `tb_seguidores`
--
ALTER TABLE `tb_seguidores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_seguidores_id_user_seguido_foreign` (`id_user_seguido`),
  ADD KEY `tb_seguidores_id_user_seguidor_foreign` (`id_user_seguidor`);

--
-- Índices de tabela `tb_storyes`
--
ALTER TABLE `tb_storyes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_storyes_id_user_foreign` (`id_user`);

--
-- Índices de tabela `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tb_user_email_user_unique` (`email_user`),
  ADD UNIQUE KEY `tb_user_arroba_user_unique` (`arroba_user`),
  ADD UNIQUE KEY `tb_user_token_user_unique` (`token_user`);

--
-- Índices de tabela `tb_user_preferencia`
--
ALTER TABLE `tb_user_preferencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_user_preferencia_id_user_foreign` (`id_user`);

--
-- Índices de tabela `tb_visualizacao_curtei`
--
ALTER TABLE `tb_visualizacao_curtei`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_visualizacao_curtei_id_curtei_foreign` (`id_curtei`);

--
-- Índices de tabela `tb_visualizacao_grupo`
--
ALTER TABLE `tb_visualizacao_grupo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_visualizacao_grupo_id_user_foreign` (`id_user`);

--
-- Índices de tabela `tb_visualizacao_post`
--
ALTER TABLE `tb_visualizacao_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_visualizacao_post_id_post_foreign` (`id_post`);

--
-- Índices de tabela `tb_visualizacao_storyes`
--
ALTER TABLE `tb_visualizacao_storyes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_visualizacao_storyes_id_user_foreign` (`id_user`),
  ADD KEY `tb_visualizacao_storyes_id_storyes_foreign` (`id_storyes`);

--
-- Índices de tabela `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_bloqueado`
--
ALTER TABLE `tb_bloqueado`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_canal`
--
ALTER TABLE `tb_canal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_chat`
--
ALTER TABLE `tb_chat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_comentario`
--
ALTER TABLE `tb_comentario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_compartilhar_curtei`
--
ALTER TABLE `tb_compartilhar_curtei`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_compartilhar_post`
--
ALTER TABLE `tb_compartilhar_post`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_conteudo_curtei`
--
ALTER TABLE `tb_conteudo_curtei`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_curtei`
--
ALTER TABLE `tb_curtei`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_curtei_hashtag`
--
ALTER TABLE `tb_curtei_hashtag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_curtida`
--
ALTER TABLE `tb_curtida`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT de tabela `tb_curtida_comentario`
--
ALTER TABLE `tb_curtida_comentario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_denuncia`
--
ALTER TABLE `tb_denuncia`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_destaques`
--
ALTER TABLE `tb_destaques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_grupo`
--
ALTER TABLE `tb_grupo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_hashtag`
--
ALTER TABLE `tb_hashtag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de tabela `tb_instituicao`
--
ALTER TABLE `tb_instituicao`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tb_membros_canal`
--
ALTER TABLE `tb_membros_canal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_mencao_storyes`
--
ALTER TABLE `tb_mencao_storyes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_mensagem`
--
ALTER TABLE `tb_mensagem`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_mensagem_canal`
--
ALTER TABLE `tb_mensagem_canal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_nao_interessado_curtei`
--
ALTER TABLE `tb_nao_interessado_curtei`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_nao_interessado_post`
--
ALTER TABLE `tb_nao_interessado_post`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_notificacoes`
--
ALTER TABLE `tb_notificacoes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_planejamento`
--
ALTER TABLE `tb_planejamento`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_post`
--
ALTER TABLE `tb_post`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de tabela `tb_post_hashtag`
--
ALTER TABLE `tb_post_hashtag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT de tabela `tb_preferencia`
--
ALTER TABLE `tb_preferencia`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_repostar`
--
ALTER TABLE `tb_repostar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_resposta_comentario`
--
ALTER TABLE `tb_resposta_comentario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_seguidores`
--
ALTER TABLE `tb_seguidores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_storyes`
--
ALTER TABLE `tb_storyes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `tb_user_preferencia`
--
ALTER TABLE `tb_user_preferencia`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `tb_visualizacao_curtei`
--
ALTER TABLE `tb_visualizacao_curtei`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_visualizacao_grupo`
--
ALTER TABLE `tb_visualizacao_grupo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_visualizacao_post`
--
ALTER TABLE `tb_visualizacao_post`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_visualizacao_storyes`
--
ALTER TABLE `tb_visualizacao_storyes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tb_bloqueado`
--
ALTER TABLE `tb_bloqueado`
  ADD CONSTRAINT `tb_bloqueado_id_user_bloqueado_foreign` FOREIGN KEY (`id_user_bloqueado`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_bloqueado_id_user_bloqueando_foreign` FOREIGN KEY (`id_user_bloqueando`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_canal`
--
ALTER TABLE `tb_canal`
  ADD CONSTRAINT `tb_canal_user_criador_canal_foreign` FOREIGN KEY (`user_criador_canal`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_chat`
--
ALTER TABLE `tb_chat`
  ADD CONSTRAINT `tb_chat_id_user1_foreign` FOREIGN KEY (`id_user1`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_chat_id_user2_foreign` FOREIGN KEY (`id_user2`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_comentario`
--
ALTER TABLE `tb_comentario`
  ADD CONSTRAINT `tb_comentario_id_curtei_foreign` FOREIGN KEY (`id_curtei`) REFERENCES `tb_curtei` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_comentario_id_post_foreign` FOREIGN KEY (`id_post`) REFERENCES `tb_post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_comentario_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_compartilhar_curtei`
--
ALTER TABLE `tb_compartilhar_curtei`
  ADD CONSTRAINT `tb_compartilhar_curtei_id_curtei_foreign` FOREIGN KEY (`id_curtei`) REFERENCES `tb_curtei` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_compartilhar_curtei_id_mensagem_foreign` FOREIGN KEY (`id_mensagem`) REFERENCES `tb_mensagem` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_compartilhar_post`
--
ALTER TABLE `tb_compartilhar_post`
  ADD CONSTRAINT `tb_compartilhar_post_id_mensagem_foreign` FOREIGN KEY (`id_mensagem`) REFERENCES `tb_mensagem` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_compartilhar_post_id_post_foreign` FOREIGN KEY (`id_post`) REFERENCES `tb_post` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_curtei`
--
ALTER TABLE `tb_curtei`
  ADD CONSTRAINT `tb_curtei_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_curtei_hashtag`
--
ALTER TABLE `tb_curtei_hashtag`
  ADD CONSTRAINT `tb_curtei_hashtag_id_curtei_foreign` FOREIGN KEY (`id_curtei`) REFERENCES `tb_curtei` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_curtei_hashtag_id_hashtag_foreign` FOREIGN KEY (`id_hashtag`) REFERENCES `tb_hashtag` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_curtida`
--
ALTER TABLE `tb_curtida`
  ADD CONSTRAINT `tb_curtida_id_curtei_foreign` FOREIGN KEY (`id_curtei`) REFERENCES `tb_curtei` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_curtida_id_post_foreign` FOREIGN KEY (`id_post`) REFERENCES `tb_post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_curtida_id_storyes_foreign` FOREIGN KEY (`id_storyes`) REFERENCES `tb_storyes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_curtida_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_curtida_comentario`
--
ALTER TABLE `tb_curtida_comentario`
  ADD CONSTRAINT `tb_curtida_comentario_id_comentario_foreign` FOREIGN KEY (`id_comentario`) REFERENCES `tb_comentario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_curtida_comentario_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_denuncia`
--
ALTER TABLE `tb_denuncia`
  ADD CONSTRAINT `tb_denuncia_id_curtei_denunciado_foreign` FOREIGN KEY (`id_curtei_denunciado`) REFERENCES `tb_curtei` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_denuncia_id_post_denunciado_foreign` FOREIGN KEY (`id_post_denunciado`) REFERENCES `tb_post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_denuncia_id_storyes_denunciado_foreign` FOREIGN KEY (`id_storyes_denunciado`) REFERENCES `tb_storyes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_denuncia_id_user_denunciado_foreign` FOREIGN KEY (`id_user_denunciado`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_denuncia_id_user_denunciador_foreign` FOREIGN KEY (`id_user_denunciador`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_destaques`
--
ALTER TABLE `tb_destaques`
  ADD CONSTRAINT `tb_destaques_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_instituicao`
--
ALTER TABLE `tb_instituicao`
  ADD CONSTRAINT `tb_instituicao_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`);

--
-- Restrições para tabelas `tb_membros_canal`
--
ALTER TABLE `tb_membros_canal`
  ADD CONSTRAINT `tb_membros_canal_id_canal_foreign` FOREIGN KEY (`id_canal`) REFERENCES `tb_canal` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_membros_canal_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_mencao_storyes`
--
ALTER TABLE `tb_mencao_storyes`
  ADD CONSTRAINT `tb_mencao_storyes_id_storyes_foreign` FOREIGN KEY (`id_storyes`) REFERENCES `tb_storyes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_mencao_storyes_id_user_mencionado_foreign` FOREIGN KEY (`id_user_mencionado`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_mensagem`
--
ALTER TABLE `tb_mensagem`
  ADD CONSTRAINT `tb_mensagem_id_chat_foreign` FOREIGN KEY (`id_chat`) REFERENCES `tb_chat` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_mensagem_id_user_enviador_foreign` FOREIGN KEY (`id_user_enviador`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_mensagem_canal`
--
ALTER TABLE `tb_mensagem_canal`
  ADD CONSTRAINT `tb_mensagem_canal_id_canal_foreign` FOREIGN KEY (`id_canal`) REFERENCES `tb_canal` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_mensagem_canal_id_user_enviador_foreign` FOREIGN KEY (`id_user_enviador`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_nao_interessado_curtei`
--
ALTER TABLE `tb_nao_interessado_curtei`
  ADD CONSTRAINT `tb_nao_interessado_curtei_id_curtei_foreign` FOREIGN KEY (`id_curtei`) REFERENCES `tb_curtei` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_nao_interessado_curtei_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_nao_interessado_post`
--
ALTER TABLE `tb_nao_interessado_post`
  ADD CONSTRAINT `tb_nao_interessado_post_id_post_foreign` FOREIGN KEY (`id_post`) REFERENCES `tb_post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_nao_interessado_post_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_notificacoes`
--
ALTER TABLE `tb_notificacoes`
  ADD CONSTRAINT `tb_notificacoes_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_planejamento`
--
ALTER TABLE `tb_planejamento`
  ADD CONSTRAINT `tb_planejamento_id_post_foreign` FOREIGN KEY (`id_post`) REFERENCES `tb_post` (`id`);

--
-- Restrições para tabelas `tb_post`
--
ALTER TABLE `tb_post`
  ADD CONSTRAINT `tb_post_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_post_repost_id_foreign` FOREIGN KEY (`repost_id`) REFERENCES `tb_post` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_post_hashtag`
--
ALTER TABLE `tb_post_hashtag`
  ADD CONSTRAINT `tb_post_hashtag_id_hashtag_foreign` FOREIGN KEY (`id_hashtag`) REFERENCES `tb_hashtag` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_post_hashtag_id_post_foreign` FOREIGN KEY (`id_post`) REFERENCES `tb_post` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_repostar`
--
ALTER TABLE `tb_repostar`
  ADD CONSTRAINT `tb_repostar_id_post_foreign` FOREIGN KEY (`id_post`) REFERENCES `tb_post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_repostar_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_resposta_comentario`
--
ALTER TABLE `tb_resposta_comentario`
  ADD CONSTRAINT `tb_resposta_comentario_id_comentario_foreign` FOREIGN KEY (`id_comentario`) REFERENCES `tb_comentario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_resposta_comentario_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_seguidores`
--
ALTER TABLE `tb_seguidores`
  ADD CONSTRAINT `tb_seguidores_id_user_seguido_foreign` FOREIGN KEY (`id_user_seguido`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_seguidores_id_user_seguidor_foreign` FOREIGN KEY (`id_user_seguidor`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_storyes`
--
ALTER TABLE `tb_storyes`
  ADD CONSTRAINT `tb_storyes_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_user_preferencia`
--
ALTER TABLE `tb_user_preferencia`
  ADD CONSTRAINT `tb_user_preferencia_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_visualizacao_curtei`
--
ALTER TABLE `tb_visualizacao_curtei`
  ADD CONSTRAINT `tb_visualizacao_curtei_id_curtei_foreign` FOREIGN KEY (`id_curtei`) REFERENCES `tb_curtei` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_visualizacao_grupo`
--
ALTER TABLE `tb_visualizacao_grupo`
  ADD CONSTRAINT `tb_visualizacao_grupo_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_visualizacao_post`
--
ALTER TABLE `tb_visualizacao_post`
  ADD CONSTRAINT `tb_visualizacao_post_id_post_foreign` FOREIGN KEY (`id_post`) REFERENCES `tb_post` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tb_visualizacao_storyes`
--
ALTER TABLE `tb_visualizacao_storyes`
  ADD CONSTRAINT `tb_visualizacao_storyes_id_storyes_foreign` FOREIGN KEY (`id_storyes`) REFERENCES `tb_storyes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_visualizacao_storyes_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
