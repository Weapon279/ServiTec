-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para cursos
CREATE DATABASE IF NOT EXISTS `cursos` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cursos`;

-- Volcando estructura para tabla cursos.alumnos
CREATE TABLE IF NOT EXISTS `alumnos` (
  `id_Alumno` int NOT NULL AUTO_INCREMENT,
  `Fk_id_User` int DEFAULT NULL,
  `Status` binary(1) DEFAULT NULL,
  `FechaHoraC` timestamp NULL DEFAULT NULL,
  `FechaHoraA` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_Alumno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla cursos.alumnos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla cursos.convocatoria
CREATE TABLE IF NOT EXISTS `convocatoria` (
  `Id_Convoca` int NOT NULL AUTO_INCREMENT,
  `NombreConvoca` varchar(255) DEFAULT NULL,
  `DocenteConvoca` varchar(255) DEFAULT NULL,
  `Fk_id_User` int DEFAULT NULL,
  `Status` binary(1) DEFAULT NULL,
  `FechaHoraC` timestamp NULL DEFAULT NULL,
  `FechaHoraA` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Id_Convoca`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla cursos.convocatoria: ~0 rows (aproximadamente)

-- Volcando estructura para tabla cursos.curso
CREATE TABLE IF NOT EXISTS `curso` (
  `id_Curso` int NOT NULL AUTO_INCREMENT,
  `Fk_id_ofer` int DEFAULT NULL,
  `Perfil` varchar(255) DEFAULT NULL,
  `NombreCurso` varchar(255) DEFAULT NULL,
  `ObjectivoCurso` varchar(255) DEFAULT NULL,
  `DuracionCurso` varchar(255) DEFAULT NULL,
  `Modalidad` varchar(255) DEFAULT NULL,
  `DescripcionCurso` varchar(255) DEFAULT NULL,
  `ConocimientosCurso` varchar(255) DEFAULT NULL,
  `ContenidoCurso` varchar(255) DEFAULT NULL,
  `CostoCurso` int DEFAULT NULL,
  `Status` binary(1) DEFAULT NULL,
  `FechaHoraC` timestamp NULL DEFAULT NULL,
  `FechaHoraA` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_Curso`),
  CONSTRAINT `curso_ibfk_1` FOREIGN KEY (`id_Curso`) REFERENCES `grupo` (`id_Grupo`),
  CONSTRAINT `curso_ibfk_2` FOREIGN KEY (`id_Curso`) REFERENCES `grupo` (`id_Grupo`),
  CONSTRAINT `curso_ibfk_3` FOREIGN KEY (`id_Curso`) REFERENCES `grupo` (`id_Grupo`),
  CONSTRAINT `curso_ibfk_4` FOREIGN KEY (`id_Curso`) REFERENCES `grupo` (`id_Grupo`),
  CONSTRAINT `curso_ibfk_5` FOREIGN KEY (`id_Curso`) REFERENCES `grupo` (`id_Grupo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla cursos.curso: ~0 rows (aproximadamente)

-- Volcando estructura para tabla cursos.grupo
CREATE TABLE IF NOT EXISTS `grupo` (
  `id_Grupo` int NOT NULL AUTO_INCREMENT,
  `Fk_id_Curso` int DEFAULT NULL,
  `ClaveGrupo` int DEFAULT NULL,
  `FechaI` timestamp NULL DEFAULT NULL,
  `FechaF` timestamp NULL DEFAULT NULL,
  `Capacidad` int DEFAULT NULL,
  `Costo` int DEFAULT NULL,
  `Fk_id_Alumno` int DEFAULT NULL,
  `Status` binary(1) DEFAULT NULL,
  `FechaHoraC` timestamp NULL DEFAULT NULL,
  `FechaHoraA` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_Grupo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla cursos.grupo: ~0 rows (aproximadamente)

-- Volcando estructura para tabla cursos.intereses
CREATE TABLE IF NOT EXISTS `intereses` (
  `id_Intereses` int NOT NULL AUTO_INCREMENT,
  `NombreInteres` varchar(255) DEFAULT NULL,
  `Fk_id_User` int DEFAULT NULL,
  `Status` binary(1) DEFAULT NULL,
  PRIMARY KEY (`id_Intereses`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla cursos.intereses: ~0 rows (aproximadamente)

-- Volcando estructura para tabla cursos.notificaciones
CREATE TABLE IF NOT EXISTS `notificaciones` (
  `id_Noti` int NOT NULL AUTO_INCREMENT,
  `NombreNoti` varchar(255) DEFAULT NULL,
  `TextoNoti` varchar(255) DEFAULT NULL,
  `StatusNoti` binary(1) DEFAULT NULL,
  `LecturaNoti` varchar(255) DEFAULT NULL,
  `FechaHoraC` timestamp NULL DEFAULT NULL,
  `FechaHoraA` timestamp NULL DEFAULT NULL,
  `Fk_TypeNoti` int DEFAULT NULL,
  PRIMARY KEY (`id_Noti`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla cursos.notificaciones: ~0 rows (aproximadamente)

-- Volcando estructura para tabla cursos.oferta
CREATE TABLE IF NOT EXISTS `oferta` (
  `id_ofer` int NOT NULL AUTO_INCREMENT,
  `NombreOfer` varchar(255) DEFAULT NULL,
  `Fk_id_convoca` int DEFAULT NULL,
  `FechaHoraC` timestamp NULL DEFAULT NULL,
  `FechaHoraA` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_ofer`),
  KEY `Fk_id_convoca` (`Fk_id_convoca`),
  CONSTRAINT `oferta_ibfk_1` FOREIGN KEY (`Fk_id_convoca`) REFERENCES `convocatoria` (`Id_Convoca`),
  CONSTRAINT `oferta_ibfk_10` FOREIGN KEY (`Fk_id_convoca`) REFERENCES `convocatoria` (`Id_Convoca`),
  CONSTRAINT `oferta_ibfk_2` FOREIGN KEY (`Fk_id_convoca`) REFERENCES `convocatoria` (`Id_Convoca`),
  CONSTRAINT `oferta_ibfk_3` FOREIGN KEY (`Fk_id_convoca`) REFERENCES `convocatoria` (`Id_Convoca`),
  CONSTRAINT `oferta_ibfk_4` FOREIGN KEY (`Fk_id_convoca`) REFERENCES `convocatoria` (`Id_Convoca`),
  CONSTRAINT `oferta_ibfk_5` FOREIGN KEY (`Fk_id_convoca`) REFERENCES `convocatoria` (`Id_Convoca`),
  CONSTRAINT `oferta_ibfk_6` FOREIGN KEY (`Fk_id_convoca`) REFERENCES `convocatoria` (`Id_Convoca`),
  CONSTRAINT `oferta_ibfk_7` FOREIGN KEY (`Fk_id_convoca`) REFERENCES `convocatoria` (`Id_Convoca`),
  CONSTRAINT `oferta_ibfk_8` FOREIGN KEY (`Fk_id_convoca`) REFERENCES `convocatoria` (`Id_Convoca`),
  CONSTRAINT `oferta_ibfk_9` FOREIGN KEY (`Fk_id_convoca`) REFERENCES `convocatoria` (`Id_Convoca`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla cursos.oferta: ~0 rows (aproximadamente)

-- Volcando estructura para tabla cursos.typenotificacion
CREATE TABLE IF NOT EXISTS `typenotificacion` (
  `id_TypeNoti` int NOT NULL AUTO_INCREMENT,
  `TypeNoti` varchar(255) DEFAULT NULL,
  `Status` binary(1) DEFAULT NULL,
  `FechaHoraC` timestamp NULL DEFAULT NULL,
  `FechaHoraA` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_TypeNoti`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla cursos.typenotificacion: ~0 rows (aproximadamente)

-- Volcando estructura para tabla cursos.typeuser
CREATE TABLE IF NOT EXISTS `typeuser` (
  `id_TypeUser` int NOT NULL AUTO_INCREMENT,
  `NombreTypeUser` varchar(255) DEFAULT NULL COMMENT 'Alumano, Aspirante, Maestro',
  `Status` binary(1) DEFAULT NULL,
  `FechaHoraC` timestamp NULL DEFAULT NULL,
  `FechaHoraA` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_TypeUser`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla cursos.typeuser: ~1 rows (aproximadamente)
INSERT INTO `typeuser` (`id_TypeUser`, `NombreTypeUser`, `Status`, `FechaHoraC`, `FechaHoraA`) VALUES
	(1, 'Alumno', _binary 0x31, '2024-05-12 23:04:59', '2024-05-12 23:05:00');

-- Volcando estructura para tabla cursos.user
CREATE TABLE IF NOT EXISTS `user` (
  `id_User` int NOT NULL AUTO_INCREMENT,
  `Fk_TypeUser` int DEFAULT NULL,
  `vNombre` varchar(50) DEFAULT NULL,
  `vApellidoP` varchar(50) DEFAULT NULL,
  `vApellidoM` varchar(50) DEFAULT NULL,
  `vCorreo` varchar(50) DEFAULT NULL,
  `nWhats` int DEFAULT '0',
  `nPass` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bStatus` bit(1) DEFAULT NULL,
  `iFechaHoraC` timestamp NULL DEFAULT NULL,
  `iFechaHoraA` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_User`),
  KEY `Fk_TypeUser` (`Fk_TypeUser`),
  CONSTRAINT `Fk_TypeUser` FOREIGN KEY (`Fk_TypeUser`) REFERENCES `typeuser` (`id_TypeUser`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla cursos.user: ~1 rows (aproximadamente)
INSERT INTO `user` (`id_User`, `Fk_TypeUser`, `vNombre`, `vApellidoP`, `vApellidoM`, `vCorreo`, `nWhats`, `nPass`, `bStatus`, `iFechaHoraC`, `iFechaHoraA`) VALUES
	(1, 1, 'Raul', 'Pineda', 'Pineda', 'pineda@gmail.com', 314547853, 'pineda123', b'1', '2024-05-12 23:05:47', '2024-05-12 23:05:48');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
