CREATE TABLE `users` (
  `user_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

CREATE TABLE `stories` (
  `story_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` smallint(5) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `story` text NOT NULL,
  `author` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`story_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `stories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

CREATE TABLE `comments` (
  `comment_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `story_id` smallint(5) unsigned NOT NULL,
  `user_id` smallint(5) unsigned NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment` text NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `story_id` (`story_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `stories` (`story_id`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;