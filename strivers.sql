CREATE DATABASE IF NOT EXISTS strivers;
USE strivers;

DROP TABLE IF EXISTS `groups`;

#
# Table structure for table 'groups'
#

CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Dumping data for table 'groups'
#

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
     (1,'superadmin','Super Administrator'),
     (2,'admin','Administrator'),
     (3,'viewer','Viewers'),
     (4,'loader', 'Loaders'),
     (5, 'im', 'Inventory Manager');



DROP TABLE IF EXISTS `user`;

#
# Table structure for table 'users'
#

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) UNIQUE NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,

  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


#
# Dumping data for table 'users'
#

INSERT INTO `user` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`) VALUES
     ('1','127.0.0.1','admin','$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36','','admin@admin.com','',NULL,'1268889823','1268889823','1', 'Admin','istrator');


DROP TABLE IF EXISTS `users_groups`;

#
# Table structure for table 'users_groups'
#

CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `uc_users_groups` UNIQUE (`user_id`, `group_id`),
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
     (1,1,1),
     (2,1,2);


DROP TABLE IF EXISTS `login_attempts`;

#
# Table structure for table 'login_attempts'
#

CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `global_balance`;
CREATE TABLE `global_balance` (
  `network` varchar(10) NOT NULL,
  `current_balance` numeric(19,2) NOT NULL DEFAULT 0,
  `global_name`    varchar(15) NOT NULL UNIQUE,
  PRIMARY KEY (`global_name`),
  INDEX(`global_name`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `am`;
CREATE TABLE `am` (
  `am_code` varchar(10) NOT NULL,
  `am_location` varchar(50) NOT NULL,
  `am_totalbalance` numeric(19,2) DEFAULT 0,
  PRIMARY KEY (`am_code`),
  INDEX(`am_totalbalance`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `dsp`;
CREATE TABLE `dsp` (
  `dsp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `am_code` varchar(10),
  `dsp_firstname` varchar(50) NOT NULL,
  `dsp_lastname` varchar(50) NOT NULL,
  `dsp_email` varchar(50),
  `dsp_gender` varchar(10) NOT NULL,
  `dsp_birthday` date NOT NULL,
  PRIMARY KEY (`dsp_id`),
  INDEX(`dsp_firstname`, `dsp_lastname`),
  INDEX(`dsp_id`),
  Foreign key (`am_code`) references am(`am_code`)
	ON DELETE SET NULL
) ENGINE=InnoDB;



DROP TABLE IF EXISTS `dsp_details`;
CREATE TABLE `dsp_details` (
  `dsp_id` int(10) unsigned NOT NULL,
  `dsp_dealer_no` varchar(30) NOT NULL,
  `dsp_network` varchar(10) NOT NULL,
  `dsp_contactno` varchar(50) NOT NULL,
  `dsp_percentage` numeric(6,4) DEFAULT 0,
  `dsp_balance` numeric(19,2) DEFAULT 0,
  PRIMARY KEY (`dsp_dealer_no`),
  INDEX(`dsp_id`),
  INDEX(`dsp_dealer_no`),
  Foreign key (`dsp_id`) references dsp(`dsp_id`)
	ON UPDATE CASCADE ON DELETE CASCADE,
  Foreign key (`dsp_network`) references `global_balance`(`global_name`)
  ON UPDATE CASCADE
) ENGINE=InnoDB;



