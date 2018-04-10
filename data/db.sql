
/**
 *	JOUEURS / EQUIPES / TOURNOIS DEBUT
 */

/** suppression des données précèdentes dans la table */
DROP TABLE "user" ;

DROP TABLE "inscription_match" ;
DROP TABLE "match" CASCADE ;

DROP TABLE "joueur_equipe" ;
DROP TABLE "equipe" CASCADE ;
DROP TABLE "tournoi" CASCADE ;
DROP TYPE "t_mode";
DROP TYPE "t_jeu";

DROP TABLE "joueur" ;
DROP TABLE "ecole" CASCADE ;
DROP TYPE "t_ecole";


/** les différents types d'école possible */
CREATE TYPE t_ecole AS ENUM ('ingenieur', 'commerce', 'universite', 'bts', 'iut');

/** les écoles */
CREATE TABLE "ecole" (
	id	SERIAL	PRIMARY KEY ,
	nom	VARCHAR	NOT NULL ,
	type	t_ecole	NOT NULL
);

/** joueur */
CREATE TABLE "joueur" (
	id		SERIAL		PRIMARY KEY,

	email		VARCHAR		NOT NULL,
	password	VARCHAR		NOT NULL,
	prenom		VARCHAR		NOT NULL,
	nom		VARCHAR		NOT NULL,
	naissance	date		NOT NULL,

	ecole_id	INTEGER,
	FOREIGN KEY (ecole_id) REFERENCES ecole(id)
);

/** les différents jeux possibles */
CREATE TYPE t_jeu AS ENUM ('lol', 'fortnite', 'csgo', 'minecraft', 'hearthstone') ;

/**
 * les différents modes de tournois possibles :
 * libre (les ecoles peuvent se mélanger),
 * restreint (les ecoles ne peuvent pas se mélanger)
 */
CREATE TYPE t_mode AS ENUM ('libre', 'restreint') ;

/** un tournoi (peut être une ligue, ou un tournoi ponctuel) */
CREATE TABLE "tournoi" (
	id			SERIAL	PRIMARY KEY,
	nom			VARCHAR	NOT NULL,
	description		VARCHAR,
	jeu			t_jeu	NOT NULL,
	debut_inscriptions	date	NOT NULL,
	fin_inscriptions	date	NOT NULL,
	mode			t_mode	DEFAULT 'restreint' 
);

/** équipe */
CREATE TABLE "equipe" (
	id		SERIAL	PRIMARY KEY,

	nom		VARCHAR	NOT NULL,

	tournoi_id	INTEGER,
	FOREIGN KEY (tournoi_id) REFERENCES tournoi(id),

	date_inscription date NOT NULL
);

/** association joueur/equipe */
CREATE TABLE "joueur_equipe" (
	equipe_id	INTEGER,
	FOREIGN KEY (equipe_id) REFERENCES equipe(id),
	
	joueur_id	INTEGER,
	FOREIGN KEY (joueur_id) REFERENCES joueur(id),

	PRIMARY KEY (equipe_id, joueur_id)
);

/** un match */
CREATE TABLE "match" (
	id		SERIAL	PRIMARY KEY,

	tournoi_id	INTEGER,
	FOREIGN KEY (tournoi_id) REFERENCES tournoi(id),

	date_debut	date NOT NULL
);

/** l'inscription d'équipe à un match */
CREATE TABLE "inscription_match" (
	equipe_id	INTEGER,
	FOREIGN KEY (equipe_id) REFERENCES equipe(id),

	match_id	INTEGER,
	FOREIGN KEY (match_id) REFERENCES match(id),
	
	PRIMARY KEY (equipe_id, match_id)
);

/**
 *	JOUEURS / EQUIPES / TOURNOIS FIN
 */





/** debug */
CREATE TABLE "user" (
    id SERIAL PRIMARY KEY ,
    firstname VARCHAR NOT NULL ,
    lastname VARCHAR NOT NULL ,
    birthday date
);

INSERT INTO "user"(firstname, lastname, birthday) VALUES ('John', 'Doe', '1967-11-22');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Yvette', 'Angel', '1932-01-24');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Amelia', 'Waters', '1981-12-01');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Manuel', 'Holloway', '1979-07-25');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Alonzo', 'Erickson', '1947-11-13');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Otis', 'Roberson', '1995-01-09');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Jaime', 'King', '1924-05-30');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Vicky', 'Pearson', '1982-12-12)');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Silvia', 'Mcguire', '1971-03-02');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Brendan', 'Pena', '1950-02-17');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Jackie', 'Cohen', '1967-01-27');
INSERT INTO "user"(firstname, lastname, birthday) VALUES ('Delores', 'Williamson', '1961-07-19');
