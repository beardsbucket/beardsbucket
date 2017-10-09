-- ﻿CREATE USER 'bucket'@'localhost' IDENTIFIED BY '123';
-- GRANT ALL PRIVILEGES ON * . * TO 'bucket'@'localhost';
-- 
-- SELECT * FROM mysql.user;
-- 	
-- select * from INFORMATION_SCHEMA.PROCESSLIST

DROP DATABASE IF EXISTS BUCKET;
CREATE DATABASE BUCKET;
USE BUCKET;


CREATE TABLE EMPRESA (
EMP_COD INT PRIMARY KEY AUTO_INCREMENT,
EMP_NOME_EMPRESA VARCHAR(200) NOT NULL,
EMP_CNPJ VARCHAR(30) UNIQUE 	
);



CREATE TABLE CONTA (
CNT_COD INT PRIMARY KEY AUTO_INCREMENT,
CNT_NOME VARCHAR(50),
CNT_BANCO VARCHAR(30),
CNT_AGNC VARCHAR(30),
CNT_NMCONTA VARCHAR(30),
CNT_TIPO CHAR(2),
CNT_SALDOINICIAL DOUBLE(10,2) NOT NULL,
COD_EMPR INT NOT NULL,
FOREIGN KEY(COD_EMPR) REFERENCES EMPRESA (EMP_COD)
);

CREATE TABLE CLIENTE (
CLI_COD INT PRIMARY KEY AUTO_INCREMENT,
CLI_NOME VARCHAR(100) NOT NULL,
CLI_TIPO CHAR(2) NOT NULL,
CLI_CPF_CNPJ VARCHAR(20) UNIQUE,
CLI_TELEFONE VARCHAR(20),
CLI_EMAIL VARCHAR(200),
CLI_BANCO VARCHAR(15),
CLI_AGENCIA VARCHAR(15),
CLI_CONTA VARCHAR(15),
CLI_TIPOCONTA CHAR(2)
);



CREATE TABLE USUARIO (
USR_COD INT PRIMARY KEY AUTO_INCREMENT,
USR_SENHA VARCHAR(50),
USR_LOGIN VARCHAR(50) UNIQUE,
USR_NOME VARCHAR(200),
USR_EMAIL VARCHAR(200),
USR_PERMISSAO TINYINT,
USR_STATUS TINYINT
);

CREATE TABLE USR_EMPR (
COD_USR_EMPR INT PRIMARY KEY AUTO_INCREMENT,
COD_USR INT NOT NULL,
COD_EMPR INT NOT NULL,
FOREIGN KEY(COD_USR) REFERENCES USUARIO (USR_COD),
FOREIGN KEY(COD_EMPR) REFERENCES EMPRESA (EMP_COD)
);

CREATE TABLE LANCAMENTO (
LCT_COD INT PRIMARY KEY AUTO_INCREMENT,
LCT_DESCRICAO VARCHAR(200) NOT NULL,
LCT_DTCADASTR DATETIME,
LCT_DTPAG DATETIME,
LCT_VLRPAGO DOUBLE(10,2),
LCT_VLRTITULO DOUBLE(10,2),
LCT_JUROSDIA FLOAT,
LCT_NPARC TINYINT,
LCT_STATUSLANC VARCHAR(30),
LCT_TIPO VARCHAR(30) NOT NULL,
LCT_FRMPAG VARCHAR(15),
CAT_COD INT NOT NULL,
CLI_COD INT NOT NULL,
CNT_COD INT NOT NULL,
USR_COD INT NOT NULL,
FOREIGN KEY(CLI_COD) REFERENCES CLIENTE (CLI_COD),
FOREIGN KEY(CNT_COD) REFERENCES CONTA (CNT_COD),
FOREIGN KEY(USR_COD) REFERENCES USUARIO (USR_COD)
);



CREATE TABLE CATEGORIA (
CAT_COD INT PRIMARY KEY AUTO_INCREMENT,
CAT_NOME VARCHAR(50) NOT NULL,
COD_EMPRESA INT NOT NULL,
FOREIGN KEY(COD_EMPRESA) REFERENCES EMPRESA (EMP_COD)
);



ALTER TABLE LANCAMENTO ADD FOREIGN KEY(CAT_COD) REFERENCES CATEGORIA (CAT_COD);


/*---------------------------INSERTS--------------------------------------*/

INSERT INTO USUARIO VALUES
(0, '123', 'bucket', 'Sistema', 'contato@beardsweb.com.br', 1,1),
(0, '123', 'alex', 'Alex Santos', 'alexsantosinformatica@gmail.com', 2,1),
(0, '123', 'rogerio', 'Rogério Santos', 'contato@hotelclubeazuldomar.com.br', 0,1),
(0, '123', 'brazolin', 'José Brazolin', 'brazolin@brazolin.com.br', 2,1);
--

