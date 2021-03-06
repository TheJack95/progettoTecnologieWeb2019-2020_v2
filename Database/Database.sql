CREATE DATABASE IF NOT EXISTS concessionaria;

USE concessionaria;

CREATE TABLE IF NOT EXISTS Utenti(
    Email varchar(50),
    Password varchar(100),
    Nome varchar(50),
    Cognome varchar(50),
    Telefono varchar(12),
    Indirizzo varchar(100),
    DataNascita date,
    FlAdmin boolean,
    PRIMARY KEY(Email)
);

CREATE TABLE IF NOT EXISTS AutoVendita(
    IdAuto int AUTO_INCREMENT,
	Marca varchar(50),
	Modello varchar(50),
	KM int,
	Cilindrata smallint,
	PrezzoVendita int,
	Immagine text NULL,
	DescrImmagine text NULL,

	PRIMARY KEY(IdAuto)
);

CREATE TABLE IF NOT EXISTS AutoNoleggio(
    Targa varchar(7),
	Marca varchar(50),
	Modello varchar(50),
	Cilindrata smallint,
	CostoNoleggio int,
	Cauzione int,
	Immagine text NULL,
	DescrImmagine text NULL,

	PRIMARY KEY(Targa)
);

CREATE TABLE IF NOT EXISTS PreventivoAcquisto(
	IdPrev int AUTO_INCREMENT,
	Utente varchar(50),
    Automobile int,
	PrezzoVendita int,
	PRIMARY KEY(IdPrev)
);

CREATE TABLE IF NOT EXISTS PrenotazioneNoleggio(
	IdPrenot int AUTO_INCREMENT,
	Utente varchar(50),
    Targa varchar(7),
	InizioNoleggio date,
	FineNoleggio date,
	CostoTotale int,
	PRIMARY KEY(IdPrenot)
);

CREATE TABLE IF NOT EXISTS Messaggi (
    IdMess int AUTO_INCREMENT,
    Nome varchar(50),
    Cognome varchar(50),
    Email varchar(50),
    NumeroTelefono varchar(12),
    Messaggio text,
    PRIMARY KEY(IdMess)
);

CREATE TABLE IF NOT EXISTS RisposteMessaggi (
    IdRisp int AUTO_INCREMENT,
    Destinatario int,
	Oggetto varchar(50),
    Messaggio text,
    PRIMARY KEY(IdRisp)
);

ALTER TABLE PreventivoAcquisto
	ADD CONSTRAINT FK_PrevUtente FOREIGN KEY (Utente) REFERENCES Utenti(Email)
	ON UPDATE CASCADE;

ALTER TABLE PreventivoAcquisto
	ADD CONSTRAINT FK_PrevTarga FOREIGN KEY (Automobile) REFERENCES AutoVendita(IdAuto);

ALTER TABLE PrenotazioneNoleggio
	ADD CONSTRAINT FK_PrenUtente FOREIGN KEY (Utente) REFERENCES Utenti(Email)
	ON UPDATE CASCADE;

ALTER TABLE PrenotazioneNoleggio
	ADD CONSTRAINT FK_PrenTarga FOREIGN KEY (Targa) REFERENCES AutoNoleggio(Targa);

ALTER TABLE RisposteMessaggi
	ADD CONSTRAINT FK_Destinatario FOREIGN KEY (Destinatario) REFERENCES Messaggi(IdMess);
