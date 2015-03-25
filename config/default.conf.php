<?php

return [
		// Configuration de la base de donnée
		/* base de donnée sqlite */
		'DB_PROVIDER' => 'SQLite',
		'DB_FILE' => ROOT . '_db_' . DS . 'calindex.db',
		/* base de donnée mysql
		  "DB_PROVIDER" => "MySQL",
		  "DB_NAME"     => "",
		  "DB_USER"     => "",
		  "DB_PASSWORD" => "",
		  "DB_HOST"     => "",
		 */

		// url du calendrier des vacances de l'éducation nationnale
		'CALENDRIER_VACANCES' => 'http://www.education.gouv.fr/download.php?file=http%3A%2F%2Fcache.media.education.gouv.fr%2Fics%2FCalendrier_Scolaire_Zones_A_B_C.ics&submit='
];
