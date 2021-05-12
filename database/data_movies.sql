-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2021 at 09:37 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_movie`
--

-- --------------------------------------------------------

--
-- Table structure for table `actors`
--

CREATE TABLE `actors` (
  `id` int(10) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `actors`
--

INSERT INTO `actors` (`id`, `first_name`, `last_name`, `gender`) VALUES
(4, 'Morgan', 'Freeman', 'male'),
(6, 'Keanu', 'Reaves', 'male'),
(10, 'Christain', 'Bale', 'male'),
(11, 'Marlon', 'Brando', 'male'),
(12, 'Al', 'Pacino', 'male'),
(13, 'Tom', 'Hanks', 'male'),
(14, 'Brad', 'Pitt', 'male'),
(15, 'Liam', 'Neeson', 'male'),
(17, 'Russell', 'Crowe', 'male'),
(19, 'Johny', 'Depp', 'male'),
(20, 'George', 'Kosturos', 'male'),
(21, 'Vin', 'Diesel', 'male');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `username`, `email`, `password`) VALUES
(8, 'Pedro Ordonez', 'pedroo', 'pedroordonez@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(9, 'John', 'Doe', '1234@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Top Rated'),
(2, 'Most Popular'),
(3, 'Top Box Office'),
(4, 'In Theatres'),
(15, 'Coming Soon');

-- --------------------------------------------------------

--
-- Table structure for table `directors`
--

CREATE TABLE `directors` (
  `id` int(10) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `directors`
--

INSERT INTO `directors` (`id`, `first_name`, `last_name`) VALUES
(5, 'Frank', 'Darabont'),
(6, 'Robert', 'Zemeckis'),
(7, 'Ilya', 'Naishuller'),
(8, 'Simon', 'McQuoid'),
(9, 'Adam', 'Wingard'),
(10, 'Edgar', 'Wright'),
(11, 'Francis', 'Ford Coppola'),
(12, 'Christopher', 'Nolan'),
(14, 'Ridley', 'Scott'),
(16, 'Justin', 'Lin'),
(17, 'Shaun Paul', 'Piccinino');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Drama 1'),
(2, 'Crime'),
(3, 'Action'),
(4, 'Biography '),
(5, 'Western'),
(6, 'Comedy'),
(7, 'Sci-FI'),
(9, 'Romance '),
(10, 'Thriller'),
(11, 'Mystery'),
(12, 'Animation'),
(13, 'Adventure'),
(14, 'Superhero');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) NOT NULL,
  `userId` int(10) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `userId`, `subject`, `message`) VALUES
(11, 7, 'Regarding movies', 'What is the best movie?');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `rating` varchar(255) NOT NULL,
  `rank` float(10,2) NOT NULL,
  `runtime` varchar(255) NOT NULL,
  `release_date` date NOT NULL,
  `summary` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `rating`, `rank`, `runtime`, `release_date`, `summary`, `image`) VALUES
(13, 'The Shawshank Redemption', 'R', 9.40, '2h 55min', '1999-10-15', 'Two imprisoned men bond over a number of years, finding solace \r\n    and eventual redemption through acts of common decency.', 'upload/e8b0ac72c4.jpg'),
(15, 'Forrest Gump', 'PG-13', 8.80, '2h 32min', '1994-07-07', 'The presidencies of Kennedy and Johnson, the Vietnam War, the Watergate scandal and other historical events unfold from the perspective of an Alabama man with an IQ of 75, whose only desire is to be reunited with his childhood sweetheart.', 'upload/a33c7ffa54.jpg'),
(16, 'The Matrix', 'R', 8.70, '2h 32min', '1999-10-15', 'When a beautiful stranger leads computer hacker Neo to a forbidding underworld, he discovers the shocking truth--the life he knows is the elaborate deception of an evil cyber-intelligence. He then figures out the truth.', 'upload/7f19ce5b58.jpg'),
(18, 'The GodFather', 'R', 9.60, '2h 56min', '1972-03-24', 'An organized crime dynasty\'s aging patriarch transfers control of his clandestine empire to his reluctant son.         ..', 'upload/98b6f19eab.jpg'),
(19, '12 Angry Men', 'Approved', 8.90, '1h 36min', '1957-04-01', 'A jury holdout attempts to prevent a miscarriage of justice by\r\n     forcing his colleagues to reconsider the evidence.', 'upload/afbe024987.jpg'),
(20, 'The Dark Knight', 'PG-13', 9.00, '2h 32min', '2008-07-18', 'When the menace known as the Joker wreaks havoc and chaos on\r\n    the people of Gotham, Batman must accept one of the greatest psychological \r\n    and physical tests of his ability to fight injustice.', 'upload/464b202ce5.jpg'),
(21, 'The Good, The Bad and The Ugly', 'R', 8.90, '2h 58m', '1967-12-29', 'A bounty hunting scam joins two men in an uneasy alliance \r\n    against a third in a race to find a fortune in gold buried in a remote cemetery.', 'upload/b7571c4de2.jpg'),
(22, 'The Lord of the Rings: The Return of the King', 'R', 8.90, '3h 21m', '2003-12-17', 'Gandalf and Aragorn lead the World of Men against Sauron\'s army \r\n    to draw his gaze from Frodo and Sam as they approach Mount Doom with the One Ring', 'upload/68a8cde426.jpg'),
(23, 'The GodFather: Part II', 'R', 9.00, '3h 22min', '1974-12-18', 'The early life and career of Vito Corleone in 1920s New York City is \r\n    portrayed, while his son, Michael, expands and tightens his grip on the family crime \r\n    syndicate', 'upload/a96121af44.jpg'),
(24, 'The Lord of The Rings: The Fellowship of the Ring', 'PG-13', 8.80, '2h 58min', '2001-12-19', 'A meek Hobbit from the Shire and eight companions set out on a \r\n    journey to destroy the powerful One Ring and save Middle-earth from the \r\n    Dark Lord Sauron.', 'upload/8816a9c849.jpg'),
(25, 'Fight Club', 'R', 9.10, '2h 19min', '1999-10-15', 'An insomniac office worker and a devil-may-care soapmaker form an underground fight club that evolves into something much, much more.', 'upload/1f6fa8ea59.jpg'),
(26, 'Schindlers List', 'R', 8.70, '3h 15min', '1994-10-14', 'In German-occupied Poland during World War II, industrialist \r\n    Oskar Schindler gradually becomes concerned for his Jewish workforce after\r\n     witnessing their persecution by the Nazis.', 'upload/63543fc13a.jpg'),
(27, 'Mortal Kombat', 'R', 6.30, '1h 50min', '2021-04-23', 'MMA fighter Cole Young seeks out Earth\'s greatest champions in order to stand against the enemies of Outworld in a high stakes battle for the universe.', 'upload/ead0d1b1f2.jpg'),
(28, 'Nobody', 'R', 7.40, '1h 32min', '2021-03-26', 'A bystander who intervenes to help a woman being harassed by a group of men becomes the target of a vengeful drug lord.', 'upload/4c7641993d.jpg'),
(29, 'Godzilla vs. Kong', 'PG-13', 6.50, '1h 53min', '2021-03-31', 'The epic next chapter in the cinematic Monsterverse pits two of the greatest icons in motion picture history against one another - the fearsome Godzilla and the mighty Kong - with humanity caught in the balance.', 'upload/9fb7130b70.jpg'),
(30, 'Scott Pilgrim vs. the World', 'PG-13', 7.50, 'PG-13', '2010-08-13', 'In a magically realistic version of Toronto, a young man must defeat his new girlfriend\'s seven evil exes one by one in order to win her heart.', 'upload/f8fe284e2e.jpg'),
(32, 'Gladiator', 'R', 8.50, '2h 35min', '2000-05-05', 'A former Roman General sets out to exact vengeance against the corrupt emperor who murdered his family and sent him into slavery.', 'upload/2b395801be.jpg'),
(39, 'American Fighter', 'R', 6.00, '1h 38min', '2021-05-21', 'In this gritty action tale, a young wrestler competes in the world of underground fighting to raise money for his ailing mother. But will he survive his next match?', 'upload/9ffc8b56e5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `movies_categories`
--

CREATE TABLE `movies_categories` (
  `id` int(10) NOT NULL,
  `movie_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `movies_categories`
