-- MySQL dump 10.13  Distrib 8.0.39, for Linux (x86_64)
--
-- Host: localhost    Database: bd_adocaoPet
-- ------------------------------------------------------
-- Server version	8.0.39-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tb_admin`
--

DROP TABLE IF EXISTS `tb_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_admin` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  PRIMARY KEY (`id_admin`),
  KEY `fk_admuser` (`id_user`),
  CONSTRAINT `fk_admuser` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_admin`
--

LOCK TABLES `tb_admin` WRITE;
/*!40000 ALTER TABLE `tb_admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_adocao`
--

DROP TABLE IF EXISTS `tb_adocao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_adocao` (
  `id_adocao` int NOT NULL AUTO_INCREMENT,
  `data_adocao` date DEFAULT NULL,
  `id_adotante` int DEFAULT NULL,
  PRIMARY KEY (`id_adocao`),
  KEY `fk_adocAdotante` (`id_adotante`),
  CONSTRAINT `fk_adocAdotante` FOREIGN KEY (`id_adotante`) REFERENCES `tb_adotante` (`id_adotante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_adocao`
--

LOCK TABLES `tb_adocao` WRITE;
/*!40000 ALTER TABLE `tb_adocao` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_adocao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_adotante`
--

DROP TABLE IF EXISTS `tb_adotante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_adotante` (
  `id_adotante` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  PRIMARY KEY (`id_adotante`),
  KEY `fk_adouser` (`id_user`),
  CONSTRAINT `fk_adouser` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_adotante`
--

LOCK TABLES `tb_adotante` WRITE;
/*!40000 ALTER TABLE `tb_adotante` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_adotante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_agendoacao`
--

DROP TABLE IF EXISTS `tb_agendoacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_agendoacao` (
  `id_agendoacao` int NOT NULL,
  `data_agendoacao` date NOT NULL,
  `desc_agendoacao` varchar(350) DEFAULT NULL,
  `endereco_agendoacao` varchar(100) DEFAULT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_agendoacao`),
  KEY `fk_agendoacao_user` (`id_user`),
  CONSTRAINT `fk_agendoacao_user` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_agendoacao`
--

LOCK TABLES `tb_agendoacao` WRITE;
/*!40000 ALTER TABLE `tb_agendoacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_agendoacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_animais`
--

DROP TABLE IF EXISTS `tb_animais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_animais` (
  `id_animais` int NOT NULL,
  `nome_animal` varchar(100) NOT NULL,
  `especie_animal` varchar(100) NOT NULL,
  `raca_animal` varchar(90) NOT NULL,
  `sexo_animal` enum('M','F') NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `id_doador` int DEFAULT NULL,
  `id_doacao` int DEFAULT NULL,
  `id_adocao` int DEFAULT NULL,
  `id_adotante` int DEFAULT NULL,
  PRIMARY KEY (`id_animais`),
  KEY `fk_animaldoador` (`id_doador`),
  KEY `fk_animaldoacao` (`id_doacao`),
  KEY `fk_animaladocao` (`id_adocao`),
  KEY `fk_animaladotante` (`id_adotante`),
  CONSTRAINT `fk_animaladocao` FOREIGN KEY (`id_adocao`) REFERENCES `tb_adocao` (`id_adocao`),
  CONSTRAINT `fk_animaladotante` FOREIGN KEY (`id_adotante`) REFERENCES `tb_adotante` (`id_adotante`),
  CONSTRAINT `fk_animaldoacao` FOREIGN KEY (`id_doacao`) REFERENCES `tb_doacao` (`id_doacao`),
  CONSTRAINT `fk_animaldoador` FOREIGN KEY (`id_doador`) REFERENCES `tb_doador` (`id_doador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_animais`
--

LOCK TABLES `tb_animais` WRITE;
/*!40000 ALTER TABLE `tb_animais` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_animais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_animais_veterinario_consultas_procedimentos`
--

DROP TABLE IF EXISTS `tb_animais_veterinario_consultas_procedimentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_animais_veterinario_consultas_procedimentos` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_animais_veterinario_consultas_procedimentos`
--

LOCK TABLES `tb_animais_veterinario_consultas_procedimentos` WRITE;
/*!40000 ALTER TABLE `tb_animais_veterinario_consultas_procedimentos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_animais_veterinario_consultas_procedimentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_consultas`
--

DROP TABLE IF EXISTS `tb_consultas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_consultas` (
  `id_consultas` int NOT NULL,
  `data_consulta` datetime NOT NULL,
  `motivo_consulta` text NOT NULL,
  `obs_consulta` text NOT NULL,
  PRIMARY KEY (`id_consultas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_consultas`
--

LOCK TABLES `tb_consultas` WRITE;
/*!40000 ALTER TABLE `tb_consultas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_consultas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_doacao`
--

DROP TABLE IF EXISTS `tb_doacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_doacao` (
  `id_doacao` int NOT NULL AUTO_INCREMENT,
  `data_doacao` date NOT NULL,
  `desc_doacao` varchar(200) DEFAULT NULL,
  `id_doador` int DEFAULT NULL,
  PRIMARY KEY (`id_doacao`),
  KEY `fk_doacDoador` (`id_doador`),
  CONSTRAINT `fk_doacDoador` FOREIGN KEY (`id_doador`) REFERENCES `tb_doador` (`id_doador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_doacao`
--

LOCK TABLES `tb_doacao` WRITE;
/*!40000 ALTER TABLE `tb_doacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_doacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_doador`
--

DROP TABLE IF EXISTS `tb_doador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_doador` (
  `id_doador` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  PRIMARY KEY (`id_doador`),
  KEY `fk_doauser` (`id_user`),
  CONSTRAINT `fk_doauser` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_doador`
--

LOCK TABLES `tb_doador` WRITE;
/*!40000 ALTER TABLE `tb_doador` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_doador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_endereco`
--

DROP TABLE IF EXISTS `tb_endereco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_endereco` (
  `id_endereco` int NOT NULL,
  `estado_ende` varchar(30) NOT NULL,
  `cidade_ende` varchar(85) NOT NULL,
  `rua_ende` varchar(85) NOT NULL,
  `bairro_ende` varchar(85) NOT NULL,
  `numero_ende` int NOT NULL,
  PRIMARY KEY (`id_endereco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_endereco`
--

LOCK TABLES `tb_endereco` WRITE;
/*!40000 ALTER TABLE `tb_endereco` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_endereco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_endereco_has_tb_veterinario`
--

DROP TABLE IF EXISTS `tb_endereco_has_tb_veterinario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_endereco_has_tb_veterinario` (
  `id_vet` int NOT NULL,
  `id_endereco` int NOT NULL,
  PRIMARY KEY (`id_vet`,`id_endereco`),
  KEY `id_endereco` (`id_endereco`),
  CONSTRAINT `tb_endereco_has_tb_veterinario_ibfk_1` FOREIGN KEY (`id_vet`) REFERENCES `tb_veterinario` (`id_vet`),
  CONSTRAINT `tb_endereco_has_tb_veterinario_ibfk_2` FOREIGN KEY (`id_endereco`) REFERENCES `tb_endereco` (`id_endereco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_endereco_has_tb_veterinario`
--

LOCK TABLES `tb_endereco_has_tb_veterinario` WRITE;
/*!40000 ALTER TABLE `tb_endereco_has_tb_veterinario` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_endereco_has_tb_veterinario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_enduser`
--

DROP TABLE IF EXISTS `tb_enduser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_enduser` (
  `id_user` int DEFAULT NULL,
  `id_endereco` int DEFAULT NULL,
  KEY `fk_enduser` (`id_user`),
  KEY `fk_userend` (`id_endereco`),
  CONSTRAINT `fk_enduser` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`),
  CONSTRAINT `fk_userend` FOREIGN KEY (`id_endereco`) REFERENCES `tb_endereco` (`id_endereco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_enduser`
--

LOCK TABLES `tb_enduser` WRITE;
/*!40000 ALTER TABLE `tb_enduser` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_enduser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_procedimentos`
--

DROP TABLE IF EXISTS `tb_procedimentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_procedimentos` (
  `id_proce` int NOT NULL,
  `inicio_proce` date NOT NULL,
  `fim_proce` date NOT NULL,
  `descricao_proce` text NOT NULL,
  `vacinaS_proce` varchar(60) NOT NULL,
  `data_vacina` date NOT NULL,
  PRIMARY KEY (`id_proce`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_procedimentos`
--

LOCK TABLES `tb_procedimentos` WRITE;
/*!40000 ALTER TABLE `tb_procedimentos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_procedimentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_telefone`
--

DROP TABLE IF EXISTS `tb_telefone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_telefone` (
  `id_telefone` int NOT NULL,
  `telefone_tutor` int NOT NULL,
  `id_user` int DEFAULT NULL,
  PRIMARY KEY (`id_telefone`),
  KEY `fk_teluser` (`id_user`),
  CONSTRAINT `fk_teluser` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_telefone`
--

LOCK TABLES `tb_telefone` WRITE;
/*!40000 ALTER TABLE `tb_telefone` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_telefone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_tutor`
--

DROP TABLE IF EXISTS `tb_tutor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_tutor` (
  `id_tutor` int NOT NULL,
  `nome_tutor` varchar(150) NOT NULL,
  `email_tutor` varchar(180) NOT NULL,
  PRIMARY KEY (`id_tutor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_tutor`
--

LOCK TABLES `tb_tutor` WRITE;
/*!40000 ALTER TABLE `tb_tutor` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_tutor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_tutor_has_tb_animais`
--

DROP TABLE IF EXISTS `tb_tutor_has_tb_animais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_tutor_has_tb_animais` (
  `id_tutor` int NOT NULL,
  `id_animais` int NOT NULL,
  PRIMARY KEY (`id_tutor`,`id_animais`),
  KEY `id_animais` (`id_animais`),
  CONSTRAINT `tb_tutor_has_tb_animais_ibfk_1` FOREIGN KEY (`id_tutor`) REFERENCES `tb_tutor` (`id_tutor`),
  CONSTRAINT `tb_tutor_has_tb_animais_ibfk_2` FOREIGN KEY (`id_animais`) REFERENCES `tb_animais` (`id_animais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_tutor_has_tb_animais`
--

LOCK TABLES `tb_tutor_has_tb_animais` WRITE;
/*!40000 ALTER TABLE `tb_tutor_has_tb_animais` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_tutor_has_tb_animais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_tutor_has_tb_endereco`
--

DROP TABLE IF EXISTS `tb_tutor_has_tb_endereco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_tutor_has_tb_endereco` (
  `id_tutor` int NOT NULL,
  `id_endereco` int NOT NULL,
  PRIMARY KEY (`id_tutor`,`id_endereco`),
  KEY `id_endereco` (`id_endereco`),
  CONSTRAINT `tb_tutor_has_tb_endereco_ibfk_1` FOREIGN KEY (`id_tutor`) REFERENCES `tb_tutor` (`id_tutor`),
  CONSTRAINT `tb_tutor_has_tb_endereco_ibfk_2` FOREIGN KEY (`id_endereco`) REFERENCES `tb_endereco` (`id_endereco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_tutor_has_tb_endereco`
--

LOCK TABLES `tb_tutor_has_tb_endereco` WRITE;
/*!40000 ALTER TABLE `tb_tutor_has_tb_endereco` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_tutor_has_tb_endereco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_tutor_tb_telefone_tb_veterinario`
--

DROP TABLE IF EXISTS `tb_tutor_tb_telefone_tb_veterinario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_tutor_tb_telefone_tb_veterinario` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_tutor_tb_telefone_tb_veterinario`
--

LOCK TABLES `tb_tutor_tb_telefone_tb_veterinario` WRITE;
/*!40000 ALTER TABLE `tb_tutor_tb_telefone_tb_veterinario` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_tutor_tb_telefone_tb_veterinario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_user`
--

DROP TABLE IF EXISTS `tb_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nome_user` varchar(80) NOT NULL,
  `email_user` varchar(100) NOT NULL,
  `senha_user` varchar(150) NOT NULL,
  `foto_user` varchar(150) DEFAULT NULL,
  `classe_user` varchar(45) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_user`
--

LOCK TABLES `tb_user` WRITE;
/*!40000 ALTER TABLE `tb_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_veterinario`
--

DROP TABLE IF EXISTS `tb_veterinario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_veterinario` (
  `id_vet` int NOT NULL,
  `nome_vet` varchar(45) NOT NULL,
  `especialidade_vet` varchar(60) NOT NULL,
  `email_vet` varchar(180) NOT NULL,
  PRIMARY KEY (`id_vet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_veterinario`
--

LOCK TABLES `tb_veterinario` WRITE;
/*!40000 ALTER TABLE `tb_veterinario` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_veterinario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-20 16:03:06
