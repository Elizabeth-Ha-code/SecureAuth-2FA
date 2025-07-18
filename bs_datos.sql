CREATE DATABASE clinica;

USE clinica;

CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    cedula VARCHAR(20),
    edad INT,
    motivo TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

select * from pacientes;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) UNIQUE,
  password VARCHAR(255),
  secret VARCHAR(32)
);

select *from  usuarios;
select*  from  pacientes;

/* delete from usuarios where id = 2 */
/*DELETE FROM pacientes WHERE id IN (4,5,6,7,8,9,10,11,12,13,14,15,16);*/
/*DELETE FROM usuarios WHERE id BETWEEN 1 AND 21;*/


