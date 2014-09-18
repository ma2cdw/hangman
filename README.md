Hangman Game

Requires a session database table

CREATE TABLE `hangman_sessions` (
 `id` char(32) NOT NULL DEFAULT '',
 `name` varchar(255) NOT NULL,
 `modified` int(11) DEFAULT NULL,
 `lifetime` int(11) DEFAULT NULL,
 `data` text,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

config path /config/autoload/local.php
