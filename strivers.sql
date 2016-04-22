CREATE DATABASE IF NOT EXISTS strivers;
USE strivers;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(25) UNIQUE NOT NULL,
  `password` varchar(50) NOT NULL,
  `type`     varchar(10) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `dss`;
CREATE TABLE `dss` (
  `dss_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dss_firstname` varchar(50) NOT NULL,
  `dss_lastname` varchar(50),
  `dss_contactno` varchar(50),
  `dss_email` varchar(50),
  `dss_birthday` date NOT NULL,
  `dss_gender` varchar(10) NOT NULL,
  PRIMARY KEY (`dss_id`),
  INDEX(`dss_id`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `dsp`;
CREATE TABLE `dsp` (
  `dsp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dss_id` int(10) unsigned,
  `dsp_firstname` varchar(50) NOT NULL,
  `dsp_lastname` varchar(50) NOT NULL,
  `dsp_email` varchar(50),
  `dsp_gender` varchar(10) NOT NULL,
  `dsp_birthday` date NOT NULL,
  PRIMARY KEY (`dsp_id`),
  INDEX(`dsp_firstname`, `dsp_lastname`),
  INDEX(`dsp_id`),
  Foreign key (`dss_id`) references dss(`dss_id`)
	ON DELETE SET NULL
) ENGINE=InnoDB;



DROP TABLE IF EXISTS `dsp_details`;
CREATE TABLE `dsp_details` (
  `dsp_id` int(10) unsigned NOT NULL,
  `dsp_dealer_no` varchar(30) NOT NULL,
  `dsp_network` varchar(10) NOT NULL,
  `dsp_contactno` varchar(50) NOT NULL,
  `dsp_percentage` float(12,4),
  `dsp_balance` double(16,4),
  PRIMARY KEY (`dsp_dealer_no`),
  INDEX(`dsp_id`),
  INDEX(`dsp_dealer_no`),
  Foreign key (`dsp_id`) references dsp(`dsp_id`)
	ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `global_balance`;
CREATE TABLE `global_balance` (
  `network` varchar(10) NOT NULL,
  `current_balance` double(20,4) NOT NULL,
  `global_name`    varchar(15) NOT NULL UNIQUE,
  PRIMARY KEY (`global_name`),
  INDEX(`global_name`)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS `load_transaction`;
CREATE TABLE `load_transaction` (
  `transaction_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dsp_id` int(10) unsigned NOT NULL,
  `global_name` varchar(15) NOT NULL,
  `amount` double(16,4) NOT NULL,
  `confirm_no` varchar(30) NOT NULL,
  `date_created` datetime NOT NULL,
  `dealer_no` varchar(30) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`transaction_id`),
  INDEX(`date_created`, `global_name`),
  INDEX(`dsp_id`),
  Foreign key (`user_id`) references `user`(`user_id`)
	ON UPDATE CASCADE,
  Foreign key (`global_name`) references `global_balance`(`global_name`)
) ENGINE=InnoDB;



DROP TABLE IF EXISTS `purchase_order`;
CREATE TABLE `purchase_order` (
  `purchase_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `global_name` varchar(15) NOT NULL,
  `amount` double(16,4) NOT NULL,
  `date_created` datetime NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`purchase_id`),
  INDEX(`date_created`),
  Foreign key (`user_id`) references `user`(`user_id`),
  Foreign key (`global_name`) references global_balance(`global_name`)
	ON UPDATE CASCADE
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `transaction_history`;
CREATE TABLE `transaction_history` (
  `transaction_id` int(10) unsigned NOT NULL,
  `transaction_type` varchar(10),
  `status` varchar(10),
  `amount` double(16,4) NOT NULL,
  `date_created` datetime NOT NULL,
  `beg_bal` double(16,4) NOT NULL,
  `run_bal` double(16,4) NOT NULL,
  `dealer_no` varchar(30) NOT NULL,
  `confirm_no` varchar(30) NOT NULL,
  PRIMARY KEY (`transaction_id`, `transaction_type`)
) ENGINE=InnoDB;

INSERT INTO `strivers`.`dss` (`dss_id`, `dss_firstname`, `dss_birthday`, `dss_gender`) VALUES ('0', 'Unassigned', '0000-00-00', 'Male');
INSERT INTO `strivers`.`global_balance` (`network`, `current_balance`, `global_name`) VALUES ('SUN', '50000', 'SUN');
INSERT INTO `strivers`.`global_balance` (`network`, `current_balance`, `global_name`) VALUES ('SMART', '50000', 'SMART');
INSERT INTO `strivers`.`user` (`username`, `password`, `type`,`firstname`, `lastname`) VALUES ('admin', '21232f297a57a5a743894a0e4a801fc3', 'Mikko','Basilio','admin');
UPDATE `strivers`.`dss` SET `dss_id`='0' WHERE `dss_id`='1';

