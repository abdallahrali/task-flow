-- Table structure for table `users`

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `tasks`

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `descriptions` text DEFAULT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- random ah user, i honestly do not know
INSERT INTO `tasks` (`id`, `user_id`, `title`, `descriptions`, `is_completed`, `created_at`) VALUES ('21321', '54654', 'sdfsdfs', 'sdfsdfsdfds', '0', CURRENT_TIMESTAMP);

-- users mock data
insert into users (username, email, password) values ('ftaberner0', 'mabramchik0@amazonaws.com', 'vV6/bqPyXB');
insert into users (username, email, password) values ('ebrockest1', 'fhoggetts1@walmart.com', 'zL5$6!S8eP)0');
insert into users (username, email, password) values ('giskowitz2', 'dgallaccio2@cornell.edu', 'dZ6<suH9''yg6*S1');
insert into users (username, email, password) values ('nmolyneaux3', 'eeichmann3@scribd.com', 'wK5?yS4uhmQ>');
insert into users (username, email, password) values ('cbezemer4', 'lfoot4@yolasite.com', 'hY9+p@WG7p');
insert into users (username, email, password) values ('jshortall5', 'bgoodban5@tinypic.com', 'zP2*P|=j');
insert into users (username, email, password) values ('miorns6', 'kgrimme6@elegantthemes.com', 'tD9}sSQHfU9~');
insert into users (username, email, password) values ('hstratton7', 'lhollows7@naver.com', 'nK8>F.j\EGPH5$(c');
insert into users (username, email, password) values ('gfrew8', 'nstrafen8@delicious.com', 'eO3"w>wTKcZe#');
insert into users (username, email, password) values ('cmoncreiffe9', 'gstother9@salon.com', 'kJ3?()>C(');
insert into users (username, email, password) values ('lplumsteada', 'cferrierioa@mayoclinic.com', 'mZ1@jdkv)1RAE0');
