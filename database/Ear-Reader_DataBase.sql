-- Tables Creation ----------------------

CREATE database if not exists Earreader;
use Earreader;

CREATE TABLE Generi (
    NomeGenere VARCHAR(50) PRIMARY KEY
);

CREATE TABLE Testi (
    Codice INT AUTO_INCREMENT PRIMARY KEY,
    Data_ora DATE NOT NULL,
    Titolo VARCHAR(255) NOT NULL,
    Singolo BOOLEAN NOT NULL,
    Percorso VARCHAR(255) NOT NULL,
    Costo INT NOT NULL,
    Voto DECIMAL(3, 1) DEFAULT 0,
    NomeGenere VARCHAR(50) NOT NULL,
    FOREIGN KEY (NomeGenere) REFERENCES Generi(NomeGenere)
);

CREATE TABLE Gruppi (
    NomeGruppo VARCHAR(50) PRIMARY KEY,
    Descrizione TEXT NOT NULL
);

CREATE TABLE Appartenenze (
    CodiceTesto INT,
    NomeGruppo VARCHAR(50),
    PRIMARY KEY (CodiceTesto, NomeGruppo),
    FOREIGN KEY (CodiceTesto) REFERENCES Testi(Codice),
    FOREIGN KEY (NomeGruppo) REFERENCES Gruppi(NomeGruppo)
);

CREATE TABLE Autori (
    CodiceAutore INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    Alias VARCHAR(100) DEFAULT NULL,
    Punteggio DECIMAL(3, 2) DEFAULT 0
);

CREATE TABLE Scritture (
    CodiceAutore INT,
    CodiceTesto INT,
    PRIMARY KEY (CodiceAutore, CodiceTesto),
    FOREIGN KEY (CodiceAutore) REFERENCES Autori(CodiceAutore),
    FOREIGN KEY (CodiceTesto) REFERENCES Testi(Codice)
);

CREATE TABLE Tag (
    Codice INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL
);

CREATE TABLE Contiene (
    CodiceTesto INT,
    CodiceTag INT,
    PRIMARY KEY (CodiceTesto, CodiceTag),
    FOREIGN KEY (CodiceTesto) REFERENCES Testi(Codice),
    FOREIGN KEY (CodiceTag) REFERENCES Tag(Codice)
);

CREATE TABLE Capitoli (
    CodiceTesto INT NOT NULL,
    Numero INT NOT NULL,
    Data_ora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PercorsoCapitolo VARCHAR(255) NOT NULL,
    Titolo VARCHAR(255) NOT NULL,
    PRIMARY KEY (CodiceTesto, Numero),
    FOREIGN KEY (CodiceTesto) REFERENCES Testi(Codice)
);

CREATE TABLE Utenti (
    Email VARCHAR(100) PRIMARY KEY,
    Nickname VARCHAR(50) UNIQUE NOT NULL,
    Password_hash VARCHAR(255) NOT NULL,
    EarCoins INT DEFAULT 500
);

CREATE TABLE AcquistiCap (
    Numero INT NOT NULL,
    CodiceTesto INT NOT NULL,
    Email VARCHAR(100) NOT NULL,
    PRIMARY KEY (Numero, CodiceTesto, Email),
    FOREIGN KEY (CodiceTesto, Numero) REFERENCES Capitoli(CodiceTesto, Numero),
    FOREIGN KEY (Email) REFERENCES Utenti(Email)
);

CREATE TABLE Metodi (
    CodiceMetodo INT AUTO_INCREMENT PRIMARY KEY,
    NomeMetodo VARCHAR(100) NOT NULL
);

CREATE TABLE Sconti (
    CodiceSconto INT AUTO_INCREMENT PRIMARY KEY,
    QuantitaMinima INT NOT NULL,
    Percentuale INT NOT NULL 
);

CREATE TABLE Pagamenti (
    CodicePagamento INT AUTO_INCREMENT NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Data_ora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    EarCoins INT NOT NULL,
    -- Costo INT NOT NULL,
    CodiceMetodo INT NOT NULL,
    CodiceSconto INT NOT NULL,
    PRIMARY KEY (CodicePagamento, Email),
    FOREIGN KEY (Email) REFERENCES Utenti(Email),
    FOREIGN KEY (CodiceMetodo) REFERENCES Metodi(CodiceMetodo),
    FOREIGN KEY (CodiceSconto) REFERENCES Sconti(CodiceSconto)
);

CREATE TABLE Discussioni (
    Email VARCHAR(100) NOT NULL,
    Titolo VARCHAR(255) NOT NULL,
    Data_ora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Stringa TEXT NOT NULL,
    Argomento VARCHAR(255) NOT NULL,
    NumeroCommenti INT DEFAULT 0,
    PRIMARY KEY (Email, Titolo),
    FOREIGN KEY (Email) REFERENCES Utenti(Email)
);

CREATE TABLE Commenti (
    Email VARCHAR(100) NOT NULL,
    Titolo VARCHAR(255) NOT NULL,
    Codice INT AUTO_INCREMENT NOT NULL,
    Data_ora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Stringa TEXT NOT NULL,
    EmailUtente VARCHAR(100),
    PRIMARY KEY (Codice, Email, Titolo),
    FOREIGN KEY (Email, Titolo) REFERENCES Discussioni(Email, Titolo),
    FOREIGN KEY (EmailUtente) REFERENCES Utenti(Email)
);

CREATE TABLE Valutazioni (
    EmailUtente VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Titolo VARCHAR(255) NOT NULL,
    Codice INT NOT NULL,
    MiPiace BOOLEAN NOT NULL,
    PRIMARY KEY (EmailUtente, Email, Titolo, Codice),
    FOREIGN KEY (EmailUtente) REFERENCES Utenti(Email),
    FOREIGN KEY (Email, Titolo, Codice) REFERENCES Commenti(Email, Titolo, Codice) 
);

CREATE TABLE Recensioni (
    Email VARCHAR(100) NOT NULL,
    CodiceTesto INT NOT NULL,
    Voto INT NOT NULL,
    Titolo VARCHAR(255) NOT NULL,
    Stringa TEXT,
    PRIMARY KEY (Email, CodiceTesto),
    FOREIGN KEY (Email) REFERENCES Utenti(Email),
    FOREIGN KEY (CodiceTesto) REFERENCES Testi(Codice)
);