DROP TABLE IF EXISTS `load_payment_am`;
CREATE TABLE `load_payment_am` (
  `load_payment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `am_code` varchar(10) NOT NULL,
  `amount` numeric(19,2) NOT NULL,
  `paymentmode` varchar(15) NOT NULL,
  `confirm_no` varchar(30) UNIQUE, 
  `date_created` datetime NOT NULL,
  `user_name` varchar(50) NOT NULL,
  PRIMARY KEY (`load_payment_id`),
  INDEX(`date_created`),
  INDEX(`am_code`),
  Foreign key (`am_code`) references `am`(`am_code`)
  ON UPDATE CASCADE
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `load_transaction`;
CREATE TABLE `load_transaction` (
  `transaction_code` varchar(15) NOT NULL,
  `dsp_id` int(10) unsigned,
  `dsp_name` varchar(50) NOT NULL,
  `am_code` varchar(10) NOT NULL,
  `global_name` varchar(15) NOT NULL,
  `amount` numeric(19,2) NOT NULL,
  `confirm_no` varchar(30) NOT NULL,
  `date_created` datetime NOT NULL,
  `dealer_no` varchar(30) NOT NULL,
  `load_percentage` numeric(6,4) DEFAULT 0, 
  `net_amount` numeric(19,2) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  PRIMARY KEY (`transaction_code`),
  INDEX(`date_created`, `global_name`),
  Foreign key (`am_code`) references am(`am_code`),
  Foreign key (`dsp_id`) references `dsp`(`dsp_id`) 
  ON DELETE SET NULL,
  Foreign key (`global_name`) references `global_balance`(`global_name`)
  ON UPDATE CASCADE
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `load_payment_un`;
CREATE TABLE `load_payment_un` (
  `load_payment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payment_transaction_code` varchar(15),
  `dsp_id` int(10) unsigned,
  `am_code` varchar(10) NOT NULL,
  `dsp_name` varchar(50) NOT NULL,
  `dealer_no` varchar(30) NOT NULL,
  `global_name` varchar(15) NOT NULL,
  `paymentmode` varchar(15) NOT NULL,
  `amount` numeric(19,2) NOT NULL,
  `confirm_no` varchar(30),
  `date_created` datetime NOT NULL,
  `user_name` varchar(50) NOT NULL,
  PRIMARY KEY (`load_payment_id`),
  INDEX(`date_created`, `global_name`),
  INDEX(`dsp_id`),
  Foreign key (`am_code`) references am(`am_code`)
  ON UPDATE CASCADE,
  Foreign key (`dsp_id`) references `dsp`(`dsp_id`) 
  ON DELETE SET NULL,
  Foreign key (`global_name`) references `global_balance`(`global_name`)
  ON UPDATE CASCADE,
  Foreign key (`payment_transaction_code`) references `load_transaction`(`transaction_code`)
  ON DELETE CASCADE
) ENGINE=InnoDB;


DROP TABLE IF EXISTS `purchase_order`;
CREATE TABLE `purchase_order` (
  `purchase_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `global_name` varchar(15) NOT NULL,
  `amount` numeric(19,2) NOT NULL,
  `paymentmode` varchar(15) NOT NULL,
  `referencenumber` varchar(50),
  `date_created` datetime NOT NULL,
  `user_name` varchar(50) NOT NULL,
  PRIMARY KEY (`purchase_id`),
  INDEX(`date_created`),
  Foreign key (`global_name`) references global_balance(`global_name`)
	ON UPDATE CASCADE
) ENGINE=InnoDB;



