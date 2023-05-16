
INSERT INTO usuarios (nombre,apellidos,mail,telefono,nombreusuario,pass,rol) 
VALUES('Jose Luis','Nunez', 'joseluisnunez@iesamachado.org', '123456789','joseluisnunez','726a2afac2eaa573bc8dfdd2a854cb2d','3f987ad2fb3e34f616ae6d63b7bbb4fa');

INSERT INTO usuarios (nombre,apellidos,mail,telefono,nombreusuario,pass,rol)
VALUES('Paco','Maestre', 'pacomaestre@iesamachado.org', '123456789','Packomaster','58aa37d87cd2cccf402ede8803ca3a28','3f987ad2fb3e34f616ae6d63b7bbb4fa');

INSERT INTO usuarios (nombre,apellidos,mail,telefono,nombreusuario,pass,rol)  
VALUES('Jose Carlos','Garcia', 'josecarlosgarcia@iesamachado.org', '123456789','josecarlosgarcia','937f488d42aa099b486ed3223fec5c73','251534536e2a723665d034ecb6297d75');

INSERT INTO usuarios (nombre,apellidos,mail,telefono,nombreusuario,pass,rol) 
VALUES('Rocio','Alvarez Garrido', 'rocioalvarezgarrido@iesamachado.org', '123456789','rocioalvarez','08668c1844a80821ba7b381354c28e06','658467db779dc02fdc7bc8dd1e40775a');

INSERT INTO usuarios (nombre,apellidos,mail,telefono,nombreusuario,pass,rol)  
VALUES('Antonio','Empresa', 'antonioempresa@iesamachado.org', '123456789','antonioempresa','99d0e7182c5ad81b9c7f5b19f0f71fac','1c56d96ade04183154c0a998c707856c');

INSERT INTO usuarios (nombre,apellidos,mail,telefono,nombreusuario,pass,rol)
VALUES('Paquito','Chocolatero', 'paquitochocolatero@iesamachado.org', '123456789','paquitochocolatero','51ff8250c0b0ec1819d856e1da69bc72','45e6dcc26fdae94364c1ba987453ca1f');

INSERT INTO plantas (nombreplanta) 
VALUES('baja');

INSERT INTO plantas (nombreplanta) 
VALUES('primera');

INSERT INTO plantas (nombreplanta) 
VALUES('segunda');

INSERT INTO aulas (aula,idplanta) 
VALUES('sala profesores','1');

INSERT INTO aulas (aula,idplanta) 
VALUES('biblioteca','1');

INSERT INTO aulas (aula,idplanta)  
VALUES('secretaria','1');

INSERT INTO aulas (aula,idplanta) 
VALUES('conserjeria','1');

INSERT INTO aulas (aula,idplanta)  
VALUES('1 cliclo superior','1');

INSERT INTO aulas (aula,idplanta)  
VALUES('1 bachillerato','2');

INSERT INTO aulas (aula,idplanta)  
VALUES('2 bachillerato','2');

INSERT INTO aulas (aula,idplanta)  
VALUES('2 ciclo superior','3');

INSERT INTO incidencias (descripcion,comentario,idaula,idusuario,fecha_alta) 
VALUES('falla pc secretaria',' ','3','1',now());

INSERT INTO incidencias (descripcion,comentario,idaula,idusuario,fecha_alta) 
VALUES('falla teclado conserjeria','','4','1',now());

INSERT INTO incidencias (descripcion,comentario,idaula,idusuario,fecha_alta) 
VALUES('falla proyector','','8','4',now());