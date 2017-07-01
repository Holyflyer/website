SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;



CREATE TABLE IF NOT EXISTS `items` (
  `server_id` int(5) NOT NULL auto_increment primary key,
  `hostname` varchar(50) DEFAULT NULL,
  `environment` varchar(100) DEFAULT NULL,
  `virtual_ip` varchar(21) DEFAULT NULL,
  `ip_address` varchar(21) DEFAULT NULL,
  `os` varchar(50) DEFAULT NULL,
  `application` varchar(100) DEFAULT NULL,
  `security_zone` varchar(50) DEFAULT NULL,
  `client` varchar(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;