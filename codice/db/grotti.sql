create database grotti;
use grotti;

create table ruolo(
	nome varchar(50) primary key
);

create table utente(
	email varchar(50) primary key,
    username varchar(50) not null,
    nome varchar(50) not null,
    cognome varchar(50) not null,
    password varchar(64) not null,
    nome_ruolo varchar(50) not null,
    foreign key(nome_ruolo) references ruolo(nome)
);