DROP TABLE IF EXISTS `inventory_items`;
CREATE TABLE `inventory_items` (
  `item_code` varchar(10) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `item_category` varchar(30),
  `item_cost` numeric(10,2) DEFAULT 0,
  `item_stock` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`item_code`),
  INDEX(`item_category`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `inventory_purchase`;
CREATE TABLE `inventory_purchase` (
  `purchase_code` varchar(15) NOT NULL,
  `purchase_receiptnumber` varchar(30) NOT NULL,
  `date_purchase` date NOT NULL,
  PRIMARY KEY (`purchase_code`),
  INDEX(`date_purchase`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `inventory_purchase_items`;
CREATE TABLE `inventory_purchase_items` (
  `purchase_item_id` int(10) unsigned AUTO_INCREMENT NOT NULL,
  `item_code` varchar(10) NOT NULL,
  `purchase_code` varchar(15) NOT NULL,
  `purchase_amount` int(10) unsigned NOT NULL,
  `purchase_itemcost` numeric(10,2) NOT NULL,
  `purchase_totalcost` numeric(16,2) NOT NULL,
  PRIMARY KEY (`purchase_item_id`),
  INDEX(`item_code`),
  Foreign key (`purchase_code`) references `inventory_purchase`(`purchase_code`)
  ON DELETE CASCADE,
  Foreign key (`item_code`) references `inventory_items`(`item_code`)
  ON UPDATE CASCADE
) ENGINE=InnoDB;



DROP TABLE IF EXISTS `inventory_sales`;
CREATE TABLE `inventory_sales` (
  `sales_code` varchar(15) NOT NULL,
  `sales_name` varchar(50) NOT NULL,
  `date_sales` date NOT NULL,
  PRIMARY KEY (`sales_code`),
  INDEX(`date_sales`),
  INDEX(`sales_name`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `inventory_sales_items`;
CREATE TABLE `inventory_sales_items` (
  `sales_item_id` int(10) unsigned AUTO_INCREMENT NOT NULL,
  `sales_code` varchar(15) NOT NULL,
  `item_code` varchar(10) NOT NULL,
  `sales_amount` int(10) unsigned NOT NULL,
  `sales_originalcost` numeric(16,2) NOT NULL,
  `sales_margincost` numeric(16,2) NOT NULL,
  `sales_totalcost` numeric(16,2) NOT NULL,
  `sales_margin` numeric(10,2) DEFAULT 0,
  `sales_remark` text,
  PRIMARY KEY (`sales_item_id`),
  INDEX(`item_code`),
  INDEX(`sales_code`),
  Foreign key (`item_code`) references `inventory_items`(`item_code`)
  ON UPDATE CASCADE,
  Foreign key (`sales_code`) references `inventory_sales`(`sales_code`)
  ON DELETE CASCADE
) ENGINE=InnoDB;




DROP TABLE IF EXISTS `inventory_sales_payment`;
CREATE TABLE `inventory_sales_payment` (
  `sales_code` varchar(15) NOT NULL,
  `date_payment` date NOT NULL,
  `sales_mop` varchar(15),
  `sales_receiptnumber` varchar(30),
  `payment_amount` numeric(16,2) NOT NULL,
  PRIMARY KEY (`sales_code`),
  INDEX(`date_payment`),
  Foreign key (`sales_code`) references `inventory_sales`(`sales_code`)
  ON DELETE CASCADE
) ENGINE=InnoDB;
INSERT INTO `strivers`.`global_balance` (`network`, `current_balance`, `global_name`) VALUES ('SUN', '50000', 'SUN');
INSERT INTO `strivers`.`global_balance` (`network`, `current_balance`, `global_name`) VALUES ('SMART', '50000', 'SMART');
INSERT INTO `strivers`.`am` (`am_code`, `am_location`) VALUES ('Unassigned', 'Unassigned');

INSERT INTO `strivers`.`user` (`username`, `password`, `type`,`firstname`, `lastname`) VALUES ('admin', '21232f297a57a5a743894a0e4a801fc3', 'admin','Mikko','Basilio');


drop procedure if exists generateInventoryPurchaseReport;


DELIMITER $$
 
CREATE PROCEDURE generateInventoryPurchaseReport(
    IN  date1 date,
    IN date2 date
)
BEGIN
SET @SQL = NULL;
SELECT
  GROUP_CONCAT(DISTINCT
    CONCAT(
      'sum(CASE WHEN date_purchase = ''',
      dt,
      ''' then purchase_amount else 0 end) AS `',
      dt, '`'
    )
  ) INTO @SQL
FROM
(
  SELECT date_purchase AS dt
  FROM (select date_purchase, purchase_code from inventory_purchase where date_purchase between date1 and date2) d
  left join (select purchase_amount, purchase_code from inventory_purchase_items) i on d.purchase_code = i.purchase_code
  ORDER BY date_purchase
) d;

SET @SQL 
  = CONCAT('SELECT i.item_code,i.item_name, i.item_stock, ', @SQL, ' 
            from inventory_items i
            left join (select * from (select purchase_code as p_code, purchase_receiptnumber, date_purchase from inventory_purchase where date_purchase between ''', date1 ,''' and ''', date2, ''') i 
      left join inventory_purchase_items s on i.p_code = s.purchase_code)  d
              on i.item_code = d.item_code
            group by i.item_code;');
 
PREPARE stmt FROM @SQL;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

 
END$$

DELIMITER ;

drop procedure if exists generateInventorySalesReport;


DELIMITER $$
 
CREATE PROCEDURE generateInventorySalesReport(
    IN  date1 date,
    IN date2 date
)
BEGIN
SET @SQL = NULL;
  SELECT
    GROUP_CONCAT(DISTINCT
      CONCAT(
        'sum(case when date_sales = ''',
        dt,
        ''' then sales_amount else 0 end) AS `',
        dt, '`'
      )
    ) INTO @SQL
  FROM
  (
  SELECT date_sales AS dt
  FROM (select date_sales, sales_code from inventory_sales where date_sales between date1 and date2) d
  left join (select sales_amount, sales_code from inventory_sales_items) i on d.sales_code = i.sales_code
  ORDER BY date_sales
  ) d;

  SET @SQL 
    = CONCAT('SELECT i.item_code,i.item_name, i.item_stock, ', @SQL, ' 
              from inventory_items i
              left join (select * from (select sales_code as s_code, sales_name, date_sales from inventory_sales where date_sales between ''', date1 ,''' and ''', date2, ''') i 
        left join inventory_sales_items s on i.s_code = s.sales_code)  d
              on i.item_code = d.item_code
              group by i.item_code;');
   
  PREPARE stmt FROM @SQL;
  EXECUTE stmt;
  DEALLOCATE PREPARE stmt;
 
END