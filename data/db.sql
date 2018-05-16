
/**
 *	utilisateurS / EQUIPES / TOURNOIS DEBUT
 */

/** suppression des données précèdentes dans la table */
DROP TABLE "notification" CASCADE;
DROP TYPE "t_notification";
DROP TYPE "t_notification_status";

DROP TRIGGER "t_insert_utilisateur" ON utilisateur ;
DROP FUNCTION "on_utilisateur_inserted" ;

DROP TRIGGER "t_insert_invitation" ON invitation;
DROP FUNCTION "notifier_invite" ;

DROP TABLE "match_equipe" ;
DROP TABLE "match" CASCADE ;

DROP TYPE "t_invitation_status" ;
DROP TABLE "invitation" ;
DROP TABLE "utilisateur_equipe" ;
DROP TABLE "equipe_tournoi" CASCADE;
DROP TABLE "equipe" CASCADE ;
DROP TABLE "tournoi" CASCADE ;
DROP TYPE "t_jeu";

DROP TABLE "utilisateur_lol" CASCADE ;
DROP TRIGGER "t_update_reset_token" ON reset_token;
DROP FUNCTION "update_reset_token" ;
DROP TABLE "reset_token" CASCADE ;
DROP TABLE "utilisateur_ecole" CASCADE ;

DROP TABLE "utilisateur_role" CASCADE ;
DROP TABLE "role" CASCADE ;

DROP TABLE "utilisateur" CASCADE ;
DROP TABLE "ecole" CASCADE ;
DROP TYPE "t_ecole_status" CASCADE ;

/** utilisateur */
CREATE TABLE "utilisateur" (
	id			SERIAL		PRIMARY KEY,
	mail		VARCHAR		NOT NULL UNIQUE,
	pseudo		VARCHAR		NOT NULL UNIQUE,
	pass		VARCHAR		NOT NULL
);

/* lorsque l'utilisateur s'inscrit sur le site */
CREATE FUNCTION on_utilisateur_inserted() RETURNS TRIGGER AS
$$
	BEGIN
		INSERT INTO notification (type, utilisateur_id) VALUES ('bienvenue', NEW.id) ;
		INSERT INTO utilisateur_role (utilisateur_id) VALUES (NEW.id) ;
		RETURN NULL ;
	END
$$
LANGUAGE 'plpgsql';

/** trigger lorsqu'un utilisateur s'enregistre */
CREATE TRIGGER "t_insert_utilisateur" AFTER INSERT ON utilisateur FOR EACH ROW EXECUTE PROCEDURE on_utilisateur_inserted() ;



/**
 *	les différentes notifications possibles
 *
 *	bienvenue : l'utilisateur vient de rejoindre le site
 *	message: un message brute d'information
 *	invitation : notification qu'un utilisateur a été invité dans une équipe
 *	join : notification qu'un utilisateur à rejoinds une équipe
 */

CREATE TYPE t_notification_status AS ENUM ('unseen', 'seen');
CREATE TYPE t_notification AS ENUM ('bienvenue', 'message', 'invitation', 'join') ;

CREATE TABLE "notification" (
	id			SERIAL	PRIMARY KEY,

	/* status de la requete */
	status		t_notification_status	DEFAULT 'unseen',

	/* le type de la notification */
	type		t_notification	NOT NULL,

	/* date ou la notification a été envoyé */
	date_envoie	timestamp 		DEFAULT now(),

	/* utilisateur auquelle la notification a été envoyé */
	utilisateur_id	INTEGER		NOT NULL,
	FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id)
);





/** DEBUT DES PERMISSIONS */

/** les roles possibles */
CREATE TABLE "role" (
	id		INTEGER	PRIMARY KEY,
	name	VARCHAR	NOT NULL
);

/** les roles associés à un utilisateur */
CREATE TABLE "utilisateur_role" (
	utilisateur_id	INTEGER	NOT NULL,
	FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id),
	
	role_id			INTEGER	DEFAULT 1,
	FOREIGN KEY (role_id) REFERENCES role(id),
	
	PRIMARY KEY (utilisateur_id, role_id)
);

/** les roles */
INSERT INTO role (id, name) VALUES (0, 'utilisateur');
INSERT INTO role (id, name) VALUES (1, 'joueur');
INSERT INTO role (id, name) VALUES (2, 'moderateur');
INSERT INTO role (id, name) VALUES (3, 'administrateur');

/** FIN DES PERMISSIONS */



/** token de reinitialisation mot de passe */
CREATE TABLE "reset_token" (
	/* l'utilisateur */
	utilisateur_id		INTEGER 	PRIMARY KEY,
	FOREIGN KEY (utilisateur_id) 	REFERENCES utilisateur(id),
	
	/* le token */
	token 				VARCHAR(32)	NOT NULL,
	
	/* date de création du token */
	date_generation	TIMESTAMP 	DEFAULT now()
);

/* met à jour la date de génération du token */
CREATE FUNCTION update_reset_token() RETURNS TRIGGER AS
$$
	BEGIN
		IF NEW IS NOT NULL THEN
			UPDATE reset_token SET date_generation=NOW() WHERE utilisateur_id=NEW.utilisateur_id ;
		END IF ;
		RETURN NULL ;
	END
$$
LANGUAGE 'plpgsql';

CREATE TRIGGER "t_update_reset_token" AFTER UPDATE OF token ON reset_token FOR EACH ROW EXECUTE PROCEDURE update_reset_token() ;

/** les écoles */
CREATE TYPE t_ecole_status AS ENUM('public', 'privé');

