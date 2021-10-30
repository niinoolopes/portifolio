CREATE TABLE `usuario_cargo` (
  `CARGO_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `CARGO_NOME` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`CARGO_ID`),
  UNIQUE KEY `usuario_cargo_CARGO_NOME_unique` (`CARGO_NOME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `usuario_tipo` (
  `TIPO_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `NOME` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`TIPO_ID`),
  UNIQUE KEY `usuario_tipo_NOME_unique` (`NOME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `usuario` (
  `USUARIO_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `NOME` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CARGO_NOME` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NOME` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EMAIL` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SENHA` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`USUARIO_ID`),
  UNIQUE KEY `usuario_EMAIL_unique` (`EMAIL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `vendedor` (
  `VENDEDOR_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `NOME` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`VENDEDOR_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `vendedor` (`NOME`, `created_at`, `updated_at`) VALUES ('JOÃO', '2020-04-24 00:00:01', '2020-04-24 00:00:01');


CREATE TABLE `pedido_status` (
  `PEDIDO_STATUS_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `PEDIDO_STATUS_DESCRICAO` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`PEDIDO_STATUS_ID`),
  UNIQUE KEY `pedido_status_pedido_status_descricao_unique` (`PEDIDO_STATUS_DESCRICAO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `banco` (
  `BANCO_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `NOME` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SITE` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CODIGO` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `LOGO` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`BANCO_ID`),
  UNIQUE KEY `banco_NOME_unique` (`NOME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `cliente` (
  `CLIENTE_ID` INT NOT NULL,
  `CLIENTE_NOME` VARCHAR(100) NULL,
  `CLIENTE_COR` VARCHAR(45) NULL,
  PRIMARY KEY (`CLIENTE_ID`));
