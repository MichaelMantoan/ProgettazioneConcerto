create database Organizzazione_Concerto;
create table Organizzazione_Concerto.concerti(
    id int not null auto_increment primary key,
    codice varchar(50),
    titolo varchar(50),
    descrizione varchar(100),
    data datetime

);
