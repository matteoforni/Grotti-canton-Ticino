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

create table grotto(
	id int primary key auto_increment,
    nome varchar(50) not null,
    lon double not null,
    lat double not null,
    no_civico varchar(10) not null,
    via varchar(50) not null,
    paese varchar(50) not null,
    cap int not null,
    fascia_prezzo enum("Buon mercato", "Nella norma", "Caro") not null,
    valutazione int not null
);

create table foto(
	id int primary key auto_increment,
    titolo varchar(50) not null,
    path varchar(50) not null
);

create table voto(
	email_utente varchar(50),
    id_grotto int,
    voto int not null,
    primary key(email_utente, id_grotto),
    foreign key(email_utente) references utente(email),
    foreign key(id_grotto) references grotto(id)
);

create user 'grotti_user'@'127.0.0.1' identified by 'GrottiUser&2019';
grant all privileges on grotti.* to 'grotti_user'@'127.0.0.1';
revoke grant option on grotti.* from 'grotti_user'@'127.0.0.1';
flush privileges;
show grants for 'grotti_user'@'127.0.0.1';