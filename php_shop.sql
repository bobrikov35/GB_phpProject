-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3366
-- Время создания: Июл 24 2020 г., 09:50
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
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `id_product` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `image` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `price` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`id`, `name`, `title`, `description`, `image`, `price`) VALUES
(1, 'Apple iPhone Xr 128gb', 'Смартфон Apple iPhone Xr 128GB', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/1056698/img_id928265425244961193.jpeg/orig', 52990),
(2, 'Apple iPhone 11 128gb', 'Смартфон Apple iPhone 11 128GB', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/1644362/img_id7639771822857696854.png/orig', 64450),
(3, 'Apple iPphone 11 Pro Max 256gb', 'Смартфон Apple iPhone 11 Pro Max 256GB', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/1901647/img_id6102094781164549117.jpeg/orig', 108980),
(4, 'Huawei P30 Pro 8/256gb', 'Смартфон HUAWEI P30 Pro 8/256GB', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/1453843/img_id7572256930696998619.jpeg/orig', 49890),
(5, 'OnePlus 7T Pro 8/256gb', 'Смартфон OnePlus 7T Pro 8/256GB', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/1673800/img_id4964892947089529380.jpeg/orig', 47779),
(6, 'OnePlus 8 8/128gb', 'Смартфон OnePlus 8 8/128GB', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium', 'https://avatars.mds.yandex.net/get-mpic/2017291/img_id807100893314621149.png/orig ', 43650);

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id` int NOT NULL,
  `link` varchar(100) NOT NULL,
  `id_product` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `link`, `id_product`) VALUES
(2, 'https://avatars.mds.yandex.net/get-mpic/1363071/img_id4618435699647098574.jpeg/orig', 1),
(3, 'https://avatars.mds.yandex.net/get-mpic/932277/img_id8895455767670829773.jpeg/orig', 1),
(4, 'https://avatars.mds.yandex.net/get-mpic/1056698/img_id928265425244961193.jpeg/orig', 1),
(5, 'https://avatars.mds.yandex.net/get-mpic/1644362/img_id7639771822857696854.png/orig', 2),
(6, 'https://avatars.mds.yandex.net/get-mpic/1644362/img_id3874083265819140661.jpeg/orig', 2),
(7, 'https://avatars.mds.yandex.net/get-mpic/1862611/img_id3875664305237307428.jpeg/orig', 2),
(8, 'https://avatars.mds.yandex.net/get-mpic/1525215/img_id2134311285036447010.jpeg/orig', 2),
(9, 'https://avatars.mds.yandex.net/get-mpic/1901647/img_id6102094781164549117.jpeg/orig', 3),
(10, 'https://avatars.mds.yandex.net/get-mpic/1767083/img_id2551798935058468322.jpeg/orig', 3),
(11, 'https://avatars.mds.yandex.net/get-mpic/1707869/img_id3182441690383315907.jpeg/orig', 3),
(12, 'https://avatars.mds.yandex.net/get-mpic/1924580/img_id6208666797214031108.jpeg/orig', 3),
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
(24, 'https://avatars.mds.yandex.net/get-mpic/1602935/img_id7572934812901580663.jpeg/orig', 4),
(25, 'https://avatars.mds.yandex.net/get-mpic/2017291/img_id807100893314621149.png/orig', 6),
(26, 'https://avatars.mds.yandex.net/get-mpic/2008488/img_id983913640726536627.png/orig', 6),
(27, 'https://avatars.mds.yandex.net/get-mpic/1923922/img_id7213668051626289099.png/orig', 6),
(28, 'https://avatars.mds.yandex.net/get-mpic/1644362/img_id8010136961790537898.jpeg/orig', 6);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `id_user` int NOT NULL,
  `status` set('Передан на обработку','Формируется к отправке','Подготовлен счет на оплату','Ждите звонка от оператора','Едет в пункт выдачи','Ожидаем поставку товара','Отменен','Готов к получению','Передан в отдел доставки','Передан курьеру','Передан в транспортную компанию','Нам не удалось с Вами связаться','Выполнен') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `id_user`, `status`) VALUES
(1, 1, 'Ждите звонка от оператора'),
(2, 1, 'Отменен'),
(3, 2, 'Отменен');

-- --------------------------------------------------------

--
-- Структура таблицы `order_product`
--

CREATE TABLE `order_product` (
  `id_order` int NOT NULL,
  `id_product` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `order_product`
--

INSERT INTO `order_product` (`id_order`, `id_product`, `price`, `quantity`) VALUES
(1, 4, '49890.00', 2),
(1, 5, '47779.00', 1),
(2, 3, '108980.00', 1),
(2, 4, '49890.00', 1),
(3, 1, '52990.00', 1),
(3, 5, '47779.00', 2),
(3, 6, '43650.00', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  ADD UNIQUE KEY `email` (`email`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

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
