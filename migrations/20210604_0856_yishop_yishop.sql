-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.24 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para yishop
CREATE DATABASE IF NOT EXISTS `yishop` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `yishop`;

-- Volcando estructura para tabla yishop.categoria
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `con_talla` tinyint(1) NOT NULL,
  `principal` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla yishop.categoria: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` (`id`, `nombre`, `con_talla`, `principal`) VALUES
	(1, 'Mujer', 0, 1),
	(2, 'Hombre', 0, 1),
	(3, 'Niños', 0, 1),
	(4, 'Accesorios', 0, 1),
	(5, 'Camisetas', 1, 0),
	(6, 'Vestidos', 1, 0),
	(7, 'Pantalones', 1, 0);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;

-- Volcando estructura para tabla yishop.categorias_productos
CREATE TABLE IF NOT EXISTS `categorias_productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2AA1DD383397707A` (`categoria_id`),
  KEY `IDX_2AA1DD387645698E` (`producto_id`),
  CONSTRAINT `FK_2AA1DD383397707A` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`),
  CONSTRAINT `FK_2AA1DD387645698E` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla yishop.categorias_productos: ~12 rows (aproximadamente)
/*!40000 ALTER TABLE `categorias_productos` DISABLE KEYS */;
INSERT INTO `categorias_productos` (`id`, `categoria_id`, `producto_id`) VALUES
	(35, 4, 4),
	(36, 5, 2),
	(37, 1, 2),
	(38, 1, 1),
	(39, 6, 1),
	(43, 2, 5),
	(44, 5, 5),
	(45, 1, 6),
	(46, 7, 6),
	(47, 2, 7),
	(48, 5, 7),
	(50, 4, 3);
/*!40000 ALTER TABLE `categorias_productos` ENABLE KEYS */;

