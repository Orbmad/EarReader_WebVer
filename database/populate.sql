-- Utenti --
INSERT INTO Utenti (Email, Nickname, Password_hash)
VALUES
("toad@hotmail.com", "SadToad", SHA2("toad", 256)),
("yoshi@hotmail.com", "YOSHIIIID", SHA2("yoshi", 256)),
("mario@libero.it", "Mariooo", SHA2("mario", 256)),
("peach@libero.it", "PinkyPeach", SHA2("peach", 256)),
("daisy@gmail.com", "BellisPerennis", SHA2("daisy", 256)),
("luigi@gmail.com", "Its-A-Me-Luigiii", SHA2("luigi", 256));

-- Metodi --
INSERT INTO Metodi (NomeMetodo)
VALUES
("CARTA PREPAGATA"),
("PAYPAL");

-- Sconti --
INSERT INTO Sconti (QuantitaMinima, Percentuale)
VALUES
(100, 0),
(1000, 0.05),
(2500, 0.15),
(5000, 0.25),
(10000, 0.35);

-- Discussioni --
INSERT INTO Discussioni (Email, Titolo, Stringa, Argomento)
VALUES
(
    "toad@hotmail.com",
    "Ho paura degli horror",
    "I libri horror mi fanno troppa paura!! Ogni volta che provo a leggerli poi la notte non riesco a dormire, eppure non vorrei privarmi di questo genere. Avete consigli?",
    "Libri horror"
);

INSERT INTO Discussioni (Email, Titolo, Stringa, Argomento)
VALUES
("yoshi@hotmail.com", "Fantasy preferito?", "Qual è il vostro libro fantasy preferito e perché?", "Libri fantasy"),
("mario@libero.it", "Classici italiani", "Vorrei iniziare a leggere dei classici italiani. Quali consigliate?", "Letteratura italiana"),
("peach@libero.it", "Romanzi rosa consigliati", "Cerco consigli su romanzi rosa non troppo sdolcinati.", "Libri romantici"),
("daisy@gmail.com", "Migliori thriller", "Quali sono i migliori thriller che abbiate mai letto?", "Libri thriller"),
("luigi@gmail.com", "Autori emergenti", "Mi piacerebbe scoprire nuovi autori emergenti. Avete suggerimenti?", "Letteratura contemporanea"),
("toad@hotmail.com", "Libri di avventura", "Cerco libri di avventura coinvolgenti e adrenalinici.", "Libri d'avventura"),
("yoshi@hotmail.com", "Poesia moderna", "Quali poeti moderni vi hanno colpito di più?", "Poesia"),
("mario@libero.it", "Libri di fantascienza", "Suggerimenti su libri di fantascienza non troppo tecnici?", "Libri di fantascienza"),
("peach@libero.it", "Libri per rilassarsi", "Cerco libri leggeri per rilassarmi dopo il lavoro.", "Letteratura leggera"),
("daisy@gmail.com", "Graphic novel da leggere", "Quali graphic novel consigliereste a un neofita?", "Graphic novel");

-- Commenti --
INSERT INTO Commenti (Email, Titolo, Stringa, EmailUtente)
VALUES
(
    "toad@hotmail.com",
    "Ho paura degli horror",
    "Secondo me dovresti smettere di leggere, sei un fifone!",
    "daisy@gmail.com"
),
(
    "toad@hotmail.com",
    "Ho paura degli horror",
    "Continua a provarci, prima o poi ci farai l'abitudine",
    "mario@libero.it"
);
UPDATE Discussioni
SET NumeroCommenti = NumeroCommenti + 2
WHERE Email = "toad@hotmail.com"
AND Titolo = "Ho paura degli horror";

INSERT INTO Commenti (Email, Titolo, Stringa, EmailUtente)
VALUES
("yoshi@hotmail.com", "Fantasy preferito?", "Io adoro Il Signore degli Anelli, un capolavoro!", "mario@libero.it"),
("yoshi@hotmail.com", "Fantasy preferito?", "Harry Potter rimane sempre il top.", "peach@libero.it"),
("mario@libero.it", "Classici italiani", "Ti consiglio I Promessi Sposi, è un must!", "luigi@gmail.com"),
("peach@libero.it", "Romanzi rosa consigliati", "Prova Orgoglio e Pregiudizio, un classico.", "daisy@gmail.com"),
("daisy@gmail.com", "Migliori thriller", "Gillian Flynn scrive thriller incredibili!", "toad@hotmail.com"),
("luigi@gmail.com", "Autori emergenti", "Dai un'occhiata a nuovi autori su Goodreads.", "yoshi@hotmail.com"),
("toad@hotmail.com", "Libri di avventura", "Ti consiglio L'Isola del Tesoro!", "mario@libero.it"),
("mario@libero.it", "Libri di fantascienza", "Io adoro Dune, è incredibile!", "peach@libero.it"),
("peach@libero.it", "Libri per rilassarsi", "Leggi Il Piccolo Principe, perfetto per rilassarsi.", "yoshi@hotmail.com"),
("daisy@gmail.com", "Graphic novel da leggere", "Inizia con Maus, un classico imprescindibile.", "luigi@gmail.com"),
("luigi@gmail.com", "Autori emergenti", "Scopri Sally Rooney, sta avendo molto successo.", "toad@hotmail.com"),
("yoshi@hotmail.com", "Poesia moderna", "Leggi Rupi Kaur, molto emozionante.", "daisy@gmail.com"),
("yoshi@hotmail.com", "Poesia moderna", "Io odiooo la poesia", "peach@libero.it"),
("yoshi@hotmail.com", "Poesia moderna", "Sono io il poeta migliore hahahahaha", "toad@hotmail.com"),
("mario@libero.it", "Classici italiani", "La Divina Commedia è imprescindibile!", "peach@libero.it");

UPDATE Discussioni
SET NumeroCommenti = NumeroCommenti + 3
WHERE Titolo = "Poesia moderna";

UPDATE Discussioni
SET NumeroCommenti = NumeroCommenti + 2
WHERE Titolo = "Fantasy preferito?";

UPDATE Discussioni
SET NumeroCommenti = NumeroCommenti + 1
WHERE Titolo IN ("Classici italiani", "Romanzi rosa consigliati", "Migliori thriller", "Autori emergenti", "Libri di avventura", "Libri di fantascienza", "Libri per rilassarsi", "Graphic novel da leggere");

