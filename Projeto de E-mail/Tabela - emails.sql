-- -----------------------------------------------------
-- Table `mydb`.`inbounds`
-- -----------------------------------------------------
CREATE TABLE `emails` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `from` varchar(50) NOT NULL,
  `to` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `assunto` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dado_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1