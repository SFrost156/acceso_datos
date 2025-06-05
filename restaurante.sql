

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



CREATE TABLE `administrador` (
  `username` varchar(30) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `administrador` (`username`, `nombre_completo`, `telefono`, `password`) VALUES
('Admin1', 'administrador demo', '3124567890', '$2y$10$kPDgXPVnFJmDhSD2SvCmv.Pck7o4RYWPxZYB/jFgGw21T7/EbrQQe');


CREATE TABLE `mesero` (
  `username` varchar(30) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `mesero` (`username`, `nombre_completo`, `telefono`, `password`) VALUES
('Mesero1', 'mesero demo', '31231231234', '$2y$10$R85.uso/hc4rr5W1T8945ufsyNHw1VieR/4C/RGBbnBc0IOfm9Fkm'),
('Mesero2', 'Mesero demo dos', '3111111111', '$2y$10$wHPRuFc4a1vFg6bmsK6dKOaw1jwVApaNmIt6lxQZPKj3LgF2c5FVW');

CREATE TABLE `pagado` (
  `id` int(11) NOT NULL,
  `mesa` int(11) DEFAULT NULL,
  `usuario_mesero` varchar(50) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `pagado` (`id`, `mesa`, `usuario_mesero`, `fecha`, `producto_id`, `cantidad`) VALUES
(1, 1, 'Mesero1', '2025-06-01', 1, 1),
(2, 1, 'Mesero2', '2025-06-01', 1, 1),
(3, 1, 'Mesero1', '2025-06-02', 1, 4),
(4, 1, 'Mesero1', '2025-06-01', 1, 2),
(5, 2, 'Mesero2', '2025-01-01', 1, 1),
(6, 3, 'Mesero1', '2025-01-01', 1, 1),
(7, 3, 'Mesero1', '2025-01-01', 1, 1);


CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `mesa` int(11) DEFAULT NULL,
  `usuario_mesero` varchar(50) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `estado` varchar(10) DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `pedidos` (`id`, `mesa`, `usuario_mesero`, `fecha`, `producto_id`, `cantidad`, `estado`) VALUES
(1, 1, 'Mesero1', '2025-06-01', 1, 1, 'pagado'),
(2, 1, 'Mesero2', '2025-06-01', 1, 1, 'pagado'),
(3, 1, 'Mesero1', '2025-06-02', 1, 4, 'pagado'),
(4, 1, 'Mesero1', '2025-06-01', 1, 2, 'pagado'),
(5, 2, 'Mesero2', '2025-01-01', 1, 1, 'pagado'),
(6, 3, 'Mesero1', '2025-01-01', 1, 1, 'pagado'),
(7, 3, 'Mesero1', '2025-01-01', 1, 1, 'pagado');


CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL CHECK (`cantidad` > 0),
  `categoria` varchar(50) NOT NULL,
  `precio` decimal(10,2) NOT NULL CHECK (`precio` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `productos` (`id`, `fecha`, `nombre`, `cantidad`, `categoria`, `precio`) VALUES
(1, '2025-06-01', 'Pizza ', 5, 'Comida', 10000.00);

--

ALTER TABLE `administrador`
  ADD PRIMARY KEY (`username`);


ALTER TABLE `mesero`
  ADD PRIMARY KEY (`username`);


ALTER TABLE `pagado`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `pagado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