CREATE TABLE "ecole" (
	id			SERIAL	PRIMARY KEY ,
	academie 	VARCHAR,
	nom			VARCHAR	NOT NULL ,
	sigle		VARCHAR,
	status 		t_ecole_status NOT NULL,
	domaine		VARCHAR,
	ville		VARCHAR
);

/*\copy ecole(id, academie, sigle, domaine, ville)  FROM '/home/rpereira/ecoles.csv' DELIMITER ';' CSV HEADER;*/

/** un utilisateur est lié à une ou plusieurs écoles */
CREATE TABLE "utilisateur_ecole" (
	utilisateur_id	INTEGER	NOT NULL,
	FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id),
	
	ecole_id		INTEGER	NOT NULL,
	FOREIGN KEY (ecole_id) REFERENCES ecole(id),
	
	PRIMARY KEY (utilisateur_id, ecole_id)
);

/** les différents jeux possibles */
CREATE TYPE t_jeu AS ENUM ('lol', 'fortnite', 'csgo', 'minecraft', 'hearthstone') ;

/** un tournoi (peut être une ligue, ou un tournoi ponctuel) */
CREATE TABLE "tournoi" (
	id					SERIAL		PRIMARY KEY,
	nom					VARCHAR		NOT NULL,
	description			VARCHAR 	NOT NULL,
	jeu					t_jeu		NOT NULL,
	debut_inscriptions	timestamp 	NOT NULL,
	fin_inscriptions	timestamp	NOT NULL,
	createur_id			INTEGER		NOT NULL
);

/** équipe */
CREATE TABLE "equipe" (
	id		SERIAL		PRIMARY KEY,
	nom		VARCHAR		NOT NULL UNIQUE
);

/** association tournoi/equipe (inscription d'une equipe à un tournoi) */
CREATE TABLE "equipe_tournoi" (
	tournoi_id	INTEGER	NOT NULL,
	FOREIGN KEY (tournoi_id) 	REFERENCES tournoi(id),

	equipe_id	INTEGER	NOT NULL,
	FOREIGN KEY (tournoi_id) 	REFERENCES tournoi(id),
	
	date_inscription timestamp 	DEFAULT now(),

	PRIMARY KEY (tournoi_id, equipe_id)
);

/** association utilisateur/equipe */
CREATE TABLE "utilisateur_equipe" (
	equipe_id	INTEGER,
	FOREIGN KEY (equipe_id) REFERENCES equipe(id),
	
	utilisateur_id	INTEGER,
	FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id),

	PRIMARY KEY (equipe_id, utilisateur_id)
);

/** invitations à rejoindre des équipes */
CREATE TYPE t_invitation_status AS ENUM ('pending', 'accepted', 'refused');

CREATE TABLE "invitation" (
	id			SERIAL		PRIMARY KEY,

	equipe_id	INTEGER,
	FOREIGN KEY (equipe_id) REFERENCES equipe(id),
		
	invited_id	INTEGER,
	FOREIGN KEY (invited_id) REFERENCES utilisateur(id)
);

/* envoie une notification quand un utilisateur est invité dans une équipe */
CREATE FUNCTION notifier_invite() RETURNS TRIGGER AS
$$
	BEGIN
		INSERT INTO notification (type, utilisateur_id) VALUES ('invitation', NEW.invited_id) ;
		RETURN NULL ;
	END
$$
LANGUAGE 'plpgsql';

CREATE TRIGGER "t_insert_invitation" AFTER INSERT ON invitation FOR EACH ROW EXECUTE PROCEDURE notifier_invite() ;

/** un match */
CREATE TABLE "match" (
	id			SERIAL	PRIMARY KEY,

	tournoi_id	INTEGER,
	FOREIGN KEY (tournoi_id) REFERENCES tournoi(id),

	date_debut	timestamp	NOT NULL
);

/** association match/equipe : l'inscription d'une équipe à un match */
CREATE TABLE "match_equipe" (
	equipe_id	INTEGER,
	FOREIGN KEY (equipe_id) REFERENCES equipe(id),

	match_id	INTEGER,
	FOREIGN KEY (match_id) REFERENCES match(id),
	
	PRIMARY KEY (equipe_id, match_id)
);

/**
 *	utilisateurs / EQUIPES / TOURNOIS FIN
 */

/** les identifiants permettant de relier un utilisateur à un compte League of Legend (le compte ne peut être lié qu'une fois)*/
CREATE TABLE "utilisateur_lol" (
	/** riot summoner id (long <=> BIGINT) */
	summoner_id	BIGINT PRIMARY KEY,
	
	/** l'id de l'utilisateur */
	utilisateur_id	INTEGER	NOT NULL,
	FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id)
);





/** DONNEES DE TESTS */


/** TESTS : pass: '123456' */
INSERT INTO utilisateur (mail, pseudo, pass) VALUES ('a@a.fr', 'toss', '$2y$10$9YX30iU9gZ7QpTrOXErofuKlxswhQka2ZFu9m.XJHxfPHppuoTu4y');
INSERT INTO utilisateur_role (utilisateur_id, role_id) VALUES (1, 3); /* toss, administrateur */

INSERT INTO utilisateur (mail, pseudo, pass) VALUES ('b@b.fr', 'Spingz',    '$2y$10$9YX30iU9gZ7QpTrOXErofuKlxswhQka2ZFu9m.XJHxfPHppuoTu4y');
INSERT INTO utilisateur_role (utilisateur_id, role_id) VALUES (2, 2); /* Spingz, moderateur */

INSERT INTO utilisateur (mail, pseudo, pass) VALUES ('c@c.fr', 'lousticos', '$2y$10$9YX30iU9gZ7QpTrOXErofuKlxswhQka2ZFu9m.XJHxfPHppuoTu4y');
