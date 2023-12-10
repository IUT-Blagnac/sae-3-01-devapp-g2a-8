DROP TABLE Commander ;
DROP TABLE BonCommande ;
DROP TABLE AppartenirPack ;
DROP TABLE Evaluation ;
DROP TABLE AdrLivraison ;
DROP TABLE CarteBancaire ;
DROP TABLE Livraison ;
DROP TABLE Pack ;
DROP TABLE Article ;
DROP TABLE Regroupement ;
DROP TABLE Categorie ;
DROP TABLE Client ;


CREATE TABLE Client(
    idClient INT NOT NULL AUTO_INCREMENT,
    mdp VARCHAR(100),
    ptFidelite DECIMAL(4),
    civiliteClient CHAR(1),
    nomClient VARCHAR(30),
    prenomClient VARCHAR(30),
    adresseRueClient VARCHAR(100),
    codePostalClient DECIMAL(10),
    villeClient VARCHAR(30),
    telephoneClient VARCHAR(25),
    dtNaissanceClient DATE,
    emailClient VARCHAR(100),
    typeCompte VARCHAR(10),
    CONSTRAINT pk_Client PRIMARY KEY (idClient)
);

CREATE TABLE Categorie(
    idCategorie VARCHAR(10),
    nomCategorie VARCHAR(100),
    categorieMere VARCHAR(20), 
    CONSTRAINT pk_Categorie PRIMARY KEY (idCategorie),
    CONSTRAINT fk_Categorie_categorieMere FOREIGN KEY (categorieMere) REFERENCES Categorie (idCategorie)

);

CREATE TABLE Regroupement(
    idRegroupement VARCHAR(10),
    nomRegroupement VARCHAR(30),
    CONSTRAINT pk_Regroupement PRIMARY KEY (idRegroupement)
);

CREATE TABLE Article(
    idArticle VARCHAR(10),
    nomArticle VARCHAR(100),
    taille VARCHAR(15),
    couleur VARCHAR(30),
    gout VARCHAR(30),
    prix DECIMAL(7,2),
    description VARCHAR(1000),
    stock DECIMAL (4),
    categorie VARCHAR(10),
    regroupement VARCHAR(10), 
    articleApparente VARCHAR(10), 
    CONSTRAINT pk_Article PRIMARY KEY (idArticle),
    CONSTRAINT fk_Article_articleApparente FOREIGN KEY (articleApparente) REFERENCES Article (idArticle),
    CONSTRAINT fk_Article_categorie FOREIGN KEY (categorie) REFERENCES Categorie (idCategorie),
    CONSTRAINT fk_Article_regroupement FOREIGN KEY (regroupement) REFERENCES Regroupement (idRegroupement)
);

CREATE TABLE Pack(
    idPack VARCHAR(10),
    nomPack VARCHAR(100),
    prix DECIMAL(7,2),
    stock DECIMAL(4),
    description VARCHAR(1000),
    CONSTRAINT pk_Pack PRIMARY KEY (idPack)
);

CREATE TABLE Livraison(
    idLiv INT NOT NULL AUTO_INCREMENT,
    modeLiv VARCHAR(20),
    fraisLiv DECIMAL(6,2) CHECK (fraisLiv > 0),
    CONSTRAINT pk_Livraison PRIMARY KEY (idLiv)
);

CREATE TABLE CarteBancaire(
    nCB DECIMAL(16),
    dateExp DATE,
    CONSTRAINT pk_CarteBancaire PRIMARY KEY (nCB)
);

CREATE TABLE AdrLivraison(
    idAdrLiv INT NOT NULL AUTO_INCREMENT,
    adresseLiv VARCHAR(30),
    codePostalLiv CHAR(5),
    villeLiv VARCHAR(30),
    idClient INT NOT NULL,
    CONSTRAINT pk_AdrLivraison PRIMARY KEY (idAdrLiv),
    CONSTRAINT fk_AdrLivraison_idClient FOREIGN KEY (idClient) REFERENCES Client (idClient)
);

CREATE TABLE Evaluation(
    idEval INT NOT NULL AUTO_INCREMENT,
    note DECIMAL(1),
    avis VARCHAR(300),
    dateEval DATE,
    idArticle VARCHAR(10),
    idClient INT NOT NULL,
    CONSTRAINT pk_Evaluation PRIMARY KEY (idEval),
    CONSTRAINT fk_Evaluation_idArticle FOREIGN KEY (idArticle) REFERENCES Article (idArticle),
    CONSTRAINT fk_Evaluation_idClient FOREIGN KEY (idClient) REFERENCES Client (idClient)
);

CREATE TABLE AppartenirPack(
    quantite DECIMAL(3),
    idPack VARCHAR(10),
    idArticle VARCHAR(10),
    CONSTRAINT pk_AppartenirPack PRIMARY KEY (idPack, idArticle),
    CONSTRAINT fk_AppartenirPack_idPack FOREIGN KEY (idPack) REFERENCES Pack (idPack),
    CONSTRAINT fk_AppartenirPack_idArticle FOREIGN KEY (idArticle) REFERENCES Article (idArticle)
);

CREATE TABLE BonCommande(
    idBC INT NOT NULL AUTO_INCREMENT,
    dateBC DATE,
    modePaiement VARCHAR(10),
    idClient INT NOT NULL,
    idLiv INT NOT NULL,
    nCB DECIMAL(16),
    CONSTRAINT pk_BonCommande PRIMARY KEY (idBC),
    CONSTRAINT fk_BonCommande_idClient FOREIGN KEY (idClient) REFERENCES Client (idClient),
    CONSTRAINT fk_BonCommande_idLiv FOREIGN KEY (idLiv) REFERENCES Livraison (idLiv),
    CONSTRAINT fk_BonCommande_nCB FOREIGN KEY (nCB) REFERENCES CarteBancaire (nCB)
);

CREATE TABLE Commander(
    quantite DECIMAL(3),
    idBC INT NOT NULL,
    idArticle VARCHAR(10),
    CONSTRAINT fk_Commander_idBC FOREIGN KEY (idBC) REFERENCES BonCommande (idBC),
    CONSTRAINT fk_Commander_idArticle FOREIGN KEY (idArticle) REFERENCES Article (idArticle)
);

