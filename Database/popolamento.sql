USE consessionaria;

/* popolamento tabella Utenti */
INSERT INTO Utenti() VALUE
('admin@admin.com', '$2y$10$FWWRA1aayii/Uzp0aq6Gq.uGPymgkB5xpf/rFIRbOA2dOHNWX2Xge', 'Admin', 'Admin', NULL, NULL, NULL, 1),
('utente@utente.com', '$2y$10$hnGoPYPog4gPStcxHuKX7.uPBZ7G.oNh.PkKAHJV9uV0vOilK2Q72', 'Utente', 'Utente', 999999999, 'Via Trieste, 63 - 35121 Padova (Italy)', '1970-01-01', 0);

INSERT INTO AutoVendita() VALUE 
(NULL,'Citroen','C4 Picasso',0,1560,26800,'../Images/Citroen_C4_Picasso.jpg','Citroen C4 Picasso'),
(NULL,'Fiat','Tipo',30000,1368,11000,'../Images/Fiat_Tipo.jpg','Fiat Tipo'),
(NULL,'Peugeot','308',0,1199,21400,'../Images/Peugeot-308.jpg','Peugeot 308');

INSERT INTO AutoNoleggio() VALUE 
('AB357RU','Audi','Q5',1984,30,350,'../Images/Audi_Q5.jpg','Audi Q5'),
('EZ286XM','Porsche','Cayenne',2967,50,500,'../Images/Porsche_Cayenne.jpg','Porsche Cayenne'),
('MA455YT','Fiat','Grande Punto',1368,15,100,'../Images/Fiat_Grande_Punto.jpg','Fiat Grande Punto');




