-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3366
-- Время создания: Июл 30 2020 г., 19:51
-- Версия сервера: 8.0.19
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `php_shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `id_product` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `name`, `email`, `comment`, `id_product`) VALUES
(1, 'Алексей', 'bobrikov.spb@ya.ru', 'Крутой телефон', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

CREATE TABLE `goods` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `description` varchar(1024) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `image` varchar(128) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `price` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`id`, `name`, `title`, `description`, `image`, `price`) VALUES
(1, 'Apple iPhone Xr 128gb', 'Смартфон Apple iPhone Xr 128GB', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/1056698/img_id928265425244961193.jpeg/orig', 52990),
(2, 'Apple iPhone 11 128gb', 'Смартфон Apple iPhone 11 128GB', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/1644362/img_id7639771822857696854.png/orig', 64450),
(3, 'Apple iPphone 11 Pro Max 256gb', 'Смартфон Apple iPhone 11 Pro Max 256GB', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/1901647/img_id6102094781164549117.jpeg/orig', 108980),
(4, 'Huawei P30 Pro 8/256gb', 'Смартфон HUAWEI P30 Pro 8/256GB', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/1453843/img_id7572256930696998619.jpeg/orig', 49890),
(5, 'OnePlus 7T Pro 8/256gb', 'Смартфон OnePlus 7T Pro 8/256GB', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/1673800/img_id4964892947089529380.jpeg/orig', 47779),
(6, 'OnePlus 8 8/128gb', 'Смартфон OnePlus 8 8/128GB', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/2017291/img_id807100893314621149.png/orig ', 43650),
(7, 'Honor 30 Pro+ 8/256GB', 'Смартфон Honor 30 Pro+ 8/256GB', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/1600461/img_id72431386138343975.jpeg/orig', 54980),
(8, 'Xiaomi Mi Note 10 6/128GB', 'Смартфон Xiaomi Mi Note 10 6/128GB', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/1924580/img_id347356219384600702.png/orig', 30750),
(9, 'Samsung Galaxy S10 8/128GB', 'Смартфон Samsung Galaxy S10 8/128GB', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/2014136/img_id1876774959447677906.jpeg/orig', 36850),
(10, 'Samsung Galaxy S10+ 8/128GB', 'Смартфон Samsung Galaxy S10+ 8/128GB', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/1674591/img_id34031754996922301.jpeg/orig', 54990),
(11, 'Google Pixel 4 XL 6/128GB', 'Смартфон Google Pixel 4 XL 6/128GB', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/1545401/img_id3166910857140137379.jpeg/orig', 61320),
(12, 'Xiaomi Mi Band 4', 'Браслет Xiaomi Mi Band 4', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/1681399/img_id8867112713093477946.jpeg/orig', 2980),
(13, 'Xiaomi Mi Band 5', 'Браслет Xiaomi Mi Band 5', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/1674591/img_id7954720739800882322.jpeg/orig', 3399),
(14, 'Honor Band 5', 'Браслет Honor Band 5', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/1543318/img_id964990683551535520.jpeg/orig', 2490),
(15, 'HONOR MagicWatch 2 46mm', 'Часы HONOR MagicWatch 2 46mm', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/1680954/img_id1015335036853981239.jpeg/orig', 12990),
(16, 'Samsung Galaxy Watch Active2 алюминий 44 мм', 'Часы Samsung Galaxy Watch Active2 алюминий 44 мм', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/1926093/img_id2726895593290043033.jpeg/orig', 18082),
(17, 'Apple Watch Series 5 GPS 44mm Aluminum Case with Nike Sport Band', 'Часы Apple Watch Series 5 GPS 44mm Aluminum Case with Nike Sport Band', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/1864685/img_id656886914789012896.jpeg/orig', 34490);

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id` int NOT NULL,
  `link` varchar(100) NOT NULL,
  `id_product` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `link`, `id_product`) VALUES