--

INSERT INTO `movies_categories` (`id`, `movie_id`, `category_id`) VALUES
(2, 13, 1),
(5, 16, 1),
(11, 18, 1),
(12, 19, 1),
(13, 20, 1),
(15, 22, 1),
(16, 23, 1),
(17, 24, 1),
(18, 25, 1),
(19, 26, 1),
(21, 28, 2),
(22, 29, 2),
(23, 30, 2),
(24, 13, 2),
(26, 32, 1),
(27, 29, 1),
(29, 27, 2),
(36, 39, 15),
(37, 28, 4),
(38, 18, 4);

-- --------------------------------------------------------

--
-- Table structure for table `movies_directors`
--

CREATE TABLE `movies_directors` (
  `id` int(10) NOT NULL,
  `movie_id` int(10) NOT NULL,
  `director_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `movies_directors`
--

INSERT INTO `movies_directors` (`id`, `movie_id`, `director_id`) VALUES
(2, 15, 6),
(4, 28, 7),
(5, 27, 8),
(6, 29, 9),
(7, 30, 10),
(8, 18, 11),
(9, 23, 11),
(10, 20, 12),
(11, 32, 14),
(17, 13, 5);

-- --------------------------------------------------------

--
-- Table structure for table `movies_genres`
--

CREATE TABLE `movies_genres` (
  `id` int(11) NOT NULL,
  `movie_id` int(10) NOT NULL,
  `genre_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `movies_genres`
--

INSERT INTO `movies_genres` (`id`, `movie_id`, `genre_id`) VALUES
(2, 13, 1),
(4, 15, 1),
(7, 16, 7),
(9, 18, 2),
(10, 19, 2),
(11, 20, 3),
(12, 21, 5),
(13, 22, 3),
(14, 23, 2),
(15, 24, 1),
(16, 25, 1),
(18, 23, 3),
(19, 16, 3),
(20, 27, 3),
(22, 29, 7),
(23, 30, 3),
(25, 32, 3),
(26, 25, 3),
(33, 39, 3),
(34, 18, 3);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) NOT NULL,
  `movie_id` int(10) NOT NULL,
  `actor_id` int(10) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `movie_id`, `actor_id`, `role`) VALUES
