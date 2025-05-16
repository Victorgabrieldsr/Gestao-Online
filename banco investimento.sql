-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.34-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para investimento
CREATE DATABASE IF NOT EXISTS `investimento` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `investimento`;

-- Copiando estrutura para tabela investimento.ativos
CREATE TABLE IF NOT EXISTS `ativos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) DEFAULT NULL,
  `nomeAtivo` varchar(50) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `dataCompra` date DEFAULT NULL,
  `descricao` varchar(50) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `precoUnitario` decimal(10,2) DEFAULT NULL,
  `valorTotal` decimal(10,2) DEFAULT NULL,
  `porcentagemAno` double DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `valorAtual` decimal(10,2) DEFAULT NULL,
  `dataComparacao` date DEFAULT NULL,
  `bola` varchar(20) DEFAULT NULL,
  `DataUltimaAtualizacaoAtivo` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idUser` (`idUser`),
  CONSTRAINT `ativos_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela investimento.config
CREATE TABLE IF NOT EXISTS `config` (
  `id_name` varchar(50) NOT NULL,
  `valor` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela investimento.cotasativos
CREATE TABLE IF NOT EXISTS `cotasativos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) DEFAULT NULL,
  `nomeAtivo` varchar(50) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `precoUnitario` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela investimento.cotascriptos
CREATE TABLE IF NOT EXISTS `cotascriptos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) DEFAULT NULL,
  `nomeCripto` varchar(255) DEFAULT NULL,
  `quantidade` decimal(23,11) DEFAULT NULL,
  `valorTotal` decimal(10,2) DEFAULT NULL,
  `valorAtual` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idUser` (`idUser`),
  CONSTRAINT `cotascriptos_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela investimento.criptos
CREATE TABLE IF NOT EXISTS `criptos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) DEFAULT NULL,
  `nomeCripto` varchar(50) DEFAULT NULL,
  `dataCompra` date DEFAULT NULL,
  `descricao` varchar(50) DEFAULT NULL,
  `quantidade` decimal(23,11) unsigned DEFAULT NULL,
  `valorTotal` decimal(10,2) DEFAULT NULL,
  `valorAtual` decimal(10,2) DEFAULT NULL,
  `quantidadeAtual` decimal(23,11) DEFAULT NULL,
  `DataUltimaAtualizacaoCripto` date DEFAULT NULL,
  `bola` varchar(20) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idUser` (`idUser`),
  CONSTRAINT `criptos_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela investimento.painel
CREATE TABLE IF NOT EXISTS `painel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) DEFAULT NULL,
  `totalInvestido` decimal(10,2) DEFAULT NULL,
  `totalRendido` decimal(10,2) DEFAULT NULL,
  `totalProvento` decimal(10,2) DEFAULT NULL,
  `totalRetirado` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idUser` (`idUser`),
  CONSTRAINT `painel_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela investimento.painelcriptos
CREATE TABLE IF NOT EXISTS `painelcriptos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) DEFAULT NULL,
  `totalCripto` decimal(10,2) DEFAULT NULL,
  `lucroEPrejuizo` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idUser` (`idUser`),
  CONSTRAINT `painelcriptos_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela investimento.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) DEFAULT NULL,
  `senha` blob DEFAULT NULL,
  `remember_token` blob DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Exportação de dados foi desmarcado.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
