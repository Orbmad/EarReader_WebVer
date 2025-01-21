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

-- Ricalcolo numero commenti
UPDATE Discussioni D
SET NumeroCommenti = (
    SELECT COUNT(*)
    FROM Commenti C
    WHERE C.Titolo = D.Titolo
    AND C.Email = D.Email
)
WHERE D.Titolo = ?
AND Email = ?;

-- Generi --
INSERT INTO Generi (NomeGenere)
VALUES
('Fantasy'),
('Sci-Fi'),
('Giallo'),
('Storico'),
('Critico'),
('Poesia');

-- Tag --
INSERT INTO Tag (Nome)
VALUES
('#En'),
('#It'),
('#Distopia'),
('#Poesia'),
('#Violenza'),
('#Politica'),
('#Introspettivo'),
('#Investigazione'),
('#Mistero'),
('#Amore'),
('#Guerra'),
('#Drammatico');

-- Gruppi --
INSERT INTO Gruppi (NomeGruppo, Descrizione)
VALUES
('Consigliati', 'Una raccolta dei testi consigliati!'),
('Best sellers', 'Una raccolta dei testi più famosi di sempre');

-- Autori --
INSERT INTO Autori (Nome, Alias)
VALUES
('Franz Kafka', 'Kafka'),
('Ugo FOscolo', 'Foscolo'),
('George Orwell', 'G. Orwell'),
('Herbert George Well', 'H. G. Well'),
('Arthur Conan Doyle', 'A. C. Doyle');

-- Testi --
INSERT INTO Testi (Titolo, Data_ora, Singolo, Percorso, Costo, NomeGenere)
VALUES
('1984', '1949-06-08', 1, 'files/1984/', 70, 'Sci-Fi'),
('La fattoria degli animali', '1945-08-17', 0, 'files/la-fattoria-degli-animali/', 10, 'Critico'),
('Il processo', '1925-01-01', 1, 'files/il-processo/', 30, 'Critico'),
('La metamorfosi', '1915-01-01', 1, 'files/la-metamorfosi/', 40, 'Critico'),
('Le ultime lettere di Jacopo Ortis', '1802-01-01', 1, 'files/le-ultime-lettere-di-Jacopo-Ortis/', 60, 'Poesia'),
('The Hound of The Baskervilles', '1902-03-25', 0, 'files/the-hound-of-the-baskervilles/', 15, 'Giallo'),
('The War of The Worlds', '1898-01-01', 0, 'files/the-war-of-the-worlds/', 6, 'Sci-Fi');

-- Appartenenze --
INSERT INTO Appartenenze (CodiceTesto, NomeGruppo)
VALUES
(8, 'Best sellers'), -- 1984
(9, 'Best sellers'), -- La fattoria
(13, 'Best sellers'), -- Basker
(8, 'Consigliati'), -- 1984
(12, 'Consigliati'), -- Jacopo
(14, 'Consigliati'), -- war
(9, 'Consigliati'); -- fattoria

-- Scritture --
INSERT INTO Scritture (CodiceAutore, CodiceTesto)
VALUES
(3, 8), -- 1984
(3, 9), -- fattoria
(1, 10), -- processo
(1, 11), -- metam
(2, 12), -- Jacopo
(5, 13), -- hound
(4, 14); -- war

-- Contiene --
INSERT INTO Contiene (CodiceTesto, CodiceTag)
VALUES
(13, 1), -- en
(14, 1), -- en
(8, 2), -- it
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(8, 3), -- dist
(14, 3),
(12, 4), -- poesia
(14, 5), -- viol
(13, 5),
(8, 5),
(8, 6), -- poli
(9, 6),
(12, 6),
(12, 7), -- intro
(10, 7),
(11, 7),
(13, 8), -- Invest
(13, 9), -- mist
(11, 9),
(12, 10), -- amor
(14, 11),
(10, 12), -- drama
(9, 12),
(12, 12);

