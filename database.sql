/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  2DAW - Felix Lozano Dominguez
 * Created: 13-feb-2018
 */
DROP DATABASE IF EXISTS bdfct;

CREATE DATABASE IF NOT EXISTS bdfct;

DROP TABLE IF EXISTS ALUMNOS;

DROP TABLE IF EXISTS CICLOS;

DROP TABLE IF EXISTS EMPRESAS;

DROP TABLE IF EXISTS FCT;

DROP TABLE IF EXISTS PROFESORES;

DROP TABLE IF EXISTS USUARIOS;

USE bdfct;

/*==============================================================*/
/* Table: PROFESORES                                            */
/*==============================================================*/
create table PROFESORES
(
   NIF_PROF             varchar(9) not null,
   NOMBRE_PROF          varchar(20),
   APELLIDO1_PROF       varchar(20),
   APELLIDO2_PROF       varchar(20),
   FOTOGRAFIA_PROF      varchar(100),
   NICKNAME_PROF        varchar(20) unique not null,
   TELF_FIJO_PROF       numeric(9,0),
   TELF_MOVIL_PROF      numeric(9,0),
   EMAIL_PROF           varchar(25),
   PASSWORD_PROF        varchar(60) unique not null,
   ROL_PROF             varchar(20) not null,
   primary key (NIF_PROF)
);

/*==============================================================*/
/* Table: USUARIOS                                              */
/*==============================================================*/
/*create table USUARIOS
(
   NIF_USER             varchar(9) not null,
   NOMBRE_USER          varchar(20),
   APELLIDO1_USER       varchar(20),
   APELLIDO2_USER       varchar(20),
   FOTOGRAFIA_USER      varchar(100),
   NICKNAME_USER        varchar(20) unique not null,
   TELF_FIJO_USER       numeric(9,0),
   TELF_MOVIL_USER      numeric(9,0),
   EMAIL_USER           varchar(25),
   PASSWORD_USER        varchar(20) unique not null,
   ROL_USER             varchar(5) not null,
   primary key (NIF_USER)
);*/

/*==============================================================*/
/* Table: PROVINCIAS                                            */
/*==============================================================*/
create table PROVINCIAS
(
   ID_PROVINCIA         numeric(2,0) not null,
   NOMBRE               varchar(10),
   primary key (ID_PROVINCIA)
);

/*==============================================================*/
/* Table: CICLOS                                                */
/*==============================================================*/
create table CICLOS
(
   CODIGO               varchar(5) not null,
   NOMBRE_CICLO         varchar(30),
   GRADO                varchar(30),
   HORASFCT             numeric(4,0),
   primary key (CODIGO)
);

/*==============================================================*/
/* Table: ALUMNOS                                               */
/*==============================================================*/
CREATE TABLE ALUMNOS
(
   NIF_ALU              varchar(9) not null,
   COD_CICLO            varchar(5) not null,
   NOMBRE_ALU           varchar(20),
   APELLIDO1_ALU        varchar(20),
   APELLIDO2_ALU        varchar(20),
   FOTOGRAFIA_ALU       varchar(100),
   NICKNAME_ALU         varchar(20) unique not null,
   DIRECCION_ALU        varchar(40),
   POBLACION_ALU        varchar(25),
   CPOSTAL_ALU          numeric(5,0),
   PROVINCIA_ALU        numeric(2,0),
   TELF_FIJO_ALU        numeric(9,0),
   TELF_MOVIL_ALU       numeric(9,0),
   EMAIL_ALU            varchar(25),
   primary key (NIF_ALU),
   constraint FK_AL_CF foreign key (COD_CICLO) references CICLOS (CODIGO)
);

/*==============================================================*/
/* Table: EMPRESAS                                              */
/*==============================================================*/
create table EMPRESAS
(
   CIF_EMP              varchar(9) not null,
   NOMBRE_EMP           varchar(20),
   TUTOR_EMP            varchar(20),
   DIRECCION_EMP        varchar(40),
   POBLACION_EMP        varchar(25),
   CPOSTAL_EMP          numeric(5,0),
   PROVINCIA_EMP        numeric(2,0),
   TELF_FIJO_EMP        numeric(9,0),
   TELF_MOVIL_EMP       numeric(9,0),
   EMAIL_EMP            varchar(25),
   primary key (CIF_EMP)
);

/*==============================================================*/
/* Table: FCT                                                   */
/*==============================================================*/
create table FCT
(
   ID_FCT               integer(9) not null AUTO_INCREMENT,
   NIF_PROF             varchar(9) not null,
   CIF_EMP              varchar(9) not null,
   NIF_ALU              varchar(9) not null,
   ANIO                 numeric(4,0),
   primary key (ID_FCT),
   /*primary key (NIF_PROF, CIF_EMP, NIF_ALU),*/
   constraint FK_FCT foreign key (NIF_PROF) references PROFESORES (NIF_PROF),
   constraint FK_FCT2 foreign key (CIF_EMP) references EMPRESAS (CIF_EMP),
   constraint FK_FCT3 foreign key (NIF_ALU) references ALUMNOS (NIF_ALU)
);

