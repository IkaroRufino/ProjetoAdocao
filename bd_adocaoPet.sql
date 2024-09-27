-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           8.0.30 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Copiando estrutura para tabela bd_adocaopet.tb_admin
CREATE TABLE IF NOT EXISTS `tb_admin` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  PRIMARY KEY (`id_admin`),
  KEY `fk_admuser` (`id_user`),
  CONSTRAINT `fk_admuser` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela bd_adocaopet.tb_adocao
CREATE TABLE IF NOT EXISTS `tb_adocao` (
  `id_adocao` int NOT NULL AUTO_INCREMENT,
  `data_adocao` date DEFAULT NULL,
  `id_adotante` int DEFAULT NULL,
  PRIMARY KEY (`id_adocao`),
  KEY `fk_adocAdotante` (`id_adotante`),
  CONSTRAINT `fk_adocAdotante` FOREIGN KEY (`id_adotante`) REFERENCES `tb_adotante` (`id_adotante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela bd_adocaopet.tb_adotante
CREATE TABLE IF NOT EXISTS `tb_adotante` (
  `id_adotante` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  PRIMARY KEY (`id_adotante`),
  KEY `fk_adouser` (`id_user`),
  CONSTRAINT `fk_adouser` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela bd_adocaopet.tb_agendoacao
CREATE TABLE IF NOT EXISTS `tb_agendoacao` (
  `id_agendoacao` int NOT NULL AUTO_INCREMENT,
  `data_agendoacao` date NOT NULL,
  `desc_agendoacao` varchar(350) DEFAULT NULL,
  `endereco_agendoacao` varchar(100) DEFAULT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_agendoacao`),
  KEY `fk_agendoacao_user` (`id_user`),
  CONSTRAINT `fk_agendoacao_user` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela bd_adocaopet.tb_animais
CREATE TABLE IF NOT EXISTS `tb_animais` (
  `id_animais` int NOT NULL AUTO_INCREMENT,
  `nome_animal` varchar(100) NOT NULL,
  `especie_animal` varchar(100) NOT NULL,
  `raca_animal` varchar(90) NOT NULL,
  `sexo_animal` enum('M','F') NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  PRIMARY KEY (`id_animais`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela bd_adocaopet.tb_animais_veterinario_consultas_procedimentos
CREATE TABLE IF NOT EXISTS `tb_animais_veterinario_consultas_procedimentos` (
  `id_animais` int NOT NULL,
  `id_vet` int NOT NULL,
  `id_consultas` int NOT NULL,
  `id_proce` int NOT NULL,
  PRIMARY KEY (`id_animais`,`id_vet`,`id_consultas`,`id_proce`),
  KEY `id_vet` (`id_vet`),
  KEY `id_consultas` (`id_consultas`),
  KEY `id_proce` (`id_proce`),
  CONSTRAINT `tb_animais_veterinario_consultas_procedimentos_ibfk_1` FOREIGN KEY (`id_vet`) REFERENCES `tb_veterinario` (`id_vet`),
  CONSTRAINT `tb_animais_veterinario_consultas_procedimentos_ibfk_2` FOREIGN KEY (`id_consultas`) REFERENCES `tb_consultas` (`id_consultas`),
  CONSTRAINT `tb_animais_veterinario_consultas_procedimentos_ibfk_3` FOREIGN KEY (`id_proce`) REFERENCES `tb_procedimentos` (`id_proce`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela bd_adocaopet.tb_consultas
CREATE TABLE IF NOT EXISTS `tb_consultas` (
  `id_consultas` int NOT NULL,
  `data_consulta` datetime NOT NULL,
  `motivo_consulta` text NOT NULL,
  `obs_consulta` text NOT NULL,
  PRIMARY KEY (`id_consultas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela bd_adocaopet.tb_doacao
CREATE TABLE IF NOT EXISTS `tb_doacao` (
  `id_doacao` int NOT NULL AUTO_INCREMENT,
  `data_doacao` date NOT NULL,
  `desc_doacao` varchar(200) DEFAULT NULL,
  `id_doador` int DEFAULT NULL,
  PRIMARY KEY (`id_doacao`),
  KEY `fk_doacDoador` (`id_doador`),
  CONSTRAINT `fk_doacDoador` FOREIGN KEY (`id_doador`) REFERENCES `tb_doador` (`id_doador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela bd_adocaopet.tb_doador
CREATE TABLE IF NOT EXISTS `tb_doador` (
  `id_doador` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  PRIMARY KEY (`id_doador`),
  KEY `fk_doauser` (`id_user`),
  CONSTRAINT `fk_doauser` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela bd_adocaopet.tb_endereco
CREATE TABLE IF NOT EXISTS `tb_endereco` (
  `id_endereco` int NOT NULL,
  `estado_ende` varchar(30) NOT NULL,
  `cidade_ende` varchar(85) NOT NULL,
  `rua_ende` varchar(85) NOT NULL,
  `bairro_ende` varchar(85) NOT NULL,
  `numero_ende` int NOT NULL,
  PRIMARY KEY (`id_endereco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela bd_adocaopet.tb_endereco_has_tb_veterinario
CREATE TABLE IF NOT EXISTS `tb_endereco_has_tb_veterinario` (
  `id_vet` int NOT NULL,
  `id_endereco` int NOT NULL,
  PRIMARY KEY (`id_vet`,`id_endereco`),
  KEY `id_endereco` (`id_endereco`),
  CONSTRAINT `tb_endereco_has_tb_veterinario_ibfk_1` FOREIGN KEY (`id_vet`) REFERENCES `tb_veterinario` (`id_vet`),
  CONSTRAINT `tb_endereco_has_tb_veterinario_ibfk_2` FOREIGN KEY (`id_endereco`) REFERENCES `tb_endereco` (`id_endereco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela bd_adocaopet.tb_enduser
CREATE TABLE IF NOT EXISTS `tb_enduser` (
  `id_user` int DEFAULT NULL,
  `id_endereco` int DEFAULT NULL,
  KEY `fk_enduser` (`id_user`),
  KEY `fk_userend` (`id_endereco`),
  CONSTRAINT `fk_enduser` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`),
  CONSTRAINT `fk_userend` FOREIGN KEY (`id_endereco`) REFERENCES `tb_endereco` (`id_endereco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela bd_adocaopet.tb_procedimentos
CREATE TABLE IF NOT EXISTS `tb_procedimentos` (
  `id_proce` int NOT NULL,
  `inicio_proce` date NOT NULL,
  `fim_proce` date NOT NULL,
  `descricao_proce` text NOT NULL,
  `vacinaS_proce` varchar(60) NOT NULL,
  `data_vacina` date NOT NULL,
  PRIMARY KEY (`id_proce`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela bd_adocaopet.tb_telefone
CREATE TABLE IF NOT EXISTS `tb_telefone` (
  `id_telefone` int NOT NULL,
  `telefone_tutor` int NOT NULL,
  `id_user` int DEFAULT NULL,
  PRIMARY KEY (`id_telefone`),
  KEY `fk_teluser` (`id_user`),
  CONSTRAINT `fk_teluser` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela bd_adocaopet.tb_tutor
CREATE TABLE IF NOT EXISTS `tb_tutor` (
  `id_tutor` int NOT NULL,
  `nome_tutor` varchar(150) NOT NULL,
  `email_tutor` varchar(180) NOT NULL,
  PRIMARY KEY (`id_tutor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela bd_adocaopet.tb_tutor_has_tb_animais
CREATE TABLE IF NOT EXISTS `tb_tutor_has_tb_animais` (
  `id_tutor` int NOT NULL,
  `id_animais` int NOT NULL,
  PRIMARY KEY (`id_tutor`,`id_animais`),
  KEY `id_animais` (`id_animais`),
  CONSTRAINT `tb_tutor_has_tb_animais_ibfk_1` FOREIGN KEY (`id_tutor`) REFERENCES `tb_tutor` (`id_tutor`),
  CONSTRAINT `tb_tutor_has_tb_animais_ibfk_2` FOREIGN KEY (`id_animais`) REFERENCES `tb_animais` (`id_animais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela bd_adocaopet.tb_tutor_has_tb_endereco
CREATE TABLE IF NOT EXISTS `tb_tutor_has_tb_endereco` (
  `id_tutor` int NOT NULL,
  `id_endereco` int NOT NULL,
  PRIMARY KEY (`id_tutor`,`id_endereco`),
  KEY `id_endereco` (`id_endereco`),
  CONSTRAINT `tb_tutor_has_tb_endereco_ibfk_1` FOREIGN KEY (`id_tutor`) REFERENCES `tb_tutor` (`id_tutor`),
  CONSTRAINT `tb_tutor_has_tb_endereco_ibfk_2` FOREIGN KEY (`id_endereco`) REFERENCES `tb_endereco` (`id_endereco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela bd_adocaopet.tb_tutor_tb_telefone_tb_veterinario
CREATE TABLE IF NOT EXISTS `tb_tutor_tb_telefone_tb_veterinario` (
  `id_vet` int NOT NULL,
  `id_tutor` int NOT NULL,
  `id_telefone` int NOT NULL,
  PRIMARY KEY (`id_vet`,`id_tutor`,`id_telefone`),
  KEY `id_tutor` (`id_tutor`),
  KEY `id_telefone` (`id_telefone`),
  CONSTRAINT `tb_tutor_tb_telefone_tb_veterinario_ibfk_1` FOREIGN KEY (`id_vet`) REFERENCES `tb_veterinario` (`id_vet`),
  CONSTRAINT `tb_tutor_tb_telefone_tb_veterinario_ibfk_2` FOREIGN KEY (`id_tutor`) REFERENCES `tb_tutor` (`id_tutor`),
  CONSTRAINT `tb_tutor_tb_telefone_tb_veterinario_ibfk_3` FOREIGN KEY (`id_telefone`) REFERENCES `tb_telefone` (`id_telefone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela bd_adocaopet.tb_user
CREATE TABLE IF NOT EXISTS `tb_user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nome_user` varchar(80) NOT NULL,
  `email_user` varchar(100) NOT NULL,
  `senha_user` varchar(150) NOT NULL,
  `foto_user` varchar(150) DEFAULT NULL,
  `classe_user` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela bd_adocaopet.tb_veterinario
CREATE TABLE IF NOT EXISTS `tb_veterinario` (
  `id_vet` int NOT NULL,
  `nome_vet` varchar(45) NOT NULL,
  `especialidade_vet` varchar(60) NOT NULL,
  `email_vet` varchar(180) NOT NULL,
  PRIMARY KEY (`id_vet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Exportação de dados foi desmarcado.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
