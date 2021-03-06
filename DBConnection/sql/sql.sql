-- MySQL Script generated by MySQL Workbench
-- Tue 14 Feb 2017 02:55:28 PM CET
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema desertdb
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `desertdb` ;

-- -----------------------------------------------------
-- Schema desertdb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `desertdb` DEFAULT CHARACTER SET utf8 ;
USE `desertdb` ;

-- -----------------------------------------------------
-- Table `desertdb`.`User`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `desertdb`.`User` ;

CREATE TABLE IF NOT EXISTS `desertdb`.`User` (
  `login` VARCHAR(16) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `score` INT NULL,
  PRIMARY KEY (`login`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `desertdb`.`Level`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `desertdb`.`Level` ;

CREATE TABLE IF NOT EXISTS `desertdb`.`Level` (
  `level` INT NOT NULL,
  `rows` INT NOT NULL,
  `coef` DOUBLE(2,1) NOT NULL,
  `timelimit` INT NOT NULL,
  `type` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`level`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `desertdb`.`ConstRow`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `desertdb`.`ConstRow` ;

CREATE TABLE IF NOT EXISTS `desertdb`.`ConstRow` (
  `level` INT NOT NULL,
  `row` INT NOT NULL,
  PRIMARY KEY (`level`, `row`),
  CONSTRAINT `modificabile`
    FOREIGN KEY (`level`)
    REFERENCES `desertdb`.`Level` (`level`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `desertdb`.`Campaign`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `desertdb`.`Campaign` ;

CREATE TABLE IF NOT EXISTS `desertdb`.`Campaign` (
  `login` VARCHAR(16) NOT NULL,
  `level` INT NOT NULL,
  `score` INT NOT NULL,
  PRIMARY KEY (`login`, `level`),
  INDEX `played_idx` (`level` ASC),
  CONSTRAINT `player`
    FOREIGN KEY (`login`)
    REFERENCES `desertdb`.`User` (`login`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `played`
    FOREIGN KEY (`level`)
    REFERENCES `desertdb`.`Level` (`level`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `desertdb`.`Grade`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `desertdb`.`Grade` ;

CREATE TABLE IF NOT EXISTS `desertdb`.`Grade` (
  `id` INT NOT NULL,
  `score` INT NOT NULL,
  `type` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `desertdb`.`Achievement`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `desertdb`.`Achievement` ;

CREATE TABLE IF NOT EXISTS `desertdb`.`Achievement` (
  `id` INT NOT NULL,
  `title` VARCHAR(64) NOT NULL,
  `descr` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `details_UNIQUE` (`title` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `desertdb`.`Achieved`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `desertdb`.`Achieved` ;

CREATE TABLE IF NOT EXISTS `desertdb`.`Achieved` (
  `login` VARCHAR(16) NOT NULL,
  `achievement` INT NOT NULL,
  PRIMARY KEY (`login`, `achievement`),
  INDEX `fkAchieved_idx` (`achievement` ASC),
  CONSTRAINT `fkAchiever`
    FOREIGN KEY (`login`)
    REFERENCES `desertdb`.`User` (`login`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fkAchieved`
    FOREIGN KEY (`achievement`)
    REFERENCES `desertdb`.`Achievement` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `desertdb`.`Graduated`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `desertdb`.`Graduated` ;

CREATE TABLE IF NOT EXISTS `desertdb`.`Graduated` (
  `login` VARCHAR(16) NOT NULL,
  `grade` INT NOT NULL,
  PRIMARY KEY (`login`, `grade`),
  INDEX `fkGraduated_idx` (`grade` ASC),
  CONSTRAINT `fkPlayer`
    FOREIGN KEY (`login`)
    REFERENCES `desertdb`.`User` (`login`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fkGraduated`
    FOREIGN KEY (`grade`)
    REFERENCES `desertdb`.`Grade` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `desertdb`.`User`
-- -----------------------------------------------------
START TRANSACTION;
USE `desertdb`;
INSERT INTO `desertdb`.`User` (`login`, `password`, `score`) VALUES ('gan', 'gan', 0);
INSERT INTO `desertdb`.`User` (`login`, `password`, `score`) VALUES ('maghi', 'maghi', 0);

COMMIT;


-- -----------------------------------------------------
-- Data for table `desertdb`.`Level`
-- -----------------------------------------------------
START TRANSACTION;
USE `desertdb`;
INSERT INTO `desertdb`.`Level` (`level`, `rows`, `coef`, `timelimit`, `type`) VALUES (1, 10, 1, 90, 'debugging');
INSERT INTO `desertdb`.`Level` (`level`, `rows`, `coef`, `timelimit`, `type`) VALUES (2, 1, 1, 90, 'debugging');
INSERT INTO `desertdb`.`Level` (`level`, `rows`, `coef`, `timelimit`, `type`) VALUES (3, 1, 1, 90, 'debugging');
INSERT INTO `desertdb`.`Level` (`level`, `rows`, `coef`, `timelimit`, `type`) VALUES (4, 1, 1, 90, 'refactoring');
INSERT INTO `desertdb`.`Level` (`level`, `rows`, `coef`, `timelimit`, `type`) VALUES (5, 1, 1, 90, 'refactoring');
INSERT INTO `desertdb`.`Level` (`level`, `rows`, `coef`, `timelimit`, `type`) VALUES (6, 1, 1, 90, 'refactoring');
INSERT INTO `desertdb`.`Level` (`level`, `rows`, `coef`, `timelimit`, `type`) VALUES (7, 1, 1, 90, 'designing');
INSERT INTO `desertdb`.`Level` (`level`, `rows`, `coef`, `timelimit`, `type`) VALUES (8, 1, 1, 90, 'designing');
INSERT INTO `desertdb`.`Level` (`level`, `rows`, `coef`, `timelimit`, `type`) VALUES (9, 1, 1, 90, 'designing');

COMMIT;


-- -----------------------------------------------------
-- Data for table `desertdb`.`ConstRow`
-- -----------------------------------------------------
START TRANSACTION;
USE `desertdb`;
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (1, 0);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (1, 1);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (1, 2);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (1, 3);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (1, 4);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (1, 5);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (1, 7);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (2, 0);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (2, 1);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (2, 2);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (2, 3);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (2, 4);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (2, 5);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (2, 9);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (2, 10);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (3, 0);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (3, 1);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (3, 3);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (3, 4);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (3, 5);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (4, 0);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (4, 1);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (4, 3);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (5, 0);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (5, 7);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (6, 0);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (6, 1);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (6, 2);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (6, 3);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (6, 13);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (6, 14);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (6, 15);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (7, 0);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (7, 1);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (7, 3);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (8, 0);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (8, 1);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (8, 3);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (9, 0);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (9, 1);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (9, 3);
INSERT INTO `desertdb`.`ConstRow` (`level`, `row`) VALUES (9, 4);

COMMIT;


-- -----------------------------------------------------
-- Data for table `desertdb`.`Grade`
-- -----------------------------------------------------
START TRANSACTION;
USE `desertdb`;
INSERT INTO `desertdb`.`Grade` (`id`, `score`, `type`) VALUES (1, 0, 'Newbie');
INSERT INTO `desertdb`.`Grade` (`id`, `score`, `type`) VALUES (2, 250, 'Junior Developer');
INSERT INTO `desertdb`.`Grade` (`id`, `score`, `type`) VALUES (3, 500, 'Senior Developer');
INSERT INTO `desertdb`.`Grade` (`id`, `score`, `type`) VALUES (4, 750, 'Lead Developer');

COMMIT;


-- -----------------------------------------------------
-- Data for table `desertdb`.`Achievement`
-- -----------------------------------------------------
START TRANSACTION;
USE `desertdb`;
INSERT INTO `desertdb`.`Achievement` (`id`, `title`, `descr`) VALUES (1, 'Ti fai valere', 'Qualcuno aveva dei dubbi su di te, ma hai dimostrato di saperci fare affrontando la prima minaccia');
INSERT INTO `desertdb`.`Achievement` (`id`, `title`, `descr`) VALUES (2, 'A metà strada', 'Se ce l\'hai fatta ad arrivare qui, ce la farai anche a finire. Hai completato più della metà dei livelli');
INSERT INTO `desertdb`.`Achievement` (`id`, `title`, `descr`) VALUES (3, 'Programmatore Indie', 'Suggerimento? Non fa parte del tuo vocabolario, ti piace a modo tuo. Hai completato il livello senza alcuna dritta');
INSERT INTO `desertdb`.`Achievement` (`id`, `title`, `descr`) VALUES (4, 'Fra i Migliori', 'Sei entrato a far parte della TOP 3, verifica tu stesso!');
INSERT INTO `desertdb`.`Achievement` (`id`, `title`, `descr`) VALUES (5, 'Generale Supremo', 'Hai superato chiunque nella tua corsa di salvare il mondo programmando! Ma attenzione, anche gli altri sono affamati di successo');
INSERT INTO `desertdb`.`Achievement` (`id`, `title`, `descr`) VALUES (6, 'Investigatore dei Bug', 'Là dove gli altri non vedono niente, tu scopri le insidie! Hai completato tutti i livelli di debugging');
INSERT INTO `desertdb`.`Achievement` (`id`, `title`, `descr`) VALUES (7, 'Maestro del Refactoring', 'Quando le cose devono essere cambiate per il meglio, sei la persona giusta a cui rivolgersi. Hai completato tutti i livelli di refactoring');
INSERT INTO `desertdb`.`Achievement` (`id`, `title`, `descr`) VALUES (8, 'Artista del Codice', 'Tutti i livelli di Designing sono stati completati');
INSERT INTO `desertdb`.`Achievement` (`id`, `title`, `descr`) VALUES (9, 'Dio della Guerra', 'Non è ancora nota una missione che tu non possa portare a termine, hai completato tutti i livelli');

COMMIT;


-- -----------------------------------------------------
-- Data for table `desertdb`.`Achieved`
-- -----------------------------------------------------
START TRANSACTION;
USE `desertdb`;
INSERT INTO `desertdb`.`Achieved` (`login`, `achievement`) VALUES ('gan', 3);
INSERT INTO `desertdb`.`Achieved` (`login`, `achievement`) VALUES ('maghi', 1);

COMMIT;

