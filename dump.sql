-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Янв 15 2020 г., 21:52
-- Версия сервера: 5.7.23-24
-- Версия PHP: 5.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `smm`
--

-- --------------------------------------------------------

--
-- Структура таблицы `queue`
--

CREATE TABLE IF NOT EXISTS `queue` (
  `id` int(11) NOT NULL,
  `channel` varchar(255) NOT NULL,
  `job` blob NOT NULL,
  `pushed_at` int(11) NOT NULL,
  `ttr` int(11) NOT NULL,
  `delay` int(11) NOT NULL DEFAULT '0',
  `priority` int(11) unsigned NOT NULL DEFAULT '1024',
  `reserved_at` int(11) DEFAULT NULL,
  `attempt` int(11) DEFAULT NULL,
  `done_at` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `uni_select`
--

CREATE TABLE IF NOT EXISTS `uni_select` (
  `uni_select_id` int(10) unsigned NOT NULL,
  `select_name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `uni_select`
--

INSERT INTO `uni_select` (`uni_select_id`, `select_name`) VALUES
(9, 'Нелюбин Юрий, 25 лет, Пермь, Olymp59'),
(10, 'Шилов Александр, 26 лет, Пермь'),
(11, 'Александр Михайлов, vegetarianskie_nishtyaki'),
(12, 'ЖК Олимп Нелюбин Юрий 26 лет'),
(13, 'Нелюбин Тест');

-- --------------------------------------------------------

--
-- Структура таблицы `uni_select_attr`
--

CREATE TABLE IF NOT EXISTS `uni_select_attr` (
  `uni_select_attr_id` int(10) unsigned NOT NULL,
  `uni_select_id` int(10) unsigned NOT NULL,
  `attr_type_id` int(10) unsigned NOT NULL,
  `nval` double DEFAULT NULL,
  `cval` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `uni_select_attr`
--

INSERT INTO `uni_select_attr` (`uni_select_attr_id`, `uni_select_id`, `attr_type_id`, `nval`, `cval`) VALUES
(30, 9, 1, NULL, 'Нелюбин Юрий'),
(31, 9, 2, 1, NULL),
(32, 9, 3, 110, NULL),
(33, 9, 4, 0, NULL),
(34, 9, 5, 0, NULL),
(35, 9, 6, 25, NULL),
(36, 9, 7, 25, NULL),
(37, 9, 8, 134614353, NULL),
(38, 10, 1, NULL, 'Шилов александр'),
(39, 10, 2, 1, NULL),
(40, 10, 3, 110, NULL),
(41, 10, 4, 0, NULL),
(42, 10, 5, 0, NULL),
(43, 10, 6, 27, NULL),
(44, 10, 7, 27, NULL),
(45, 11, 1, NULL, 'Александр Михайлов'),
(46, 11, 4, 0, NULL),
(47, 11, 5, 0, NULL),
(48, 11, 8, 40105770, NULL),
(49, 12, 1, NULL, 'Нелюбин Юрий'),
(50, 12, 2, 1, NULL),
(51, 12, 3, 110, NULL),
(52, 12, 4, 2, NULL),
(53, 12, 5, 0, NULL),
(54, 12, 6, 26, NULL),
(55, 12, 7, 26, NULL),
(56, 12, 8, 134614353, NULL),
(57, 13, 1, NULL, 'Нелюбин Юрий'),
(58, 13, 2, 1, NULL),
(59, 13, 3, 110, NULL),
(60, 13, 4, 2, NULL),
(61, 13, 5, 0, NULL),
(62, 13, 6, 25, NULL),
(63, 13, 7, 27, NULL),
(64, 13, 8, 134614353, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `uni_select_attr_type`
--

CREATE TABLE IF NOT EXISTS `uni_select_attr_type` (
  `attr_type_id` int(10) unsigned NOT NULL,
  `attr_type_name` varchar(15) NOT NULL,
  `attr_type_str_id` varchar(15) NOT NULL COMMENT 'Строковый id типа'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `uni_select_attr_type`
--

INSERT INTO `uni_select_attr_type` (`attr_type_id`, `attr_type_name`, `attr_type_str_id`) VALUES
(1, 'Username', 'q'),
(2, 'Country', 'country'),
(3, 'City', 'city'),
(4, 'Sex', 'sex'),
(5, 'Status', 'status'),
(6, 'Age From', 'age_from'),
(7, 'Age To', 'age_to'),
(8, 'Group', 'group_id');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `channel` (`channel`),
  ADD KEY `reserved_at` (`reserved_at`),
  ADD KEY `priority` (`priority`);

--
-- Индексы таблицы `uni_select`
--
ALTER TABLE `uni_select`
  ADD PRIMARY KEY (`uni_select_id`);

--
-- Индексы таблицы `uni_select_attr`
--
ALTER TABLE `uni_select_attr`
  ADD PRIMARY KEY (`uni_select_attr_id`),
  ADD KEY `uni_select_id` (`uni_select_id`),
  ADD KEY `attr_type_id` (`attr_type_id`);

--
-- Индексы таблицы `uni_select_attr_type`
--
ALTER TABLE `uni_select_attr_type`
  ADD PRIMARY KEY (`attr_type_id`),
  ADD UNIQUE KEY `attr_type_str_id` (`attr_type_str_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT для таблицы `uni_select`
--
ALTER TABLE `uni_select`
  MODIFY `uni_select_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT для таблицы `uni_select_attr`
--
ALTER TABLE `uni_select_attr`
  MODIFY `uni_select_attr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT для таблицы `uni_select_attr_type`
--
ALTER TABLE `uni_select_attr_type`
  MODIFY `attr_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `uni_select_attr`
--
ALTER TABLE `uni_select_attr`
  ADD CONSTRAINT `fk_sel_attr` FOREIGN KEY (`uni_select_id`) REFERENCES `uni_select` (`uni_select_id`),
  ADD CONSTRAINT `fk_sel_attr_type` FOREIGN KEY (`attr_type_id`) REFERENCES `uni_select_attr_type` (`attr_type_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