(1, 'https://avatars.mds.yandex.net/get-mpic/1363071/img_id4618435699647098574.jpeg/orig', 1),
(2, 'https://avatars.mds.yandex.net/get-mpic/932277/img_id8895455767670829773.jpeg/orig', 1),
(3, 'https://avatars.mds.yandex.net/get-mpic/1056698/img_id928265425244961193.jpeg/orig', 1),
(4, 'https://avatars.mds.yandex.net/get-mpic/1644362/img_id7639771822857696854.png/orig', 2),
(5, 'https://avatars.mds.yandex.net/get-mpic/1525215/img_id2134311285036447010.jpeg/orig', 2),
(6, 'https://avatars.mds.yandex.net/get-mpic/1644362/img_id3874083265819140661.jpeg/orig', 2),
(7, 'https://avatars.mds.yandex.net/get-mpic/1862611/img_id3875664305237307428.jpeg/orig', 2),
(8, 'https://avatars.mds.yandex.net/get-mpic/1924580/img_id6208666797214031108.jpeg/orig', 3),
(9, 'https://avatars.mds.yandex.net/get-mpic/1901647/img_id6102094781164549117.jpeg/orig', 3),
(10, 'https://avatars.mds.yandex.net/get-mpic/1767083/img_id2551798935058468322.jpeg/orig', 3),
(11, 'https://avatars.mds.yandex.net/get-mpic/1707869/img_id3182441690383315907.jpeg/orig', 3),
(12, 'https://avatars.mds.yandex.net/get-mpic/1602935/img_id7572934812901580663.jpeg/orig', 4),
(13, 'https://avatars.mds.yandex.net/get-mpic/1453843/img_id7572256930696998619.jpeg/orig', 4),
(14, 'https://avatars.mds.yandex.net/get-mpic/1522540/img_id1781507115794225327.jpeg/orig', 4),
(15, 'https://avatars.mds.yandex.net/get-mpic/1525355/img_id1684064494552229080.jpeg/orig', 4),
(16, 'https://avatars.mds.yandex.net/get-mpic/1605421/img_id8198610464614109383.jpeg/orig', 4),
(17, 'https://avatars.mds.yandex.net/get-mpic/1522540/img_id5598393164660268385.jpeg/orig', 4),
(18, 'https://avatars.mds.yandex.net/get-mpic/1538707/img_id4109054992169609109.jpeg/orig', 4),
(19, 'https://avatars.mds.yandex.net/get-mpic/1767083/img_id2690075877951564612.jpeg/orig', 4),
(20, 'https://avatars.mds.yandex.net/get-mpic/1669769/img_id974825961385307961.jpeg/orig', 4),
(21, 'https://avatars.mds.yandex.net/get-mpic/1626700/img_id2025759767868684713.jpeg/orig', 4),
(22, 'https://avatars.mds.yandex.net/get-mpic/1669769/img_id6300030043864689639.jpeg/orig', 4),
(23, 'https://avatars.mds.yandex.net/get-mpic/1605421/img_id4957840606235394042.jpeg/orig', 4),
(24, 'https://avatars.mds.yandex.net/get-mpic/1644362/img_id8010136961790537898.jpeg/orig', 6),
(25, 'https://avatars.mds.yandex.net/get-mpic/2017291/img_id807100893314621149.png/orig', 6),
(26, 'https://avatars.mds.yandex.net/get-mpic/2008488/img_id983913640726536627.png/orig', 6),
(27, 'https://avatars.mds.yandex.net/get-mpic/1923922/img_id7213668051626289099.png/orig', 6),
(28, 'https://avatars.mds.yandex.net/get-mpic/1865278/img_id4876650549001608677.jpeg/orig', 7),
(29, 'https://avatars.mds.yandex.net/get-mpic/1599966/img_id7938789954716524684.jpeg/orig', 7),
(30, 'https://avatars.mds.yandex.net/get-mpic/1681399/img_id6621392622585821269.jpeg/orig', 7),
(31, 'https://avatars.mds.yandex.net/get-mpic/1733932/img_id2952585581202032095.jpeg/orig', 7),
(32, 'https://avatars.mds.yandex.net/get-mpic/1521939/img_id7549177668518958281.jpeg/orig', 7),
(33, 'https://avatars.mds.yandex.net/get-mpic/1600461/img_id72431386138343975.jpeg/orig', 7),
(34, 'https://avatars.mds.yandex.net/get-mpic/1865219/img_id5335008434261718918.jpeg/orig', 7),
(35, 'https://avatars.mds.yandex.net/get-mpic/1644362/img_id6722836631798219371.jpeg/orig', 7),
(36, 'https://avatars.mds.yandex.net/get-mpic/1713519/img_id7487680393237089657.jpeg/orig', 7),
(37, 'https://avatars.mds.yandex.net/get-mpic/1860966/img_id1775282140438705058.jpeg/orig', 7),
(38, 'https://avatars.mds.yandex.net/get-mpic/1674591/img_id34031754996922301.jpeg/orig', 10),
(39, 'https://avatars.mds.yandex.net/get-mpic/1853752/img_id786190585078100013.jpeg/orig', 10),
(40, 'https://avatars.mds.yandex.net/get-mpic/1571888/img_id3153588661565953057.jpeg/orig', 10),
(41, 'https://avatars.mds.yandex.net/get-mpic/2008455/img_id2527314961438547311.jpeg/orig', 10),
(42, 'https://avatars.mds.yandex.net/get-mpic/1926093/img_id8088554768595750936.jpeg/orig', 10),
(43, 'https://avatars.mds.yandex.net/get-mpic/1862701/img_id7422334153302033202.jpeg/orig', 10),
(44, 'https://avatars.mds.yandex.net/get-mpic/1545401/img_id3166910857140137379.jpeg/orig', 11),
(45, 'https://avatars.mds.yandex.net/get-mpic/1883514/img_id4866840576779363899.jpeg/orig', 11),
(46, 'https://avatars.mds.yandex.net/get-mpic/1554397/img_id696006308804861518.jpeg/orig', 11),
(47, 'https://avatars.mds.yandex.net/get-mpic/1992523/img_id8929047665580963762.jpeg/orig', 11),
(48, 'https://avatars.mds.yandex.net/get-mpic/1681399/img_id8867112713093477946.jpeg/orig', 12),
(49, 'https://avatars.mds.yandex.net/get-mpic/1581127/img_id6246385336054703251.jpeg/orig', 12),
(50, 'https://avatars.mds.yandex.net/get-mpic/1886039/img_id7085449214898586445.jpeg/orig', 12),
(51, 'https://avatars.mds.yandex.net/get-mpic/1924580/img_id8040921486035729704.jpeg/orig', 12),
(52, 'https://avatars.mds.yandex.net/get-mpic/1901070/img_id7042544251145214426.jpeg/orig', 12),
(53, 'https://avatars.mds.yandex.net/get-mpic/1674591/img_id7954720739800882322.jpeg/orig', 13),
(54, 'https://avatars.mds.yandex.net/get-mpic/1985106/img_id3170571162008499041.jpeg/orig', 13),
(55, 'https://avatars.mds.yandex.net/get-mpic/1673800/img_id8930996587263847910.jpeg/orig', 13),
(56, 'https://avatars.mds.yandex.net/get-mpic/1865723/img_id1983744527129108830.jpeg/orig', 13),
(57, 'https://avatars.mds.yandex.net/get-mpic/1543318/img_id964990683551535520.jpeg/orig', 14),
(58, 'https://avatars.mds.yandex.net/get-mpic/1985106/img_id5700984342455016185.jpeg/orig', 14),
(59, 'https://avatars.mds.yandex.net/get-mpic/1865271/img_id1066174896767759539.jpeg/orig', 14),
(60, 'https://avatars.mds.yandex.net/get-mpic/1597983/img_id1467995106644553962.jpeg/orig', 14),
(61, 'https://avatars.mds.yandex.net/get-mpic/1680954/img_id1015335036853981239.jpeg/orig', 15),
(62, 'https://avatars.mds.yandex.net/get-mpic/1992523/img_id4893897627747971513.jpeg/orig', 15),
(63, 'https://avatars.mds.yandex.net/get-mpic/1749547/img_id9073170114665731378.jpeg/orig', 15),
(64, 'https://avatars.mds.yandex.net/get-mpic/1865652/img_id3610312835141448992.jpeg/orig', 15),
(65, 'https://avatars.mds.yandex.net/get-mpic/1924204/img_id8165635609089490741.jpeg/orig', 15),
(66, 'https://avatars.mds.yandex.net/get-mpic/1970506/img_id8267511704062308721.jpeg/orig', 15),
(67, 'https://avatars.mds.yandex.net/get-mpic/1865652/img_id5297289203937660104.jpeg/orig', 16),
(68, 'https://avatars.mds.yandex.net/get-mpic/1926093/img_id2726895593290043033.jpeg/orig', 16),
(69, 'https://avatars.mds.yandex.net/get-mpic/1901070/img_id5535378631625859363.jpeg/orig', 16),
(70, 'https://avatars.mds.yandex.net/get-mpic/1453843/img_id4948715467920905156.jpeg/orig', 16),
(71, 'https://avatars.mds.yandex.net/get-mpic/1859063/img_id8041999258673268299.jpeg/orig', 16),
(72, 'https://avatars.mds.yandex.net/get-mpic/1525999/img_id8217794868845404044.jpeg/orig', 16),
(73, 'https://avatars.mds.yandex.net/get-mpic/1864685/img_id656886914789012896.jpeg/orig', 17),
(74, 'https://avatars.mds.yandex.net/get-mpic/1862701/img_id4112820584444860238.jpeg/orig', 17),
(75, 'https://avatars.mds.yandex.net/get-mpic/1912105/img_id1088681317430603897.jpeg/orig', 17);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `id_user` int NOT NULL,
  `status` set('Передан на обработку','Формируется к отправке','Подготовлен счет на оплату','Ждите звонка от оператора','Едет в пункт выдачи','Ожидаем поставку товара','Отменен','Готов к получению','Передан в отдел доставки','Передан курьеру','Передан в транспортную компанию','Нам не удалось с Вами связаться','Выполнен') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `id_user`, `status`) VALUES
