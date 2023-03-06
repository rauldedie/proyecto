CREATE TABLE usuarios (
id_usuario INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(30) NOT NULL,
nombre VARCHAR(30) NOT NULL,
apellidos VARCHAR(30) NOT NULL,
email VARCHAR(50),
telefono varchar(9),
password varchar(20),
rol varchar(20),
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE planta (
    id_planta int (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombreplanta varchar(25)
);

CREATE TABLE aula (
    id_aula int (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombreaula char(30),
    id_planta int(6) CONSTRAINT fk_aulaplanta FOREIGN KEY REFERENCES planta
);

CREATE TABLE incidencias (
    id_incidencia int (6) unsigned auto_increment primary key,
    descripcion text not null,
    id_aula int (6) CONSTRAINT fk_aulaincidencia FOREIGN KEY REFERENCES aula,
    id_planta int (6) CONSTRAINT fk_plantaincidencia FOREIGN key REFERENCES planta,
    id_usuario int (6) CONSTRAINT fk_usuarioincidencia FOREIGN KEY REFERENCES usuarios,
    fecha_alta TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    fecha_mod date,
    fecha_resol date
);

INSERT INTO usuarios (username,nombre,apellidos,email,telefono,password,rol) 
VALUES('joseluisnunez','Jose Luis','Nunez', 'joseluisnunez@iesamachado.org', '123456789','12345','administrador');

INSERT INTO usuarios (username,nombre,apellidos,email,telefono,password,rol) 
VALUES('Packomaster','Paco','Maestre', 'pacomaestre@iesamachado.org', '123456789','12345','administrador');

INSERT INTO usuarios (username,nombre,apellidos,email,telefono,password,rol) 
VALUES('josecarlosgarcia','Jose Carlos','Garcia', 'josecarlosgarcia@iesamachado.org', '123456789','12345','administrador');

INSERT INTO usuarios (username,nombre,apellidos,email,telefono,password,rol) 
VALUES('rociobbdd','Rocio','bbdd', 'rociobbdd@iesamachado.org', '123456789','12345','profesorado');

INSERT INTO usuarios (username,nombre,apellidos,email,telefono,password,rol) 
VALUES('antonioempresa','Antonio','Empresa', 'antonioempresa@iesamachado.org', '123456789','12345','profesorado');

INSERT INTO usuarios (username,nombre,apellidos,email,telefono,password,rol) 
VALUES('paquitochocolatero','Paquito','Chocolatero', 'paquitochocolatero@iesamachado.org', '123456789','12345','direccion');

INSERT INTO planta (nombreplanta) 
VALUES('baja');

INSERT INTO planta (nombreplanta) 
VALUES('primera');

INSERT INTO planta (nombreplanta) 
VALUES('segunda');

INSERT INTO aula (nombreaula,id_planta) 
VALUES('sala profesores','1');

INSERT INTO aula (nombreaula,id_planta) 
VALUES('biblioteca','1');

INSERT INTO aula (nombreaula,id_planta) 
VALUES('secretaria','1');

INSERT INTO aula (nombreaula,id_planta) 
VALUES('conserjeria','1');

INSERT INTO aula (nombreaula,id_planta) 
VALUES('1 cliclo superior','1');

INSERT INTO aula (nombreaula,id_planta) 
VALUES('1 bachillerato','2');

INSERT INTO aula (nombreaula,id_planta) 
VALUES('2 bachillerato','2');

INSERT INTO aula (nombreaula,id_planta) 
VALUES('2 ciclo superior','3');

INSERT INTO incidencias (descripcion,id_aula,id_planta,id_usuario) 
VALUES('falla pc secretaria','3','1', '1');
INSERT INTO incidencias (descripcion,id_aula,id_planta,id_usuario) 
VALUES('falla teclado conserjeria','4','1', '1');

INSERT INTO incidencias (descripcion,id_aula,id_planta,id_usuario) 
VALUES('falla proyector','8','3', '4');