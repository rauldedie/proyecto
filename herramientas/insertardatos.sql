
INSERT INTO usuarios2 (nombre,apellidos,mail,telefono,nombreusuario,pass,rol) 
VALUES('Jose Luis','Nunez', 'joseluisnunez@iesamachado.org', '123456789','joseluisnunez','lince73','administrador');

INSERT INTO usuarios2 (nombre,apellidos,mail,telefono,nombreusuario,pass,rol)
VALUES('Paco','Maestre', 'pacomaestre@iesamachado.org', '123456789','Packomaster','lince73','administrador');

INSERT INTO usuarios2 (nombre,apellidos,mail,telefono,nombreusuario,pass,rol)  
VALUES('Jose Carlos','Garcia', 'josecarlosgarcia@iesamachado.org', '123456789','josecarlosgarcia','lince73','administrador');

INSERT INTO usuarios2 (nombre,apellidos,mail,telefono,nombreusuario,pass,rol) 
VALUES('Rocio','Alvarez Garrido', 'rocioalvarezgarrido@iesamachado.org', '123456789','rocioalvarez','lince73','direccion');

INSERT INTO usuarios2 (nombre,apellidos,mail,telefono,nombreusuario,pass,rol)  
VALUES('Antonio','Empresa', 'antonioempresa@iesamachado.org', '123456789','antonioempresa','lince73','profesorado');

INSERT INTO usuarios2 (nombre,apellidos,mail,telefono,nombreusuario,pass,rol)
VALUES('Paquito','Chocolatero', 'paquitochocolatero@iesamachado.org', '123456789','paquitochocolatero','lince73','profesorado');

INSERT INTO plantas2 (planta) 
VALUES('baja');

INSERT INTO plantas2 (planta) 
VALUES('primera');

INSERT INTO plantas2 (planta) 
VALUES('segunda');

INSERT INTO aulas2 (aula,idplanta) 
VALUES('sala profesores','1');

INSERT INTO aulas2 (aula,idplanta) 
VALUES('biblioteca','1');

INSERT INTO aulas2 (aula,idplanta)  
VALUES('secretaria','1');

INSERT INTO aulas2 (aula,idplanta) 
VALUES('conserjeria','1');

INSERT INTO aulas2 (aula,idplanta)  
VALUES('1 cliclo superior','1');

INSERT INTO aulas2 (aula,idplanta)  
VALUES('1 bachillerato','2');

INSERT INTO aulas2 (aula,idplanta)  
VALUES('2 bachillerato','2');

INSERT INTO aulas2 (aula,idplanta)  
VALUES('2 ciclo superior','3');

INSERT INTO incidencias2 (descripcion,comentario,idaula,idusuario,fecha_alta) 
VALUES('falla pc secretaria',' ','3','1',now());

INSERT INTO incidencias2 (descripcion,comentario,idaula,idusuario,fecha_alta) 
VALUES('falla teclado conserjeria','','4','1',now());

INSERT INTO incidencias2 (descripcion,comentario,idaula,idusuario,fecha_alta) 
VALUES('falla proyector','','8','4',now());