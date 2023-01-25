-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema collection_jeux
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema collection_jeux
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `collection_jeux` DEFAULT CHARACTER SET utf8mb4 ;
USE `collection_jeux` ;

-- -----------------------------------------------------
-- Table `collection_jeux`.`console`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `collection_jeux`.`console` (
  `id_console` INT NOT NULL AUTO_INCREMENT,
  `nom_console` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_console`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `collection_jeux`.`jeux`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `collection_jeux`.`jeux` (
  `id_jeux` INT(11) NOT NULL AUTO_INCREMENT,
  `nom_jeux` VARCHAR(45) NOT NULL,
  `console_id` INT NOT NULL,
  PRIMARY KEY (`id_jeux`),
  UNIQUE INDEX `nom` (`nom_jeux` ASC),
  INDEX `fk_jeux_console_idx` (`console_id` ASC),
  CONSTRAINT `fk_jeux_console`
    FOREIGN KEY (`console_id`)
    REFERENCES `collection_jeux`.`console` (`id_console`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
