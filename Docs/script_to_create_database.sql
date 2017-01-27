SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `ordersmgt`.`tab_customers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ordersmgt`.`tab_customers` ;

CREATE TABLE IF NOT EXISTS `ordersmgt`.`tab_customers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `phone` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `credit` DECIMAL(15,2) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ordersmgt`.`tab_products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ordersmgt`.`tab_products` ;

CREATE TABLE IF NOT EXISTS `ordersmgt`.`tab_products` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `description` VARCHAR(45) NOT NULL,
  `unitPrice` DECIMAL(15,2) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ordersmgt`.`tab_order_details`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ordersmgt`.`tab_order_details` ;

CREATE TABLE IF NOT EXISTS `ordersmgt`.`tab_order_details` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_product` INT NOT NULL,
  `discount` DECIMAL(15,2) NOT NULL,
  `quantity` INT NOT NULL,
  `unitPrice` DECIMAL(15,2) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_tab_orders_tab_products_idx` (`id_product` ASC),
  CONSTRAINT `fk_tab_orders_tab_products`
    FOREIGN KEY (`id_product`)
    REFERENCES `ordersmgt`.`tab_products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ordersmgt`.`tab_orders`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ordersmgt`.`tab_orders` ;

CREATE TABLE IF NOT EXISTS `ordersmgt`.`tab_orders` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_customers` INT NOT NULL,
  `id_order_details` INT NOT NULL,
  `orderDate` DATETIME NOT NULL,
  `requiredDate` DATETIME NULL,
  `shippedDate` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_tab_orders_tab_customers1_idx` (`id_customers` ASC),
  INDEX `fk_tab_orders_tab_order_details1_idx` (`id_order_details` ASC),
  CONSTRAINT `fk_tab_orders_tab_customers1`
    FOREIGN KEY (`id_customers`)
    REFERENCES `ordersmgt`.`tab_customers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tab_orders_tab_order_details1`
    FOREIGN KEY (`id_order_details`)
    REFERENCES `ordersmgt`.`tab_order_details` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ordersmgt`.`tab_product_details`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ordersmgt`.`tab_product_details` ;

CREATE TABLE IF NOT EXISTS `ordersmgt`.`tab_product_details` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_products` INT NOT NULL,
  `cost` DECIMAL(15,2) NOT NULL,
  PRIMARY KEY (`id`, `id_products`),
  INDEX `fk_tab_product_detail_tab_products1_idx` (`id_products` ASC),
  CONSTRAINT `fk_tab_product_detail_tab_products1`
    FOREIGN KEY (`id_products`)
    REFERENCES `ordersmgt`.`tab_products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
