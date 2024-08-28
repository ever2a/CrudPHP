create database crudphp;
use crudphp;

create table tbl_usuarios(
    id int not null auto_increment,
    usuario varchar(20) not null,
    pass varchar(10) not null unique,
    correo varchar(100) not null unique,

    primary key(id)
);

create table tbl_puestos(
    id int not null auto_increment,
    nombredelpuesto varchar(50) not null,

    primary key(id)
);

create table tbl_empleados(
    id int not null auto_increment,
    nombres varchar(20) not null,
    apellidos varchar(20) not null unique,
    foto varchar(255) not null unique,
    cv varchar(255) not null,
    idpuesto int not null,
    fechadeingreso date not null,

    primary key(id),
    constraint fk_empleados_puesto_id foreign key(idpuesto) references tbl_puestos(id)
);

select * from tbl_puestos;
select * from tbl_usuarios;
select * from tbl_empleados;
