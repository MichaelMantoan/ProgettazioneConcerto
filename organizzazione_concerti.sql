create database if not exists organizzazione_concerti;
create table if not exists organizzazione_concerti.concerti
(
    id int not null auto_increment primary key,
    codice varchar(50),
    titolo varchar(50),
    descrizione varchar(100),
    data_concerto datetime,
    sala_id int
);

create table if not exists organizzazione_concerti.sale
(
    id int not null auto_increment primary key,
    codice varchar(50),
    nome varchar(50),
    capienza int
);    


Alter table if not exists organizzazione_concerti.concerti
add foreign key sala_id references sale(id);


insert into organizzazione_concerti.sale (codice,nome,capienza) values 

    ("N69420","SALA1", 80),
    ("43AR23","SALA2",5),
    ("AK47U","DANIELTARGA",100),
    ("M4A1","BRITESH",70),
    ("NEZZO","AL BAJABI THEATER",2018);

