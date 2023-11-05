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


Alter table  organizzazione_concerti.concerti
add foreign key (sala_id) references sale(id);


INSERT INTO organizzazione_concerti.sale (codice, nome, capienza) VALUES
    ("N69420", "SALA1", 80),
    ("43AR23", "SALA2", 5),
    ("AK47U", "DANIELTARGA", 100),
    ("M4A1", "BRITESH", 70),
    ("NEZZO", "AL BAJABI THEATER", 2018);

create table organizzazione_concerti.pezzi(

    id int not null auto_increment primary key,
    codice varchar(50),
    titolo varchar(100)
);
insert into organizzazione_concerti.pezzi (codice,titolo) values
("42321","PEZZO1"),
("23133","PEZZO2"),
("67544","PEZZO3"),
("32211","PEZZO4");

create table organizzazione_concerti.concerti_pezzi(

    concerto_id int,
    pezzo_id int
);

insert into organizzazione_concerti.concerti_pezzi (concerto_id,pezzo_id) values
(1,3),
(1,2),
(2,4),
(3,4);

Alter table organizzazione_concerti.concerti_pezzi
add foreign key (concerto_id) references concerti(id),
add foreign key (pezzo_id) references pezzi(id);