(5, 16, 6, 'Neo'),
(6, 20, 10, 'Batman'),
(7, 18, 11, 'Don Vito Corleone'),
(8, 23, 12, 'Michael'),
(9, 18, 12, 'Michael'),
(10, 15, 13, 'Forrest Gump'),
(11, 25, 14, 'Tyler Durden'),
(12, 26, 15, 'Oskar Schindler'),
(14, 32, 17, 'Maximus'),
(21, 13, 4, 'Ellis Boyd'),
(22, 18, 4, 'Morgan');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `l_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `city` varchar(30) NOT NULL,
  `zip` varchar(30) NOT NULL,
  `country` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `f_name`, `l_name`, `username`, `email`, `password`, `city`, `zip`, `country`) VALUES
(7, 'Pedro', 'Ordonez III', 'pedroordonez', 'eproject675@gmail.com', '$2y$10$eMa3eAeB7Ry0GPwiEgkdaO.Vdx1oJF3.RZCi6ysrcRDiI4CSXYHLC', 'Hays', '67601', 'United States'),
(10, 'John', 'Doe', 'jdoe', 'jdoe@gmail.com', '$2y$10$tu.unKYAoeqSp8EKQVFgC./6oa1M.7PFR1pfPsjEuzRfZ1zJLCyly', 'Hays', '67601', 'United States');

-- --------------------------------------------------------

--
-- Table structure for table `user_ratings`
--

CREATE TABLE `user_ratings` (
  `id` int(10) NOT NULL,
  `userId` int(10) NOT NULL,
  `movieId` int(10) NOT NULL,
  `rating` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_watchlater`
