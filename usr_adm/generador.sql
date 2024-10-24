
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE igorcollazos_tcpro.adm_usuario (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.adm_usuario ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.adm_usuario ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.adm_usuario ADD borrar INT;
INSERT INTO igorcollazos_tcpro.adm_usuario (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.adm_views (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.adm_views ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.adm_views ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.adm_views ADD borrar INT;
INSERT INTO igorcollazos_tcpro.adm_views (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.adm_perfil (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.adm_perfil ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.adm_perfil ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.adm_perfil ADD borrar INT;
INSERT INTO igorcollazos_tcpro.adm_perfil (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.adm_viewPerfil (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.adm_viewPerfil ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.adm_viewPerfil ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.adm_viewPerfil ADD borrar INT;
INSERT INTO igorcollazos_tcpro.adm_viewPerfil (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.adm_cadenas (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.adm_cadenas ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.adm_cadenas ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.adm_cadenas ADD borrar INT;
INSERT INTO igorcollazos_tcpro.adm_cadenas (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.adm_cadenas2 (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.adm_cadenas2 ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.adm_cadenas2 ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.adm_cadenas2 ADD borrar INT;
INSERT INTO igorcollazos_tcpro.adm_cadenas2 (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.adm_reporte (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.adm_reporte ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.adm_reporte ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.adm_reporte ADD borrar INT;
INSERT INTO igorcollazos_tcpro.adm_reporte (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.adm_master (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.adm_master ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.adm_master ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.adm_master ADD borrar INT;
INSERT INTO igorcollazos_tcpro.adm_master (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.adm_campos (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.adm_campos ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.adm_campos ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.adm_campos ADD borrar INT;
INSERT INTO igorcollazos_tcpro.adm_campos (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.adm_tablas (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.adm_tablas ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.adm_tablas ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.adm_tablas ADD borrar INT;
INSERT INTO igorcollazos_tcpro.adm_tablas (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.adm_alias (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.adm_alias ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.adm_alias ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.adm_alias ADD borrar INT;
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.adm_hijos (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.adm_hijos ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.adm_hijos ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.adm_hijos ADD borrar INT;
INSERT INTO igorcollazos_tcpro.adm_hijos (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.alias (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.alias ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.alias ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.alias ADD borrar INT;
INSERT INTO igorcollazos_tcpro.alias (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.adm_ctrlViews (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.adm_ctrlViews ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.adm_ctrlViews ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.adm_ctrlViews ADD borrar INT;
INSERT INTO igorcollazos_tcpro.adm_ctrlViews (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.gra_consulta (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.gra_consulta ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.gra_consulta ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.gra_consulta ADD borrar INT;
INSERT INTO igorcollazos_tcpro.gra_consulta (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.ind_modulo (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.ind_modulo ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.ind_modulo ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.ind_modulo ADD borrar INT;
INSERT INTO igorcollazos_tcpro.ind_modulo (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.ind_consulta (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.ind_consulta ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.ind_consulta ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.ind_consulta ADD borrar INT;
INSERT INTO igorcollazos_tcpro.ind_consulta (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.adm_input (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.adm_input ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.adm_input ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.adm_input ADD borrar INT;
INSERT INTO igorcollazos_tcpro.adm_input (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.adm_descendencia (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.adm_descendencia ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.adm_descendencia ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.adm_descendencia ADD borrar INT;
INSERT INTO igorcollazos_tcpro.adm_descendencia (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.adm_paginaPerfil (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.adm_paginaPerfil ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.adm_paginaPerfil ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.adm_paginaPerfil ADD borrar INT;
INSERT INTO igorcollazos_tcpro.adm_paginaPerfil (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.ind_reportes (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.ind_reportes ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.ind_reportes ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.ind_reportes ADD borrar INT;
INSERT INTO igorcollazos_tcpro.ind_reportes (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.aaa_proyecto (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.aaa_proyecto ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.aaa_proyecto ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.aaa_proyecto ADD borrar INT;
INSERT INTO igorcollazos_tcpro.aaa_proyecto (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.aaa_seguimiento (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.aaa_seguimiento ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.aaa_seguimiento ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.aaa_seguimiento ADD borrar INT;
INSERT INTO igorcollazos_tcpro.aaa_seguimiento (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.aaa_item (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.aaa_item ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.aaa_item ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.aaa_item ADD borrar INT;
INSERT INTO igorcollazos_tcpro.aaa_item (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.aaa_texto (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.aaa_texto ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.aaa_texto ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.aaa_texto ADD borrar INT;
INSERT INTO igorcollazos_tcpro.aaa_texto (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.aaa_variable (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.aaa_variable ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.aaa_variable ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.aaa_variable ADD borrar INT;
INSERT INTO igorcollazos_tcpro.aaa_variable (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.aaa_seguimientoEspejo (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.aaa_seguimientoEspejo ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.aaa_seguimientoEspejo ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.aaa_seguimientoEspejo ADD borrar INT;
INSERT INTO igorcollazos_tcpro.aaa_seguimientoEspejo (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.aaa_valor (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.aaa_valor ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.aaa_valor ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.aaa_valor ADD borrar INT;
INSERT INTO igorcollazos_tcpro.aaa_valor (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.aaa_textoValor (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.aaa_textoValor ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.aaa_textoValor ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.aaa_textoValor ADD borrar INT;
INSERT INTO igorcollazos_tcpro.aaa_textoValor (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.aaa_tipoVariable (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.aaa_tipoVariable ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.aaa_tipoVariable ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.aaa_tipoVariable ADD borrar INT;
INSERT INTO igorcollazos_tcpro.aaa_tipoVariable (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.aaa_dicTextoValor (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.aaa_dicTextoValor ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.aaa_dicTextoValor ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.aaa_dicTextoValor ADD borrar INT;
INSERT INTO igorcollazos_tcpro.aaa_dicTextoValor (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.aaa_idioma (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.aaa_idioma ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.aaa_idioma ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.aaa_idioma ADD borrar INT;
INSERT INTO igorcollazos_tcpro.aaa_idioma (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.aaa_lemaPar (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.aaa_lemaPar ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.aaa_lemaPar ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.aaa_lemaPar ADD borrar INT;
INSERT INTO igorcollazos_tcpro.aaa_lemaPar (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.aaa_textoSentimiento (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.aaa_textoSentimiento ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.aaa_textoSentimiento ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.aaa_textoSentimiento ADD borrar INT;
INSERT INTO igorcollazos_tcpro.aaa_textoSentimiento (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.aaa_sentimiento (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.aaa_sentimiento ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.aaa_sentimiento ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.aaa_sentimiento ADD borrar INT;
INSERT INTO igorcollazos_tcpro.aaa_sentimiento (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.aaa_dicDescarte (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.aaa_dicDescarte ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.aaa_dicDescarte ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.aaa_dicDescarte ADD borrar INT;
INSERT INTO igorcollazos_tcpro.aaa_dicDescarte (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.aaa_tipoSeguimiento (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.aaa_tipoSeguimiento ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.aaa_tipoSeguimiento ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.aaa_tipoSeguimiento ADD borrar INT;
INSERT INTO igorcollazos_tcpro.aaa_tipoSeguimiento (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.aaa_dicValor (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.aaa_dicValor ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.aaa_dicValor ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.aaa_dicValor ADD borrar INT;
INSERT INTO igorcollazos_tcpro.aaa_dicValor (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.aaa_dicRechazo (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.aaa_dicRechazo ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.aaa_dicRechazo ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.aaa_dicRechazo ADD borrar INT;
INSERT INTO igorcollazos_tcpro.aaa_dicRechazo (descriptor) VALUES ('No Definido');

CREATE TABLE igorcollazos_tcpro.aaa_fuente (descriptor VARCHAR(2560) );

ALTER TABLE igorcollazos_tcpro.aaa_fuente ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.aaa_fuente ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.aaa_fuente ADD borrar INT;
INSERT INTO igorcollazos_tcpro.aaa_fuente (descriptor) VALUES ('No Definido');

SET FOREIGN_KEY_CHECKS = 1;

SET FOREIGN_KEY_CHECKS = 0;
ALTER TABLE igorcollazos_tcpro.adm_perfil ADD tipo_adm_unidad VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.adm_views ADD alias VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.adm_views ADD rango INT;
ALTER TABLE igorcollazos_tcpro.adm_perfil ADD tipo_adm_nivel VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.adm_master ADD valores VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.adm_reporte ADD tipo_adm_unidad VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.adm_alias ADD alias VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.adm_hijos ADD padre VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.adm_hijos ADD hijo VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.adm_master ADD tabla VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.adm_master ADD campo VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.adm_usuario ADD clave VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.gra_consulta ADD consulta VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.ind_consulta ADD consulta VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.adm_paginaPerfil ADD pagina VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.ind_reportes ADD resumen VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.ind_reportes ADD fecha DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.aaa_texto ADD url VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.aaa_texto ADD textoLimpio VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.aaa_texto ADD analizado INT;
ALTER TABLE igorcollazos_tcpro.aaa_texto ADD longitud INT;
ALTER TABLE igorcollazos_tcpro.aaa_texto ADD textoTarzan VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.aaa_lemaPar ADD lemaPar VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.aaa_lemaPar ADD lema1 VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.aaa_lemaPar ADD lema2 VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.aaa_lemaPar ADD lop VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.aaa_lemaPar ADD relevancia INT;
ALTER TABLE igorcollazos_tcpro.aaa_lemaPar ADD numSocios INT;
ALTER TABLE igorcollazos_tcpro.aaa_textoValor ADD roh VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.aaa_textoValor ADD puntaje DECIMAL(11,4);
ALTER TABLE igorcollazos_tcpro.aaa_dicTextoValor ADD lemaPar VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.aaa_dicTextoValor ADD LOP VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.aaa_texto ADD fecha DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.aaa_texto ADD controlador VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.aaa_dicValor ADD LOP VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.aaa_dicValor ADD lemaPar VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.aaa_dicRechazo ADD LOP VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.aaa_dicRechazo ADD lemaPar VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.aaa_texto ADD fuente VARCHAR (2560) ;
ALTER TABLE igorcollazos_tcpro.alias ADD idadm_ctrlViews INT NULL DEFAULT '1';

ALTER TABLE alias ADD FOREIGN KEY (idadm_ctrlViews) REFERENCES adm_ctrlViews(id)  ON DELETE CASCADE ON UPDATE SET NULL ;
ALTER TABLE igorcollazos_tcpro.adm_viewPerfil ADD idadm_perfil INT NULL DEFAULT '1';
ALTER TABLE adm_viewPerfil ADD FOREIGN KEY (idadm_perfil) REFERENCES adm_perfil(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.adm_viewPerfil ADD idadm_views INT NULL DEFAULT '1';
ALTER TABLE adm_viewPerfil ADD FOREIGN KEY (idadm_views) REFERENCES adm_views(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.adm_usuario ADD idadm_perfil INT NULL DEFAULT '1';
ALTER TABLE adm_usuario ADD FOREIGN KEY (idadm_perfil) REFERENCES adm_perfil(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.adm_master ADD idadm_campos INT NULL DEFAULT '1';
ALTER TABLE adm_master ADD FOREIGN KEY (idadm_campos) REFERENCES adm_campos(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.adm_campos ADD idadm_tablas INT NULL DEFAULT '1';
ALTER TABLE adm_campos ADD FOREIGN KEY (idadm_tablas) REFERENCES adm_tablas(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.ind_consulta ADD idind_modulo INT NULL DEFAULT '1';
ALTER TABLE ind_consulta ADD FOREIGN KEY (idind_modulo) REFERENCES ind_modulo(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.adm_paginaPerfil ADD idadm_perfil INT NULL DEFAULT '1';
ALTER TABLE adm_paginaPerfil ADD FOREIGN KEY (idadm_perfil) REFERENCES adm_perfil(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.aaa_seguimiento ADD idaaa_proyecto INT NULL DEFAULT '1';
ALTER TABLE aaa_seguimiento ADD FOREIGN KEY (idaaa_proyecto) REFERENCES aaa_proyecto(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.aaa_item ADD idaaa_seguimiento INT NULL DEFAULT '1';
ALTER TABLE aaa_item ADD FOREIGN KEY (idaaa_seguimiento) REFERENCES aaa_seguimiento(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.aaa_texto ADD idaaa_item INT NULL DEFAULT '1';
ALTER TABLE aaa_texto ADD FOREIGN KEY (idaaa_item) REFERENCES aaa_item(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.aaa_variable ADD idaaa_seguimientoEspejo INT NULL DEFAULT '1';
ALTER TABLE aaa_variable ADD FOREIGN KEY (idaaa_seguimientoEspejo) REFERENCES aaa_seguimientoEspejo(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.aaa_valor ADD idaaa_variable INT NULL DEFAULT '1';
ALTER TABLE aaa_valor ADD FOREIGN KEY (idaaa_variable) REFERENCES aaa_variable(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.aaa_textoValor ADD idaaa_texto INT NULL DEFAULT '1';
ALTER TABLE aaa_textoValor ADD FOREIGN KEY (idaaa_texto) REFERENCES aaa_texto(id)  ON DELETE CASCADE ON UPDATE SET NULL ;
ALTER TABLE igorcollazos_tcpro.aaa_textoValor ADD idaaa_valor INT NULL DEFAULT '1';
ALTER TABLE aaa_textoValor ADD FOREIGN KEY (idaaa_valor) REFERENCES aaa_valor(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.aaa_variable ADD idaaa_tipoVariable INT NULL DEFAULT '1';
ALTER TABLE aaa_variable ADD FOREIGN KEY (idaaa_tipoVariable) REFERENCES aaa_tipoVariable(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.aaa_lemaPar ADD idaaa_texto INT NULL DEFAULT '1';
ALTER TABLE aaa_lemaPar ADD FOREIGN KEY (idaaa_texto) REFERENCES aaa_texto(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.aaa_textoSentimiento ADD idaaa_sentimiento INT NULL DEFAULT '1';
ALTER TABLE aaa_textoSentimiento ADD FOREIGN KEY (idaaa_sentimiento) REFERENCES aaa_sentimiento(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.aaa_textoSentimiento ADD idaaa_texto INT NULL DEFAULT '1';
ALTER TABLE aaa_textoSentimiento ADD FOREIGN KEY (idaaa_texto) REFERENCES aaa_texto(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.aaa_dicDescarte ADD idaaa_idioma INT NULL DEFAULT '1';
ALTER TABLE aaa_dicDescarte ADD FOREIGN KEY (idaaa_idioma) REFERENCES aaa_idioma(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.aaa_dicTextoValor ADD idaaa_textoValor INT NULL DEFAULT '1';
ALTER TABLE aaa_dicTextoValor ADD FOREIGN KEY (idaaa_textoValor) REFERENCES aaa_textoValor(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.aaa_fuente ADD idaaa_tipoSeguimiento INT NULL DEFAULT '1';
ALTER TABLE aaa_fuente ADD FOREIGN KEY (idaaa_tipoSeguimiento) REFERENCES aaa_tipoSeguimiento(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.aaa_dicValor ADD idaaa_valor INT NULL DEFAULT '1';
ALTER TABLE aaa_dicValor ADD FOREIGN KEY (idaaa_valor) REFERENCES aaa_valor(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.aaa_dicRechazo ADD idaaa_valor INT NULL DEFAULT '1';
ALTER TABLE aaa_dicRechazo ADD FOREIGN KEY (idaaa_valor) REFERENCES aaa_valor(id)  ON DELETE CASCADE ON UPDATE CASCADE ;
ALTER TABLE igorcollazos_tcpro.aaa_seguimiento ADD idaaa_fuente INT NULL DEFAULT '1';
ALTER TABLE aaa_seguimiento ADD FOREIGN KEY (idaaa_fuente) REFERENCES aaa_fuente(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('tipo_adm_unidad','Unidad');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idtipo_adm_unidad','Unidad');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('adm_usuario','Adm. Usuario');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idadm_usuario','Adm. Usuario');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('adm_views','Adm. View');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idadm_views','Adm. View');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('rango','Rango');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idrango','Rango');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('tipo_adm_nivel','Nivel');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idtipo_adm_nivel','Nivel');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('adm_perfil','Adm. Perfil de Usuario');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idadm_perfil','Adm. Perfil de Usuario');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('adm_viewPerfil','Adm. Perfil Asociado a View');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idadm_viewPerfil','Adm. Perfil Asociado a View');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('adm_cadenas','Adm. Cadenas');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idadm_cadenas','Adm. Cadenas');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('adm_cadenas2','Adm. Cadenas2');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idadm_cadenas2','Adm. Cadenas2');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('adm_reporte','Adm. Reporte');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idadm_reporte','Adm. Reporte');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('adm_master','Adm. Master');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idadm_master','Adm. Master');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('valores','Valores');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idvalores','Valores');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('adm_campos','Adm. Campos');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idadm_campos','Adm. Campos');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('adm_tablas','Adm. Tablas');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idadm_tablas','Adm. Tablas');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('adm_alias','Adm. Alias de Tablas');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idadm_alias','Adm. Alias de Tablas');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('adm_hijos','Adm. Hijos');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idadm_hijos','Adm. Hijos');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('alias','Alias');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idalias','Alias');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('padre','Padre');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idpadre','Padre');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('hijo','Hijo');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idhijo','Hijo');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('tabla','Tabla');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idtabla','Tabla');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('campo','Campo');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idcampo','Campo');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('clave','Clave');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idclave','Clave');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('gra_consulta','Adm. Generador');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idgra_consulta','Adm. Generador');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('consulta','Consulta');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idconsulta','Consulta');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('ind_modulo','Ind. Modulos');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idind_modulo','Ind. Modulos');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('ind_consulta','Ind. Consultas');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idind_consulta','Ind. Consultas');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('adm_input','Adm. Input Inicial');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idadm_input','Adm. Input Inicial');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('adm_descendencia','Adm. Descendencia');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idadm_descendencia','Adm. Descendencia');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('adm_paginaPerfil','Adm. Páginas Asociadas a Perfil');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idadm_paginaPerfil','Adm. Páginas Asociadas a Perfil');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('ind_reportes','Ind. Reportes Ejecutivos');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idind_reportes','Ind. Reportes Ejecutivos');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('resumen','Resumen Ejecutivo');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idresumen','Resumen Ejecutivo');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('fecha','Fecha');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idfecha','Fecha');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('aaa_proyecto','Pri. Proyecto');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idaaa_proyecto','Pri. Proyecto');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('aaa_seguimiento','Pri. Seguimiento');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idaaa_seguimiento','Pri. Seguimiento');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('aaa_item','Pri. Item');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idaaa_item','Pri. Item');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('aaa_texto','Pri. Texto');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idaaa_texto','Pri. Texto');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('aaa_variable','Pri. Variable');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idaaa_variable','Pri. Variable');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('aaa_seguimientoEspejo','Pri. SegVariable');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idaaa_seguimientoEspejo','Pri. SegVariable');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('aaa_valor','Pri. Valor');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idaaa_valor','Pri. Valor');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('aaa_textoValor','Pri. TextoValor');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idaaa_textoValor','Pri. TextoValor');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('aaa_tipoVariable','Ref. Tipo de Variable');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idaaa_tipoVariable','Ref. Tipo de Variable');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('aaa_dicTextoValor','Pri. DicTextoValor');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idaaa_dicTextoValor','Pri. DicTextoValor');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('aaa_idioma','Ref. Idioma');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idaaa_idioma','Ref. Idioma');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('aaa_lemaPar','Pri. LemaPar');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idaaa_lemaPar','Pri. LemaPar');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('aaa_textoSentimiento','Pri. TextoSentimiento');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idaaa_textoSentimiento','Pri. TextoSentimiento');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('aaa_sentimiento','Ref. Sentimiento');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idaaa_sentimiento','Ref. Sentimiento');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('aaa_dicDescarte','Ref. DicDescarte');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idaaa_dicDescarte','Ref. DicDescarte');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('url','URL');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idurl','URL');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('textoLimpio','Texto Limpio');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idtextoLimpio','Texto Limpio');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('analizado','Analizado');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idanalizado','Analizado');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('longitud','Longitud');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idlongitud','Longitud');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('textoTarzan','Texto Tarzan');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idtextoTarzan','Texto Tarzan');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('lemaPar','LemaPar');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idlemaPar','LemaPar');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('lema1','Lema 1');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idlema1','Lema 1');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('lema2','Lema 2');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idlema2','Lema 2');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('lop','Lema o Par');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idlop','Lema o Par');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('relevancia','Relevancia');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idrelevancia','Relevancia');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('numSocios','Número de Socios');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idnumSocios','Número de Socios');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('roh','Robot o Humano');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idroh','Robot o Humano');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('puntaje','Puntaje');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idpuntaje','Puntaje');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('LOP','Lema o Par');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idLOP','Lema o Par');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('aaa_tipoSeguimiento','Ref. Tipo de Seguimiento');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idaaa_tipoSeguimiento','Ref. Tipo de Seguimiento');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('controlador','Controlador');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idcontrolador','Controlador');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('aaa_dicValor','Pri. DicValor');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idaaa_dicValor','Pri. DicValor');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('aaa_dicRechazo','Pri. DicRechazo');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idaaa_dicRechazo','Pri. DicRechazo');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('aaa_fuente','Ref. Fuente');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idaaa_fuente','Ref. Fuente');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('fuente','Fuente del Texto');
INSERT INTO igorcollazos_tcpro.adm_alias (descriptor,alias) VALUES ('idfuente','Fuente del Texto');
INSERT INTO igorcollazos_tcpro.adm_hijos (descriptor) VALUES ('descriptor');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('adm_ctrlViews','alias');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('adm_perfil','adm_viewPerfil');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('adm_views','adm_viewPerfil');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('adm_perfil','adm_usuario');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('adm_campos','adm_master');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('adm_tablas','adm_campos');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('ind_modulo','ind_consulta');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('adm_perfil','adm_paginaPerfil');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('aaa_proyecto','aaa_seguimiento');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('aaa_seguimiento','aaa_item');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('aaa_item','aaa_texto');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('aaa_seguimientoEspejo','aaa_variable');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('aaa_variable','aaa_valor');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('aaa_texto','aaa_textoValor');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('aaa_valor','aaa_textoValor');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('aaa_tipoVariable','aaa_variable');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('aaa_texto','aaa_lemaPar');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('aaa_sentimiento','aaa_textoSentimiento');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('aaa_texto','aaa_textoSentimiento');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('aaa_idioma','aaa_dicDescarte');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('aaa_textoValor','aaa_dicTextoValor');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('aaa_tipoSeguimiento','aaa_fuente');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('aaa_valor','aaa_dicValor');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('aaa_valor','aaa_dicRechazo');
INSERT INTO igorcollazos_tcpro.adm_hijos (padre,hijo) VALUES ('aaa_fuente','aaa_seguimiento');

SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE igorcollazos_tcpro.doc_adm_usuario (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_adm_usuario ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_adm_usuario ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_adm_usuario ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_adm_usuario (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_adm_usuario ADD idadm_usuario INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_adm_usuario ADD FOREIGN KEY (idadm_usuario) REFERENCES adm_usuario(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_adm_views (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_adm_views ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_adm_views ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_adm_views ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_adm_views (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_adm_views ADD idadm_views INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_adm_views ADD FOREIGN KEY (idadm_views) REFERENCES adm_views(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_adm_perfil (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_adm_perfil ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_adm_perfil ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_adm_perfil ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_adm_perfil (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_adm_perfil ADD idadm_perfil INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_adm_perfil ADD FOREIGN KEY (idadm_perfil) REFERENCES adm_perfil(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_adm_viewPerfil (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_adm_viewPerfil ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_adm_viewPerfil ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_adm_viewPerfil ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_adm_viewPerfil (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_adm_viewPerfil ADD idadm_viewPerfil INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_adm_viewPerfil ADD FOREIGN KEY (idadm_viewPerfil) REFERENCES adm_viewPerfil(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_adm_cadenas (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_adm_cadenas ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_adm_cadenas ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_adm_cadenas ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_adm_cadenas (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_adm_cadenas ADD idadm_cadenas INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_adm_cadenas ADD FOREIGN KEY (idadm_cadenas) REFERENCES adm_cadenas(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_adm_cadenas2 (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_adm_cadenas2 ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_adm_cadenas2 ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_adm_cadenas2 ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_adm_cadenas2 (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_adm_cadenas2 ADD idadm_cadenas2 INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_adm_cadenas2 ADD FOREIGN KEY (idadm_cadenas2) REFERENCES adm_cadenas2(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_adm_reporte (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_adm_reporte ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_adm_reporte ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_adm_reporte ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_adm_reporte (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_adm_reporte ADD idadm_reporte INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_adm_reporte ADD FOREIGN KEY (idadm_reporte) REFERENCES adm_reporte(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_adm_master (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_adm_master ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_adm_master ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_adm_master ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_adm_master (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_adm_master ADD idadm_master INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_adm_master ADD FOREIGN KEY (idadm_master) REFERENCES adm_master(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_adm_campos (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_adm_campos ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_adm_campos ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_adm_campos ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_adm_campos (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_adm_campos ADD idadm_campos INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_adm_campos ADD FOREIGN KEY (idadm_campos) REFERENCES adm_campos(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_adm_tablas (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_adm_tablas ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_adm_tablas ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_adm_tablas ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_adm_tablas (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_adm_tablas ADD idadm_tablas INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_adm_tablas ADD FOREIGN KEY (idadm_tablas) REFERENCES adm_tablas(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_adm_alias (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_adm_alias ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_adm_alias ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_adm_alias ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_adm_alias (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_adm_alias ADD idadm_alias INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_adm_alias ADD FOREIGN KEY (idadm_alias) REFERENCES adm_alias(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_adm_hijos (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_adm_hijos ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_adm_hijos ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_adm_hijos ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_adm_hijos (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_adm_hijos ADD idadm_hijos INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_adm_hijos ADD FOREIGN KEY (idadm_hijos) REFERENCES adm_hijos(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_alias (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_alias ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_alias ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_alias ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_alias (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_alias ADD idalias INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_alias ADD FOREIGN KEY (idalias) REFERENCES alias(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_adm_ctrlViews (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_adm_ctrlViews ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_adm_ctrlViews ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_adm_ctrlViews ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_adm_ctrlViews (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_adm_ctrlViews ADD idadm_ctrlViews INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_adm_ctrlViews ADD FOREIGN KEY (idadm_ctrlViews) REFERENCES adm_ctrlViews(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_gra_consulta (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_gra_consulta ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_gra_consulta ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_gra_consulta ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_gra_consulta (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_gra_consulta ADD idgra_consulta INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_gra_consulta ADD FOREIGN KEY (idgra_consulta) REFERENCES gra_consulta(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_ind_modulo (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_ind_modulo ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_ind_modulo ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_ind_modulo ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_ind_modulo (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_ind_modulo ADD idind_modulo INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_ind_modulo ADD FOREIGN KEY (idind_modulo) REFERENCES ind_modulo(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_ind_consulta (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_ind_consulta ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_ind_consulta ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_ind_consulta ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_ind_consulta (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_ind_consulta ADD idind_consulta INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_ind_consulta ADD FOREIGN KEY (idind_consulta) REFERENCES ind_consulta(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_adm_input (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_adm_input ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_adm_input ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_adm_input ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_adm_input (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_adm_input ADD idadm_input INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_adm_input ADD FOREIGN KEY (idadm_input) REFERENCES adm_input(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_adm_descendencia (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_adm_descendencia ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_adm_descendencia ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_adm_descendencia ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_adm_descendencia (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_adm_descendencia ADD idadm_descendencia INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_adm_descendencia ADD FOREIGN KEY (idadm_descendencia) REFERENCES adm_descendencia(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_adm_paginaPerfil (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_adm_paginaPerfil ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_adm_paginaPerfil ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_adm_paginaPerfil ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_adm_paginaPerfil (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_adm_paginaPerfil ADD idadm_paginaPerfil INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_adm_paginaPerfil ADD FOREIGN KEY (idadm_paginaPerfil) REFERENCES adm_paginaPerfil(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_ind_reportes (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_ind_reportes ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_ind_reportes ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_ind_reportes ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_ind_reportes (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_ind_reportes ADD idind_reportes INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_ind_reportes ADD FOREIGN KEY (idind_reportes) REFERENCES ind_reportes(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_aaa_proyecto (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_aaa_proyecto ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_aaa_proyecto ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_aaa_proyecto ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_aaa_proyecto (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_aaa_proyecto ADD idaaa_proyecto INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_aaa_proyecto ADD FOREIGN KEY (idaaa_proyecto) REFERENCES aaa_proyecto(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_aaa_seguimiento (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_aaa_seguimiento ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_aaa_seguimiento ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_aaa_seguimiento ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_aaa_seguimiento (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_aaa_seguimiento ADD idaaa_seguimiento INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_aaa_seguimiento ADD FOREIGN KEY (idaaa_seguimiento) REFERENCES aaa_seguimiento(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_aaa_item (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_aaa_item ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_aaa_item ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_aaa_item ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_aaa_item (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_aaa_item ADD idaaa_item INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_aaa_item ADD FOREIGN KEY (idaaa_item) REFERENCES aaa_item(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_aaa_texto (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_aaa_texto ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_aaa_texto ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_aaa_texto ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_aaa_texto (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_aaa_texto ADD idaaa_texto INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_aaa_texto ADD FOREIGN KEY (idaaa_texto) REFERENCES aaa_texto(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_aaa_variable (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_aaa_variable ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_aaa_variable ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_aaa_variable ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_aaa_variable (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_aaa_variable ADD idaaa_variable INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_aaa_variable ADD FOREIGN KEY (idaaa_variable) REFERENCES aaa_variable(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_aaa_seguimientoEspejo (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_aaa_seguimientoEspejo ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_aaa_seguimientoEspejo ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_aaa_seguimientoEspejo ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_aaa_seguimientoEspejo (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_aaa_seguimientoEspejo ADD idaaa_seguimientoEspejo INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_aaa_seguimientoEspejo ADD FOREIGN KEY (idaaa_seguimientoEspejo) REFERENCES aaa_seguimientoEspejo(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_aaa_valor (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_aaa_valor ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_aaa_valor ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_aaa_valor ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_aaa_valor (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_aaa_valor ADD idaaa_valor INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_aaa_valor ADD FOREIGN KEY (idaaa_valor) REFERENCES aaa_valor(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_aaa_textoValor (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_aaa_textoValor ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_aaa_textoValor ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_aaa_textoValor ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_aaa_textoValor (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_aaa_textoValor ADD idaaa_textoValor INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_aaa_textoValor ADD FOREIGN KEY (idaaa_textoValor) REFERENCES aaa_textoValor(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_aaa_tipoVariable (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_aaa_tipoVariable ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_aaa_tipoVariable ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_aaa_tipoVariable ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_aaa_tipoVariable (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_aaa_tipoVariable ADD idaaa_tipoVariable INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_aaa_tipoVariable ADD FOREIGN KEY (idaaa_tipoVariable) REFERENCES aaa_tipoVariable(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_aaa_dicTextoValor (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_aaa_dicTextoValor ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_aaa_dicTextoValor ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_aaa_dicTextoValor ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_aaa_dicTextoValor (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_aaa_dicTextoValor ADD idaaa_dicTextoValor INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_aaa_dicTextoValor ADD FOREIGN KEY (idaaa_dicTextoValor) REFERENCES aaa_dicTextoValor(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_aaa_idioma (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_aaa_idioma ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_aaa_idioma ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_aaa_idioma ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_aaa_idioma (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_aaa_idioma ADD idaaa_idioma INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_aaa_idioma ADD FOREIGN KEY (idaaa_idioma) REFERENCES aaa_idioma(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_aaa_lemaPar (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_aaa_lemaPar ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_aaa_lemaPar ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_aaa_lemaPar ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_aaa_lemaPar (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_aaa_lemaPar ADD idaaa_lemaPar INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_aaa_lemaPar ADD FOREIGN KEY (idaaa_lemaPar) REFERENCES aaa_lemaPar(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_aaa_textoSentimiento (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_aaa_textoSentimiento ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_aaa_textoSentimiento ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_aaa_textoSentimiento ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_aaa_textoSentimiento (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_aaa_textoSentimiento ADD idaaa_textoSentimiento INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_aaa_textoSentimiento ADD FOREIGN KEY (idaaa_textoSentimiento) REFERENCES aaa_textoSentimiento(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_aaa_sentimiento (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_aaa_sentimiento ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_aaa_sentimiento ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_aaa_sentimiento ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_aaa_sentimiento (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_aaa_sentimiento ADD idaaa_sentimiento INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_aaa_sentimiento ADD FOREIGN KEY (idaaa_sentimiento) REFERENCES aaa_sentimiento(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_aaa_dicDescarte (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_aaa_dicDescarte ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_aaa_dicDescarte ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_aaa_dicDescarte ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_aaa_dicDescarte (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_aaa_dicDescarte ADD idaaa_dicDescarte INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_aaa_dicDescarte ADD FOREIGN KEY (idaaa_dicDescarte) REFERENCES aaa_dicDescarte(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_aaa_tipoSeguimiento (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_aaa_tipoSeguimiento ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_aaa_tipoSeguimiento ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_aaa_tipoSeguimiento ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_aaa_tipoSeguimiento (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_aaa_tipoSeguimiento ADD idaaa_tipoSeguimiento INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_aaa_tipoSeguimiento ADD FOREIGN KEY (idaaa_tipoSeguimiento) REFERENCES aaa_tipoSeguimiento(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_aaa_dicValor (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_aaa_dicValor ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_aaa_dicValor ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_aaa_dicValor ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_aaa_dicValor (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_aaa_dicValor ADD idaaa_dicValor INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_aaa_dicValor ADD FOREIGN KEY (idaaa_dicValor) REFERENCES aaa_dicValor(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_aaa_dicRechazo (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_aaa_dicRechazo ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_aaa_dicRechazo ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_aaa_dicRechazo ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_aaa_dicRechazo (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_aaa_dicRechazo ADD idaaa_dicRechazo INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_aaa_dicRechazo ADD FOREIGN KEY (idaaa_dicRechazo) REFERENCES aaa_dicRechazo(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

CREATE TABLE igorcollazos_tcpro.doc_aaa_fuente (descriptor VARCHAR(256) );

ALTER TABLE igorcollazos_tcpro.doc_aaa_fuente ADD id INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id),ENGINE = InnoDB;
ALTER TABLE igorcollazos_tcpro.doc_aaa_fuente ADD fechaHora DATE NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE igorcollazos_tcpro.doc_aaa_fuente ADD borrar INT;
INSERT INTO igorcollazos_tcpro.doc_aaa_fuente (descriptor) VALUES ('No Definido');

ALTER TABLE igorcollazos_tcpro.doc_aaa_fuente ADD idaaa_fuente INT NULL DEFAULT '1';
ALTER TABLE igorcollazos_tcpro.doc_aaa_fuente ADD FOREIGN KEY (idaaa_fuente) REFERENCES aaa_fuente(id)  ON DELETE CASCADE ON UPDATE CASCADE ;

SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO adm_master (tabla,campo,valores) VALUES ('tabla','campo','V1');
INSERT INTO adm_master (tabla,campo,valores) VALUES ('tabla','campo','V2');
INSERT INTO adm_master (tabla,campo,valores) VALUES ('tabla','campo','V3');


CREATE VIEW v_adm_usuario AS SELECT
	adm_usuario_adm_usuario.id AS id,
	adm_usuario_adm_usuario.descriptor AS descriptor,
	adm_usuario_adm_usuario.fechaHora AS fechaHora,
	adm_usuario_adm_usuario.clave,
	adm_usuario_adm_perfil.id AS id_perfil_usuario,
	adm_usuario_adm_perfil.descriptor AS descriptor_perfil_usuario FROM adm_usuario AS adm_usuario_adm_usuario     
	INNER JOIN adm_perfil AS adm_usuario_adm_perfil ON adm_usuario_adm_usuario.idadm_perfil = adm_usuario_adm_perfil.id   ;


CREATE VIEW v_adm_views AS SELECT
	adm_views_adm_views.id AS id,
	adm_views_adm_views.descriptor AS descriptor,
	adm_views_adm_views.fechaHora AS fechaHora,
	adm_views_adm_views.alias,
	adm_views_adm_views.rango FROM adm_views AS adm_views_adm_views    ;

CREATE VIEW v_adm_perfil AS SELECT
	adm_perfil_adm_perfil.id AS id,
	adm_perfil_adm_perfil.descriptor AS descriptor,
	adm_perfil_adm_perfil.fechaHora AS fechaHora,
	adm_perfil_adm_perfil.tipo_adm_unidad,
	adm_perfil_adm_perfil.tipo_adm_nivel FROM adm_perfil AS adm_perfil_adm_perfil    ;

CREATE VIEW v_adm_viewPerfil AS SELECT
	adm_viewPerfil_adm_viewPerfil.id AS id,
	adm_viewPerfil_adm_viewPerfil.descriptor AS descriptor,
	adm_viewPerfil_adm_viewPerfil.fechaHora AS fechaHora,
	adm_viewPerfil_adm_perfil.id AS id_perfil_viewPerfil,
	adm_viewPerfil_adm_perfil.descriptor AS descriptor_perfil_viewPerfil ,
	adm_viewPerfil_adm_views.id AS id_views_viewPerfil,
	adm_viewPerfil_adm_views.descriptor AS descriptor_views_viewPerfil FROM adm_viewPerfil AS adm_viewPerfil_adm_viewPerfil     
	INNER JOIN adm_perfil AS adm_viewPerfil_adm_perfil ON adm_viewPerfil_adm_viewPerfil.idadm_perfil = adm_viewPerfil_adm_perfil.id    
	INNER JOIN adm_views AS adm_viewPerfil_adm_views ON adm_viewPerfil_adm_viewPerfil.idadm_views = adm_viewPerfil_adm_views.id   ;

CREATE VIEW v_adm_cadenas AS SELECT
	adm_cadenas_adm_cadenas.id AS id,
	adm_cadenas_adm_cadenas.descriptor AS descriptor,
	adm_cadenas_adm_cadenas.fechaHora AS fechaHora FROM adm_cadenas AS adm_cadenas_adm_cadenas    ;

CREATE VIEW v_adm_cadenas2 AS SELECT
	adm_cadenas2_adm_cadenas2.id AS id,
	adm_cadenas2_adm_cadenas2.descriptor AS descriptor,
	adm_cadenas2_adm_cadenas2.fechaHora AS fechaHora FROM adm_cadenas2 AS adm_cadenas2_adm_cadenas2    ;

CREATE VIEW v_adm_reporte AS SELECT
	adm_reporte_adm_reporte.id AS id,
	adm_reporte_adm_reporte.descriptor AS descriptor,
	adm_reporte_adm_reporte.fechaHora AS fechaHora,
	adm_reporte_adm_reporte.tipo_adm_unidad FROM adm_reporte AS adm_reporte_adm_reporte    ;

CREATE VIEW v_adm_master AS SELECT
	adm_master_adm_master.id AS id,
	adm_master_adm_master.descriptor AS descriptor,
	adm_master_adm_master.fechaHora AS fechaHora,
	adm_master_adm_master.valores,
	adm_master_adm_master.tabla,
	adm_master_adm_master.campo,
	adm_master_adm_campos.id AS id_campos_master,
	adm_master_adm_campos.descriptor AS descriptor_campos_master ,
	adm_campos_adm_tablas.id AS id_tablas_campos,
	adm_campos_adm_tablas.descriptor AS descriptor_tablas_campos FROM adm_master AS adm_master_adm_master     
	INNER JOIN adm_campos AS adm_master_adm_campos ON adm_master_adm_master.idadm_campos = adm_master_adm_campos.id   
	INNER JOIN adm_tablas AS adm_campos_adm_tablas ON adm_master_adm_campos.idadm_tablas = adm_campos_adm_tablas.id   ;

CREATE VIEW v_adm_campos AS SELECT
	adm_campos_adm_campos.id AS id,
	adm_campos_adm_campos.descriptor AS descriptor,
	adm_campos_adm_campos.fechaHora AS fechaHora,
	adm_campos_adm_tablas.id AS id_tablas_campos,
	adm_campos_adm_tablas.descriptor AS descriptor_tablas_campos FROM adm_campos AS adm_campos_adm_campos     
	INNER JOIN adm_tablas AS adm_campos_adm_tablas ON adm_campos_adm_campos.idadm_tablas = adm_campos_adm_tablas.id   ;

CREATE VIEW v_adm_tablas AS SELECT
	adm_tablas_adm_tablas.id AS id,
	adm_tablas_adm_tablas.descriptor AS descriptor,
	adm_tablas_adm_tablas.fechaHora AS fechaHora FROM adm_tablas AS adm_tablas_adm_tablas    ;

CREATE VIEW v_adm_alias AS SELECT
	adm_alias_adm_alias.id AS id,
	adm_alias_adm_alias.descriptor AS descriptor,
	adm_alias_adm_alias.fechaHora AS fechaHora,
	adm_alias_adm_alias.alias FROM adm_alias AS adm_alias_adm_alias    ;

CREATE VIEW v_adm_hijos AS SELECT
	adm_hijos_adm_hijos.id AS id,
	adm_hijos_adm_hijos.descriptor AS descriptor,
	adm_hijos_adm_hijos.fechaHora AS fechaHora,
	adm_hijos_adm_hijos.padre,
	adm_hijos_adm_hijos.hijo FROM adm_hijos AS adm_hijos_adm_hijos    ;

CREATE VIEW v_alias AS SELECT
	alias_alias.id AS id,
	alias_alias.descriptor AS descriptor,
	alias_alias.fechaHora AS fechaHora,
	alias_adm_ctrlViews.id AS id_ctrlViews_s,
	alias_adm_ctrlViews.descriptor AS descriptor_ctrlViews_s FROM alias AS alias_alias     
	INNER JOIN adm_ctrlViews AS alias_adm_ctrlViews ON alias_alias.idadm_ctrlViews = alias_adm_ctrlViews.id   ;

CREATE VIEW v_adm_ctrlViews AS SELECT
	adm_ctrlViews_adm_ctrlViews.id AS id,
	adm_ctrlViews_adm_ctrlViews.descriptor AS descriptor,
	adm_ctrlViews_adm_ctrlViews.fechaHora AS fechaHora FROM adm_ctrlViews AS adm_ctrlViews_adm_ctrlViews    ;

CREATE VIEW v_gra_consulta AS SELECT
	gra_consulta_gra_consulta.id AS id,
	gra_consulta_gra_consulta.descriptor AS descriptor,
	gra_consulta_gra_consulta.fechaHora AS fechaHora,
	gra_consulta_gra_consulta.consulta FROM gra_consulta AS gra_consulta_gra_consulta    ;

CREATE VIEW v_ind_modulo AS SELECT
	ind_modulo_ind_modulo.id AS id,
	ind_modulo_ind_modulo.descriptor AS descriptor,
	ind_modulo_ind_modulo.fechaHora AS fechaHora FROM ind_modulo AS ind_modulo_ind_modulo    ;

CREATE VIEW v_ind_consulta AS SELECT
	ind_consulta_ind_consulta.id AS id,
	ind_consulta_ind_consulta.descriptor AS descriptor,
	ind_consulta_ind_consulta.fechaHora AS fechaHora,
	ind_consulta_ind_consulta.consulta,
	ind_consulta_ind_modulo.id AS id_modulo_consulta,
	ind_consulta_ind_modulo.descriptor AS descriptor_modulo_consulta FROM ind_consulta AS ind_consulta_ind_consulta     
	INNER JOIN ind_modulo AS ind_consulta_ind_modulo ON ind_consulta_ind_consulta.idind_modulo = ind_consulta_ind_modulo.id   ;

CREATE VIEW v_adm_input AS SELECT
	adm_input_adm_input.id AS id,
	adm_input_adm_input.descriptor AS descriptor,
	adm_input_adm_input.fechaHora AS fechaHora FROM adm_input AS adm_input_adm_input    ;

CREATE VIEW v_adm_descendencia AS SELECT
	adm_descendencia_adm_descendencia.id AS id,
	adm_descendencia_adm_descendencia.descriptor AS descriptor,
	adm_descendencia_adm_descendencia.fechaHora AS fechaHora FROM adm_descendencia AS adm_descendencia_adm_descendencia    ;

CREATE VIEW v_adm_paginaPerfil AS SELECT
	adm_paginaPerfil_adm_paginaPerfil.id AS id,
	adm_paginaPerfil_adm_paginaPerfil.descriptor AS descriptor,
	adm_paginaPerfil_adm_paginaPerfil.fechaHora AS fechaHora,
	adm_paginaPerfil_adm_paginaPerfil.pagina,
	adm_paginaPerfil_adm_perfil.id AS id_perfil_paginaPerfil,
	adm_paginaPerfil_adm_perfil.descriptor AS descriptor_perfil_paginaPerfil FROM adm_paginaPerfil AS adm_paginaPerfil_adm_paginaPerfil     
	INNER JOIN adm_perfil AS adm_paginaPerfil_adm_perfil ON adm_paginaPerfil_adm_paginaPerfil.idadm_perfil = adm_paginaPerfil_adm_perfil.id   ;

CREATE VIEW v_ind_reportes AS SELECT
ind_reportes_ind_reportes.id AS id,
ind_reportes_ind_reportes.descriptor AS descriptor,
ind_reportes_ind_reportes.fechaHora AS fechaHora,
ind_reportes_ind_reportes.resumen,
ind_reportes_ind_reportes.fecha FROM ind_reportes AS ind_reportes_ind_reportes    ;

CREATE VIEW v_aaa_proyecto AS SELECT
	aaa_proyecto_aaa_proyecto.id AS id,
	aaa_proyecto_aaa_proyecto.descriptor AS descriptor,
	aaa_proyecto_aaa_proyecto.fechaHora AS fechaHora FROM aaa_proyecto AS aaa_proyecto_aaa_proyecto    ;

CREATE VIEW v_aaa_seguimiento AS SELECT
	aaa_seguimiento_aaa_seguimiento.id AS id,
	aaa_seguimiento_aaa_seguimiento.descriptor AS descriptor,
	aaa_seguimiento_aaa_seguimiento.fechaHora AS fechaHora,
	aaa_seguimiento_aaa_proyecto.id AS id_proyecto_seguimiento,
	aaa_seguimiento_aaa_proyecto.descriptor AS descriptor_proyecto_seguimiento ,
	aaa_seguimiento_aaa_fuente.id AS id_fuente_seguimiento,
	aaa_seguimiento_aaa_fuente.descriptor AS descriptor_fuente_seguimiento ,
	aaa_fuente_aaa_tipoSeguimiento.id AS id_tipoSeguimiento_fuente,
	aaa_fuente_aaa_tipoSeguimiento.descriptor AS descriptor_tipoSeguimiento_fuente FROM aaa_seguimiento AS aaa_seguimiento_aaa_seguimiento     
	INNER JOIN aaa_proyecto AS aaa_seguimiento_aaa_proyecto ON aaa_seguimiento_aaa_seguimiento.idaaa_proyecto = aaa_seguimiento_aaa_proyecto.id    
	INNER JOIN aaa_fuente AS aaa_seguimiento_aaa_fuente ON aaa_seguimiento_aaa_seguimiento.idaaa_fuente = aaa_seguimiento_aaa_fuente.id   
	INNER JOIN aaa_tipoSeguimiento AS aaa_fuente_aaa_tipoSeguimiento ON aaa_seguimiento_aaa_fuente.idaaa_tipoSeguimiento = aaa_fuente_aaa_tipoSeguimiento.id   ;

CREATE VIEW v_aaa_item AS SELECT
	aaa_item_aaa_item.id AS id,
	aaa_item_aaa_item.descriptor AS descriptor,
	aaa_item_aaa_item.fechaHora AS fechaHora,
	aaa_item_aaa_seguimiento.id AS id_seguimiento_item,
	aaa_item_aaa_seguimiento.descriptor AS descriptor_seguimiento_item ,
	aaa_seguimiento_aaa_proyecto.id AS id_proyecto_seguimiento,   aaa_seguimiento_aaa_proyecto.descriptor AS descriptor_proyecto_seguimiento ,   aaa_seguimiento_aaa_fuente.id AS id_fuente_seguimiento,   aaa_seguimiento_aaa_fuente.descriptor AS descriptor_fuente_seguimiento ,   aaa_fuente_aaa_tipoSeguimiento.id AS id_tipoSeguimiento_fuente,   aaa_fuente_aaa_tipoSeguimiento.descriptor AS descriptor_tipoSeguimiento_fuente FROM aaa_item AS aaa_item_aaa_item     
	INNER JOIN aaa_seguimiento AS aaa_item_aaa_seguimiento ON aaa_item_aaa_item.idaaa_seguimiento = aaa_item_aaa_seguimiento.id   
	INNER JOIN aaa_proyecto AS aaa_seguimiento_aaa_proyecto ON aaa_item_aaa_seguimiento.idaaa_proyecto = aaa_seguimiento_aaa_proyecto.id   
	INNER JOIN aaa_fuente AS aaa_seguimiento_aaa_fuente ON aaa_item_aaa_seguimiento.idaaa_fuente = aaa_seguimiento_aaa_fuente.id   
	INNER JOIN aaa_tipoSeguimiento AS aaa_fuente_aaa_tipoSeguimiento ON aaa_seguimiento_aaa_fuente.idaaa_tipoSeguimiento = aaa_fuente_aaa_tipoSeguimiento.id   ;

CREATE VIEW v_aaa_texto AS SELECT
	aaa_texto_aaa_texto.id AS id,
	aaa_texto_aaa_texto.descriptor AS descriptor,
	aaa_texto_aaa_texto.fechaHora AS fechaHora,
	aaa_texto_aaa_texto.url,
	aaa_texto_aaa_texto.textoLimpio,
	aaa_texto_aaa_texto.analizado,
	aaa_texto_aaa_texto.longitud,
	aaa_texto_aaa_texto.textoTarzan,
	aaa_texto_aaa_texto.fecha,
	aaa_texto_aaa_texto.controlador,
	aaa_texto_aaa_texto.fuente,
	aaa_texto_aaa_item.id AS id_item_texto,
	aaa_texto_aaa_item.descriptor AS descriptor_item_texto ,
	aaa_item_aaa_seguimiento.id AS id_seguimiento_item,
	aaa_item_aaa_seguimiento.descriptor AS descriptor_seguimiento_item ,
	aaa_seguimiento_aaa_proyecto.id AS id_proyecto_seguimiento,
	aaa_seguimiento_aaa_proyecto.descriptor AS descriptor_proyecto_seguimiento ,
	aaa_seguimiento_aaa_fuente.id AS id_fuente_seguimiento,
	aaa_seguimiento_aaa_fuente.descriptor AS descriptor_fuente_seguimiento ,
	aaa_fuente_aaa_tipoSeguimiento.id AS id_tipoSeguimiento_fuente,
	aaa_fuente_aaa_tipoSeguimiento.descriptor AS descriptor_tipoSeguimiento_fuente FROM aaa_texto AS aaa_texto_aaa_texto     
	INNER JOIN aaa_item AS aaa_texto_aaa_item ON aaa_texto_aaa_texto.idaaa_item = aaa_texto_aaa_item.id   
	INNER JOIN aaa_seguimiento AS aaa_item_aaa_seguimiento ON aaa_texto_aaa_item.idaaa_seguimiento = aaa_item_aaa_seguimiento.id   
	INNER JOIN aaa_proyecto AS aaa_seguimiento_aaa_proyecto ON aaa_item_aaa_seguimiento.idaaa_proyecto = aaa_seguimiento_aaa_proyecto.id   
	INNER JOIN aaa_fuente AS aaa_seguimiento_aaa_fuente ON aaa_item_aaa_seguimiento.idaaa_fuente = aaa_seguimiento_aaa_fuente.id   
	INNER JOIN aaa_tipoSeguimiento AS aaa_fuente_aaa_tipoSeguimiento ON aaa_seguimiento_aaa_fuente.idaaa_tipoSeguimiento = aaa_fuente_aaa_tipoSeguimiento.id   ;

CREATE VIEW v_aaa_variable AS SELECT
	aaa_variable_aaa_variable.id AS id,
	aaa_variable_aaa_variable.descriptor AS descriptor,
	aaa_variable_aaa_variable.fechaHora AS fechaHora,
	aaa_variable_aaa_seguimientoEspejo.id AS id_seguimientoEspejo_variable,
	aaa_variable_aaa_seguimientoEspejo.descriptor AS descriptor_seguimientoEspejo_variable ,
	aaa_variable_aaa_tipoVariable.id AS id_tipoVariable_variable,
	aaa_variable_aaa_tipoVariable.descriptor AS descriptor_tipoVariable_variable FROM aaa_variable AS aaa_variable_aaa_variable     
	INNER JOIN aaa_seguimientoEspejo AS aaa_variable_aaa_seguimientoEspejo ON aaa_variable_aaa_variable.idaaa_seguimientoEspejo = aaa_variable_aaa_seguimientoEspejo.id    
	INNER JOIN aaa_tipoVariable AS aaa_variable_aaa_tipoVariable ON aaa_variable_aaa_variable.idaaa_tipoVariable = aaa_variable_aaa_tipoVariable.id   ;

CREATE VIEW v_aaa_seguimientoEspejo AS SELECT
	aaa_seguimientoEspejo_aaa_seguimientoEspejo.id AS id,
	aaa_seguimientoEspejo_aaa_seguimientoEspejo.descriptor AS descriptor,
	aaa_seguimientoEspejo_aaa_seguimientoEspejo.fechaHora AS fechaHora FROM aaa_seguimientoEspejo AS aaa_seguimientoEspejo_aaa_seguimientoEspejo    ;

CREATE VIEW v_aaa_valor AS SELECT
	aaa_valor_aaa_valor.id AS id,
	aaa_valor_aaa_valor.descriptor AS descriptor,
	aaa_valor_aaa_valor.fechaHora AS fechaHora,
	aaa_valor_aaa_variable.id AS id_variable_valor,
	aaa_valor_aaa_variable.descriptor AS descriptor_variable_valor ,
	aaa_variable_aaa_seguimientoEspejo.id AS id_seguimientoEspejo_variable,
	aaa_variable_aaa_seguimientoEspejo.descriptor AS descriptor_seguimientoEspejo_variable ,
	aaa_variable_aaa_tipoVariable.id AS id_tipoVariable_variable,
	aaa_variable_aaa_tipoVariable.descriptor AS descriptor_tipoVariable_variable FROM aaa_valor AS aaa_valor_aaa_valor     
	INNER JOIN aaa_variable AS aaa_valor_aaa_variable ON aaa_valor_aaa_valor.idaaa_variable = aaa_valor_aaa_variable.id   
	INNER JOIN aaa_seguimientoEspejo AS aaa_variable_aaa_seguimientoEspejo ON aaa_valor_aaa_variable.idaaa_seguimientoEspejo = aaa_variable_aaa_seguimientoEspejo.id   
	INNER JOIN aaa_tipoVariable AS aaa_variable_aaa_tipoVariable ON aaa_valor_aaa_variable.idaaa_tipoVariable = aaa_variable_aaa_tipoVariable.id   ;

CREATE VIEW v_aaa_textoValor AS SELECT
	aaa_textoValor_aaa_textoValor.id AS id,
	aaa_textoValor_aaa_textoValor.descriptor AS descriptor,
	aaa_textoValor_aaa_textoValor.fechaHora AS fechaHora,
	aaa_textoValor_aaa_textoValor.roh,
	aaa_textoValor_aaa_textoValor.puntaje,
	aaa_textoValor_aaa_texto.id AS id_texto_textoValor,
	aaa_textoValor_aaa_texto.descriptor AS descriptor_texto_textoValor ,
	aaa_textoValor_aaa_valor.id AS id_valor_textoValor,
	aaa_textoValor_aaa_valor.descriptor AS descriptor_valor_textoValor ,
	aaa_texto_aaa_item.id AS id_item_texto,
	aaa_texto_aaa_item.descriptor AS descriptor_item_texto ,
	aaa_valor_aaa_variable.id AS id_variable_valor,
	aaa_valor_aaa_variable.descriptor AS descriptor_variable_valor ,
	aaa_item_aaa_seguimiento.id AS id_seguimiento_item,
	aaa_item_aaa_seguimiento.descriptor AS descriptor_seguimiento_item ,
	aaa_variable_aaa_seguimientoEspejo.id AS id_seguimientoEspejo_variable,
	aaa_variable_aaa_seguimientoEspejo.descriptor AS descriptor_seguimientoEspejo_variable ,
	aaa_variable_aaa_tipoVariable.id AS id_tipoVariable_variable,
	aaa_variable_aaa_tipoVariable.descriptor AS descriptor_tipoVariable_variable ,
	aaa_seguimiento_aaa_proyecto.id AS id_proyecto_seguimiento,
	aaa_seguimiento_aaa_proyecto.descriptor AS descriptor_proyecto_seguimiento ,
	aaa_seguimiento_aaa_fuente.id AS id_fuente_seguimiento,
	aaa_seguimiento_aaa_fuente.descriptor AS descriptor_fuente_seguimiento ,
	aaa_fuente_aaa_tipoSeguimiento.id AS id_tipoSeguimiento_fuente,
	aaa_fuente_aaa_tipoSeguimiento.descriptor AS descriptor_tipoSeguimiento_fuente FROM aaa_textoValor AS aaa_textoValor_aaa_textoValor     
	INNER JOIN aaa_texto AS aaa_textoValor_aaa_texto ON aaa_textoValor_aaa_textoValor.idaaa_texto = aaa_textoValor_aaa_texto.id    
	INNER JOIN aaa_valor AS aaa_textoValor_aaa_valor ON aaa_textoValor_aaa_textoValor.idaaa_valor = aaa_textoValor_aaa_valor.id   
	INNER JOIN aaa_item AS aaa_texto_aaa_item ON aaa_textoValor_aaa_texto.idaaa_item = aaa_texto_aaa_item.id   
	INNER JOIN aaa_variable AS aaa_valor_aaa_variable ON aaa_textoValor_aaa_valor.idaaa_variable = aaa_valor_aaa_variable.id   
	INNER JOIN aaa_seguimiento AS aaa_item_aaa_seguimiento ON aaa_texto_aaa_item.idaaa_seguimiento = aaa_item_aaa_seguimiento.id   
	INNER JOIN aaa_seguimientoEspejo AS aaa_variable_aaa_seguimientoEspejo ON aaa_valor_aaa_variable.idaaa_seguimientoEspejo = aaa_variable_aaa_seguimientoEspejo.id   
	INNER JOIN aaa_tipoVariable AS aaa_variable_aaa_tipoVariable ON aaa_valor_aaa_variable.idaaa_tipoVariable = aaa_variable_aaa_tipoVariable.id   
	INNER JOIN aaa_proyecto AS aaa_seguimiento_aaa_proyecto ON aaa_item_aaa_seguimiento.idaaa_proyecto = aaa_seguimiento_aaa_proyecto.id   
	INNER JOIN aaa_fuente AS aaa_seguimiento_aaa_fuente ON aaa_item_aaa_seguimiento.idaaa_fuente = aaa_seguimiento_aaa_fuente.id   
	INNER JOIN aaa_tipoSeguimiento AS aaa_fuente_aaa_tipoSeguimiento ON aaa_seguimiento_aaa_fuente.idaaa_tipoSeguimiento = aaa_fuente_aaa_tipoSeguimiento.id   ;

CREATE VIEW v_aaa_tipoVariable AS SELECT
	aaa_tipoVariable_aaa_tipoVariable.id AS id,
	aaa_tipoVariable_aaa_tipoVariable.descriptor AS descriptor,
	aaa_tipoVariable_aaa_tipoVariable.fechaHora AS fechaHora FROM aaa_tipoVariable AS aaa_tipoVariable_aaa_tipoVariable    ;

CREATE VIEW v_aaa_dicTextoValor AS SELECT
	aaa_dicTextoValor_aaa_dicTextoValor.id AS id,
	aaa_dicTextoValor_aaa_dicTextoValor.descriptor AS descriptor,
	aaa_dicTextoValor_aaa_dicTextoValor.fechaHora AS fechaHora,
	aaa_dicTextoValor_aaa_dicTextoValor.lemaPar,
	aaa_dicTextoValor_aaa_dicTextoValor.LOP,
	aaa_dicTextoValor_aaa_textoValor.id AS id_textoValor_dicTextoValor,
	aaa_dicTextoValor_aaa_textoValor.descriptor AS descriptor_textoValor_dicTextoValor ,
	aaa_textoValor_aaa_texto.id AS id_texto_textoValor,
	aaa_textoValor_aaa_texto.descriptor AS descriptor_texto_textoValor ,
	aaa_textoValor_aaa_valor.id AS id_valor_textoValor,
	aaa_textoValor_aaa_valor.descriptor AS descriptor_valor_textoValor ,
	aaa_texto_aaa_item.id AS id_item_texto,
	aaa_texto_aaa_item.descriptor AS descriptor_item_texto ,
	aaa_valor_aaa_variable.id AS id_variable_valor,
	aaa_valor_aaa_variable.descriptor AS descriptor_variable_valor ,
	aaa_item_aaa_seguimiento.id AS id_seguimiento_item,
	aaa_item_aaa_seguimiento.descriptor AS descriptor_seguimiento_item ,
	aaa_variable_aaa_seguimientoEspejo.id AS id_seguimientoEspejo_variable,
	aaa_variable_aaa_seguimientoEspejo.descriptor AS descriptor_seguimientoEspejo_variable ,
	aaa_variable_aaa_tipoVariable.id AS id_tipoVariable_variable,
	aaa_variable_aaa_tipoVariable.descriptor AS descriptor_tipoVariable_variable ,
	aaa_seguimiento_aaa_proyecto.id AS id_proyecto_seguimiento,
	aaa_seguimiento_aaa_proyecto.descriptor AS descriptor_proyecto_seguimiento ,
	aaa_seguimiento_aaa_fuente.id AS id_fuente_seguimiento,
	aaa_seguimiento_aaa_fuente.descriptor AS descriptor_fuente_seguimiento ,
	aaa_fuente_aaa_tipoSeguimiento.id AS id_tipoSeguimiento_fuente,
	aaa_fuente_aaa_tipoSeguimiento.descriptor AS descriptor_tipoSeguimiento_fuente FROM aaa_dicTextoValor AS aaa_dicTextoValor_aaa_dicTextoValor     
	INNER JOIN aaa_textoValor AS aaa_dicTextoValor_aaa_textoValor ON aaa_dicTextoValor_aaa_dicTextoValor.idaaa_textoValor = aaa_dicTextoValor_aaa_textoValor.id   
	INNER JOIN aaa_texto AS aaa_textoValor_aaa_texto ON aaa_dicTextoValor_aaa_textoValor.idaaa_texto = aaa_textoValor_aaa_texto.id   
	INNER JOIN aaa_valor AS aaa_textoValor_aaa_valor ON aaa_dicTextoValor_aaa_textoValor.idaaa_valor = aaa_textoValor_aaa_valor.id   
	INNER JOIN aaa_item AS aaa_texto_aaa_item ON aaa_textoValor_aaa_texto.idaaa_item = aaa_texto_aaa_item.id   
	INNER JOIN aaa_variable AS aaa_valor_aaa_variable ON aaa_textoValor_aaa_valor.idaaa_variable = aaa_valor_aaa_variable.id   
	INNER JOIN aaa_seguimiento AS aaa_item_aaa_seguimiento ON aaa_texto_aaa_item.idaaa_seguimiento = aaa_item_aaa_seguimiento.id   
	INNER JOIN aaa_seguimientoEspejo AS aaa_variable_aaa_seguimientoEspejo ON aaa_valor_aaa_variable.idaaa_seguimientoEspejo = aaa_variable_aaa_seguimientoEspejo.id   
	INNER JOIN aaa_tipoVariable AS aaa_variable_aaa_tipoVariable ON aaa_valor_aaa_variable.idaaa_tipoVariable = aaa_variable_aaa_tipoVariable.id   
	INNER JOIN aaa_proyecto AS aaa_seguimiento_aaa_proyecto ON aaa_item_aaa_seguimiento.idaaa_proyecto = aaa_seguimiento_aaa_proyecto.id   
	INNER JOIN aaa_fuente AS aaa_seguimiento_aaa_fuente ON aaa_item_aaa_seguimiento.idaaa_fuente = aaa_seguimiento_aaa_fuente.id   
	INNER JOIN aaa_tipoSeguimiento AS aaa_fuente_aaa_tipoSeguimiento ON aaa_seguimiento_aaa_fuente.idaaa_tipoSeguimiento = aaa_fuente_aaa_tipoSeguimiento.id   ;

CREATE VIEW v_aaa_idioma AS SELECT
	aaa_idioma_aaa_idioma.id AS id,
	aaa_idioma_aaa_idioma.descriptor AS descriptor,
	aaa_idioma_aaa_idioma.fechaHora AS fechaHora FROM aaa_idioma AS aaa_idioma_aaa_idioma    ;

CREATE VIEW v_aaa_lemaPar AS SELECT
	aaa_lemaPar_aaa_lemaPar.id AS id,
	aaa_lemaPar_aaa_lemaPar.descriptor AS descriptor,
	aaa_lemaPar_aaa_lemaPar.fechaHora AS fechaHora,
	aaa_lemaPar_aaa_lemaPar.lemaPar,
	aaa_lemaPar_aaa_lemaPar.lema1,
	aaa_lemaPar_aaa_lemaPar.lema2,
	aaa_lemaPar_aaa_lemaPar.lop,
	aaa_lemaPar_aaa_lemaPar.relevancia,
	aaa_lemaPar_aaa_lemaPar.numSocios,
	aaa_lemaPar_aaa_texto.id AS id_texto_lemaPar,
	aaa_lemaPar_aaa_texto.descriptor AS descriptor_texto_lemaPar ,
	aaa_texto_aaa_item.id AS id_item_texto,
	aaa_texto_aaa_item.descriptor AS descriptor_item_texto ,
	aaa_item_aaa_seguimiento.id AS id_seguimiento_item,
	aaa_item_aaa_seguimiento.descriptor AS descriptor_seguimiento_item ,
	aaa_seguimiento_aaa_proyecto.id AS id_proyecto_seguimiento,
	aaa_seguimiento_aaa_proyecto.descriptor AS descriptor_proyecto_seguimiento ,
	aaa_seguimiento_aaa_fuente.id AS id_fuente_seguimiento,
	aaa_seguimiento_aaa_fuente.descriptor AS descriptor_fuente_seguimiento ,
	aaa_fuente_aaa_tipoSeguimiento.id AS id_tipoSeguimiento_fuente,
	aaa_fuente_aaa_tipoSeguimiento.descriptor AS descriptor_tipoSeguimiento_fuente FROM aaa_lemaPar AS aaa_lemaPar_aaa_lemaPar     
	INNER JOIN aaa_texto AS aaa_lemaPar_aaa_texto ON aaa_lemaPar_aaa_lemaPar.idaaa_texto = aaa_lemaPar_aaa_texto.id   
	INNER JOIN aaa_item AS aaa_texto_aaa_item ON aaa_lemaPar_aaa_texto.idaaa_item = aaa_texto_aaa_item.id   
	INNER JOIN aaa_seguimiento AS aaa_item_aaa_seguimiento ON aaa_texto_aaa_item.idaaa_seguimiento = aaa_item_aaa_seguimiento.id   
	INNER JOIN aaa_proyecto AS aaa_seguimiento_aaa_proyecto ON aaa_item_aaa_seguimiento.idaaa_proyecto = aaa_seguimiento_aaa_proyecto.id   
	INNER JOIN aaa_fuente AS aaa_seguimiento_aaa_fuente ON aaa_item_aaa_seguimiento.idaaa_fuente = aaa_seguimiento_aaa_fuente.id   
	INNER JOIN aaa_tipoSeguimiento AS aaa_fuente_aaa_tipoSeguimiento ON aaa_seguimiento_aaa_fuente.idaaa_tipoSeguimiento = aaa_fuente_aaa_tipoSeguimiento.id   ;

CREATE VIEW v_aaa_textoSentimiento AS SELECT
	aaa_textoSentimiento_aaa_textoSentimiento.id AS id,
	aaa_textoSentimiento_aaa_textoSentimiento.descriptor AS descriptor,
	aaa_textoSentimiento_aaa_textoSentimiento.fechaHora AS fechaHora,
	aaa_textoSentimiento_aaa_sentimiento.id AS id_sentimiento_textoSentimiento,
	aaa_textoSentimiento_aaa_sentimiento.descriptor AS descriptor_sentimiento_textoSentimiento ,
	aaa_textoSentimiento_aaa_texto.id AS id_texto_textoSentimiento,
	aaa_textoSentimiento_aaa_texto.descriptor AS descriptor_texto_textoSentimiento ,
	aaa_texto_aaa_item.id AS id_item_texto,
	aaa_texto_aaa_item.descriptor AS descriptor_item_texto ,
	aaa_item_aaa_seguimiento.id AS id_seguimiento_item,
	aaa_item_aaa_seguimiento.descriptor AS descriptor_seguimiento_item ,
	aaa_seguimiento_aaa_proyecto.id AS id_proyecto_seguimiento,
	aaa_seguimiento_aaa_proyecto.descriptor AS descriptor_proyecto_seguimiento ,
	aaa_seguimiento_aaa_fuente.id AS id_fuente_seguimiento,
	aaa_seguimiento_aaa_fuente.descriptor AS descriptor_fuente_seguimiento ,
	aaa_fuente_aaa_tipoSeguimiento.id AS id_tipoSeguimiento_fuente,
	aaa_fuente_aaa_tipoSeguimiento.descriptor AS descriptor_tipoSeguimiento_fuente FROM aaa_textoSentimiento AS aaa_textoSentimiento_aaa_textoSentimiento     
	INNER JOIN aaa_sentimiento AS aaa_textoSentimiento_aaa_sentimiento ON aaa_textoSentimiento_aaa_textoSentimiento.idaaa_sentimiento = aaa_textoSentimiento_aaa_sentimiento.id    
	INNER JOIN aaa_texto AS aaa_textoSentimiento_aaa_texto ON aaa_textoSentimiento_aaa_textoSentimiento.idaaa_texto = aaa_textoSentimiento_aaa_texto.id   
	INNER JOIN aaa_item AS aaa_texto_aaa_item ON aaa_textoSentimiento_aaa_texto.idaaa_item = aaa_texto_aaa_item.id   
	INNER JOIN aaa_seguimiento AS aaa_item_aaa_seguimiento ON aaa_texto_aaa_item.idaaa_seguimiento = aaa_item_aaa_seguimiento.id   
	INNER JOIN aaa_proyecto AS aaa_seguimiento_aaa_proyecto ON aaa_item_aaa_seguimiento.idaaa_proyecto = aaa_seguimiento_aaa_proyecto.id   
	INNER JOIN aaa_fuente AS aaa_seguimiento_aaa_fuente ON aaa_item_aaa_seguimiento.idaaa_fuente = aaa_seguimiento_aaa_fuente.id   
	INNER JOIN aaa_tipoSeguimiento AS aaa_fuente_aaa_tipoSeguimiento ON aaa_seguimiento_aaa_fuente.idaaa_tipoSeguimiento = aaa_fuente_aaa_tipoSeguimiento.id   ;

CREATE VIEW v_aaa_sentimiento AS SELECT
	aaa_sentimiento_aaa_sentimiento.id AS id,
	aaa_sentimiento_aaa_sentimiento.descriptor AS descriptor,
	aaa_sentimiento_aaa_sentimiento.fechaHora AS fechaHora FROM aaa_sentimiento AS aaa_sentimiento_aaa_sentimiento    ;

CREATE VIEW v_aaa_dicDescarte AS SELECT
	aaa_dicDescarte_aaa_dicDescarte.id AS id,
	aaa_dicDescarte_aaa_dicDescarte.descriptor AS descriptor,
	aaa_dicDescarte_aaa_dicDescarte.fechaHora AS fechaHora,
	aaa_dicDescarte_aaa_idioma.id AS id_idioma_dicDescarte,
	aaa_dicDescarte_aaa_idioma.descriptor AS descriptor_idioma_dicDescarte FROM aaa_dicDescarte AS aaa_dicDescarte_aaa_dicDescarte     
	INNER JOIN aaa_idioma AS aaa_dicDescarte_aaa_idioma ON aaa_dicDescarte_aaa_dicDescarte.idaaa_idioma = aaa_dicDescarte_aaa_idioma.id   ;

CREATE VIEW v_aaa_tipoSeguimiento AS SELECT
	aaa_tipoSeguimiento_aaa_tipoSeguimiento.id AS id,
	aaa_tipoSeguimiento_aaa_tipoSeguimiento.descriptor AS descriptor,
	aaa_tipoSeguimiento_aaa_tipoSeguimiento.fechaHora AS fechaHora FROM aaa_tipoSeguimiento AS aaa_tipoSeguimiento_aaa_tipoSeguimiento    ;

CREATE VIEW v_aaa_dicValor AS SELECT
	aaa_dicValor_aaa_dicValor.id AS id,
	aaa_dicValor_aaa_dicValor.descriptor AS descriptor,
	aaa_dicValor_aaa_dicValor.fechaHora AS fechaHora,
	aaa_dicValor_aaa_dicValor.LOP,
	aaa_dicValor_aaa_dicValor.lemaPar,
	aaa_dicValor_aaa_valor.id AS id_valor_dicValor,
	aaa_dicValor_aaa_valor.descriptor AS descriptor_valor_dicValor ,
	aaa_valor_aaa_variable.id AS id_variable_valor,
	aaa_valor_aaa_variable.descriptor AS descriptor_variable_valor ,
	aaa_variable_aaa_seguimientoEspejo.id AS id_seguimientoEspejo_variable,
	aaa_variable_aaa_seguimientoEspejo.descriptor AS descriptor_seguimientoEspejo_variable ,
	aaa_variable_aaa_tipoVariable.id AS id_tipoVariable_variable,
	aaa_variable_aaa_tipoVariable.descriptor AS descriptor_tipoVariable_variable FROM aaa_dicValor AS aaa_dicValor_aaa_dicValor     
	INNER JOIN aaa_valor AS aaa_dicValor_aaa_valor ON aaa_dicValor_aaa_dicValor.idaaa_valor = aaa_dicValor_aaa_valor.id   
	INNER JOIN aaa_variable AS aaa_valor_aaa_variable ON aaa_dicValor_aaa_valor.idaaa_variable = aaa_valor_aaa_variable.id   
	INNER JOIN aaa_seguimientoEspejo AS aaa_variable_aaa_seguimientoEspejo ON aaa_valor_aaa_variable.idaaa_seguimientoEspejo = aaa_variable_aaa_seguimientoEspejo.id   
	INNER JOIN aaa_tipoVariable AS aaa_variable_aaa_tipoVariable ON aaa_valor_aaa_variable.idaaa_tipoVariable = aaa_variable_aaa_tipoVariable.id   ;

CREATE VIEW v_aaa_dicRechazo AS SELECT
	aaa_dicRechazo_aaa_dicRechazo.id AS id,
	aaa_dicRechazo_aaa_dicRechazo.descriptor AS descriptor,
	aaa_dicRechazo_aaa_dicRechazo.fechaHora AS fechaHora,
	aaa_dicRechazo_aaa_dicRechazo.LOP,
	aaa_dicRechazo_aaa_dicRechazo.lemaPar,
	aaa_dicRechazo_aaa_valor.id AS id_valor_dicRechazo,
	aaa_dicRechazo_aaa_valor.descriptor AS descriptor_valor_dicRechazo,
	aaa_valor_aaa_variable.id AS id_variable_valor,
	aaa_valor_aaa_variable.descriptor AS descriptor_variable_valor ,
	aaa_variable_aaa_seguimientoEspejo.id AS id_seguimientoEspejo_variable,
	aaa_variable_aaa_seguimientoEspejo.descriptor AS descriptor_seguimientoEspejo_variable ,
	aaa_variable_aaa_tipoVariable.id AS id_tipoVariable_variable,
	aaa_variable_aaa_tipoVariable.descriptor AS descriptor_tipoVariable_variable FROM aaa_dicRechazo AS aaa_dicRechazo_aaa_dicRechazo     
	INNER JOIN aaa_valor AS aaa_dicRechazo_aaa_valor ON aaa_dicRechazo_aaa_dicRechazo.idaaa_valor = aaa_dicRechazo_aaa_valor.id   
	INNER JOIN aaa_variable AS aaa_valor_aaa_variable ON aaa_dicRechazo_aaa_valor.idaaa_variable = aaa_valor_aaa_variable.id   
	INNER JOIN aaa_seguimientoEspejo AS aaa_variable_aaa_seguimientoEspejo ON aaa_valor_aaa_variable.idaaa_seguimientoEspejo = aaa_variable_aaa_seguimientoEspejo.id   
	INNER JOIN aaa_tipoVariable AS aaa_variable_aaa_tipoVariable ON aaa_valor_aaa_variable.idaaa_tipoVariable = aaa_variable_aaa_tipoVariable.id   ;

CREATE VIEW v_aaa_fuente AS SELECT
	aaa_fuente_aaa_fuente.id AS id,    aaa_fuente_aaa_fuente.descriptor AS descriptor,    aaa_fuente_aaa_fuente.fechaHora AS fechaHora,    aaa_fuente_aaa_tipoSeguimiento.id AS id_tipoSeguimiento_fuente,   aaa_fuente_aaa_tipoSeguimiento.descriptor AS descriptor_tipoSeguimiento_fuente FROM aaa_fuente AS aaa_fuente_aaa_fuente     
	INNER JOIN aaa_tipoSeguimiento AS aaa_fuente_aaa_tipoSeguimiento ON aaa_fuente_aaa_fuente.idaaa_tipoSeguimiento = aaa_fuente_aaa_tipoSeguimiento.id   ;

INSERT INTO adm_perfil(descriptor, tipo_adm_unidad, tipo_adm_nivel) VALUES ('Administrador', 'Administrador', 'Administrador');
INSERT INTO adm_perfil(descriptor, tipo_adm_unidad, tipo_adm_nivel) VALUES ('Analista', 'Analista', 'Analista');

INSERT INTO adm_usuario(descriptor, clave, idadm_perfil) VALUES ('A', 'A', '2');
INSERT INTO adm_usuario(descriptor, clave, idadm_perfil) VALUES ('ICOLLAZOS', 'ICOLLAZOS', '3');

INSERT INTO aaa_sentimiento(descriptor) VALUES ('ALEGRIA'), ('TRISTEZA'), ('IRA'), ('MIEDO'), ('AVERSION');

INSERT INTO aaa_tipoVariable(descriptor) VALUES ('EMERGENTE');
INSERT INTO aaa_tipoVariable(descriptor) VALUES ('SENTIMIENTO');
INSERT INTO aaa_tipoVariable(descriptor) VALUES ('FABRICA');

INSERT INTO aaa_proyecto(descriptor) VALUES ('BANCA ARGENTINA');
INSERT INTO aaa_proyecto(descriptor) VALUES ('PRUEBA DESCARTE');

INSERT INTO aaa_tipoSeguimiento(descriptor) VALUES ('CRON-API'),('MANUAL'),('TWITTER'),('RSS');

INSERT INTO aaa_fuente(descriptor,idaaa_tipoSeguimiento) VALUES ('NEWSAPI',2);
INSERT INTO aaa_fuente(descriptor,idaaa_tipoSeguimiento) VALUES ('CALL CENTER',3);

INSERT INTO aaa_seguimiento(descriptor,idaaa_proyecto,idaaa_fuente) VALUES ('NOTICIAS ARGENTINA',2,2);
INSERT INTO aaa_seguimiento(descriptor,idaaa_proyecto,idaaa_fuente) VALUES ('NOTICIAS BANCARIAS',2,2);
INSERT INTO aaa_seguimientoEspejo(descriptor) VALUES ('NOTICIAS ARGENTINA');
INSERT INTO aaa_seguimientoEspejo(descriptor) VALUES ('NOTICIAS BANCARIAS');

INSERT INTO aaa_item(descriptor,idaaa_seguimiento) VALUES ('ARGENTINA',2);
INSERT INTO aaa_item(descriptor,idaaa_seguimiento) VALUES ('MILEI',2);
INSERT INTO aaa_item(descriptor,idaaa_seguimiento) VALUES ('MARADONA',2);
INSERT INTO aaa_item(descriptor,idaaa_seguimiento) VALUES ('ADORNI',2);
INSERT INTO aaa_item(descriptor,idaaa_seguimiento) VALUES ('PRESIDENTE DE ARGENTINA',2);
INSERT INTO aaa_item(descriptor,idaaa_seguimiento) VALUES ('NOTICIAS NACIONALES',2);
INSERT INTO aaa_item(descriptor,idaaa_seguimiento) VALUES ('BANCA',3);
INSERT INTO aaa_item(descriptor,idaaa_seguimiento) VALUES ('BANCOS',3);
INSERT INTO aaa_item(descriptor,idaaa_seguimiento) VALUES ('ENTIDADES FINANCIERAS',3);

INSERT INTO aaa_variable(descriptor,idaaa_seguimientoEspejo,idaaa_tipoVariable) VALUES ('TEMA',2,2);
INSERT INTO aaa_variable(descriptor,idaaa_seguimientoEspejo,idaaa_tipoVariable) VALUES ('PAIS',2,2);
INSERT INTO aaa_variable(descriptor,idaaa_seguimientoEspejo,idaaa_tipoVariable) VALUES ('PERSONA',2,2);
INSERT INTO aaa_variable(descriptor,idaaa_seguimientoEspejo,idaaa_tipoVariable) VALUES ('TEMA BANCARIO',3,2);
INSERT INTO aaa_variable(descriptor,idaaa_seguimientoEspejo,idaaa_tipoVariable) VALUES ('BANCO',3,2);
INSERT INTO aaa_variable(descriptor,idaaa_seguimientoEspejo,idaaa_tipoVariable) VALUES ('PERSONA',3,2);
INSERT INTO aaa_variable(descriptor,idaaa_seguimientoEspejo,idaaa_tipoVariable) VALUES ('FUENTE',2,4);
INSERT INTO aaa_variable(descriptor,idaaa_seguimientoEspejo,idaaa_tipoVariable) VALUES ('FUENTE',3,4);

INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('ECONOMIA',2);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('POLITICA',2);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('DEPORTES',2);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('FARANDULA',2);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('SUCESOS',2);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('CIENCIA Y TECNOLOGIA',2);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('ARGENTINA',3);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('ESPAÑA',3);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('ESTADOS UNIDOS',3);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('CHINA',3);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('VENEZUELA',3);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('MEXICO',3);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('COLOMBIA',3);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('FRANCIA',3);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('MILEI',4);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('CFK',4);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('BULLRICH',4);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('AHORRO',5);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('CREDITO',5);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('INVERSIONES',5);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('CENTRAL',6);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('BUENOS AIRES',6);
INSERT INTO aaa_valor(descriptor,idaaa_variable) VALUES ('NACIONAL DE CREDITO',6);

INSERT INTO `aaa_idioma` (`descriptor`) VALUES ('es'),('en'),('cat'),('pt'),('fr'),('it');

INSERT INTO `aaa_dicDescarte` (descriptor, idaaa_idioma) VALUES ('la', 2),('los', 2),('las', 2),('un', 2),('unas', 2),('uno', 2),('una', 2),('unos', 2),('a', 2),('e', 2),('o', 2),('y', 2),('u', 2),('ante', 2),('cabe', 2),('con', 2),('contra', 2),('de', 2),('desde', 2),('en', 2),('entre', 2),('hacia', 2),('hasta', 2),('segun', 2),('sin', 2),('so', 2),('sobre', 2),('tras', 2),('para', 2),('por', 2),('que', 2),('cuando', 2),('quienes', 2),('quien', 2),('cuyas', 2),('cuya', 2),('cuyos', 2),('cuyo', 2),('cuales', 2),('cual', 2),('lo', 2),('al', 2),('del', 2),('noxxx', 2),('casi', 2),('como', 2),('se', 2),('ha', 2),('he', 2),('hemos', 2),('ha', 2),('habeis', 2),('han', 2),('es', 2),('algo', 2),('alguien', 2),('alguno', 2),('algunos', 2),('alguna', 2),('algunas', 2),('su', 2),('sus', 2),('suya', 2),('suyas', 2),('suyo', 2),('suyos', 2),('mi', 2),('tu', 2),('mis', 2),('mio', 2),('mia', 2),('mios', 2),('mias', 2),('tus', 2),('tuyo', 2),('tuya', 2),('tuyos', 2),('tuyas', 2),('ella', 2),('nosotros', 2),('nos', 2),('ustedes', 2),('usted', 2),('ellos', 2),('ellas', 2),('ello', 2),('vos', 2),('me', 2),('te', 2),('se', 2),('os', 2),('le', 2),('les', 2),('este', 2),('esta', 2),('esto', 2),('estas', 2),('estos', 2),('otro', 2),('otra', 2),('otros', 2),('otras', 2),('menos', 2),('mas', 2),('pero', 2),('si', 2),('muy', 2),('poco', 2),('q', 2),('hay', 2),('habia', 2),('habian', 2),('habiamos', 2),('ya', 2),('has', 2),('habias', 2),('habra', 2),('ni', 2),('solo', 2),('tan', 2),('era', 2),('son', 2),('soy', 2),('eres', 2),('somos', 2),('todo', 2),('toda', 2),('eso', 2),('esa', 2),('ser', 2),('esos', 2),('esas', 2),('ese', 2),('eran', 2),('eras', 2),('eramos', 2),('porque', 2),('sera', 2),('junto', 2),('ahi', 2),('todos', 2),('entonces', 2),('alla', 2),('', 2),('aqui', 2),('fue', 2),('donde', 2),('tambien', 2),('estan', 2),('hace', 2),('muchos', 2),('entonces', 2),('noticias24', 2),('puede', 2),('dijo', 2),('más', 2),('siempre', 2),('él', 2),('cada', 2),('i', 2),('sólo', 2),('también', 2),('además', 2),('durante', 2),('según', 2),('t', 2),('http', 2),('co', 2),('https', 2),('es', 2),('Es', 2),('luego', 2),('puedes', 2),('tienes', 2),('dentro', 2),('no', 2),('no', 2),('el', 2);

INSERT INTO adm_views (descriptor,alias,rango) values 			('adm_usuario','Adm. Usuario','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('adm_views','Adm. View','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('adm_perfil','Adm. Perfil de Usuario','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('adm_viewPerfil','Adm. Perfil Asociado a View','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('adm_cadenas','Adm. Cadenas','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('adm_cadenas2','Adm. Cadenas2','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('adm_reporte','Adm. Reporte','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('adm_master','Adm. Master','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('adm_campos','Adm. Campos','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('adm_tablas','Adm. Tablas','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('adm_alias','Adm. Alias de Tablas','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('adm_hijos','Adm. Hijos','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('gra_consulta','Adm. Generador','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('ind_modulo','Ind. Modulos','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('ind_consulta','Ind. Consultas','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('adm_input','Adm. Input Inicial','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('adm_descendencia','Adm. Descendencia','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('adm_paginaPerfil','Adm. Páginas Asociadas a Perfil','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('ind_reportes','Ind. Reportes Ejecutivos','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('aaa_proyecto','Pri. Proyecto','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('aaa_seguimiento','Pri. Seguimiento','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('aaa_item','Pri. Item','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('aaa_texto','Pri. Texto','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('aaa_variable','Pri. Variable','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('aaa_seguimientoEspejo','Pri. SegVariable','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('aaa_valor','Pri. Valor','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('aaa_textoValor','Pri. TextoValor','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('aaa_tipoVariable','Ref. Tipo de Variable','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('aaa_dicTextoValor','Pri. DicTextoValor','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('aaa_idioma','Ref. Idioma','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('aaa_lemaPar','Pri. LemaPar','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('aaa_textoSentimiento','Pri. TextoSentimiento','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('aaa_sentimiento','Ref. Sentimiento','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('aaa_dicDescarte','Ref. DicDescarte','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('aaa_tipoSeguimiento','Ref. Tipo de Seguimiento','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('aaa_dicValor','Pri. DicValor','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('aaa_dicRechazo','Pri. DicRechazo','1');
INSERT INTO adm_views (descriptor,alias,rango) values 			('aaa_fuente','Ref. Fuente','1');
INSERT INTO adm_views (descriptor,alias,rango) values ('aaa_facturaTotalizacion','Pri. Factura Calculado','1');

INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','1');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','2');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','3');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','4');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','5');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','6');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','7');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','8');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','9');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','10');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','11');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','12');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','13');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','14');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','15');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','16');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','17');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','18');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','19');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','20');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','21');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','22');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','23');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','24');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','25');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','26');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','27');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','28');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','29');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','30');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','31');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','32');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','33');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','34');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','35');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','36');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','37');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','38');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('2','39');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','1');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','2');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','3');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','4');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','5');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','6');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','7');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','8');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','9');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','10');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','11');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','12');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','13');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','14');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','15');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','16');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','17');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','18');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','19');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','20');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','21');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','22');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','23');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','24');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','25');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','26');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','27');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','28');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','29');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','30');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','31');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','32');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','33');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','34');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','35');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','36');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','37');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','38');
INSERT INTO adm_viewPerfil ( idadm_perfil, idadm_views ) VALUES ('3','39');

INSERT INTO adm_cadenas(descriptor) VALUES  	('idper_persona,idgeo_municipio,idgeo_estado'),	('idgeo_municipio,idgeo_estado'),	('idinv_indicePersona,idinv_indice,idinv_investigacion'),	('idfor_temaActividad,idfor_actividad,idfor_formacion,idper_persona'),	('idfor_actividad,idfor_formacion,idper_persona'),	('idfor_formacion,idper_persona'),	('idper_persona')	;

INSERT INTO adm_cadenas2 ( descriptor ) VALUES  		( 'idgeo_estado,idgeo_municipio' ),	( 'idleg_expediente,idleg_actuacion' ),	( 'idinvestigacion,idinvIndicePersona' ),	( 'idinvIndicePersona' ),	('idfor_temaActividad,idfor_actividad,idfor_formacion,idper_persona'),	('idfor_actividad,idfor_formacion,idper_persona'),	('idfor_formacion,idper_persona'),	('idper_persona')	;

INSERT INTO adm_alias (descriptor,alias) VALUES  	('adm_alias','Alias de Tablas'),	('adm_alias','Alias'),	('adm_cadenas','Cadenas'),	('adm_cadenas2','Cadenas2'),	('adm_campos','Campos'),	('adm_ctrlViews','Control de Vistas'),	('adm_hijos','Hijos'),	('adm_master','Master'),	('adm_perfil','Perfil de Usuario'),	('adm_reporte','Reporte'),	('adm_tablas','Tablas'),	('adm_usuario','Usuario'),	('adm_viewPerfil','Perfil Asociado a View'),	('adm_views','View'),	('ind_modulo','Modulos'),	('ind_consulta','Consultas'),	('apellido','Apellido'),	('borrar','Borrado'),	('campo','Campo'),	('clave','Clave'),	('descriptor','Descriptor'),	('hijo','Hijo'),	('fecha','Fecha'),	('fechaHora','Registro'),	('fecha_YYYY','Año'),	('fecha_MM','Mes'),	('fecha_DD','Día'),	('fecha_SEMANA','Semana')	;
INSERT INTO adm_alias (descriptor,alias) VALUES  	('idcid_editorial','Editorial')	;
INSERT INTO adm_alias (descriptor,alias) VALUES  	('adm_alias','Alias de Tablas')	;

INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('2','usr_adm/index.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('3','usr_adm/index.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('2','usr_adm/controlDeVistas.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('3','usr_adm/controlDeVistas.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('2','usr_adm/controlDePaginas.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('3','usr_adm/controlDePaginas.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('2','usr_adm/consultas.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('3','usr_adm/consultas.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('2','usr_adm/filtrado_consulta.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('3','usr_adm/filtrado_consulta.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('2','usr_adm/pry_textoIndividual.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('3','usr_adm/pry_textoIndividual.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('2','usr_adm/pry_textoValor_tabla.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('3','usr_adm/pry_textoValor_tabla.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('2','usr_adm/pry_textoValor_crear.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('3','usr_adm/pry_textoValor_crear.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('2','usr_adm/pry_frasesClave.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('3','usr_adm/pry_frasesClave.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('2','usr_adm/gra_nube.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('3','usr_adm/gra_nube.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('2','usr_adm/gra_nubeCategorias.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('3','usr_adm/gra_nubeCategorias.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('2','usr_adm/gra_unaVariable.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('3','usr_adm/gra_unaVariable.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('2','usr_adm/gra_grafo.php');
INSERT INTO adm_paginaPerfil (idadm_perfil, pagina) VALUES ('3','usr_adm/gra_grafo.php');

INSERT INTO adm_input (descriptor) VALUES ('1 %adm');
INSERT INTO adm_input (descriptor) VALUES ('2 -tipo_adm_unidad/Unidad');
INSERT INTO adm_input (descriptor) VALUES ('3 adm_usuario/Adm. Usuario');
INSERT INTO adm_input (descriptor) VALUES ('4 adm_views/Adm. View');
INSERT INTO adm_input (descriptor) VALUES ('5 -alias|Alias');
INSERT INTO adm_input (descriptor) VALUES ('6 -rango|i/Rango');
INSERT INTO adm_input (descriptor) VALUES ('7 -tipo_adm_nivel/Nivel');
INSERT INTO adm_input (descriptor) VALUES ('8 adm_perfil/Adm. Perfil de Usuario');
INSERT INTO adm_input (descriptor) VALUES ('9 adm_viewPerfil/Adm. Perfil Asociado a View');
INSERT INTO adm_input (descriptor) VALUES ('10 adm_cadenas/Adm. Cadenas');
INSERT INTO adm_input (descriptor) VALUES ('11 adm_cadenas2/Adm. Cadenas2');
INSERT INTO adm_input (descriptor) VALUES ('12 adm_reporte/Adm. Reporte');
INSERT INTO adm_input (descriptor) VALUES ('13 adm_master/Adm. Master');
INSERT INTO adm_input (descriptor) VALUES ('14 -valores/Valores');
INSERT INTO adm_input (descriptor) VALUES ('15 -tipo_adm_unidad/Unidad');
INSERT INTO adm_input (descriptor) VALUES ('16 adm_campos/Adm. Campos');
INSERT INTO adm_input (descriptor) VALUES ('17 adm_tablas/Adm. Tablas');
INSERT INTO adm_input (descriptor) VALUES ('18 adm_alias/Adm. Alias de Tablas');
INSERT INTO adm_input (descriptor) VALUES ('19 adm_hijos/Adm. Hijos');
INSERT INTO adm_input (descriptor) VALUES ('20 -alias/Alias');
INSERT INTO adm_input (descriptor) VALUES ('21 -padre/Padre');
INSERT INTO adm_input (descriptor) VALUES ('22 -hijo/Hijo');
INSERT INTO adm_input (descriptor) VALUES ('23 alias');
INSERT INTO adm_input (descriptor) VALUES ('24 adm_ctrlViews');
INSERT INTO adm_input (descriptor) VALUES ('25 -tabla/Tabla');
INSERT INTO adm_input (descriptor) VALUES ('26 -campo/Campo');
INSERT INTO adm_input (descriptor) VALUES ('27 -clave/Clave');
INSERT INTO adm_input (descriptor) VALUES ('28 gra_consulta/Adm. Generador');
INSERT INTO adm_input (descriptor) VALUES ('29 -consulta/Consulta');
INSERT INTO adm_input (descriptor) VALUES ('30 ind_modulo/Ind. Modulos');
INSERT INTO adm_input (descriptor) VALUES ('31 ind_consulta/Ind. Consultas');
INSERT INTO adm_input (descriptor) VALUES ('32 -consulta/Consulta');
INSERT INTO adm_input (descriptor) VALUES ('33 adm_input/Adm. Input Inicial');
INSERT INTO adm_input (descriptor) VALUES ('34 adm_descendencia/Adm. Descendencia');
INSERT INTO adm_input (descriptor) VALUES ('35 adm_paginaPerfil/Adm. Páginas Asociadas a Perfil');
INSERT INTO adm_input (descriptor) VALUES ('36 -pagina|Página');
INSERT INTO adm_input (descriptor) VALUES ('37 ind_reportes/Ind. Reportes Ejecutivos');
INSERT INTO adm_input (descriptor) VALUES ('38 -resumen/Resumen Ejecutivo');
INSERT INTO adm_input (descriptor) VALUES ('39 -fecha|f/Fecha del Reporte');
INSERT INTO adm_input (descriptor) VALUES ('40 #tcpro');
INSERT INTO adm_input (descriptor) VALUES ('41 aaa_proyecto/Pri. Proyecto');
INSERT INTO adm_input (descriptor) VALUES ('42 aaa_seguimiento/Pri. Seguimiento');
INSERT INTO adm_input (descriptor) VALUES ('43 aaa_item/Pri. Item');
INSERT INTO adm_input (descriptor) VALUES ('44 aaa_texto/Pri. Texto');
INSERT INTO adm_input (descriptor) VALUES ('45 aaa_variable/Pri. Variable');
INSERT INTO adm_input (descriptor) VALUES ('46 aaa_seguimientoEspejo/Pri. SegVariable');
INSERT INTO adm_input (descriptor) VALUES ('47 aaa_valor/Pri. Valor');
INSERT INTO adm_input (descriptor) VALUES ('48 aaa_textoValor/Pri. TextoValor');
INSERT INTO adm_input (descriptor) VALUES ('49 aaa_tipoVariable/Ref. Tipo de Variable');
INSERT INTO adm_input (descriptor) VALUES ('50 aaa_dicTextoValor/Pri. DicTextoValor');
INSERT INTO adm_input (descriptor) VALUES ('51 aaa_idioma/Ref. Idioma');
INSERT INTO adm_input (descriptor) VALUES ('52 aaa_lemaPar/Pri. LemaPar');
INSERT INTO adm_input (descriptor) VALUES ('53 aaa_textoSentimiento/Pri. TextoSentimiento');
INSERT INTO adm_input (descriptor) VALUES ('54 aaa_sentimiento/Ref. Sentimiento');
INSERT INTO adm_input (descriptor) VALUES ('55 aaa_dicDescarte/Ref. DicDescarte');
INSERT INTO adm_input (descriptor) VALUES ('56 -url/URL');
INSERT INTO adm_input (descriptor) VALUES ('57 -textoLimpio/Texto Limpio');
INSERT INTO adm_input (descriptor) VALUES ('58 -analizado|i/Analizado');
INSERT INTO adm_input (descriptor) VALUES ('59 -longitud|i/Longitud');
INSERT INTO adm_input (descriptor) VALUES ('60 -textoTarzan/Texto Tarzan');
INSERT INTO adm_input (descriptor) VALUES ('61 -lemaPar/LemaPar');
INSERT INTO adm_input (descriptor) VALUES ('62 -lema1/Lema 1');
INSERT INTO adm_input (descriptor) VALUES ('63 -lema2/Lema 2');
INSERT INTO adm_input (descriptor) VALUES ('64 -lop/Lema o Par');
INSERT INTO adm_input (descriptor) VALUES ('65 -relevancia|i/Relevancia');
INSERT INTO adm_input (descriptor) VALUES ('66 -numSocios|i/Número de Socios');
INSERT INTO adm_input (descriptor) VALUES ('67 -roh/Robot o Humano');
INSERT INTO adm_input (descriptor) VALUES ('68 -puntaje|e/Puntaje');
INSERT INTO adm_input (descriptor) VALUES ('69 -lemaPar/LemaPar');
INSERT INTO adm_input (descriptor) VALUES ('70 -LOP/Lema o Par');
INSERT INTO adm_input (descriptor) VALUES ('71 aaa_tipoSeguimiento/Ref. Tipo de Seguimiento');
INSERT INTO adm_input (descriptor) VALUES ('72 -fecha|f/Fecha');
INSERT INTO adm_input (descriptor) VALUES ('73 -controlador/Controlador');
INSERT INTO adm_input (descriptor) VALUES ('74 aaa_dicValor/Pri. DicValor');
INSERT INTO adm_input (descriptor) VALUES ('75 -LOP/Lema o Par');
INSERT INTO adm_input (descriptor) VALUES ('76 -lemaPar/LemaPar');
INSERT INTO adm_input (descriptor) VALUES ('77 aaa_dicRechazo/Pri. DicRechazo');
INSERT INTO adm_input (descriptor) VALUES ('78 -LOP/Lema o Par');
INSERT INTO adm_input (descriptor) VALUES ('79 -lemaPar/LemaPar');
INSERT INTO adm_input (descriptor) VALUES ('80 aaa_fuente/Ref. Fuente');
INSERT INTO adm_input (descriptor) VALUES ('81 -fuente/Fuente del Texto');
INSERT INTO adm_input (descriptor) VALUES ('#');
INSERT INTO adm_input (descriptor) VALUES ('24 23');
INSERT INTO adm_input (descriptor) VALUES ('4 5 C');
INSERT INTO adm_input (descriptor) VALUES ('4 6 C');
INSERT INTO adm_input (descriptor) VALUES ('8 9 C');
INSERT INTO adm_input (descriptor) VALUES ('4 9 C');
INSERT INTO adm_input (descriptor) VALUES ('8 3 C');
INSERT INTO adm_input (descriptor) VALUES ('13 14 C');
INSERT INTO adm_input (descriptor) VALUES ('8 2 C');
INSERT INTO adm_input (descriptor) VALUES ('8 7 C');
INSERT INTO adm_input (descriptor) VALUES ('12 15 C');
INSERT INTO adm_input (descriptor) VALUES ('16 13 C');
INSERT INTO adm_input (descriptor) VALUES ('17 16 C');
INSERT INTO adm_input (descriptor) VALUES ('18 20 C');
INSERT INTO adm_input (descriptor) VALUES ('19 22 C');
INSERT INTO adm_input (descriptor) VALUES ('19 21 C');
INSERT INTO adm_input (descriptor) VALUES ('13 25');
INSERT INTO adm_input (descriptor) VALUES ('13 26');
INSERT INTO adm_input (descriptor) VALUES ('3 27');
INSERT INTO adm_input (descriptor) VALUES ('28 29');
INSERT INTO adm_input (descriptor) VALUES ('31 32');
INSERT INTO adm_input (descriptor) VALUES ('30 31 C');
INSERT INTO adm_input (descriptor) VALUES ('8 35 C');
INSERT INTO adm_input (descriptor) VALUES ('35 36 C');
INSERT INTO adm_input (descriptor) VALUES ('37 38');
INSERT INTO adm_input (descriptor) VALUES ('37 39');
INSERT INTO adm_input (descriptor) VALUES ('41 42 C');
INSERT INTO adm_input (descriptor) VALUES ('42 43 C');
INSERT INTO adm_input (descriptor) VALUES ('43 44 C');
INSERT INTO adm_input (descriptor) VALUES ('46 45 C');
INSERT INTO adm_input (descriptor) VALUES ('45 47 C');
INSERT INTO adm_input (descriptor) VALUES ('44 48');
INSERT INTO adm_input (descriptor) VALUES ('47 48 C');
INSERT INTO adm_input (descriptor) VALUES ('49 45 C');
INSERT INTO adm_input (descriptor) VALUES ('44 52 C');
INSERT INTO adm_input (descriptor) VALUES ('54 53 C');
INSERT INTO adm_input (descriptor) VALUES ('44 53 C');
INSERT INTO adm_input (descriptor) VALUES ('51 55 C');
INSERT INTO adm_input (descriptor) VALUES ('44 57');
INSERT INTO adm_input (descriptor) VALUES ('44 56');
INSERT INTO adm_input (descriptor) VALUES ('44 58');
INSERT INTO adm_input (descriptor) VALUES ('44 59');
INSERT INTO adm_input (descriptor) VALUES ('44 60');
INSERT INTO adm_input (descriptor) VALUES ('52 61');
INSERT INTO adm_input (descriptor) VALUES ('52 62');
INSERT INTO adm_input (descriptor) VALUES ('52 63');
INSERT INTO adm_input (descriptor) VALUES ('52 64');
INSERT INTO adm_input (descriptor) VALUES ('52 65');
INSERT INTO adm_input (descriptor) VALUES ('52 66');
INSERT INTO adm_input (descriptor) VALUES ('48 67');
INSERT INTO adm_input (descriptor) VALUES ('48 68');
INSERT INTO adm_input (descriptor) VALUES ('50 69');
INSERT INTO adm_input (descriptor) VALUES ('50 70');
INSERT INTO adm_input (descriptor) VALUES ('48 50 C');
INSERT INTO adm_input (descriptor) VALUES ('71 80 C');
INSERT INTO adm_input (descriptor) VALUES ('44 72');
INSERT INTO adm_input (descriptor) VALUES ('44 73');
INSERT INTO adm_input (descriptor) VALUES ('47 74 C');
INSERT INTO adm_input (descriptor) VALUES ('74 75');
INSERT INTO adm_input (descriptor) VALUES ('74 76');
INSERT INTO adm_input (descriptor) VALUES ('77 79');
INSERT INTO adm_input (descriptor) VALUES ('77 78');
INSERT INTO adm_input (descriptor) VALUES ('47 77 C');
INSERT INTO adm_input (descriptor) VALUES ('80 42 C');
INSERT INTO adm_input (descriptor) VALUES ('44 81');

INSERT INTO ind_modulo (descriptor) VALUES 	('Facturas'),	('Gastos'),	('Beneficiarios')	;

INSERT INTO ind_consulta (descriptor,consulta,idind_modulo) VALUES (	'Total anual de gastos', 	'SELECT 	YEAR(fecha) as AAAA, 	sum(baseImponible) as `Base Imponible`, 	sum(iva) as `IVA`, 	sum(otrosImpuestos) as `Otros Impuestos`, 	sum(responsabilidadSocial) as `Responsabilidaad Social`, 	sum(sumar) as `SUMAR`, sum(islr) as `ISLR`, 	sum(montoTercerizacion) as `Monto Tercerización`, 	sum(otrosAsociados) as `Otros Asociados`, 	sum(baseImponible+iva+otrosImpuestos+responsabilidadSocial+sumar+islr+montoTercerizacion+otrosAsociados) as `Total en USD`, 	sum(baseImponible+iva+otrosImpuestos+responsabilidadSocial+sumar+islr+montoTercerizacion+otrosAsociados)*tasaF as `Total en BS` 	FROM aaa_factura 	GROUP BY YEAR(fecha) 	ORDER BY YEAR(fecha) ASC;
	',	'2');

CREATE DEFINER=`191240`@`%` TRIGGER `insert_descriptor_trigger` AFTER INSERT ON `aaa_seguimiento` FOR EACH ROW INSERT INTO aaa_seguimientoEspejo (descriptor) VALUES (NEW.descriptor);

CREATE DEFINER=`191240`@`%` TRIGGER `delete_descriptor_trigger` AFTER DELETE ON `aaa_seguimiento` FOR EACH ROW DELETE FROM aaa_seguimientoEspejo WHERE id = OLD.id;

