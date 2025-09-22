-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-09-2025 a las 00:03:29
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `technova`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atencioncliente`
--

CREATE TABLE `atencioncliente` (
  `ID_Atencion` int(11) NOT NULL,
  `ID_Usuario` int(11) NOT NULL,
  `Fecha_Consulta` datetime NOT NULL DEFAULT current_timestamp(),
  `Tema` varchar(150) NOT NULL,
  `Descripcion` text NOT NULL,
  `Estado` varchar(50) NOT NULL DEFAULT 'abierto',
  `Respuesta` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caracteristica`
--

CREATE TABLE `caracteristica` (
  `ID_Caracteristicas` int(11) NOT NULL,
  `Categoria` varchar(100) NOT NULL,
  `Color` varchar(100) NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `Precio_Compra` decimal(10,2) NOT NULL,
  `Precio_Venta` decimal(10,2) NOT NULL,
  `Marca` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `caracteristica`
--

INSERT INTO `caracteristica` (`ID_Caracteristicas`, `Categoria`, `Color`, `Descripcion`, `Precio_Compra`, `Precio_Venta`, `Marca`) VALUES
(6, 'Celulares', 'Rosado', NULL, 4000000.00, 5000000.00, 'Apple'),
(7, 'Celulares', 'Morado', '256 GB 4 GB RAM', 450000.00, 520000.00, 'Motorola'),
(8, 'Celulares', 'Rojo', '128 GB', 2500000.00, 3000000.00, 'Apple'),
(9, 'Celulares', 'Rojo', 'iPhone 14 128GB', 2500000.00, 3000000.00, 'Apple'),
(10, 'Celulares', 'Rojo', 'Xiaomi 14T Pro 12GB', 2500000.00, 3000000.00, 'Xiaomi');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caracteristicas`
--

CREATE TABLE `caracteristicas` (
  `ID_Caracteristicas` int(10) UNSIGNED NOT NULL,
  `Categoria` varchar(100) NOT NULL,
  `Color` varchar(100) NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `Precio_Compra` decimal(10,2) NOT NULL,
  `Precio_Venta` decimal(10,2) NOT NULL,
  `Marca` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `caracteristicas`
--

INSERT INTO `caracteristicas` (`ID_Caracteristicas`, `Categoria`, `Color`, `Descripcion`, `Precio_Compra`, `Precio_Venta`, `Marca`) VALUES
(6, 'Celulares', 'Rosado', NULL, 4000000.00, 5000000.00, 'Apple'),
(7, 'Celulares', 'Negro', 'Smartphone MOTOROLA G24', 450000.00, 520000.00, 'Motorola'),
(8, 'Celulares', 'Gris', NULL, 2500000.00, 3000000.00, 'Xiaomi'),
(9, 'Celulares', 'Morado', '256 GB 4 GB RAM', 450000.00, 520000.00, 'Motorola'),
(10, 'Celulares', 'Azul', '256gb 5g', 800000.00, 1000000.00, 'Motorola'),
(12, 'Celulares', 'Rojo', '128 GB', 2500000.00, 3000000.00, 'Apple'),
(14, 'Portátiles', 'Gris', NULL, 1500000.00, 1800000.00, 'Lenovo'),
(15, 'Portátiles', 'Gris', NULL, 1500000.00, 1800000.00, 'Lenovo'),
(16, 'Portátiles', 'Gris', NULL, 1500000.00, 1800000.00, 'Lenovo'),
(17, 'Portátiles', 'Gris', NULL, 1500000.00, 1800000.00, 'Lenovo'),
(18, 'Portátiles', 'Gris', NULL, 1500000.00, 1800000.00, 'Lenovo'),
(22, 'Celulares', 'b sbd', NULL, 152565.00, 363563.00, 'Motorola'),
(23, 'Celulares', 'bsbd', NULL, 152565.00, 363563.00, 'Motorola'),
(24, 'Celulares', 'bsbd', NULL, 152565.00, 363563.00, 'Motorola'),
(29, 'Celulares', 'Rosado', NULL, 1400000.00, 1500000.00, 'Apple'),
(31, 'Celulares', 'Rojo', 'Smartphone Xiaomi 14T Pro 12GB', 2500000.00, 3000000.00, 'Xiaomi'),
(32, 'Celulares', 'Rojo', 'iPhone 14 128GB', 2500000.00, 3000000.00, 'Apple');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `ID_Carrito` int(11) NOT NULL,
  `ID_Usuario` int(11) NOT NULL,
  `Fecha_Creacion` datetime NOT NULL,
  `Estado` varchar(50) NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`ID_Carrito`, `ID_Usuario`, `Fecha_Creacion`, `Estado`) VALUES
(1, 1, '2025-09-15 20:12:09', 'activo'),
(2, 2, '2025-09-15 20:13:29', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `ID_Compras` int(11) NOT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `ID_MedioDePago` int(11) DEFAULT NULL,
  `Total` decimal(10,2) DEFAULT NULL,
  `Estado` varchar(50) DEFAULT NULL,
  `Fecha_Compra` datetime DEFAULT NULL,
  `ID_Proveedor` int(11) DEFAULT NULL,
  `Fecha_De_Compra` datetime NOT NULL,
  `Tiempo_De_Entrega` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`ID_Compras`, `ID_Usuario`, `ID_MedioDePago`, `Total`, `Estado`, `Fecha_Compra`, `ID_Proveedor`, `Fecha_De_Compra`, `Tiempo_De_Entrega`) VALUES
(6, 2, 11, 5000000.00, 'cancelado', '2025-09-16 13:51:18', NULL, '2025-09-16 13:51:18', '2025-09-19 13:51:18'),
(7, 2, 12, 520000.00, 'cancelado', '2025-09-16 13:52:33', NULL, '2025-09-16 13:52:33', '2025-09-19 13:52:33'),
(8, 2, 13, 3000000.00, 'procesado', '2025-09-16 18:20:24', NULL, '2025-09-16 18:20:24', '2025-09-19 18:20:24'),
(9, 2, 14, 3000000.00, 'procesado', '2025-09-17 03:39:41', NULL, '2025-09-17 03:39:41', '2025-09-20 03:39:41'),
(10, 2, 15, 5000000.00, 'procesado', '2025-09-17 14:54:16', NULL, '2025-09-17 14:54:16', '2025-09-20 14:54:16'),
(11, 2, 16, 2000000.00, 'procesado', '2025-09-17 17:43:21', NULL, '2025-09-17 17:43:21', '2025-09-20 17:43:21'),
(12, 2, 17, 520000.00, 'procesado', '2025-09-17 19:40:49', NULL, '2025-09-17 19:40:49', '2025-09-20 19:40:49'),
(13, 2, 18, 5000000.00, 'procesado', '2025-09-19 21:16:20', NULL, '2025-09-19 21:16:20', '2025-09-22 21:16:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecarrito`
--

CREATE TABLE `detallecarrito` (
  `ID_DetalleCarrito` int(11) NOT NULL,
  `ID_Carrito` int(11) NOT NULL,
  `ID_Producto` int(10) UNSIGNED NOT NULL,
  `Cantidad` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallecarrito`
--

INSERT INTO `detallecarrito` (`ID_DetalleCarrito`, `ID_Carrito`, `ID_Producto`, `Cantidad`) VALUES
(1, 1, 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecompras`
--

CREATE TABLE `detallecompras` (
  `ID_DetalleCompras` int(11) NOT NULL,
  `ID_Compras` int(11) NOT NULL,
  `ID_Producto` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallecompras`
--

INSERT INTO `detallecompras` (`ID_DetalleCompras`, `ID_Compras`, `ID_Producto`, `Cantidad`, `Precio`) VALUES
(6, 6, 13, 1, 5000000.00),
(7, 7, 14, 1, 520000.00),
(8, 8, 15, 1, 3000000.00),
(9, 9, 16, 1, 3000000.00),
(10, 10, 13, 1, 5000000.00),
(11, 11, 17, 2, 1000000.00),
(12, 12, 14, 1, 520000.00),
(13, 13, 13, 1, 5000000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleventas`
--

CREATE TABLE `detalleventas` (
  `ID_DetalleVentas` int(11) NOT NULL,
  `ID_Ventas` int(11) NOT NULL,
  `ID_Producto` int(11) NOT NULL,
  `Cantidad` varchar(100) NOT NULL,
  `Precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalleventas`
--

INSERT INTO `detalleventas` (`ID_DetalleVentas`, `ID_Ventas`, `ID_Producto`, `Cantidad`, `Precio`) VALUES
(12, 17, 13, '1', 0.00),
(13, 18, 14, '1', 0.00),
(14, 19, 15, '1', 0.00),
(15, 20, 16, '1', 0.00),
(16, 21, 13, '1', 0.00),
(17, 22, 17, '1', 0.00),
(18, 23, 14, '1', 0.00),
(19, 24, 13, '1', 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio`
--

CREATE TABLE `envio` (
  `ID_Envio` int(11) NOT NULL,
  `Fecha_Envio` datetime NOT NULL,
  `Numero_Guia` decimal(10,2) NOT NULL,
  `ID_Ventas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `favoritos`
--

INSERT INTO `favoritos` (`id`, `user_id`, `producto_id`, `created_at`, `updated_at`) VALUES
(18, 2, 8, '2025-09-20 02:28:34', '2025-09-20 02:28:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mediodepago`
--

CREATE TABLE `mediodepago` (
  `ID_MedioDePago` int(11) NOT NULL,
  `Metodo_pago` varchar(50) NOT NULL,
  `ID_Pagos` int(11) NOT NULL,
  `ID_DetalleVentas` int(11) NOT NULL,
  `ID_Usuario` int(11) NOT NULL,
  `Fecha_De_Compra` datetime DEFAULT NULL,
  `Tiempo_De_Entrega` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mediodepago`
--

INSERT INTO `mediodepago` (`ID_MedioDePago`, `Metodo_pago`, `ID_Pagos`, `ID_DetalleVentas`, `ID_Usuario`, `Fecha_De_Compra`, `Tiempo_De_Entrega`) VALUES
(11, 'tarjeta_credito', 17, 12, 2, '2025-09-16 13:51:18', '2025-09-19 13:51:18'),
(12, 'nequi', 18, 13, 2, '2025-09-16 13:52:33', '2025-09-19 13:52:33'),
(13, 'nequi', 19, 14, 2, '2025-09-16 18:20:24', '2025-09-19 18:20:24'),
(14, 'nequi', 20, 15, 2, '2025-09-17 03:39:41', '2025-09-20 03:39:41'),
(15, 'nequi', 21, 16, 2, '2025-09-17 14:54:16', '2025-09-20 14:54:16'),
(16, 'nequi', 22, 17, 2, '2025-09-17 17:43:21', '2025-09-20 17:43:21'),
(17, 'tarjeta_credito', 23, 18, 2, '2025-09-17 19:40:49', '2025-09-20 19:40:49'),
(18, 'nequi', 24, 19, 2, '2025-09-19 21:16:20', '2025-09-22 21:16:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_07_051200_create_caracteristicas_table', 1),
(5, '2025_09_07_051251_create_producto_table', 1),
(6, '2025_09_07_051252_add_proveedor_to_producto_table', 2),
(7, '2025_09_08_000000_add_additional_fields_to_users_table', 2),
(9, '0001_01_01_000003_create_sessions_table', 3),
(10, '2025_09_10_000000_add_role_to_users_table', 3),
(11, '2025_09_15_040029_create_favoritos_table', 4),
(12, '2025_09_15_184743_create_favoritos_table', 5),
(13, '2025_09_16_000001_create_user_payment_methods_table', 6),
(14, '2025_09_16_000002_alter_user_payment_methods_add_details', 6),
(15, '2025_09_16_000003_alter_mediodepago_add_columns', 6),
(16, '2025_09_16_145242_add_ingreso_salida_to_producto_table', 7),
(19, '2025_09_16_150000_add_customer_purchase_fields_to_compras_table', 8),
(20, '2025_09_16_150001_ensure_compras_columns_exist', 9),
(21, '2025_09_16_150002_make_id_proveedor_nullable_in_compras', 10),
(22, '2025_09_18_005955_add_metodo_pago_and_is_default_to_user_payment_methods_table', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `ID_Pagos` int(11) NOT NULL,
  `Fecha_Pago` date NOT NULL,
  `Numero_Factura` varchar(50) NOT NULL,
  `Fecha_Factura` date NOT NULL,
  `Monto` decimal(10,2) NOT NULL,
  `Estado_Pago` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`ID_Pagos`, `Fecha_Pago`, `Numero_Factura`, `Fecha_Factura`, `Monto`, `Estado_Pago`) VALUES
(17, '2025-09-16', 'FAC-1758030678-2', '2025-09-16', 5000000.00, 'procesado'),
(18, '2025-09-16', 'FAC-1758030753-2', '2025-09-16', 520000.00, 'procesado'),
(19, '2025-09-16', 'FAC-1758046824-2', '2025-09-16', 3000000.00, 'procesado'),
(20, '2025-09-17', 'FAC-1758080380-2', '2025-09-17', 3000000.00, 'procesado'),
(21, '2025-09-17', 'FAC-1758120855-2', '2025-09-17', 5000000.00, 'procesado'),
(22, '2025-09-17', 'FAC-1758131001-2', '2025-09-17', 2000000.00, 'procesado'),
(23, '2025-09-17', 'FAC-1758138049-2', '2025-09-17', 520000.00, 'procesado'),
(24, '2025-09-19', 'FAC-1758316580-2', '2025-09-19', 5000000.00, 'procesado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `ID_Producto` int(10) UNSIGNED NOT NULL,
  `Codigo` varchar(50) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Imagen` varchar(255) DEFAULT NULL,
  `ID_Caracteristicas` int(10) UNSIGNED DEFAULT NULL,
  `Stock` int(10) UNSIGNED NOT NULL,
  `Proveedor` varchar(255) DEFAULT NULL,
  `Ingreso` int(11) DEFAULT 0,
  `Salida` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`ID_Producto`, `Codigo`, `Nombre`, `Imagen`, `ID_Caracteristicas`, `Stock`, `Proveedor`, `Ingreso`, `Salida`) VALUES
(6, '11', 'iPhone 16 128 GB', 'https://co.tiendasishop.com/cdn/shop/files/IMG-14858821_a2762325-3ee8-4bd1-870c-b16dfc4877b7.jpg?v=1726245580&width=823', 6, 3, NULL, 8, 5),
(8, 'HHHH', 'Xiaomi 14T Pro 12 GB', 'https://i02.appmifile.com/971_item_co/30/09/2024/32ea27394ad9513ec81639e1c517215e.png', 8, 19, NULL, 20, 1),
(9, 'mot41', 'MOTOROLA G24', 'https://exitocol.vtexassets.com/arquivos/ids/29078055/Celular-MOTOROLA-G24-256-GB-4-GB-RAM-Lavanda-3499944_f.jpg?v=638877915400670000', 9, 7, NULL, 9, 2),
(10, 'mo7', 'motorola edge 60 fusion', 'https://cdn.claro.com.co/imagenes/v9/catalogo/646x1000/70065257_7.jpg', 10, 12, NULL, 15, 3),
(12, 'aaa52', 'iPhone 14', 'https://http2.mlstatic.com/D_NQ_NP_782535-MLM51559386281_092022-O.webp', 12, 13, NULL, 15, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `ID_Producto` int(11) NOT NULL,
  `Codigo` varchar(50) DEFAULT NULL,
  `Nombre` varchar(100) DEFAULT NULL,
  `Imagen` varchar(255) DEFAULT NULL,
  `ID_Caracteristicas` int(11) DEFAULT NULL,
  `Stock` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`ID_Producto`, `Codigo`, `Nombre`, `Imagen`, `ID_Caracteristicas`, `Stock`) VALUES
(13, '11', 'iPhone 16 128 GB', 'https://co.tiendasishop.com/cdn/shop/files/IMG-14858821_a2762325-3ee8-4bd1-870c-b16dfc4877b7.jpg?v=1726245580&width=823', 6, 6),
(14, 'mot41', 'MOTOROLA G24', 'https://exitocol.vtexassets.com/arquivos/ids/29078055/Celular-MOTOROLA-G24-256-GB-4-GB-RAM-Lavanda-3499944_f.jpg?v=638877915400670000', 7, 10),
(15, 'aaa52', 'iPhone 14', 'https://http2.mlstatic.com/D_NQ_NP_782535-MLM51559386281_092022-O.webp', 9, 14),
(16, 'HHHH', 'Xiaomi 14T Pro 12 GB', 'https://i02.appmifile.com/971_item_co/30/09/2024/32ea27394ad9513ec81639e1c517215e.png', 10, 20),
(17, 'mo7', 'motorola edge 60 fusion', 'https://cdn.claro.com.co/imagenes/v9/catalogo/646x1000/70065257_7.jpg', 10, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `ID_Proveedor` int(11) NOT NULL,
  `Identificacion` varchar(50) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `ID_producto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`ID_Proveedor`, `Identificacion`, `Nombre`, `Telefono`, `Correo`, `ID_producto`) VALUES
(6, '1010369878', 'TecnodESl2', '3021234569', 'tecnodes@gmail.com', NULL),
(7, '1025896315', 'TecnoLo', '3027894563', 'tecnolo@gmail.com', NULL),
(9, '1478965456', 'Eddy Giraldo', '3216547890', 'eddy@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transportadora`
--

CREATE TABLE `transportadora` (
  `ID_Transportadora` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Telefono` varchar(100) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Guia` varchar(100) NOT NULL,
  `Monto_Envio` decimal(10,2) NOT NULL,
  `ID_Envio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `document_number` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `first_name`, `last_name`, `document_type`, `document_number`, `phone`, `address`, `role`) VALUES
(1, 'Admin Technova', 'admin@technova.com', NULL, '$2y$12$ISMMNjjUbEJnLfEVeRp3GOp2LtwnLWKPPRBN8A6ObQXMJunEPPlwa', NULL, '2025-09-13 18:36:11', '2025-09-14 14:26:13', 'Admin', 'Technova', 'N/A', 'N/A', '0000000000', 'N/A', 'admin'),
(2, 'tania caro', 'carotania32@gmail.com', NULL, '$2y$12$TpmJ2iRvFTM.dsVJ8.yhueSZbmzcaKpsAcs1vKY1ZJ/uY1K0OaDRy', NULL, '2025-09-14 07:17:01', '2025-09-20 02:06:44', 'tania', 'caro', 'CC', '1010037724', '3022860534', 'Cl norte', 'cliente'),
(3, 'Liz Ochoa', 'lizcaro1818@gmail.com', NULL, '$2y$12$EnvvUfdDXrIiah4o3oNTMO5i0OoVQCuYCTjI/P7CpUaAId9G.7Jmy', NULL, '2025-09-14 08:07:59', '2025-09-14 08:07:59', 'Liz', 'Ochoa', 'CC', '102352666', '3002378820', 'calle 16 b # 4 b 4', 'cliente'),
(4, 'Nataly', 'empleado@gym.com', NULL, '$2y$12$9ELiFEk4VzPIMWac/P1AD.BjMx6fP62yg2dX8kLeNyQAP3D1G4Iw2', NULL, '2025-09-14 10:07:45', '2025-09-14 10:07:45', 'Nataly', 'Forero', 'CC', '1010101010', '3009825795', 'calle 178 # 48b', 'empleado'),
(6, 'Eddy giraldo', 'vaghan@gmail.com', NULL, '$2y$12$aYpjZ5lsj8PlguJJ2xSCQ.Mi.qHJZYtq8Wdez19cLTnESbdFo4fLO', NULL, '2025-09-14 14:28:39', '2025-09-14 14:28:39', 'Eddy', 'giraldo', 'CC', '1002026369', '3698547896', 'calle 18 b # 4 b 4', 'cliente'),
(8, 'Lorena', 'cliente@gym.com', NULL, '$2y$12$2r1zgHOlDsF5jm/jT7hop.tKoScKCiZkrNYUlyuzE5B9x08ztuQ9S', NULL, '2025-09-15 13:51:13', '2025-09-15 14:09:48', 'abhbj', 'bhjb', 'cc', '2253698569', '3025889663', 'calle 17 # 48b', 'empleado'),
(9, 'Ana Gomez', 'ana@gmail.com', NULL, '$2y$12$vbVcnFkRTUlPPWlylmqaAeDBRgoOb8fE4GkF6XBIu5srbr/5BRvz6', NULL, '2025-09-16 08:53:57', '2025-09-16 08:53:57', 'Ana', 'Gomez', 'TI', '10000000', '3123456789', 'Cra 50 calle', 'cliente'),
(10, 'Andrea Lorena Cruz Yespez', 'Andreacruz@gmaiil.com', NULL, '$2y$12$tJlzUnJ2zm.UvQ35Vgsgm.nR.VCGwc6ESAXPdZgA/HJBwp/Z9icuW', NULL, '2025-09-16 09:25:48', '2025-09-16 09:25:48', 'Andrea', 'Cruz', 'CC', '1234569878', '3214569852', 'calle 158 # 48b', 'cliente'),
(11, 'Lorena Cruz', 'lorena.technova@gmail.com', NULL, '$2y$12$ZXApuE1BbCZjx4xi/N9Nt.ejjUP1WJxEGvYdLSxHcHwr2PqemVtlK', NULL, '2025-09-18 04:50:54', '2025-09-18 04:50:54', 'Lorena', 'Cruz', 'CC', '1234569875', '3698521478', 'Cra 80 calle', 'cliente'),
(12, 'nataly Forero', 'nataly.technova@gmail.com', NULL, '$2y$12$ziecHatxIFAHdeBHY8bK4umvFC443SBwFCc.qrZR5jlwEWeAOoCLG', NULL, '2025-09-18 04:55:44', '2025-09-18 04:55:44', 'nataly', 'Forero', 'CC', '1478523690', '3698523698', 'calle 186 b # 4 b 5', 'admin'),
(13, 'Eddy Giraldo', 'eddy5@gmail.com', NULL, '$2y$12$G/DCydIzKLB/yRAT.UF2eeI5MW0WFr6LvWvYAUXjmnqNWVE95Q/ky', NULL, '2025-09-18 04:57:25', '2025-09-18 04:57:25', 'Eddy', 'Giraldo', 'CC', '1010235698', '3254569878', 'calle 16 b # 4 b 5', 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_payment_methods`
--

CREATE TABLE `user_payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `metodo_pago` varchar(255) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `brand` varchar(255) DEFAULT NULL,
  `last4` varchar(4) DEFAULT NULL,
  `holder_name` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `exp_month` varchar(2) DEFAULT NULL,
  `exp_year` varchar(4) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `installments` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user_payment_methods`
--

INSERT INTO `user_payment_methods` (`id`, `user_id`, `metodo_pago`, `is_default`, `brand`, `last4`, `holder_name`, `token`, `created_at`, `updated_at`, `exp_month`, `exp_year`, `email`, `phone`, `installments`) VALUES
(1, 2, NULL, 0, 'Crédito', '8888', 'Tania', NULL, '2025-09-18 05:40:45', '2025-09-18 05:40:45', '10', '2030', 'carotania32@gmail.com', '3652147899', 6),
(2, 2, NULL, 0, 'Débito', '3333', 'Tania', NULL, '2025-09-18 05:41:53', '2025-09-18 05:41:53', '11', '2033', 'carotania32@gmail.com', '3652147899', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID_Usuario` int(11) NOT NULL,
  `Tipo_De_Documento` varchar(100) NOT NULL,
  `Identificacion` varchar(100) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellido` varchar(100) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Contraseña` varchar(255) NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `Direccion` varchar(100) NOT NULL,
  `Rol` varchar(100) NOT NULL,
  `Fecha_De_Registro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID_Usuario`, `Tipo_De_Documento`, `Identificacion`, `Nombre`, `Apellido`, `Correo`, `Contraseña`, `Telefono`, `Direccion`, `Rol`, `Fecha_De_Registro`) VALUES
(2, 'CC', '1010037724', 'tania', 'caro', 'carotania32@gmail.com', '$2y$12$TpmJ2iRvFTM.dsVJ8.yhueSZbmzcaKpsAcs1vKY1ZJ/uY1K0OaDRy', '3022860534', 'Cl 58 Norte', 'cliente', '2025-09-16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `ID_Ventas` int(11) NOT NULL,
  `ID_Usuario` int(11) NOT NULL,
  `fecha_venta` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`ID_Ventas`, `ID_Usuario`, `fecha_venta`) VALUES
(17, 2, '2025-09-16'),
(18, 2, '2025-09-16'),
(19, 2, '2025-09-16'),
(20, 2, '2025-09-17'),
(21, 2, '2025-09-17'),
(22, 2, '2025-09-17'),
(23, 2, '2025-09-17'),
(24, 2, '2025-09-19');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `atencioncliente`
--
ALTER TABLE `atencioncliente`
  ADD PRIMARY KEY (`ID_Atencion`),
  ADD KEY `FK_Atencion_Usuario` (`ID_Usuario`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `caracteristica`
--
ALTER TABLE `caracteristica`
  ADD PRIMARY KEY (`ID_Caracteristicas`);

--
-- Indices de la tabla `caracteristicas`
--
ALTER TABLE `caracteristicas`
  ADD PRIMARY KEY (`ID_Caracteristicas`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`ID_Carrito`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`ID_Compras`),
  ADD KEY `comprasProveedor` (`ID_Proveedor`);

--
-- Indices de la tabla `detallecarrito`
--
ALTER TABLE `detallecarrito`
  ADD PRIMARY KEY (`ID_DetalleCarrito`),
  ADD UNIQUE KEY `unique_carrito_producto` (`ID_Carrito`,`ID_Producto`);

--
-- Indices de la tabla `detallecompras`
--
ALTER TABLE `detallecompras`
  ADD PRIMARY KEY (`ID_DetalleCompras`),
  ADD KEY `Compradetalle` (`ID_Compras`),
  ADD KEY `CompraProducto` (`ID_Producto`);

--
-- Indices de la tabla `detalleventas`
--
ALTER TABLE `detalleventas`
  ADD PRIMARY KEY (`ID_DetalleVentas`),
  ADD KEY `VentaDetal` (`ID_Ventas`),
  ADD KEY `VentaProducto` (`ID_Producto`);

--
-- Indices de la tabla `envio`
--
ALTER TABLE `envio`
  ADD PRIMARY KEY (`ID_Envio`),
  ADD KEY `EnvioVenta` (`ID_Ventas`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_producto` (`user_id`,`producto_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mediodepago`
--
ALTER TABLE `mediodepago`
  ADD PRIMARY KEY (`ID_MedioDePago`),
  ADD KEY `Mediopa` (`ID_Pagos`),
  ADD KEY `MedioDetallev` (`ID_DetalleVentas`),
  ADD KEY `MedioUsuario` (`ID_Usuario`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`ID_Pagos`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`ID_Producto`),
  ADD UNIQUE KEY `producto_codigo_unique` (`Codigo`),
  ADD KEY `producto_id_caracteristicas_foreign` (`ID_Caracteristicas`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ID_Producto`),
  ADD UNIQUE KEY `Codigo` (`Codigo`),
  ADD KEY `ID_Caracteristicas` (`ID_Caracteristicas`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`ID_Proveedor`),
  ADD KEY `ID_producto` (`ID_producto`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `transportadora`
--
ALTER TABLE `transportadora`
  ADD PRIMARY KEY (`ID_Transportadora`),
  ADD KEY `EnvioTransportadora` (`ID_Envio`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_document_number_unique` (`document_number`);

--
-- Indices de la tabla `user_payment_methods`
--
ALTER TABLE `user_payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_payment_methods_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_Usuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`ID_Ventas`),
  ADD KEY `VentaUsuario` (`ID_Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `atencioncliente`
--
ALTER TABLE `atencioncliente`
  MODIFY `ID_Atencion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `caracteristica`
--
ALTER TABLE `caracteristica`
  MODIFY `ID_Caracteristicas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `caracteristicas`
--
ALTER TABLE `caracteristicas`
  MODIFY `ID_Caracteristicas` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `ID_Carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `ID_Compras` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `detallecarrito`
--
ALTER TABLE `detallecarrito`
  MODIFY `ID_DetalleCarrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `detallecompras`
--
ALTER TABLE `detallecompras`
  MODIFY `ID_DetalleCompras` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `detalleventas`
--
ALTER TABLE `detalleventas`
  MODIFY `ID_DetalleVentas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `envio`
--
ALTER TABLE `envio`
  MODIFY `ID_Envio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mediodepago`
--
ALTER TABLE `mediodepago`
  MODIFY `ID_MedioDePago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `ID_Pagos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `ID_Producto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID_Producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `ID_Proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `transportadora`
--
ALTER TABLE `transportadora`
  MODIFY `ID_Transportadora` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `user_payment_methods`
--
ALTER TABLE `user_payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `ID_Ventas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `atencioncliente`
--
ALTER TABLE `atencioncliente`
  ADD CONSTRAINT `FK_Atencion_Usuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`);

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `comprasProveedor` FOREIGN KEY (`ID_Proveedor`) REFERENCES `proveedor` (`ID_Proveedor`);

--
-- Filtros para la tabla `detallecompras`
--
ALTER TABLE `detallecompras`
  ADD CONSTRAINT `CompraProducto` FOREIGN KEY (`ID_Producto`) REFERENCES `productos` (`ID_Producto`),
  ADD CONSTRAINT `Compradetalle` FOREIGN KEY (`ID_Compras`) REFERENCES `compras` (`ID_Compras`);

--
-- Filtros para la tabla `detalleventas`
--
ALTER TABLE `detalleventas`
  ADD CONSTRAINT `VentaDetal` FOREIGN KEY (`ID_Ventas`) REFERENCES `ventas` (`ID_Ventas`),
  ADD CONSTRAINT `VentaProducto` FOREIGN KEY (`ID_Producto`) REFERENCES `productos` (`ID_Producto`);

--
-- Filtros para la tabla `envio`
--
ALTER TABLE `envio`
  ADD CONSTRAINT `EnvioVenta` FOREIGN KEY (`ID_Ventas`) REFERENCES `ventas` (`ID_Ventas`);

--
-- Filtros para la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`ID_Producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `mediodepago`
--
ALTER TABLE `mediodepago`
  ADD CONSTRAINT `MedioDetallev` FOREIGN KEY (`ID_DetalleVentas`) REFERENCES `detalleventas` (`ID_DetalleVentas`),
  ADD CONSTRAINT `MedioUsuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`),
  ADD CONSTRAINT `Mediopa` FOREIGN KEY (`ID_Pagos`) REFERENCES `pagos` (`ID_Pagos`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_id_caracteristicas_foreign` FOREIGN KEY (`ID_Caracteristicas`) REFERENCES `caracteristicas` (`ID_Caracteristicas`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`ID_Caracteristicas`) REFERENCES `caracteristica` (`ID_Caracteristicas`);

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `proveedor_ibfk_1` FOREIGN KEY (`ID_producto`) REFERENCES `productos` (`ID_Producto`);

--
-- Filtros para la tabla `transportadora`
--
ALTER TABLE `transportadora`
  ADD CONSTRAINT `EnvioTransportadora` FOREIGN KEY (`ID_Envio`) REFERENCES `envio` (`ID_Envio`);

--
-- Filtros para la tabla `user_payment_methods`
--
ALTER TABLE `user_payment_methods`
  ADD CONSTRAINT `user_payment_methods_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `VentaUsuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