-- Volcando estructura para tabla yishop.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nacionalidad` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_postal` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_50FE07D7E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla yishop.clientes: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` (`id`, `email`, `roles`, `password`, `dni`, `nombre`, `apellidos`, `direccion`, `telefono`, `nacionalidad`, `codigo_postal`, `creado`, `is_verified`) VALUES
	(1, 'linying520520@gmail.com', '["ROLE_USER"]', '$argon2id$v=19$m=65536,t=4,p=1$SUdKcUxvWlVPbDdzWXJUWA$9GpQLUx0+GiQ9J3cxRARvGu8eGhuWZDsMw3pzBojZS0', '18998701B', 'Ying512', 'Lin', 'Calle Rafaela 9', '654517789', 'china', '29009', '2021-05-25 22:06:29', 1),
	(13, 'aaaaaaa@gmail.com', '["ROLE_USER"]', '$argon2id$v=19$m=65536,t=4,p=1$NzVHclNFWHhzTy5PdC52Zw$HpYZbkw3DEJcPN6rAznw9S/hxnDCcgZKuaJc4hERORI', '18998701B', 'Ying', 'Lin', 'calle Santiago', '654517789', 'china', '29004', '2021-05-30 17:22:46', 1),
	(14, 'prueba@gmail.com', '["ROLE_USER"]', '$argon2id$v=19$m=65536,t=4,p=1$TXhGdG5BZFQ2ei8xV0RzeA$yc+bgCRjEpthNqEqdcQpJE6WECKcUnJnZiG9F6Jf6sM', '18998701B', 'prueba', 'prueba prueba', 'calle prueba 25', '657890123', 'china', '29004', '2021-06-03 22:28:30', 0);
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

-- Volcando estructura para tabla yishop.detalle_pedido
CREATE TABLE IF NOT EXISTS `detalle_pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) NOT NULL,
  `precio_unidad` int(11) NOT NULL,
  `idPedido` int(11) DEFAULT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `talla` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_detalle_pedido_productos` (`idProducto`),
  KEY `FK_detalle_pedido_pedidos` (`idPedido`),
  CONSTRAINT `FK_A834F569A7FDBE54` FOREIGN KEY (`idPedido`) REFERENCES `pedidos` (`id`),
  CONSTRAINT `FK_A834F569F4182C4E` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla yishop.detalle_pedido: ~11 rows (aproximadamente)
/*!40000 ALTER TABLE `detalle_pedido` DISABLE KEYS */;
INSERT INTO `detalle_pedido` (`id`, `cantidad`, `precio_unidad`, `idPedido`, `idProducto`, `talla`) VALUES
	(1, 1, 2000, 6, 5, 's'),
	(2, 1, 2000, 6, 5, 'l'),
	(3, 2, 300, 9, 4, 'sin talla'),
	(4, 1, 1700, 9, 1, 'm'),
	(5, 1, 1000, 10, 3, 'sin talla'),
	(6, 1, 2995, 11, 6, 's'),
	(7, 1, 1500, 11, 7, 'l'),
	(8, 3, 1500, 11, 7, 's'),
	(9, 1, 300, 12, 4, 'sin talla'),
	(10, 1, 1500, 12, 2, 'm'),
	(11, 1, 1000, 12, 3, 'sin talla'),
	(12, 1, 300, 13, 4, 'sin talla'),
	(13, 1, 1500, 13, 2, 'xl');
/*!40000 ALTER TABLE `detalle_pedido` ENABLE KEYS */;

-- Volcando estructura para tabla yishop.doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla yishop.doctrine_migration_versions: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20210417190012', '2021-04-17 19:01:08', 687),
	('DoctrineMigrations\\Version20210417190859', '2021-04-17 19:09:09', 67),
	('DoctrineMigrations\\Version20210417191858', '2021-04-17 19:19:10', 168),
	('DoctrineMigrations\\Version20210428234156', '2021-04-29 01:42:19', 306),
	('DoctrineMigrations\\Version20210510232132', '2021-05-10 23:22:26', 268),
	('DoctrineMigrations\\Version20210516182642', '2021-05-16 18:28:10', 428),
	('DoctrineMigrations\\Version20210518231715', '2021-05-18 23:17:31', 559),
	('DoctrineMigrations\\Version20210525210524', '2021-05-25 21:06:20', 241),
	('DoctrineMigrations\\Version20210530180537', '2021-05-30 18:06:25', 418),
	('DoctrineMigrations\\Version20210601214255', '2021-06-01 21:47:50', 284);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;

-- Volcando estructura para tabla yishop.imagenes_producto
CREATE TABLE IF NOT EXISTS `imagenes_producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) DEFAULT NULL,
  `ruta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre_original` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7852D3337645698E` (`producto_id`),
  CONSTRAINT `FK_7852D3337645698E` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla yishop.imagenes_producto: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `imagenes_producto` DISABLE KEYS */;
INSERT INTO `imagenes_producto` (`id`, `producto_id`, `ruta`, `creado`, `actualizado`, `nombre_original`) VALUES
	(5, 1, 'alexander-jawfox-GNd5gstTSg8-unsplash.jpg', '2021-05-15 23:21:13', '2021-05-18 23:03:10', 'alexander-jawfox-GNd5gstTSg8-unsplash.jpg'),
	(6, 2, 'david-suarez-ZPoRsYK2r-M-unsplash.jpg', '2021-05-15 23:49:02', '2021-05-15 23:49:02', 'david-suarez-ZPoRsYK2r-M-unsplash.jpg'),
	(7, 3, 'bright-red-purse-with-gold.jpg', '2021-05-16 00:12:40', '2021-05-16 00:12:40', 'bright-red-purse-with-gold.jpg'),
	(8, 4, 'reflective-sunglasses.jpg', '2021-05-16 00:19:45', '2021-05-16 00:19:45', 'reflective-sunglasses.jpg'),
	(10, 5, 'creating-a-brand-xcQWU0Eff-U-unsplash.jpg', '2021-05-16 23:14:53', '2021-05-16 23:18:03', 'creating-a-brand-xcQWU0Eff-U-unsplash.jpg'),
	(11, 1, 'victoria-volkova-otspad1fbzk-unsplash-60b02fdb03132951673541.jpg', '2021-05-27 23:48:40', '2021-05-27 23:48:43', 'victoria-volkova-OtSpaD1FBzk-unsplash.jpg'),
	(12, 6, 'h-f-e-co-mjijlvopxmm-unsplash-60b6acacccd4a416890247.jpg', '2021-06-01 21:54:52', '2021-06-01 21:54:52', 'h-f-e-co-MjIJLVoPxmM-unsplash.jpg');
/*!40000 ALTER TABLE `imagenes_producto` ENABLE KEYS */;

-- Volcando estructura para tabla yishop.pedidos
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_postal` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idCliente` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_pedidos_clientes` (`idCliente`),
  CONSTRAINT `FK_6716CCAAE4A5F0D7` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla yishop.pedidos: ~9 rows (aproximadamente)
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` (`id`, `fecha`, `estado`, `direccion`, `codigo_postal`, `idCliente`) VALUES
	(3, '2021-06-02 00:21:46', 'en proceso', '<div>calle rafaela</div>', '29009', 13),
	(4, '2021-06-02 14:19:42', 'enviado', '<div>rwetg3wga 4 32tgq 43 t</div>', '29009', 1),
	(5, '2021-06-02 14:30:40', 'recibido', '<div>64wsu456uw w64u w6 w</div>', '29009', 1),
	(6, '2021-06-03 18:24:00', 'en proceso', 'Calle Rafaela 9', '29009', 1),
	(9, '2021-06-03 18:31:46', 'en proceso', 'Calle Rafaela 9', '29009', 1),
	(10, '2021-06-03 20:34:05', 'en proceso', 'Calle Rafaela 9', '29009', 1),
	(11, '2021-06-03 23:34:04', 'en proceso', 'Calle Rafaela 9', '29009', 1),
	(12, '2021-06-04 02:08:44', 'en proceso', 'calle prueba 25', '29004', 14),
	(13, '2021-06-04 02:13:48', 'en proceso', 'calle prueba 25', '29004', 14);
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;

-- Volcando estructura para tabla yishop.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` int(11) NOT NULL,
  `peso` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `creado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `xl` int(11) DEFAULT NULL,
  `l` int(11) DEFAULT NULL,
  `m` int(11) DEFAULT NULL,
  `s` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla yishop.productos: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` (`id`, `url`, `nombre`, `descripcion`, `precio`, `peso`, `cantidad`, `activo`, `creado`, `actualizado`, `xl`, `l`, `m`, `s`) VALUES
	(1, 'vestido-de-muslo-con-abertura-de-espalda', 'Vestido de muslo con abertura de espalda', '<div><strong>VESTIDO MINI DE ESCOTE PICO Y TIRANTES ANCHOS. DETALLE DE ABERTURAS LATERALES EN CINTURA. BAJO ACABADO EN EVASÉ. CIERRE EN ESPALDA CON CREMALLERA OCULTA EN COSTURA.</strong></div><div><strong><br><br></strong><br></div>', 1700, 1, 55, 1, '2021-04-29 01:42:19', '2021-05-11 01:22:26', 15, 10, 20, 10),
	(2, 'camisa-denim', 'Camisa denim', '<div><strong>CAMISA DE CUELLO SOLAPA CON BOTONES Y MANGA LARGA ACABADA EN PUÑO. DETALLE DE PLIEGUE EN ESPALDA. CIERRE FRONTAL CON BOTONES.</strong></div>', 1500, 100, 50, 1, '2021-05-09 12:52:54', '2021-05-11 01:22:26', 6, 20, 12, 10),
	(3, 'bolso-bandolera-con-cadena', 'Bolso bandolera con cadena', '<div><strong>BOLSO DE HOMBRO DISPONIBLE EN ROJO. CUERPO Y SOLAPA ACOLCHADOS. ASA DE HOMBRO CON CADENA GRUESA. INTERIOR FORRADO CON BOLSILLO. CIERRE MEDIANTE IMÁN.<br><br>ALTO X ANCHO X FONDO: 20,5 X 29 X 5 CM.</strong></div>', 1000, 100, 87, 1, '2021-05-16 00:12:40', '2021-05-16 00:12:40', 0, 0, 0, 0),
	(4, 'gafas-de-sol-de-marco-metalico', 'Gafas de sol de marco metálico', '<div>GAFAS DE SOL CON MONTURA CUADRADA EN ACETATO. INCLUYE FUNDA.</div>', 300, 20, 43, 1, '2021-05-16 00:19:45', '2021-05-16 00:19:45', 0, 0, 0, 0),
	(5, 'camisa-botones-forrados', 'Camisa botones forrados', '<div><strong>CAMISA DE CUELLO SOLAPA CON MANGA LARGA. BAJO CON ABERTURAS LATERALES. CIERRE FRONTAL CON BOTONES.</strong></div>', 2000, 1, 60, 1, '2021-05-16 23:14:53', '2021-05-16 23:14:53', 20, 15, 15, 10),
	(6, 'jeans-rise-straight-roto', 'Jeans rise straight roto', '<div>JEANS DE TIRO ALTO Y PERNERA RECTA. CINCO BOLSILLOS Y EFECTO LAVADO. DETALLE DE ROTO EN LA RODILLA. BAJO</div>', 2995, 100, 50, 1, '2021-06-01 21:54:52', '2021-06-01 21:54:52', 10, 20, 10, 9),
	(7, 'producto-pocas-unidades', 'Producto pocas unidades', '<div>Le</div>', 1500, 1, 30, 1, '2021-06-03 20:38:14', '2021-06-03 20:38:14', 10, 0, 2, 2);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;

-- Volcando estructura para tabla yishop.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_EF687F22265B05D` (`usuario`),
  UNIQUE KEY `UNIQ_EF687F2E7927C74` (`email`),
  UNIQUE KEY `UNIQ_EF687F27F8F253B` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla yishop.usuarios: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id`, `usuario`, `roles`, `password`, `email`, `dni`, `activo`, `nombre`, `apellidos`, `creado`) VALUES
	(1, 'admin', '["ROLE_ADMIN"]', '$argon2id$v=19$m=65536,t=4,p=1$i0/JqQjEE1fe6h2VJuI0ww$vwxy4/5zdKYqRkxK8HDdeqyflKBjr1ii+p007LaGptI', 'email@admin.es', '12345678Q', 1, 'Administrador', 'Apellido1 Apellido2', '2021-04-17 21:28:44');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
