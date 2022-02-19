-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema Proteomics_Analysis
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `Proteomics_Analysis` ;

-- -----------------------------------------------------
-- Schema Proteomics_Analysis
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Proteomics_Analysis` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `Proteomics_Analysis` ;

-- -----------------------------------------------------
-- Table `Proteomics_Analysis`.`experimental_protocols`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Proteomics_Analysis`.`experimental_protocols` ;

CREATE TABLE IF NOT EXISTS `Proteomics_Analysis`.`experimental_protocols` (
  `protocol_ID` INT NOT NULL AUTO_INCREMENT,
  `protocol_name` VARCHAR(50) NOT NULL,
  `description` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`protocol_ID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `Proteomics_Analysis`.`peptide_sequences`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Proteomics_Analysis`.`peptide_sequences` ;

CREATE TABLE IF NOT EXISTS `Proteomics_Analysis`.`peptide_sequences` (
  `peptide_seq_ID` INT NOT NULL AUTO_INCREMENT,
  `sequence` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`peptide_seq_ID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `Proteomics_Analysis`.`proteins`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Proteomics_Analysis`.`proteins` ;

CREATE TABLE IF NOT EXISTS `Proteomics_Analysis`.`proteins` (
  `Uniprot_ID` VARCHAR(50) NOT NULL,
  `sequence` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`Uniprot_ID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `Proteomics_Analysis`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Proteomics_Analysis`.`user` ;

CREATE TABLE IF NOT EXISTS `Proteomics_Analysis`.`user` (
  `user_ID` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `surname` VARCHAR(50) NOT NULL,
  `user_name` VARCHAR(50) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`user_ID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `Proteomics_Analysis`.`user_has_experimental_protocols`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Proteomics_Analysis`.`user_has_experimental_protocols` ;

CREATE TABLE IF NOT EXISTS `Proteomics_Analysis`.`user_has_experimental_protocols` (
  `user_user_ID` INT NOT NULL,
  `experimental_protocols_protocol_ID` INT NOT NULL,
  PRIMARY KEY (`user_user_ID`, `experimental_protocols_protocol_ID`),
  INDEX `fk_user_has_experimental_protocols_experimental_protocols1_idx` (`experimental_protocols_protocol_ID` ASC) VISIBLE,
  INDEX `fk_user_has_experimental_protocols_user_idx` (`user_user_ID` ASC) VISIBLE,
  CONSTRAINT `fk_user_has_experimental_protocols_user`
    FOREIGN KEY (`user_user_ID`)
    REFERENCES `Proteomics_Analysis`.`user` (`user_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_experimental_protocols_experimental_protocols1`
    FOREIGN KEY (`experimental_protocols_protocol_ID`)
    REFERENCES `Proteomics_Analysis`.`experimental_protocols` (`protocol_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `Proteomics_Analysis`.`user_has_peptide_sequences`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Proteomics_Analysis`.`user_has_peptide_sequences` ;

CREATE TABLE IF NOT EXISTS `Proteomics_Analysis`.`user_has_peptide_sequences` (
  `user_user_ID` INT NOT NULL,
  `peptide_sequences_peptide_seq_ID` INT NOT NULL,
  PRIMARY KEY (`user_user_ID`, `peptide_sequences_peptide_seq_ID`),
  INDEX `fk_user_has_peptide_sequences_peptide_sequences1_idx` (`peptide_sequences_peptide_seq_ID` ASC) VISIBLE,
  INDEX `fk_user_has_peptide_sequences_user1_idx` (`user_user_ID` ASC) VISIBLE,
  CONSTRAINT `fk_user_has_peptide_sequences_user1`
    FOREIGN KEY (`user_user_ID`)
    REFERENCES `Proteomics_Analysis`.`user` (`user_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_peptide_sequences_peptide_sequences1`
    FOREIGN KEY (`peptide_sequences_peptide_seq_ID`)
    REFERENCES `Proteomics_Analysis`.`peptide_sequences` (`peptide_seq_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `Proteomics_Analysis`.`user_has_proteins`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Proteomics_Analysis`.`user_has_proteins` ;

CREATE TABLE IF NOT EXISTS `Proteomics_Analysis`.`user_has_proteins` (
  `user_user_ID` INT NOT NULL,
  `proteins_Uniprot_ID` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`user_user_ID`, `proteins_Uniprot_ID`),
  INDEX `fk_user_has_proteins_proteins1_idx` (`proteins_Uniprot_ID` ASC) VISIBLE,
  INDEX `fk_user_has_proteins_user1_idx` (`user_user_ID` ASC) VISIBLE,
  CONSTRAINT `fk_user_has_proteins_user1`
    FOREIGN KEY (`user_user_ID`)
    REFERENCES `Proteomics_Analysis`.`user` (`user_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_proteins_proteins1`
    FOREIGN KEY (`proteins_Uniprot_ID`)
    REFERENCES `Proteomics_Analysis`.`proteins` (`Uniprot_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `Proteomics_Analysis`.`peptide_sequences_has_proteins`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Proteomics_Analysis`.`peptide_sequences_has_proteins` ;

CREATE TABLE IF NOT EXISTS `Proteomics_Analysis`.`peptide_sequences_has_proteins` (
  `peptide_sequences_peptide_seq_ID` INT NOT NULL,
  `proteins_Uniprot_ID` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`peptide_sequences_peptide_seq_ID`, `proteins_Uniprot_ID`),
  INDEX `fk_peptide_sequences_has_proteins_proteins1_idx` (`proteins_Uniprot_ID` ASC) VISIBLE,
  INDEX `fk_peptide_sequences_has_proteins_peptide_sequences1_idx` (`peptide_sequences_peptide_seq_ID` ASC) VISIBLE,
  CONSTRAINT `fk_peptide_sequences_has_proteins_peptide_sequences1`
    FOREIGN KEY (`peptide_sequences_peptide_seq_ID`)
    REFERENCES `Proteomics_Analysis`.`peptide_sequences` (`peptide_seq_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_peptide_sequences_has_proteins_proteins1`
    FOREIGN KEY (`proteins_Uniprot_ID`)
    REFERENCES `Proteomics_Analysis`.`proteins` (`Uniprot_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `Proteomics_Analysis`.`References`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Proteomics_Analysis`.`References` ;

CREATE TABLE IF NOT EXISTS `Proteomics_Analysis`.`References` (
  `DOI` INT NULL,
  PRIMARY KEY (`DOI`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Proteomics_Analysis`.`user_has_References`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Proteomics_Analysis`.`user_has_References` ;

CREATE TABLE IF NOT EXISTS `Proteomics_Analysis`.`user_has_References` (
  `user_user_ID` INT NOT NULL,
  `References_DOI` INT NOT NULL,
  PRIMARY KEY (`user_user_ID`, `References_DOI`),
  INDEX `fk_user_has_References_References1_idx` (`References_DOI` ASC) VISIBLE,
  INDEX `fk_user_has_References_user1_idx` (`user_user_ID` ASC) VISIBLE,
  CONSTRAINT `fk_user_has_References_user1`
    FOREIGN KEY (`user_user_ID`)
    REFERENCES `Proteomics_Analysis`.`user` (`user_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_References_References1`
    FOREIGN KEY (`References_DOI`)
    REFERENCES `Proteomics_Analysis`.`References` (`DOI`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
