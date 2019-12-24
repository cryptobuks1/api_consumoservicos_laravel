INSERT INTO `clientes` (`id`, `nome`, `image`, `created_at`, `updated_at`) VALUES (1, 'MATEUS', '1028265cfe5afa20bfe.jpeg', '2019-06-10 10:28:26', '2019-06-10 10:28:26');
INSERT INTO `documentos` (`id`, `clientes_id`, `cpf_cnpj`, `created_at`, `updated_at`) VALUES (1, 1, '111.111.111-11', '2019-06-10 15:23:39', '2019-06-10 15:23:39');
INSERT INTO `telefones` (`id`, `clientes_id`, `numero`, `created_at`, `updated_at`) VALUES (1, 1, '(31)97177-7357', '2019-06-10 19:02:00', '2019-06-10 19:02:00');
INSERT INTO `filmes` (`id`, `titulo`, `capa`, `created_at`, `updated_at`) VALUES (1, 'ALIENÍGENAS DO PASSADO', '2113095cfef215a2c58.jpeg', '2019-06-10 21:13:09', '2019-06-10 21:13:09');
INSERT INTO `locacaos` (`id`, `clientes_id`, `filmes_id`, `data_locacao`, `created_at`, `updated_at`) VALUES (1, 1, 1, '2019-06-10', '2019-06-10 20:58:23', '2019-06-10 20:58:26');
