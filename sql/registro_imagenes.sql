
drop table if exists pueblo_foto;
CREATE TABLE pueblo_foto(
 id int(11) PRIMARY KEY AUTO_INCREMENT,
 ubicacion_foto varchar(256),
 id_pueblo int(11),
 subido_por varchar(128),
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
 FOREIGN KEY (id_pueblo) REFERENCES lenguas(id)
);

