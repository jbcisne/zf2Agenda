SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- CRIAR BANCO DE DADOS AGENDA DE CONTATOS
CREATE SCHEMA IF NOT EXISTS `agenda_contatos` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;

-- CRIAR TABELA CONTATOS DO BANCO DE DADOS
CREATE TABLE IF NOT EXISTS `agenda_contatos`.`contatos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(180) NOT NULL,
  `telefone_principal` VARCHAR(45) NOT NULL,
  `telefone_secundario` VARCHAR(45) NULL DEFAULT NULL,
  `data_criacao` DATETIME NOT NULL,
  `data_atualizacao` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- INSERIR VALORES NA TABELA CONTATOS
INSERT INTO `agenda_contatos`.`contatos`
(`nome`          , `telefone_principal`   , `telefone_secundario` , `data_criacao` , `data_atualizacao`)
VALUES
('igor rocha'    , '(85)8585-8585'        , '(58)5858-5858'       , '2013-10-17'   , '2013-10-17'),
('rocha igor'    , '(58)5858-5858'        , '(58)2323-2323'       , '2013-10-17'   , '2013-10-17'),
('paulo tião'    , '(73)7373-7373'        , '(73)1234-1234'       , '2013-10-17'   , '2013-10-17'),
('gabriel gi'    , '(29)2929-2929'        , '(92)9292-9292'       , '2013-10-17'   , '2013-10-17'),
('iandara gi'    , '(85)8585-8585'        , '(85)3232-3232'       , '2013-10-17'   , '2013-10-17'),
('neto rocha'    , '(85)8585-8585'        , '(85)3232-3232'       , '2013-10-17'   , '2013-10-17'),
('jose adail'    , '(91)9191-9191'        , '(19)1919-1919'       , '2013-10-17'   , '2013-10-17');
