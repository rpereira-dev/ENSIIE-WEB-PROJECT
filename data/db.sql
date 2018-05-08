
/**
 *	JOUEURS / EQUIPES / TOURNOIS DEBUT
 */

/** suppression des données précèdentes dans la table */
DROP TABLE "notification" CASCADE;
DROP TYPE "t_notification";
DROP TYPE "t_notification_status";

DROP TRIGGER "notifieur_enregistrement" ON joueur ;
DROP FUNCTION "notifier_bienvenue" ;

DROP TRIGGER "notifieur_invitation" ON invitation;
DROP FUNCTION "notifier_invite" ;

DROP TABLE "inscription_match" ;
DROP TABLE "match" CASCADE ;

DROP TYPE "t_invitation_status" ;
DROP TABLE "invitation" ;
DROP TABLE "joueur_equipe" ;
DROP TABLE "equipe" CASCADE ;
DROP TABLE "tournoi" CASCADE ;
DROP TYPE "t_mode";
DROP TYPE "t_jeu";

DROP TABLE "joueur_lol" CASCADE ;
DROP TRIGGER "updater_reset_token" ON reset_token;
DROP FUNCTION "update_reset_token" ;
DROP TABLE "reset_token" CASCADE ;
DROP TABLE "joueur" CASCADE ;
DROP TABLE "ecole" CASCADE ;
DROP TYPE "t_ecole";

/** les différents types d'écoles possibles */
CREATE TYPE t_ecole AS ENUM ('ingenieur', 'commerce', 'universite', 'bts', 'iut', 'lycee', 'autre');

/** les écoles */
CREATE TABLE "ecole" (
	id		SERIAL	PRIMARY KEY ,
	nom		VARCHAR	NOT NULL ,
	type	t_ecole	NOT NULL
);

/** joueur */
CREATE TABLE "joueur" (
	id			SERIAL		PRIMARY KEY,

	mail		VARCHAR		NOT NULL UNIQUE,
	pseudo		VARCHAR		NOT NULL UNIQUE,
	pass		VARCHAR		NOT NULL,

	ecole_id	INTEGER,
	FOREIGN KEY (ecole_id) REFERENCES ecole(id)
);

/** token de reinitialisation */
CREATE TABLE "reset_token" (
	/* le joueur */
	joueur_id		INTEGER 	PRIMARY KEY,
	FOREIGN KEY (joueur_id) 	REFERENCES joueur(id),
	
	/* le token */
	token 			VARCHAR(32)	NOT NULL,
	
	/* date de création du token */
	date_generation	TIMESTAMP 	DEFAULT now()
);

/* met à jour la date de génération du token */
CREATE FUNCTION update_reset_token() RETURNS TRIGGER AS
$$
	BEGIN
		IF NEW IS NOT NULL THEN
			UPDATE reset_token SET date_generation=NOW() WHERE joueur_id=NEW.joueur_id ;
		END IF ;
		RETURN NULL ;
	END
$$
LANGUAGE 'plpgsql';

CREATE TRIGGER "updater_reset_token" AFTER UPDATE OF token ON reset_token FOR EACH ROW EXECUTE PROCEDURE update_reset_token() ;



/** les différents jeux possibles */
CREATE TYPE t_jeu AS ENUM ('lol', 'fortnite', 'csgo', 'minecraft', 'hearthstone') ;

/** les identifiants permettant de relier un joueur à un compte League of Legend */
CREATE TABLE "joueur_lol" (
	joueur_id	INTEGER,
	FOREIGN KEY (joueur_id) REFERENCES joueur(id),

	/** riot summoner id (long <=> BIGINT) */
	summoner_id	BIGINT PRIMARY KEY
);

/**
 * les différents modes de tournois possibles :
 * libre (les ecoles peuvent se mélanger),
 * restreint (les ecoles ne peuvent pas se mélanger)
 */
CREATE TYPE t_mode AS ENUM ('libre', 'restreint') ;

/** un tournoi (peut être une ligue, ou un tournoi ponctuel) */
CREATE TABLE "tournoi" (
	id			SERIAL			PRIMARY KEY,
	nom			VARCHAR			NOT NULL,
	description	VARCHAR 		NOT NULL,
	jeu			t_jeu			NOT NULL,
	debut_inscriptions	date	NOT NULL,
	fin_inscriptions	date	NOT NULL,
	mode				t_mode	DEFAULT 'restreint' 
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

/** invitations à rejoindre des équipes */
CREATE TYPE t_invitation_status AS ENUM ('pending', 'accepted', 'refused');

CREATE TABLE "invitation" (
	id			SERIAL		PRIMARY KEY,

	equipe_id	INTEGER,
	FOREIGN KEY (equipe_id) REFERENCES equipe(id),
		
	invited_id	INTEGER,
	FOREIGN KEY (invited_id) REFERENCES joueur(id)
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


/**
 *	Notifications
 */

/**
 *	les différentes notifications possibles
 *
 *	bienvenue : l'utilisateur vient de rejoindre le site
 *	message: un message brute d'information
 *	invitation : notification qu'un joueur a été invité dans une équipe
 *	join : notification qu'un joueur à rejoinds une équipe
 */

CREATE TYPE t_notification_status AS ENUM ('unseen', 'seen');
CREATE TYPE t_notification AS ENUM ('bienvenue', 'message', 'invitation', 'join') ;

CREATE TABLE "notification" (
	id		SERIAL	PRIMARY KEY,

	/* status de la requete */
	status		t_notification_status	DEFAULT 'unseen',

	/* le type de la notification */
	type		t_notification	NOT NULL,

	/* date ou la notification a été envoyé */
	date_envoie	timestamp 		DEFAULT now(),

	/* joueur auquelle la notification a été envoyé */
	joueur_id	INTEGER		NOT NULL,
	FOREIGN KEY (joueur_id) REFERENCES joueur(id)
);



/* envoie une notification de bienvenue au joueur donné */
CREATE FUNCTION notifier_bienvenue() RETURNS TRIGGER AS
$$
	BEGIN
		INSERT INTO notification (type, joueur_id) VALUES ('bienvenue', NEW.id) ;
		RETURN NULL ;
	END
$$
LANGUAGE 'plpgsql';

/** trigger lorsqu'un joueur s'enregistre */
CREATE TRIGGER "notifieur_enregistrement" AFTER INSERT ON joueur FOR EACH ROW EXECUTE PROCEDURE notifier_bienvenue() ;




/* envoie une notification quand un joueur est invité dans une équipe */
CREATE FUNCTION notifier_invite() RETURNS TRIGGER AS
$$
	BEGIN
		INSERT INTO notification (type, joueur_id) VALUES ('invitation', NEW.invited_id) ;
		RETURN NULL ;
	END
$$
LANGUAGE 'plpgsql';

CREATE TRIGGER "notifieur_invitation" AFTER INSERT ON invitation FOR EACH ROW EXECUTE PROCEDURE notifier_invite() ;




/** TESTS : pass: '123456' */
INSERT INTO joueur (mail, pseudo, pass) VALUES ('a@a.fr', 'toss', '$2y$10$9YX30iU9gZ7QpTrOXErofuKlxswhQka2ZFu9m.XJHxfPHppuoTu4y');
