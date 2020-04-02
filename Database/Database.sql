CREATE TABLE IF NOT EXISTS Utenti(
    Email varchar(50),
    Password varchar(50),
    Nome varchar(30),
    Cognome varchar(30),
    Telefono varchar(15),
    Indirizzo varchar(50),
    DataNascita date,
    FlAdmin enum ('0','1','2','3'),
    PRIMARY KEY(Email)
);

CREATE TABLE IF NOT EXISTS AutoVendita(
    IdAuto int AUTO_INCREMENT,
	Marca varchar(20),
	Modello varchar(50),
	KM int,
	Cilindrata smallint,
	PrezzoVendita int,
	Immagine text NULL,
	DescImmagine text NULL,

	PRIMARY KEY(IdAuto)
);

CREATE TABLE IF NOT EXISTS AutoNoleggio(
    Targa varchar(7),
	Marca varchar(20),
	Modello varchar(50),
	Cilindrata smallint,
	CostoNoleggio smallint,
	Cauzione int,
	Immagine text NULL,
	DescImmagine text NULL,

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
    Nome varchar(30),
    Cognome varchar(30),
    Email varchar(50),
    NumeroTelefono varchar(10),
    Messaggio text,
    PRIMARY KEY(IdMess)
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




		


		
		
