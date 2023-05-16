
INSERT INTO usuarios (nombre,apellidos,email,telefono,username,password,rol) 
VALUES('Jose Luis','Nunez', 'joseluisnunez@iesamachado.org', '123456789','joseluisnunez','12345','administrador');

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

INSERT INTO plantas (nombreplanta) 
VALUES('baja');

INSERT INTO plantas (nombreplanta) 
VALUES('primera');

INSERT INTO plantas (nombreplanta) 
VALUES('segunda');

INSERT INTO aulas (nombreaula,id_planta) 
VALUES('sala profesores','1');

INSERT INTO aulas (nombreaula,id_planta) 
VALUES('biblioteca','1');

INSERT INTO aulas (nombreaula,id_planta) 
VALUES('secretaria','1');

INSERT INTO aulas (nombreaula,id_planta) 
VALUES('conserjeria','1');

INSERT INTO aulas (nombreaula,id_planta) 
VALUES('1 cliclo superior','1');

INSERT INTO aulas (nombreaula,id_planta) 
VALUES('1 bachillerato','2');

INSERT INTO aulas (nombreaula,id_planta) 
VALUES('2 bachillerato','2');

INSERT INTO aulas (nombreaula,id_planta) 
VALUES('2 ciclo superior','3');

INSERT INTO incidencias (descripcion,id_aula,id_planta,id_usuario) 
VALUES('falla pc secretaria','3','1', '1');
INSERT INTO incidencias (descripcion,id_aula,id_planta,id_usuario) 
VALUES('falla teclado conserjeria','4','1', '1');

INSERT INTO incidencias (descripcion,id_aula,id_planta,id_usuario) 
VALUES('falla proyector','8','3', '4');