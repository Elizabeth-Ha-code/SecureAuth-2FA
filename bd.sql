USE clinica;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) UNIQUE,
  password VARCHAR(255),
  secret VARCHAR(32)
);
select *from  usuarios;
delete from usuarios where id = 1
