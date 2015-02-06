SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `af_companys`
-- ----------------------------
DROP TABLE IF EXISTS `af_companys`;
CREATE TABLE `af_companys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `street_name` varchar(255) DEFAULT NULL,
  `street_number` varchar(50) DEFAULT NULL,
  `city_zip` varchar(10) DEFAULT NULL,
  `city_name` varchar(150) DEFAULT NULL,
  `service` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of af_companys
-- ----------------------------
INSERT INTO `af_companys` VALUES ('1', 'Scheibenrein GmbH & Co. KG', 'Klarestraße', '16', '12345', 'Hierunddort', '5');
INSERT INTO `af_companys` VALUES ('3', '<?adi | Web- & Softwareentwicklung', 'Oppenhoffallee', '41', '52066', 'Aachen', '1');

-- ----------------------------
-- Table structure for `af_companys_contacts`
-- ----------------------------
DROP TABLE IF EXISTS `af_companys_contacts`;
CREATE TABLE `af_companys_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_telephone_private` varchar(100) DEFAULT NULL,
  `contact_telephone_mobile` varchar(100) DEFAULT NULL,
  `contact_telephone_public` varchar(100) DEFAULT NULL,
  `contact_telephone_fax` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of af_companys_contacts
-- ----------------------------
INSERT INTO `af_companys_contacts` VALUES ('30', '3', 'Adrian', 'Preuß', 'info@adi-code.de', '', '015221245874', '', '');

-- ----------------------------
-- Table structure for `af_contracts`
-- ----------------------------
DROP TABLE IF EXISTS `af_contracts`;
CREATE TABLE `af_contracts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` varchar(255) DEFAULT NULL,
  `contact_telephone` varchar(255) DEFAULT NULL,
  `contact_fax` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `rental_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer_contact` varchar(255) DEFAULT NULL,
  `informations` longtext,
  `insurance` enum('YES','NO') DEFAULT 'NO',
  `customer_charging` enum('YES','NO') DEFAULT 'NO',
  `time_created` datetime DEFAULT NULL,
  `time_contract` datetime DEFAULT NULL,
  `from` int(11) DEFAULT NULL,
  `contact_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of af_contracts
-- ----------------------------

-- ----------------------------
-- Table structure for `af_customers`
-- ----------------------------
DROP TABLE IF EXISTS `af_customers`;
CREATE TABLE `af_customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_telephone_private` varchar(100) DEFAULT NULL,
  `contact_telephone_mobile` varchar(100) DEFAULT NULL,
  `contact_telephone_public` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of af_customers
-- ----------------------------
INSERT INTO `af_customers` VALUES ('2', 'Adrian', 'Preuß', 'a.preuss@no-replys.de', '', '', '1234546789');

-- ----------------------------
-- Table structure for `af_rental_propertys`
-- ----------------------------
DROP TABLE IF EXISTS `af_rental_propertys`;
CREATE TABLE `af_rental_propertys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `street_name` varchar(255) DEFAULT NULL,
  `street_number` varchar(50) DEFAULT NULL,
  `city_zip` varchar(10) DEFAULT NULL,
  `city_name` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of af_rental_propertys
-- ----------------------------
INSERT INTO `af_rental_propertys` VALUES ('7', 'Oppenhoffallee', '41', '52066', 'Aachen');

-- ----------------------------
-- Table structure for `af_rental_units`
-- ----------------------------
DROP TABLE IF EXISTS `af_rental_units`;
CREATE TABLE `af_rental_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `information` text,
  `unit_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of af_rental_units
-- ----------------------------
INSERT INTO `af_rental_units` VALUES ('16', '7', '3', null, 'eg');
INSERT INTO `af_rental_units` VALUES ('15', '7', '2', null, '1e');

-- ----------------------------
-- Table structure for `af_services`
-- ----------------------------
DROP TABLE IF EXISTS `af_services`;
CREATE TABLE `af_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of af_services
-- ----------------------------
INSERT INTO `af_services` VALUES ('1', 'Maler / Anstreicher');
INSERT INTO `af_services` VALUES ('2', 'Elektriker');
INSERT INTO `af_services` VALUES ('3', 'Sanitärinstallateur');
INSERT INTO `af_services` VALUES ('4', 'Schreiner');
INSERT INTO `af_services` VALUES ('5', 'Glaser');
INSERT INTO `af_services` VALUES ('6', 'Teppichleger');
INSERT INTO `af_services` VALUES ('7', 'Hausmeisterdienst');
INSERT INTO `af_services` VALUES ('8', 'Dachdecker');
INSERT INTO `af_services` VALUES ('9', 'Fliesenleger');
INSERT INTO `af_services` VALUES ('10', 'Innenausbauer');
INSERT INTO `af_services` VALUES ('11', 'Gärtner');
INSERT INTO `af_services` VALUES ('12', 'Rohrreinigung');

-- ----------------------------
-- Table structure for `af_users`
-- ----------------------------
DROP TABLE IF EXISTS `af_users`;
CREATE TABLE `af_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of af_users
-- ----------------------------
INSERT INTO `af_users` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'info@hausverwaltung.de', 'Adrian', 'Preuß');
