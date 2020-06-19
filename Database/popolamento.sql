USE concessionaria;

/* popolamento tabella Utenti */
INSERT INTO Utenti() VALUE
('admin', '$2y$10$KL3vJz2JnAzWVsYFxc4D..mFcrH99KjruekJy3d5aM2BkUim4hU.q', 'Admin', 'Admin', NULL, NULL, NULL, 1),
('user', '$2y$10$sC9n7s1gyAdlDy8W0LnOqeoM8EOY2Lio6q8JEW75D5fjQKmorMCWq', 'User', 'User', 999999999, 'Via Trieste, 63 - 35121 Padova (Italy)', '1970-01-01', 0);

INSERT INTO AutoVendita() VALUE 
(NULL,'Citroen','C4 Picasso',0,1560,26800,'../Images/Citroen_C4_Picasso.png','Citroen C4 Picasso'),
(NULL,'Fiat','Tipo',30000,1368,11000,'../Images/Fiat_Tipo.png','Fiat Tipo'),
(NULL,'Peugeot','308',0,1199,21400,'../Images/Peugeot-308.png','Peugeot 308');

INSERT INTO AutoNoleggio() VALUE 
('AB357RU','Audi','Q5',1984,30,350,'../Images/Audi_Q5.png','Audi Q5'),
('EZ286XM','Porsche','Cayenne',2967,50,500,'../Images/Porsche_Cayenne.png','Porsche Cayenne'),
('MA455YT','Fiat','Grande Punto',1368,15,100,'../Images/Fiat_Grande_Punto.png','Fiat Grande Punto');