-- Capitoli -- per Testi con capitoli
INSERT INTO Capitoli (CodiceTesto, Numero, PercorsoCapitolo, Titolo)
VALUES
(9, 1, "001_la-fattoria-degli-animali-01-4.pdf", "Capitolo 1"),
(9, 2, "002_la-fattoria-degli-animali-05-8.pdf", "Capitolo 2"),
(9, 3, "003_la-fattoria-degli-animali-09-11.pdf", "Capitolo 3"),
(9, 4, "004_la-fattoria-degli-animali-12-14.pdf", "Capitolo 4"),
(9, 5, "005_la-fattoria-degli-animali-15-19.pdf", "Capitolo 5"),
(9, 6, "006_la-fattoria-degli-animali-20-23.pdf", "Capitolo 6"),
(9, 7, "007_la-fattoria-degli-animali-24-28.pdf", "Capitolo 7"),
(9, 8, "008_la-fattoria-degli-animali-29-34.pdf", "Capitolo 8"),
(9, 9, "009_la-fattoria-degli-animali-35-39.pdf", "Capitolo 9"),
(9, 10, "010_la-fattoria-degli-animali-40-44.pdf", "Capitolo 10"),
(13, 1, "001_the_hound_of_the_baskervilles-1-5.pdf", "Capitolo 1"),
(13, 2, "002_the_hound_of_the_baskervilles-13-19.pdf", "Capitolo 2"),
(13, 3, "003_the_hound_of_the_baskervilles-20-27.pdf", "Capitolo 3"),
(13, 4, "004_the_hound_of_the_baskervilles-28-35.pdf", "Capitolo 4"),
(13, 5, "005_the_hound_of_the_baskervilles-36-43.pdf", "Capitolo 5"),
(13, 6, "006_the_hound_of_the_baskervilles-44-52.pdf", "Capitolo 6"),
(13, 7, "007_the_hound_of_the_baskervilles-53-57.pdf", "Capitolo 7"),
(13, 8, "008_the_hound_of_the_baskervilles-58-69.pdf", "Capitolo 8"),
(13, 9, "009_the_hound_of_the_baskervilles-6-12.pdf", "Capitolo 9"),
(13, 10, "010_the_hound_of_the_baskervilles-70-76.pdf", "Capitolo 10"),
(13, 11, "011_the_hound_of_the_baskervilles-77-85.pdf", "Capitolo 11"),
(13, 12, "012_the_hound_of_the_baskervilles-86-95.pdf", "Capitolo 12"),
(13, 13, "013_the_hound_of_the_baskervilles-96-102.pdf", "Capitolo 13"),
(13, 14, "014_the_hound_of_the_baskervilles-103-110.pdf", "Capitolo 14"),
(13, 15, "015_the_hound_of_the_baskervilles-111-117.pdf", "Capitolo 15"),
(14, 1, "001_The_War_of_The_Worlds-1-4.pdf", "Capitolo 1"),
(14, 2, "002_The_War_of_The_Worlds-5-7.pdf", "Capitolo 2"),
(14, 3, "003_The_War_of_The_Worlds-8-12.pdf", "Capitolo 3"),
(14, 4, "004_The_War_of_The_Worlds-13-15.pdf", "Capitolo 4"),
(14, 5, "005_The_War_of_The_Worlds-16-17.pdf", "Capitolo 5"),
(14, 6, "006_The_War_of_The_Worlds-18-20.pdf", "Capitolo 6"),
(14, 7, "007_The_War_of_The_Worlds-21-22.pdf", "Capitolo 7"),
(14, 8, "008_The_War_of_The_Worlds-23-26.pdf", "Capitolo 8"),
(14, 9, "009_The_War_of_The_Worlds-27-30.pdf", "Capitolo 9"),
(14, 10, "010_The_War_of_The_Worlds-31-34.pdf", "Capitolo 10"),
(14, 11, "011_The_War_of_The_Worlds-35-41.pdf", "Capitolo 11"),
(14, 12, "012_The_War_of_The_Worlds-42-45.pdf", "Capitolo 12"),
(14, 13, "013_The_War_of_The_Worlds-46-52.pdf", "Capitolo 13"),
(14, 14, "015_The_War_of_The_Worlds-53-57.pdf", "Capitolo 15"),
(14, 15, "016_The_War_of_The_Worlds-58-70.pdf", "Capitolo 16"),
(14, 16, "017_The_War_of_The_Worlds-71-75.pdf", "Capitolo 17"),
(14, 17, "018_The_War_of_The_Worlds-76-81.pdf", "Capitolo 18"),
(14, 18, "020_The_War_of_The_Worlds-82-85.pdf", "Capitolo 20"),
(14, 19, "021_The_War_of_The_Worlds-86-88.pdf", "Capitolo 21"),
(14, 20, "022_The_War_of_The_Worlds-89-90.pdf", "Capitolo 22"),
(14, 21, "023_The_War_of_The_Worlds-91-93.pdf", "Capitolo 23"),
(14, 22, "024_The_War_of_The_Worlds-94-103.pdf", "Capitolo 24"),
(14, 23, "025_The_War_of_The_Worlds-104-108.pdf", "Capitolo 25");



