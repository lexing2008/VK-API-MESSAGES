-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 30 2019 г., 15:45
-- Версия сервера: 5.5.62
-- Версия PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `vk_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `conversations`
--

CREATE TABLE `conversations` (
  `id` int(10) NOT NULL,
  `peer_id` int(10) NOT NULL,
  `response_time` int(10) NOT NULL,
  `date_first_message` int(10) NOT NULL,
  `date_response` int(10) NOT NULL DEFAULT '0',
  `status_messages` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date_first_message` (`date_first_message`),
  ADD KEY `response_time` (`response_time`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