INSERT INTO EMPRESA VALUES(0, "Fisa Prestadora de Serviços", "18.176.989/0001-09"),
(0, "Beards Web", "66.666.666/0001-66"), (0, "Albroz Empreendimentos", "07.833-690/0001-09"),
(0, "Pessoal", "66.112.123/1231-23"); 

INSERT INTO CONTA VALUES(0, "Fisa Itau", "Itaú", "5607", "00657-3", 'CC',60000.00,1),
(0, "Beards", "Itaú", "5602", "00127-3", 'CP', 90000.00,2),
(0, "Albroz BB", "Banco do Brasil", "5602", "00127-3",'CC', 90000.00,3),
(0, "Pessoal", "Banco do Brasil", "5612", "00132-3", 'CS', 1000.00,4);


INSERT INTO USR_EMPR VALUES(0,1,2);
INSERT INTO USR_EMPR VALUES(0,2,2);
INSERT INTO USR_EMPR VALUES(0,2,3);

INSERT INTO USR_EMPR VALUES(0,4,1);

-- 

insert into CATEGORIA VALUES
(0,"Salário",1),(0,"Transporte",1),(0,"Alimentação",1),(0,"Taxas e Impostos",1),(0,"Serviços",1),
(0,"Convênios",1),(0,"Hospedagem",1),(0,"Compras em Geral",1),(0,"Combustível",1),(0,"Viagens",1),(0,"Saúde",1),(0,"Estudos",1),
(0,"Investimentos",1),(0,"Salário",2),(0,"Transporte",2),(0,"Alimentação",2),(0,"Taxas e Impostos",2),(0,"Contratos",2),
(0,"Convênios",2),(0,"Hospedagem",2),(0,"Estornos",2),(0,"Vendas em Geral",2),(0,"Viagens",2),(0,"Estudos",2),(0,"Investimentos",2),
(0,"Salário",3),(0,"Transporte",3),(0,"Alimentação",3),(0,"Taxas e Impostos",3),(0,"Contratos",3),(0,"Convênios",3),(0,"Hospedagem",3),
(0,"Estornos",3),(0,"Vendas em Geral",3),(0,"Viagens",3),(0,"Estudos",3),(0,"Investimentos",3);
-- 

-- 

-- 
INSERT INTO CLIENTE VALUES (0, "SABESP", 'PJ', NULL, NULL, NULL, NULL, NULL, NULL, 'CC'),
(0, "Alex Santos", 'PF', "399.333.222.22", "(11) 96695-3835", "alexsantosinformatica@gmail.com", "Itaú", "5607", "00657-3", 'CP');


INSERT INTO LANCAMENTO VALUES (0,'Informática',NOW(),NOW(),150.00,150.00,0.1,0,"Pago","Despesa","Dinheiro",5,1,1,2);



-- 

-- JOIN PARA JUNTAR USUSARIO, EMPRESA CONTA. 
select * from CONTA INNER JOIN EMPRESA ON EMPRESA.EMP_COD = CONTA.COD_EMPR INNER JOIN USR_EMPR ON
 EMPRESA.EMP_COD = USR_EMPR.COD_EMPR INNER JOIN USUARIO ON USUARIO.USR_COD = USR_EMPR.COD_USR;
 
-- JOIN PARA JUNTAR EMPRESA DE USUARIOS COM CLAUSULA WHERE 
 SELECT EMP_COD, EMP_NOME_EMPRESA, EMP_CNPJ FROM USUARIO INNER JOIN USR_EMPR ON USUARIO.USR_COD = USR_EMPR.COD_USR INNER JOIN
 EMPRESA ON EMPRESA.EMP_COD = USR_EMPR.COD_EMPR WHERE COD_USR = 2;

-- JOIN PARA JUNTAR TODAS AS CONTAS DAS EMPRESAS NO QUAL O USUARIO FAZ PARTE 
SELECT CNT_COD, CNT_NOME, CNT_BANCO, CNT_AGNC, CNT_NMCONTA, CNT_TIPO, CNT_TIPO, CNT_SALDOINICIAL, EMP_NOME_EMPRESA  FROM CONTA INNER JOIN
EMPRESA ON EMPRESA.EMP_COD = CONTA.COD_EMPR INNER JOIN USR_EMPR ON USR_EMPR.COD_EMPR = EMPRESA.EMP_COD WHERE COD_USR = 2;

 -- JOIN NÃO FUNCIONA 

select * from USUARIO INNER JOIN USR_EMPR ON USR_EMPR.COD_USR = USUARIO.USR_COD;

SELECT
*
FROM USUARIO
WHERE USR_COD IN ( SELECT COD_USR FROM USR_EMPR);


SELECT DISTINCT USR_COD, USR_NOME, USR_LOGIN, USR_PERMISSAO FROM USR_EMPR INNER JOIN USUARIO ON USUARIO.USR_COD = USR_EMPR.COD_USR WHERE
 COD_EMPR IN (SELECT COD_EMPR FROM USR_EMPR WHERE COD_USR = 2);

use BUCKET;




SELECT * FROM EMPRESA WHERE EMP_COD = 2





