-- Progettazione Web 
DROP DATABASE if exists DataBaseMindwords; 
CREATE DATABASE DataBaseMindwords; 
USE DataBaseMindwords; 
-- MySQL dump 10.13  Distrib 5.7.28, for Win64 (x86_64)
--
-- Host: localhost    Database: DataBaseMindwords
-- ------------------------------------------------------
-- Server version	5.7.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `domandadisicurezza`
--

DROP TABLE IF EXISTS `domandadisicurezza`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `domandadisicurezza` (
  `keydomanda` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `domanda` varchar(100) NOT NULL,
  PRIMARY KEY (`keydomanda`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `domandadisicurezza`
--

LOCK TABLES `domandadisicurezza` WRITE;
/*!40000 ALTER TABLE `domandadisicurezza` DISABLE KEYS */;
INSERT INTO `domandadisicurezza` VALUES (1,'Qual è il nome del tuo primo animale domestico?'),(2,'Qual è il cognome da nubile di tua madre?'),(3,'In quale città sei nato/a?'),(4,'Qual è il nome della tua scuola elementare?'),(5,'Qual è il nome del tuo insegnante preferito?'),(6,'Qual è il tuo cibo preferito?'),(7,'Qual è il titolo del tuo libro preferito?'),(8,'Qual è stato il modello della tua prima auto?'),(9,'Qual è il nome del tuo migliore amico?'),(10,'Qual è il secondo nome di tuo padre?'),(11,'Qual è il nome della strada in cui sei cresciuto/a?'),(12,'In quale ospedale sei nato/a?'),(13,'Qual è il nome del tuo primo/a datore di lavoro?'),(14,'In quale città hai incontrato il tuo/a partner per la prima volta?'),(15,'Qual è il nome del tuo primo/a fidanzato/a?'),(16,'Qual è il nome del tuo primo/a insegnante?'),(17,'Qual è il cognome del tuo miglior amico/a al liceo?'),(18,'Qual è il tuo film preferito?'),(19,'In quale anno ti sei diplomato/a?'),(20,'Qual è il nome del tuo primo animale domestico?');
/*!40000 ALTER TABLE `domandadisicurezza` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friend`
--

DROP TABLE IF EXISTS `friend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friend` (
  `user1` varchar(30) NOT NULL,
  `user2` varchar(30) NOT NULL,
  PRIMARY KEY (`user1`,`user2`),
  KEY `user2` (`user2`),
  CONSTRAINT `friend_ibfk_1` FOREIGN KEY (`user1`) REFERENCES `utente` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `friend_ibfk_2` FOREIGN KEY (`user2`) REFERENCES `utente` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friend`
--

LOCK TABLES `friend` WRITE;
/*!40000 ALTER TABLE `friend` DISABLE KEYS */;
INSERT INTO `friend` VALUES ('utente1','Test'),('utente2','utente1'),('Test','utente2'),('utente3','utente2'),('Test','utente3');
/*!40000 ALTER TABLE `friend` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger AmiciziaPresente before insert on friend for each row 
begin 
	IF (NEW.user1 = NEW.user2) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = "L'amicizia con se stessi è apprezzata, ma non in questo contetso";
    END IF;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `modalita`
--

DROP TABLE IF EXISTS `modalita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modalita` (
  `idmodalita` tinyint(4) NOT NULL AUTO_INCREMENT,
  `nomemodalita` varchar(30) NOT NULL,
  PRIMARY KEY (`idmodalita`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modalita`
--

LOCK TABLES `modalita` WRITE;
/*!40000 ALTER TABLE `modalita` DISABLE KEYS */;
INSERT INTO `modalita` VALUES (1,'Wordle'),(2,'Mastermind');
/*!40000 ALTER TABLE `modalita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parola`
--

DROP TABLE IF EXISTS `parola`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parola` (
  `termine` varchar(6) NOT NULL,
  PRIMARY KEY (`termine`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parola`
--

LOCK TABLES `parola` WRITE;
/*!40000 ALTER TABLE `parola` DISABLE KEYS */;
INSERT INTO `parola` VALUES ('abbi'),('abete'),('abiuri'),('accado'),('acuta'),('adagia'),('adoro'),('adulai'),('affare'),('affili'),('aggira'),('albe'),('alga'),('alla'),('allora'),('alzate'),('amano'),('amassi'),('amate'),('amore'),('amorfo'),('ampi'),('ampio'),('anditi'),('animo'),('aperta'),('aperti'),('arai'),('archi'),('area'),('aree'),('arie'),('arino'),('arto'),('assi'),('atomi'),('attua'),('avra'),('avvio'),('badano'),('bagni'),('baie'),('banca'),('bandii'),('base'),('basi'),('batte'),('bave'),('bavero'),('becco'),('bevono'),('bimbi'),('boia'),('bosco'),('brace'),('bramo'),('bravo'),('bruci'),('brulle'),('buio'),('buon'),('calare'),('calza'),('cane'),('canore'),('canori'),('canti'),('caos'),('care'),('caro'),('carri'),('carro'),('casa'),('caso'),('casto'),('cavano'),('cave'),('ceduta'),('celare'),('celi'),('cera'),('cero'),('chine'),('cibo'),('ciclo'),('cielo'),('ciglia'),('coda'),('colli'),('colmai'),('comune'),('coni'),('cono'),('copra'),('copre'),('cori'),('corna'),('cosmo'),('cotto'),('covo'),('crea'),('creo'),('cresco'),('cresta'),('crete'),('cromo'),('crude'),('cubi'),('dacci'),('dado'),('dalle'),('danza'),('danzi'),('data'),('dato'),('dedico'),('degna'),('denti'),('deriva'),('destro'),('deve'),('devi'),('devo'),('dica'),('dice'),('dici'),('dilui'),('diluvi'),('dipani'),('dipesi'),('dira'),('dirci'),('dire'),('diro'),('dito'),('dive'),('divina'),('divini'),('divora'),('dogane'),('dolore'),('domavo'),('dormi'),('dose'),('dotti'),('droga'),('dubito'),('ebete'),('ecco'),('eluse'),('enti'),('entro'),('eppure'),('equi'),('erba'),('esca'),('esce'),('esco'),('esige'),('esimi'),('estati'),('estivi'),('esule'),('etti'),('fami'),('famosa'),('fango'),('fante'),('fasi'),('fata'),('fate'),('fatene'),('fato'),('fede'),('federe'),('ferie'),('fermo'),('feso'),('fico'),('fidato'),('figli'),('filo'),('fini'),('fino'),('fiore'),('firma'),('fissai'),('fiuti'),('fluidi'),('fluire'),('foca'),('foce'),('fondo'),('forera'),('formai'),('forte'),('fosco'),('fredde'),('fretta'),('frodi'),('fronte'),('fugai'),('fumo'),('fusi'),('gamba'),('garbo'),('gela'),('gelate'),('gemma'),('gesti'),('giace'),('giara'),('gira'),('girate'),('girati'),('giri'),('gite'),('giunte'),('giuri'),('goffo'),('grado'),('grava'),('grave'),('gravo'),('grazie'),('guasto'),('gufo'),('guizzo'),('gusci'),('idee'),('idoneo'),('iene'),('ignari'),('imperi'),('impuro'),('incubo'),('inerte'),('inetti'),('inezie'),('infame'),('inizio'),('insila'),('invoco'),('iodio'),('ironia'),('isolo'),('istiga'),('lago'),('lanose'),('lascio'),('lastre'),('leale'),('lega'),('leghi'),('letto'),('levo'),('lidi'),('lime'),('limoni'),('lingue'),('lira'),('lodai'),('lodata'),('loro'),('luce'),('lupi'),('lupo'),('madre'),('maglia'),('maiale'),('male'),('mamme'),('marche'),('mare'),('marea'),('marino'),('marmo'),('massa'),('matte'),('matti'),('mature'),('maturo'),('meduse'),('melo'),('mena'),('menai'),('merci'),('mesi'),('mesto'),('mete'),('mezzo'),('mica'),('mine'),('miri'),('misi'),('mista'),('miti'),('mitico'),('modica'),('molla'),('molo'),('molta'),('monaco'),('mora'),('morda'),('more'),('morsi'),('muffe'),('muggi'),('mugola'),('mule'),('muro'),('muti'),('muto'),('nafta'),('nafte'),('nata'),('nate'),('negati'),('negavo'),('neghi'),('negli'),('nera'),('ninfa'),('noce'),('nome'),('nomi'),('nomina'),('norme'),('note'),('nuca'),('nuoto'),('nutre'),('occupi'),('odia'),('odiavi'),('odino'),('odorai'),('oggi'),('oliamo'),('olio'),('olmo'),('ondula'),('oneri'),('operi'),('opina'),('orari'),('ordii'),('ordina'),('orma'),('orme'),('orna'),('osare'),('oserei'),('osiate'),('osti'),('pace'),('paese'),('paga'),('pagina'),('paia'),('pali'),('palle'),('pance'),('pane'),('parla'),('parve'),('patto'),('paure'),('pece'),('pecore'),('peggio'),('pela'),('pene'),('pesa'),('piatti'),('piena'),('piglia'),('pini'),('pioppo'),('plance'),('pochi'),('podio'),('poesia'),('pomata'),('porri'),('porta'),('posa'),('posavi'),('poso'),('possi'),('posti'),('pregai'),('preso'),('pulso'),('puntai'),('punti'),('pure'),('puro'),('puzza'),('quarzi'),('querce'),('radi'),('rane'),('rapa'),('rape'),('rauco'),('rebus'),('recidi'),('reco'),('redigo'),('regina'),('regoli'),('remi'),('remota'),('reni'),('resero'),('resi'),('restio'),('resto'),('reti'),('riceve'),('ridete'),('rime'),('rise'),('rito'),('riva'),('rive'),('rivela'),('roba'),('rombo'),('rosso'),('rovi'),('rozzi'),('ruba'),('ruppe'),('sacre'),('sacro'),('sala'),('sale'),('salo'),('salsa'),('sanate'),('santa'),('sarai'),('sazi'),('sbuffo'),('scafo'),('scagli'),('scala'),('scarsa'),('scoli'),('sconti'),('scopo'),('scoppi'),('scopro'),('scorra'),('scosti'),('scuola'),('sdraio'),('sedani'),('sedo'),('selva'),('senato'),('sera'),('serva'),('servi'),('sfarzo'),('sfilo'),('sfonda'),('sfondo'),('sfregi'),('sgozzi'),('sicuro'),('siepe'),('silura'),('slacci'),('slogo'),('smesso'),('smilzo'),('soffro'),('solida'),('solo'),('sopite'),('sorti'),('spalmi'),('spanda'),('spegne'),('spento'),('spilla'),('spiro'),('starei'),('stazzi'),('stelo'),('stesa'),('stia'),('stiamo'),('stufi'),('suda'),('sulle'),('sullo'),('svago'),('sviati'),('svio'),('svisa'),('svolga'),('tacco'),('tastai'),('tedi'),('tela'),('tema'),('temi'),('tempo'),('tempra'),('tesa'),('tini'),('tinti'),('tirava'),('tonde'),('tono'),('tonta'),('torba'),('tori'),('torri'),('tosai'),('toste'),('totale'),('tozza'),('tracce'),('trecca'),('tremai'),('trilla'),('trippe'),('trota'),('turi'),('turri'),('tutelo'),('tutore'),('udii'),('ultimo'),('umane'),('unire'),('unite'),('unti'),('uomo'),('urne'),('urti'),('urto'),('uscii'),('usiate'),('usurai'),('usurpi'),('vado'),('vaiolo'),('vana'),('vanita'),('vantai'),('vari'),('vasca'),('vasi'),('vasto'),('vedi'),('velato'),('vele'),('veli'),('venale'),('venali'),('venga'),('venute'),('vere'),('verga'),('veto'),('vide'),('villa'),('vino'),('virera'),('virile'),('vischi'),('visite'),('vispa'),('vispo'),('vista'),('visti'),('vite'),('vivete'),('voglia'),('volano'),('volava'),('volpi'),('volt'),('voluto'),('vorace'),('voraci'),('vuoto'),('zaino'),('zappo'),('zero');
/*!40000 ALTER TABLE `parola` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partita`
--

DROP TABLE IF EXISTS `partita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partita` (
  `userSessione` varchar(30) NOT NULL,
  `inizioSessione` datetime NOT NULL,
  `tempo` time NOT NULL,
  `tentativi` tinyint(4) NOT NULL,
  `punteggio` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`userSessione`,`inizioSessione`,`tentativi`,`punteggio`),
  CONSTRAINT `partita_ibfk_1` FOREIGN KEY (`userSessione`, `inizioSessione`) REFERENCES `sessione` (`iduser`, `inizio`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partita`
--

LOCK TABLES `partita` WRITE;
/*!40000 ALTER TABLE `partita` DISABLE KEYS */;
INSERT INTO `partita` VALUES ('utente1','2024-11-06 11:02:33','00:01:30',4,25),('utente1','2024-11-06 11:02:33','00:00:53',5,33),('utente1','2024-11-06 11:06:50','00:00:31',2,312),('utente1','2024-11-06 11:06:50','00:00:35',3,100),('utente1','2024-11-06 11:06:50','00:02:53',4,37),('utente1','2024-11-06 11:06:50','00:01:59',4,150),('utente1','2024-11-06 11:06:50','00:02:22',6,37),('utente1','2024-11-06 11:06:50','00:01:06',6,75),('utente1','2024-11-06 11:22:28','00:01:18',2,100),('utente1','2024-11-06 11:22:28','00:00:09',3,225),('utente1','2024-11-06 11:22:28','00:00:09',5,50),('utente1','2024-11-06 11:26:37','00:01:23',4,28),('utente1','2024-11-06 11:26:37','00:01:07',4,57),('utente1','2024-11-06 11:29:53','00:00:45',4,50),('utente1','2024-11-06 11:29:53','00:00:59',4,100),('utente1','2024-11-06 11:29:53','00:00:47',4,150),('utente1','2024-11-06 11:29:53','00:01:56',5,133),('utente1','2024-11-06 11:35:05','00:01:09',5,20),('utente2','2024-11-06 11:38:24','00:00:51',5,20),('utente2','2024-11-06 11:40:52','00:01:21',5,33),('utente2','2024-11-06 11:40:52','00:01:12',5,66),('utente3','2024-11-06 11:47:46','00:00:03',1,300),('utente3','2024-11-06 11:47:46','00:00:08',1,450),('utente3','2024-11-06 11:47:46','00:00:06',1,600),('utente3','2024-11-06 11:47:46','00:00:04',1,750),('utente3','2024-11-06 11:47:46','00:00:03',1,900),('utente3','2024-11-06 11:47:46','00:00:05',1,1050),('utente3','2024-11-06 11:47:46','00:00:02',1,1200),('utente3','2024-11-06 11:47:46','00:00:02',1,1350),('utente3','2024-11-06 11:47:46','00:00:02',1,1500),('utente3','2024-11-06 11:47:46','00:00:04',1,1650),('utente3','2024-11-06 11:47:46','00:01:30',3,75),('utente3','2024-11-06 11:50:32','00:00:08',1,100),('utente3','2024-11-06 11:50:32','00:00:01',1,200),('utente3','2024-11-06 11:50:32','00:00:01',1,300),('utente3','2024-11-06 11:50:32','00:00:03',1,400),('utente3','2024-11-06 11:50:32','00:00:02',1,500),('utente3','2024-11-06 11:50:32','00:00:04',1,600),('utente3','2024-11-06 11:50:32','00:00:02',1,700),('utente3','2024-11-06 11:50:32','00:00:01',1,800),('utente3','2024-11-06 11:50:32','00:00:03',2,720);
/*!40000 ALTER TABLE `partita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pending`
--

DROP TABLE IF EXISTS `pending`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pending` (
  `sender` varchar(30) NOT NULL,
  `reciver` varchar(30) NOT NULL,
  `dataInvio` date NOT NULL,
  PRIMARY KEY (`sender`,`reciver`),
  KEY `reciver` (`reciver`),
  CONSTRAINT `pending_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `utente` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pending_ibfk_2` FOREIGN KEY (`reciver`) REFERENCES `utente` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pending`
--

LOCK TABLES `pending` WRITE;
/*!40000 ALTER TABLE `pending` DISABLE KEYS */;
INSERT INTO `pending` VALUES ('utente3','utente1','2024-11-06'),('utente4','Test','2024-11-07');
/*!40000 ALTER TABLE `pending` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger PresenteParallela before insert on pending for each row 
begin 
    IF EXISTS (
        SELECT dataInvio
        FROM pending 
        WHERE (sender = NEW.reciver AND reciver = NEW.sender)
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = "Impossibile aggiugere richiesta (parallela presente)";
    END IF;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger AutoRicheista before insert on pending for each row 
begin 
    IF (NEW.sender = NEW.reciver) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = "Impossibile aggiugere richiesta (non si può inviare una richiesta a se stessi)";
    END IF;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `sessione`
--

DROP TABLE IF EXISTS `sessione`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessione` (
  `iduser` varchar(30) NOT NULL,
  `inizio` datetime NOT NULL,
  `modalita` tinyint(4) NOT NULL,
  `lughezzaSequenza` smallint(5) unsigned NOT NULL,
  `tentativiMax` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`iduser`,`inizio`),
  KEY `modalita` (`modalita`),
  CONSTRAINT `sessione_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `utente` (`username`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `sessione_ibfk_2` FOREIGN KEY (`modalita`) REFERENCES `modalita` (`idmodalita`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessione`
--

LOCK TABLES `sessione` WRITE;
/*!40000 ALTER TABLE `sessione` DISABLE KEYS */;
INSERT INTO `sessione` VALUES ('utente1','2024-11-06 11:02:33',1,4,6),('utente1','2024-11-06 11:06:50',1,5,6),('utente1','2024-11-06 11:19:16',1,5,5),('utente1','2024-11-06 11:22:28',1,6,5),('utente1','2024-11-06 11:26:37',2,4,7),('utente1','2024-11-06 11:29:53',2,5,6),('utente1','2024-11-06 11:35:05',2,4,5),('utente2','2024-11-06 11:38:24',1,5,5),('utente2','2024-11-06 11:40:52',2,5,6),('utente2','2024-11-06 11:44:21',2,6,5),('utente3','2024-11-06 11:47:46',1,6,4),('utente3','2024-11-06 11:50:29',2,5,6),('utente3','2024-11-06 11:50:32',1,5,5),('utente3','2024-11-06 11:51:37',2,5,6);
/*!40000 ALTER TABLE `sessione` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utente`
--

DROP TABLE IF EXISTS `utente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utente` (
  `username` varchar(30) NOT NULL,
  `password` char(60) NOT NULL,
  `domandadisicurezza` int(10) unsigned NOT NULL,
  `risposta` char(60) NOT NULL,
  PRIMARY KEY (`username`),
  KEY `domandadisicurezza` (`domandadisicurezza`),
  CONSTRAINT `utente_ibfk_1` FOREIGN KEY (`domandadisicurezza`) REFERENCES `domandadisicurezza` (`keydomanda`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utente`
--

LOCK TABLES `utente` WRITE;
/*!40000 ALTER TABLE `utente` DISABLE KEYS */;
INSERT INTO `utente` VALUES ('Test','$2y$10$3rrYtj/qMJwXdTKUX/2fYevNZm8LYk6YyO35rWGHTOZz.4v4mLQ4e',1,'$2y$10$I1sNEOcpXZpuXE4IchcH..F.xeKWGw0vczD6Sgmq6xhH1sYMQqq4K'),('utente1','$2y$10$bKiUZYvq0wtgcIClxNUHkuYMj5JEtYoTRtPda.Yhnek5JQwkvBUJ.',6,'$2y$10$p.yRwNJfha2UpQtSXdME7eo5lYeeu5TNqWfq2whMY2MfxLJiGvrpC'),('utente2','$2y$10$m97xRSFld37Phk1d8PS13uBHMbWkuLBk6RmM/PohIIzALnOIWQS06',18,'$2y$10$c0WjfXl8LCjI/uTkvAjcVOzN5alxNV9i0r7Su0/6UYyorsnEwk9zq'),('utente3','$2y$10$cixH.zfWNClyDG2Sa67pDuCJlDYGnaMZSkYNDNsuzH8KW0JRLnxDi',8,'$2y$10$h8U7v7Z2BmNqouZY0FefoeUyYOL7f4Zngi1/2nCQjiJHdtFIIkXPe'),('utente4','$2y$10$u4.Nyq.PjQ1lbAruPZR9B.XGl0wn5OoGXwzRs4ORrEIXbIJIfxRTO',19,'$2y$10$gNc0f6MuCHJ5bc2l3PjsV.4hjkaYr5vUUG38rnXa/JYf/14yA05nK');
/*!40000 ALTER TABLE `utente` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-07 16:05:01