--

CREATE TABLE `user_watchlater` (
  `id` int(10) NOT NULL,
  `userId` int(10) NOT NULL,
  `movieId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_watchlater`
--

INSERT INTO `user_watchlater` (`id`, `userId`, `movieId`) VALUES
(8, 10, 13),
(9, 10, 22),
(16, 7, 13);

-- --------------------------------------------------------

--
-- Table structure for table `user_watchlists`
--

CREATE TABLE `user_watchlists` (
  `id` int(10) NOT NULL,
  `userId` int(10) NOT NULL,
  `movieId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_watchlists`
--

INSERT INTO `user_watchlists` (`id`, `userId`, `movieId`) VALUES
(70, 10, 13),
(71, 10, 18),
(72, 10, 29),
(73, 10, 25),
(83, 7, 16),
(85, 7, 25),
(86, 7, 18),
(88, 7, 29),
(89, 7, 19);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actors`
--
ALTER TABLE `actors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `directors`
--
ALTER TABLE `directors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movies_categories`
--
ALTER TABLE `movies_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_idfk2` (`movie_id`),
  ADD KEY `category_idfk1` (`category_id`);

--
-- Indexes for table `movies_directors`
--
ALTER TABLE `movies_directors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movies_idkf4` (`movie_id`),
  ADD KEY `directors_idfk1` (`director_id`);

--
-- Indexes for table `movies_genres`
--
ALTER TABLE `movies_genres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_idfk1` (`movie_id`),
  ADD KEY `genre_idfk1` (`genre_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_idfk3` (`movie_id`),
  ADD KEY `actor_id1` (`actor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_ratings`
--
ALTER TABLE `user_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `movieId` (`movieId`);

--
-- Indexes for table `user_watchlater`
--
ALTER TABLE `user_watchlater`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `movieId` (`movieId`);

--
-- Indexes for table `user_watchlists`
--
ALTER TABLE `user_watchlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `movieId` (`movieId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actors`
--
ALTER TABLE `actors`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `directors`
--
ALTER TABLE `directors`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `movies_categories`
--
ALTER TABLE `movies_categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `movies_directors`
--
ALTER TABLE `movies_directors`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `movies_genres`
--
ALTER TABLE `movies_genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_ratings`
--
ALTER TABLE `user_ratings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_watchlater`
--
ALTER TABLE `user_watchlater`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_watchlists`
--
ALTER TABLE `user_watchlists`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `movies_categories`
--
ALTER TABLE `movies_categories`
  ADD CONSTRAINT `category_idfk1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `movie_idfk2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);

--
-- Constraints for table `movies_directors`
--
ALTER TABLE `movies_directors`
  ADD CONSTRAINT `directors_idfk1` FOREIGN KEY (`director_id`) REFERENCES `directors` (`id`),
  ADD CONSTRAINT `movies_idkf4` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);

--
-- Constraints for table `movies_genres`
--
ALTER TABLE `movies_genres`
  ADD CONSTRAINT `genre_idfk1` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`),
  ADD CONSTRAINT `movie_idfk1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `actor_id1` FOREIGN KEY (`actor_id`) REFERENCES `actors` (`id`),
  ADD CONSTRAINT `movie_idfk3` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);

--
-- Constraints for table `user_ratings`
--
ALTER TABLE `user_ratings`
  ADD CONSTRAINT `user_ratings_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_ratings_ibfk_2` FOREIGN KEY (`movieId`) REFERENCES `movies` (`id`);

--
-- Constraints for table `user_watchlater`
--
ALTER TABLE `user_watchlater`
  ADD CONSTRAINT `user_watchlater_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_watchlater_ibfk_2` FOREIGN KEY (`movieId`) REFERENCES `movies` (`id`);

--
-- Constraints for table `user_watchlists`
--
ALTER TABLE `user_watchlists`
  ADD CONSTRAINT `user_watchlists_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_watchlists_ibfk_2` FOREIGN KEY (`movieId`) REFERENCES `movies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