/*INSERT INTO `USUARIOS` (`NIF_USER`, `NICKNAME_USER`, `PASSWORD_USER`, `ROL_USER`) VALUES
('48922996H', 'Admin', 'admin', 'admin'),
('48922995L', 'User', 'user', 'user');*/

INSERT INTO `CICLOS` (`CODIGO`, `NOMBRE_CICLO`, `GRADO`, `HORASFCT`) VALUES
('SMR','Sistemas Microinformaticos y Redes', 'Grado Medio', 400),
('ASIR','Administracion de Sistemas Informaticos y Redes', 'Grado Superior', 400),
('DAM','Desarrollo de Aplicaciones Multiplataforma', 'Grado Superior', 400),
('DAW','Desarrollo de Aplicaciones Web', 'Grado Superior', 400);

INSERT INTO `provincias` (`ID_PROVINCIA`, `NOMBRE`) VALUES
('15', 'A Coruña'),
('01', 'Alava'),
('02', 'Albacete'),
('03', 'Alicante'),
('04', 'Almería'),
('33', 'Asturias'),
('05', 'Ávila'),
('06', 'Badajoz'),
('08', 'Barcelona'),
('09', 'Burgos'),
('10', 'Cáceres'),
('11', 'Cádiz'),
('39', 'Cantabria'),
('12', 'Castellón'),
('51', 'Ceuta'),
('13', 'Ciudad Real'),
('14', 'Córdoba'),
('16', 'Cuenca'),
('17', 'Girona'),
('18', 'Granada'),
('19', 'Guadalajara'),
('20', 'Guipzcoa'),
('21', 'Huelva'),
('22', 'Huesca'),
('07', 'Islas Baleares'),
('23', 'Jaén'),
('26', 'La Rioja'),
('35', 'Las Palmas'),
('24', 'León'),
('25', 'Lleida'),
('27', 'Lugo'),
('28', 'Madrid'),
('29', 'Málaga'),
('52', 'Melilla'),
('30', 'Murcia'),
('31', 'Navarra'),
('32', 'Ourense'),
('34', 'Palencia'),
('36', 'Pontevedra'),
('38', 'S. Cruz de Tenerife'),
('37', 'Salamanca'),
('40', 'Segovia'),
('41', 'Sevilla'),
('42', 'Soria'),
('43', 'Tarragona'),
('44', 'Teruel'),
('45', 'Toledo'),
('46', 'Valencia'),
('47', 'Valladolid'),
('48', 'Vizcaya'),
('49', 'Zamora'),
('50', 'Zaragoza');

INSERT INTO `ALUMNOS` (`NIF_ALU`, `COD_CICLO`, `NOMBRE_ALU`, `APELLIDO1_ALU`, 
`APELLIDO2_ALU`, `NICKNAME_ALU`, `DIRECCION_ALU`, `POBLACION_ALU`, `CPOSTAL_ALU`, 
`PROVINCIA_ALU`, `TELF_FIJO_ALU`, `TELF_MOVIL_ALU`, `EMAIL_ALU`) VALUES
('48922995S', 'ASIR', 'ANA', 'LOZANO', 'LOPEZ', 'ALONA', 'c/ SAN JUAN DEL PUERTO Nº4', 'HUELVA', 21004, 21, 959, 666, 'alona93@gmail.com');

INSERT INTO `PROFESORES` (`NIF_PROF`, `NOMBRE_PROF`, `APELLIDO1_PROF`, 
`APELLIDO2_PROF`, `NICKNAME_PROF`, `TELF_FIJO_PROF`, `TELF_MOVIL_PROF`, 
`EMAIL_PROF`, `PASSWORD_PROF`, `ROL_PROF`) VALUES
('48922993S', 'RAUL', 'RODRIGUEZ', 'PEREZ', 'rarpe', 959, 666, 'rarpe75@gmail.com', '$2a$04$bK/7F9CcGxp5h0hrtv4sG.t94h5RYmvZvAviCdqt3iof08IopoRpq', 'ROLE_PROFESOR'),
('48922996S', 'RODRIGO', 'RODRIGUEZ', 'PEREZ', 'rorpe', 959, 666, 'rorpe80@gmail.com', '$2a$04$TqWP1ZnQ3vMFVkGQAyHoFu7wi9kEoGkdVoBU5AHPWYkPtoU0fNmoW', 'ROLE_DIRECCION');

INSERT INTO `EMPRESAS` (`CIF_EMP`, `NOMBRE_EMP`, `TUTOR_EMP`, `DIRECCION_EMP`, 
`POBLACION_EMP`, `CPOSTAL_EMP`, `PROVINCIA_EMP`, `TELF_FIJO_EMP`, `TELF_MOVIL_EMP`, `EMAIL_EMP`)
VALUES
('1', 'SERVINFORM', 'JOSE', 'c/Alonso Sanchez nº 14', 'HUELVA', 21005, 21, 959, 666, 'rhumanos@servinform.es');

INSERT INTO `FCT` (`NIF_ALU`, `CIF_EMP`, `NIF_PROF`, `ANIO`) VALUES
('48922995S', '1', '48922993S', 2015);