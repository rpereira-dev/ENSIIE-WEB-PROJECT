/** suppression des données précèdentes dans la table */
DROP TABLE "joueur_equipe" ;
DROP TABLE "equipe_tournoi" ;
DROP TABLE "joueurs" CASCADE ;
DROP TABLE "equipes" CASCADE ;
DROP TABLE "ecoles" ;
DROP TABLE "tournois" ;
DROP TYPE "t_ecole";
DROP TYPE "t_jeu";

/** création des tables / types */

/** joueur */
CREATE TABLE "joueurs" (
	id		SERIAL		PRIMARY KEY ,
	prenom		VARCHAR		NOT NULL ,
	nom		VARCHAR		NOT NULL ,
	naissance	date		NOT NULL
);

/** équipe */
CREATE TABLE "equipes" (
	id	SERIAL	PRIMARY KEY ,
	nom	VARCHAR	NOT NULL
);

/** association joueur/equipe */
CREATE TABLE "joueur_equipe" (
	equipe_id	INTEGER,
	FOREIGN KEY (equipe_id) REFERENCES equipes(id),
	
	joueur_id	INTEGER,
	FOREIGN KEY (joueur_id) REFERENCES joueurs(id),

	PRIMARY KEY (equipe_id, joueur_id)
);

/** les différents types d'école possible */
CREATE TYPE t_ecole AS ENUM ('ingenieur', 'commerce', 'universite', 'bts', 'iut');

/** les écoles */
CREATE TABLE "ecoles" (
	id	SERIAL	PRIMARY KEY ,
	nom	VARCHAR	NOT NULL ,
	type	t_ecole	NOT NULL
);

/** les différents jeux possibles */
CREATE TYPE t_jeu AS ENUM ('lol', 'wow', 'fortnite') ;

/** un tournoi */
CREATE TABLE "tournois" (
	id		SERIAL	PRIMARY KEY,
	nom		VARCHAR	NOT NULL,
	description	VARCHAR,
	date_debut	date	NOT NULL,
	date_fin	date	NOT NULL,
	jeu		t_jeu	NOT NULL
);

/** inscriptions aux tournois */
CREATE TABLE "equipe_tournoi" (
	equipe_id	INTEGER,
	FOREIGN KEY (equipe_id) REFERENCES equipes(id),
	
	tournoi_id	INTEGER,
	FOREIGN KEY (tournoi_id) REFERENCES tournois(id),

	PRIMARY KEY (equipe_id, tournoi_id)
);

INSERT INTO "joueurs"(prenom, nom, naissance) VALUES ('John', 'Doe', '1967-11-22');
INSERT INTO "joueurs"(prenom, nom, naissance) VALUES ('Yvette', 'Angel', '1932-01-24');
INSERT INTO "joueurs"(prenom, nom, naissance) VALUES ('Amelia', 'Waters', '1981-12-01');
INSERT INTO "joueurs"(prenom, nom, naissance) VALUES ('Manuel', 'Holloway', '1979-07-25');
INSERT INTO "joueurs"(prenom, nom, naissance) VALUES ('Alonzo', 'Erickson', '1947-11-13');
INSERT INTO "joueurs"(prenom, nom, naissance) VALUES ('Otis', 'Roberson', '1995-01-09');
INSERT INTO "joueurs"(prenom, nom, naissance) VALUES ('Jaime', 'King', '1924-05-30');
INSERT INTO "joueurs"(prenom, nom, naissance) VALUES ('Vicky', 'Pearson', '1982-12-12)');
INSERT INTO "joueurs"(prenom, nom, naissance) VALUES ('Silvia', 'Mcguire', '1971-03-02');
INSERT INTO "joueurs"(prenom, nom, naissance) VALUES ('Brendan', 'Pena', '1950-02-17');
INSERT INTO "joueurs"(prenom, nom, naissance) VALUES ('Jackie', 'Cohen', '1967-01-27');
INSERT INTO "joueurs"(prenom, nom, naissance) VALUES ('Delores', 'Williamson', '1961-07-19');