(1, 1, 'Ждите звонка от оператора'),
(2, 1, 'Отменен');

-- --------------------------------------------------------

--
-- Структура таблицы `order_product`
--

CREATE TABLE `order_product` (
  `id_order` int NOT NULL,
  `id_product` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `order_product`
--

INSERT INTO `order_product` (`id_order`, `id_product`, `price`, `quantity`) VALUES
(1, 4, '49890.00', 2),
(1, 5, '47779.00', 1),
(2, 3, '108980.00', 1),
(2, 4, '49890.00', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `admin`) VALUES
(1, 'Анатолий', '123@ya.ru', '$2y$10$Q3nbTrKBLB/IoCm4b4E7UeYzNV1zEnsjHWz2.m9cWx/edVCaPfoEu', 0),
(2, 'Алексей', 'bobrikov.spb@ya.ru', '$2y$10$JYrZe5Wmis2iHrnFylXKcOHLfckr/wrSwYaylYFANwz1DpzaBtaGi', 1),
(3, 'Марина', '321@ya.ru', '$2y$10$fn6Ogh8J638WSlUPtSixLekLkfN7X0zOjXZFK2WXr/BJB1RSaGB7i', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_product` (`id_product`);

--
-- Индексы таблицы `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_product` (`id_product`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id_order`,`id_product`),
  ADD KEY `id_product` (`id_product`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `goods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `goods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `goods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
