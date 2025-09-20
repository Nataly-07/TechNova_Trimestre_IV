-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-09-2025 a las 05:14:21
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
(27, 'Celulares', 'Rosado', NULL, 151222.00, 1800000.00, 'Xiaomi');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `ID_Carrito` int(11) NOT NULL,
  `ID_Usuario` int(11) NOT NULL,
  `Fecha_Creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `Estado` varchar(50) NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `ID_Compras` int(11) NOT NULL,
  `ID_Proveedor` int(11) NOT NULL,
  `Fecha_De_Compra` datetime NOT NULL,
  `Tiempo_De_Entrega` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecarrito`
--

CREATE TABLE `detallecarrito` (
  `ID_DetalleCarrito` int(11) NOT NULL,
  `ID_Carrito` int(11) NOT NULL,
  `ID_Producto` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `ID_Usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(10, '2025_09_10_000000_add_role_to_users_table', 3);

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
  `Proveedor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`ID_Producto`, `Codigo`, `Nombre`, `Imagen`, `ID_Caracteristicas`, `Stock`, `Proveedor`) VALUES
(6, '11', 'iPhone 16 128 GB', 'https://co.tiendasishop.com/cdn/shop/files/IMG-14858821_a2762325-3ee8-4bd1-870c-b16dfc4877b7.jpg?v=1726245580&width=823', 6, 30, NULL),
(8, 'gaj', 'Xiaomi 14T Pro 12 GB', 'https://i02.appmifile.com/971_item_co/30/09/2024/32ea27394ad9513ec81639e1c517215e.png', 8, 10, NULL),
(9, 'mot41', 'MOTOROLA G24', 'https://exitocol.vtexassets.com/arquivos/ids/29078055/Celular-MOTOROLA-G24-256-GB-4-GB-RAM-Lavanda-3499944_f.jpg?v=638877915400670000', 9, 10, NULL),
(10, 'mo7', 'motorola edge 60 fusion', 'https://cdn.claro.com.co/imagenes/v9/catalogo/646x1000/70065257_7.jpg', 10, 15, NULL),
(12, 'aaa52', 'iPhone 14', 'https://http2.mlstatic.com/D_NQ_NP_782535-MLM51559386281_092022-O.webp', 12, 15, NULL),
(24, 'Len01', 'celular', NULL, 27, 1, NULL);

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
(1, 'Admin Technova', 'admin@technova.com', NULL, '$2y$12$ISMMNjjUbEJnLfEVeRp3GOp2LtwnLWKPPRBN8A6ObQXMJunEPPlwa', NULL, '2025-09-13 08:36:11', '2025-09-14 04:26:13', 'Admin', 'Technova', 'N/A', 'N/A', '0000000000', 'N/A', 'admin'),
(2, 'tania caro', 'carotania32@gmail.com', NULL, '$2y$12$TpmJ2iRvFTM.dsVJ8.yhueSZbmzcaKpsAcs1vKY1ZJ/uY1K0OaDRy', NULL, '2025-09-13 21:17:01', '2025-09-13 21:17:01', 'tania', 'caro', 'CC', '1010037724', '3022860534', 'calle 186 b # 4 b 4', 'cliente'),
(3, 'Liz Ochoa', 'lizcaro1818@gmail.com', NULL, '$2y$12$EnvvUfdDXrIiah4o3oNTMO5i0OoVQCuYCTjI/P7CpUaAId9G.7Jmy', NULL, '2025-09-13 22:07:59', '2025-09-13 22:07:59', 'Liz', 'Ochoa', 'CC', '102352666', '3002378820', 'calle 16 b # 4 b 4', 'cliente'),
(4, 'Nataly', 'empleado@gym.com', NULL, '$2y$12$9ELiFEk4VzPIMWac/P1AD.BjMx6fP62yg2dX8kLeNyQAP3D1G4Iw2', NULL, '2025-09-14 00:07:45', '2025-09-14 00:07:45', 'Nataly', 'Forero', 'CC', '1010101010', '3009825795', 'calle 178 # 48b', 'empleado'),
(5, 'Test User', 'test@example.com', '2025-09-14 04:26:12', '$2y$12$jKMsNvvoMlGIRg/oIhfuteHkJY/7X0aGh/mCczOPTVceX8.9i7XP6', 'ORiy1pX8bE', '2025-09-14 04:26:12', '2025-09-14 04:26:12', 'Theodore', 'Sanford', 'TI', '22271406', '+12486433061', '4975 Chelsey Corners Suite 947\nPort Haileytown, MN 08534', 'admin'),
(6, 'Eddy giraldo', 'vaghan@gmail.com', NULL, '$2y$12$aYpjZ5lsj8PlguJJ2xSCQ.Mi.qHJZYtq8Wdez19cLTnESbdFo4fLO', NULL, '2025-09-14 04:28:39', '2025-09-14 04:28:39', 'Eddy', 'giraldo', 'CC', '1002026369', '3698547896', 'calle 18 b # 4 b 4', 'cliente');

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
  ADD PRIMARY KEY (`ID_Carrito`),
  ADD KEY `FK_Carrito_Usuario` (`ID_Usuario`);

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
  ADD KEY `FK_DetalleCarrito_Carrito` (`ID_Carrito`),
  ADD KEY `FK_DetalleCarrito_Producto` (`ID_Producto`);

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
  MODIFY `ID_Caracteristicas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `caracteristicas`
--
ALTER TABLE `caracteristicas`
  MODIFY `ID_Caracteristicas` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `ID_Carrito` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `ID_Compras` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detallecarrito`
--
ALTER TABLE `detallecarrito`
  MODIFY `ID_DetalleCarrito` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detallecompras`
--
ALTER TABLE `detallecompras`
  MODIFY `ID_DetalleCompras` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalleventas`
--
ALTER TABLE `detalleventas`
  MODIFY `ID_DetalleVentas` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mediodepago`
--
ALTER TABLE `mediodepago`
  MODIFY `ID_MedioDePago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `ID_Pagos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `ID_Producto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID_Producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `ID_Proveedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `transportadora`
--
ALTER TABLE `transportadora`
  MODIFY `ID_Transportadora` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `ID_Ventas` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `atencioncliente`
--
ALTER TABLE `atencioncliente`
  ADD CONSTRAINT `FK_Atencion_Usuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`);

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `FK_Carrito_Usuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`);

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `comprasProveedor` FOREIGN KEY (`ID_Proveedor`) REFERENCES `proveedor` (`ID_Proveedor`);

--
-- Filtros para la tabla `detallecarrito`
--
ALTER TABLE `detallecarrito`
  ADD CONSTRAINT `FK_DetalleCarrito_Carrito` FOREIGN KEY (`ID_Carrito`) REFERENCES `carrito` (`ID_Carrito`),
  ADD CONSTRAINT `FK_DetalleCarrito_Producto` FOREIGN KEY (`ID_Producto`) REFERENCES `productos` (`ID_Producto`);

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
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `VentaUsuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
