-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 20 Mar 2023, 19:30
-- Wersja serwera: 10.4.21-MariaDB
-- Wersja PHP: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `week_planer`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `plans`
--

CREATE TABLE `plans` (
  `plan_id` int(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `plans`
--

INSERT INTO `plans` (`plan_id`, `name`) VALUES
(1, 'Testowy plan');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(255) NOT NULL,
  `plan_id` int(255) DEFAULT NULL,
  `owner_id` int(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `day` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `tasks`
--

INSERT INTO `tasks` (`task_id`, `plan_id`, `owner_id`, `name`, `description`, `day`, `date`, `status`, `type`) VALUES
(15, 1, 3, 'test', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque eleifend gravida sem, in euismod sapien luctus eu. Nam non consequat magna, id vestibulum lectus. Duis ullamcorper mauris vitae ipsum pretium blandit. Etiam vestibulum mauris ', 'Tuesday', '2023-03-14', 0, 'Basic');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `join_date` date DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`user_id`, `name`, `surname`, `email`, `password`, `join_date`, `avatar`) VALUES
(1, 'John', 'Kołodziej', 'jankolodziej99@gmail.com', '$2y$10$hVA0g/7vHNB5Je3HbylDb.Q1/NjlCcBNXI5lEAuUOJ2ZFzjXXVrPG', '2023-02-24', 'avatar_1.jpeg'),
(2, 'Ola', 'Kelner', 'ola2406@gmail.com', '$2y$10$hVA0g/7vHNB5Je3HbylDb.Q1/NjlCcBNXI5lEAuUOJ2ZFzjXXVrPG', '2023-02-24', NULL),
(3, 'Test', 'Test', 'test@gmail.com', '$2y$10$hVA0g/7vHNB5Je3HbylDb.Q1/NjlCcBNXI5lEAuUOJ2ZFzjXXVrPG', '2023-02-24', '951351'),
(4, 'Renata', 'Krezel', 'renia@gmail.com', '$2y$10$jqG.tfOT2oI2jRXyYcZva.ovNbFJvCjLg6OZ7DI5ybsOFKn0YigaS', '2023-03-18', '951351');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users_in_plan`
--

CREATE TABLE `users_in_plan` (
  `id` int(255) NOT NULL,
  `plan_id` int(255) DEFAULT NULL,
  `user_id` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users_in_plan`
--

INSERT INTO `users_in_plan` (`id`, `plan_id`, `user_id`) VALUES
(1, 1, 2),
(16, 1, 1),
(25, 1, 3);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indeksy dla tabeli `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `plan_id` (`plan_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indeksy dla tabeli `users_in_plan`
--
ALTER TABLE `users_in_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plan_id` (`plan_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `plans`
--
ALTER TABLE `plans`
  MODIFY `plan_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `users_in_plan`
--
ALTER TABLE `users_in_plan`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `users_in_plan`
--
ALTER TABLE `users_in_plan`
  ADD CONSTRAINT `users_in_plan_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`plan_id`),
  ADD CONSTRAINT `users_in_plan_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
