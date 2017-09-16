-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 16 2017 г., 12:29
-- Версия сервера: 5.5.50
-- Версия PHP: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `eshopper_test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '57', 1502874175),
('contentManager', '66', 1502874175),
('customer', '101', 1505539616),
('customer', '103', 1505539745),
('customer', '105', 1505539882),
('customer', '107', 1505539909),
('customer', '109', 1505540002),
('customer', '57', 1503483093),
('customer', '60', 1502874175),
('customer', '61', 1502874175),
('customer', '62', 1502874175),
('customer', '67', 1502882009),
('customer', '68', 1502882354),
('customer', '69', 1502882371),
('customer', '70', 1502882549),
('customer', '71', 1502882605),
('customer', '72', 1502882637),
('customer', '73', 1502882748),
('customer', '86', 1505483742),
('customer', '87', 1505483742),
('customer', '88', 1505485250),
('customer', '89', 1505485251),
('customer', '90', 1505485378),
('customer', '91', 1505485378),
('customer', '93', 1505489756),
('customer', '95', 1505489790),
('customer', '97', 1505539418),
('customer', '99', 1505539570),
('manager', '65', 1502874175);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, NULL, NULL, NULL, 1502874175, 1502874175),
('buyGoods', 2, 'Покупка товаров', NULL, NULL, 1502874175, 1502874175),
('contentManager', 1, NULL, NULL, NULL, 1502874175, 1502874175),
('customer', 1, NULL, NULL, NULL, 1502874175, 1502874175),
('manager', 1, NULL, NULL, NULL, 1502874175, 1502874175),
('superUser', 2, 'Права супер пользователя(admin)', NULL, NULL, 1502874175, 1502874175),
('viewAdminModule', 2, 'Просмотр админки', NULL, NULL, 1502874175, 1502874175),
('workWithContent', 2, 'Работать с контентом сайта', NULL, NULL, 1502874175, 1502874175),
('workWithOrders', 2, 'Работать с заказами', NULL, NULL, 1502874175, 1502874175);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('customer', 'buyGoods'),
('manager', 'contentManager'),
('contentManager', 'customer'),
('admin', 'manager'),
('admin', 'superUser'),
('contentManager', 'viewAdminModule'),
('contentManager', 'workWithContent'),
('manager', 'workWithOrders');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `id` varchar(36) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `cart_items`
--

CREATE TABLE IF NOT EXISTS `cart_items` (
  `cart_id` varchar(36) NOT NULL,
  `product_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) NOT NULL,
  `parent_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `parent_id`, `name`, `keywords`, `description`) VALUES
(1, 0, 'Sportwear', NULL, NULL),
(2, 1, 'Nike', NULL, NULL),
(3, 1, 'Under Armour', NULL, NULL),
(4, 1, 'Adidas', NULL, NULL),
(5, 1, 'Puma', NULL, NULL),
(6, 1, 'Asics', NULL, NULL),
(7, 0, 'Mens', NULL, NULL),
(8, 7, 'Fendi', NULL, NULL),
(9, 7, 'Guess', NULL, NULL),
(10, 7, 'Valentino', NULL, NULL),
(11, 7, 'Dior', NULL, NULL),
(12, 7, 'Versage', NULL, NULL),
(13, 7, 'Armani', NULL, NULL),
(14, 7, 'Prada', NULL, NULL),
(15, 7, 'Dolce and Gabanna', NULL, NULL),
(16, 7, 'Chanel', NULL, NULL),
(17, 7, 'Gucci', NULL, NULL),
(18, 0, 'Womens', NULL, NULL),
(19, 18, 'Fendi', NULL, NULL),
(20, 18, 'Guess', NULL, NULL),
(21, 18, 'Valentino', NULL, NULL),
(22, 18, 'Dior', NULL, NULL),
(23, 18, 'Versace', NULL, NULL),
(24, 0, 'Kids', NULL, NULL),
(25, 0, 'Fashion', NULL, NULL),
(26, 0, 'Households', NULL, NULL),
(27, 0, 'Interiors', NULL, NULL),
(28, 0, 'Clothing', NULL, NULL),
(29, 0, 'Bags', NULL, NULL),
(30, 0, 'Shoes', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL,
  `filePath` varchar(400) NOT NULL,
  `itemId` int(11) DEFAULT NULL,
  `isMain` tinyint(1) DEFAULT NULL,
  `modelName` varchar(150) NOT NULL,
  `urlAlias` varchar(400) NOT NULL,
  `name` varchar(80) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `image`
--

INSERT INTO `image` (`id`, `filePath`, `itemId`, `isMain`, `modelName`, `urlAlias`, `name`) VALUES
(50, 'Products/Product2/12a5af.jpg', 2, 0, 'Product', '107acbe426-3', ''),
(51, 'Products/Product2/03e397.jpg', 2, 0, 'Product', 'cbcb471453-4', ''),
(52, 'Products/Product2/83d1d4.jpg', 2, 0, 'Product', '70a3279687-5', ''),
(57, 'Products/Product1/2e1f0d.jpg', 1, 1, 'Product', '5f8d32833a-1', ''),
(58, 'Products/Product1/81f9b4.jpg', 1, NULL, 'Product', '29d5487e4e-2', ''),
(59, 'Products/Product1/4f137b.jpg', 1, NULL, 'Product', 'a5867473cd-3', ''),
(60, 'Products/Product1/bc0cab.jpg', 1, NULL, 'Product', '1957d0bdb6-4', ''),
(61, 'Products/Product1/49edff.jpg', 1, NULL, 'Product', 'fa6e5c617c-5', ''),
(62, 'Products/Product2/3fad5a.jpg', 2, 0, 'Product', '0bd8f1c0fc-2', ''),
(63, 'Products/Product2/b1c90c.jpg', 2, 1, 'Product', 'c74a6071dc-1', ''),
(68, 'Products/Product7/25eb56.jpg', 7, 1, 'Product', '2bbc507827-1', ''),
(69, 'Products/Product7/a12807.jpg', 7, NULL, 'Product', '06c18eb8a2-2', ''),
(70, 'Products/Product7/f28aad.jpg', 7, NULL, 'Product', '7d5b215321-3', ''),
(71, 'Products/Product7/cffffd.jpg', 7, NULL, 'Product', '3dc9af5b5b-4', '');

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m140506_102106_rbac_init', 1502710064),
('m170728_102325_create_category_table', 1501745947),
('m170728_102707_create_product_table', 1501745947),
('m170728_103357_create_order_table', 1501745947),
('m170728_103431_create_order_items_table', 1501745947),
('m170728_103458_create_user_table', 1501745947),
('m170803_074421_change_columns_product_table', 1501752600),
('m170803_094514_remove_img_product_table', 1501754165),
('m170803_102605_remove_sum_item_order_items', 1501756067),
('m170803_143306_remove_fields_order', 1501948999),
('m170804_163337_create_customer_table', 1501954206),
('m170805_172806_update_order_table', 1502009505),
('m170808_092944_create_cart_table', 1502652050),
('m170808_094020_create_cart_items_table', 1502652050),
('m170812_073819_change_customer_table', 1502652050),
('m170814_093259_rename_customer_table', 1502704444);

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `qty_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `price` float unsigned NOT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `new` tinyint(1) NOT NULL DEFAULT '0',
  `hit` tinyint(1) NOT NULL DEFAULT '0',
  `sale` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `content`, `price`, `keywords`, `description`, `new`, `hit`, `sale`, `deleted`) VALUES
(1, 19, 'Платье Fendi', '<p>Состав Вискоза - 95%, Эластан - 5% Размер модели на фото 42/44 Параметры модели 80-58-88 Рост модели на фото 178 Длина 113 см Длина рукава 11 см Сезон лето Цвет розовый Узор горох, полоска Застежка без застежки Детали одежды пайетки/блестки, разрезы Артикул OO001EWUTX54</p>\r\n', 1099, '', '', 1, 1, 0, 0),
(2, 20, 'Платье Guess', '<p>О ТОВАРЕ Состав Хлопок - 100% Страна производства Россия Размер модели на фото 42/44 Параметры модели 84-61-91 Рост модели на фото 180 Длина 90 см Длина рукава 41 см Сезон мульти Цвет розовый Узор однотонный Застежка без застежки Артикул TV001EWUJW19</p>\r\n', 700, '', '', 1, 1, 1, 0),
(3, 4, 'Костюм спортивный BACK2BAS 3S TS adidas Performance', '<p>Спортивный костюм adidas Performance состоит из олимпийки и брюк, выполненных из плотного гладкого трикотажа с флисовой внутренней отделкой. Детали: олимпийка прямого кроя, застежка на молнию, боковые карманы. Брюки зауженного кроя, кулиска на талии, боковые карманы. Состав Полиэстер - 100% Страна производства Бангладеш Размер модели на фото 48 Параметры модели 100-80-95 Рост модели на фото 189 Длина 67 см Длина рукава 70 см Длина по внутреннему шву 79 см Длина по боковому шву 103 см Сезон мульти Цвет бордовый, черный Узор однотонный Застежка на молнии Вид спорта фитнес Карманы 4 Артикул AD094EMUOC91</p>\r\n', 5390, '', '', 1, 1, 1, 0),
(4, 21, 'Джемпер Dorothy Perkins', 'Джемпер Dorothy Perkins выполнен из мягкого комбинированного трикотажа. Детали: круглый вырез, длинные рукава.\r\nСостав Акрил - 100%\r\nСтрана производства Бангладеш\r\nРазмер модели на фото 42\r\nПараметры модели 80-58-88\r\nРост модели на фото 178\r\nДлина 67 см\r\nДлина рукава 67 см\r\nСезон демисезон, зима\r\nЦвет бежевый, розовый\r\nУзор однотонный\r\nЗастежка без застежки\r\nТип силуэта прямой\r\nАртикул DO005EWUQJ96', 2399, NULL, NULL, 1, 1, 1, 0),
(7, 3, 'Майка спортивная UA Favorite Knit Under Armour', '<p><strong>Майка Under Armour</strong> выполнена из легкого трикотажа.</p>\r\n\r\n<p>Зауженный крой: плотно прилегает к телу, не стесняя движения. Материал Charged Cotton&reg; дарит такой же комфорт, как натуральный хлопок, но сохнет намного быстрее. Фирменная система переноса влаги обеспечивает впитывание пота, сохраняя кожу сухой и даря ощущение легкости. Особое плетение ткани, тянущейся в 4 стороны, гарантирует отличную подвижность в любом направлении. Технология защиты от неприятного запаха гарантирует более длительное сохранение свежести. Боковые швы с накатом вперед обеспечивают создание более изящного силуэта. Классический вырез &laquo;борцовка&raquo; с плетением &laquo;резинка&raquo; на спине. Состав Хлопок - 57%, Полиэстер - 38%, Эластан - 5% Сезон мульти Цвет синий Узор однотонный Застежка без застежки Технологии Moisture Transport System&reg;, Anti-microbial , 4-Way Stretch&reg; Вид спорта фитнес Артикул UN001EGTVM73</p>\r\n', 1600, '', '', 1, 1, 1, 0),
(8, 11, 'Рубашка Dior', 'Рубашка Lonsdale с трикотажным серым капюшоном на кулиске выполнена из хлопкового зеленого текстиля в клетку. Детали: полуприлегающий крой; застежка на пуговицы; два нагрудных кармана; короткие рукава с декоративными хлястиками на пуговицах; принтованный логотип бренда на спинке и вышитый на груди; нашивка в виде флага Великобритании.\r\nСостав Хлопок - 100%\r\nМатериал подкладки Полиэстер - 65%, Хлопок - 35%\r\nРазмер модели на фото 48/50\r\nПараметры модели 100-80-95\r\nРост модели на фото 189\r\nДлина 78 см\r\nДлина рукава 25 см\r\nСезон мульти\r\nЦвет зеленый\r\nУзор клетка\r\nЗастежка на пуговицах\r\nДетали одежды вышивка, заплатки/нашивки, меланж\r\nВид спорта спорт стиль\r\nКарманы 2\r\nАртикул LO789EMEFI68\r\n', 4500, NULL, NULL, 0, 1, 0, 0),
(9, 19, 'Платье Fendi', 'Состав Вискоза - 95%, Эластан - 5%\r\nРазмер модели на фото 42/44\r\nПараметры модели 80-58-88\r\nРост модели на фото 178\r\nДлина 113 см\r\nДлина рукава 11 см\r\nСезон лето\r\nЦвет розовый\r\nУзор горох, полоска\r\nЗастежка без застежки\r\nДетали одежды пайетки/блестки, разрезы\r\nАртикул OO001EWUTX54\r\n', 1099, NULL, NULL, 1, 0, 1, 0),
(10, 19, 'Платье Fendi', 'Состав Вискоза - 95%, Эластан - 5%\r\nРазмер модели на фото 42/44\r\nПараметры модели 80-58-88\r\nРост модели на фото 178\r\nДлина 113 см\r\nДлина рукава 11 см\r\nСезон лето\r\nЦвет розовый\r\nУзор горох, полоска\r\nЗастежка без застежки\r\nДетали одежды пайетки/блестки, разрезы\r\nАртикул OO001EWUTX54\r\n', 1099, NULL, NULL, 1, 1, 1, 0),
(11, 19, 'Платье Fendi', '<p>Состав Вискоза - 95%, Эластан - 5% Размер модели на фото 42/44 Параметры модели 80-58-88 Рост модели на фото 178 Длина 113 см Длина рукава 11 см Сезон лето Цвет розовый Узор горох, полоска Застежка без застежки Детали одежды пайетки/блестки, разрезы Артикул OO001EWUTX54</p>\r\n', 1199, '', '', 0, 1, 1, 0),
(12, 19, 'Платье Fendi', 'Состав Вискоза - 95%, Эластан - 5%\r\nРазмер модели на фото 42/44\r\nПараметры модели 80-58-88\r\nРост модели на фото 178\r\nДлина 113 см\r\nДлина рукава 11 см\r\nСезон лето\r\nЦвет розовый\r\nУзор горох, полоска\r\nЗастежка без застежки\r\nДетали одежды пайетки/блестки, разрезы\r\nАртикул OO001EWUTX54\r\n', 1299, NULL, NULL, 0, 0, 0, 0),
(13, 19, 'Платье Fendi', '<p>Состав Вискоза - 95%, Эластан - 5% Размер модели на фото 42/44 Параметры модели 80-58-88 Рост модели на фото 178 Длина 113 см Длина рукава 11 см Сезон лето Цвет розовый Узор горох, полоска Застежка без застежки Детали одежды пайетки/блестки, разрезы Артикул OO001EWUTX54</p>\r\n', 1399, '', '', 1, 1, 1, 0),
(14, 19, 'Платье Fendi', 'Состав Вискоза - 95%, Эластан - 5%\r\nРазмер модели на фото 42/44\r\nПараметры модели 80-58-88\r\nРост модели на фото 178\r\nДлина 113 см\r\nДлина рукава 11 см\r\nСезон лето\r\nЦвет розовый\r\nУзор горох, полоска\r\nЗастежка без застежки\r\nДетали одежды пайетки/блестки, разрезы\r\nАртикул OO001EWUTX54\r\n', 1499, NULL, NULL, 0, 1, 1, 0),
(15, 19, 'Платье Fendi', 'Состав Вискоза - 95%, Эластан - 5%\r\nРазмер модели на фото 42/44\r\nПараметры модели 80-58-88\r\nРост модели на фото 178\r\nДлина 113 см\r\nДлина рукава 11 см\r\nСезон лето\r\nЦвет розовый\r\nУзор горох, полоска\r\nЗастежка без застежки\r\nДетали одежды пайетки/блестки, разрезы\r\nАртикул OO001EWUTX54\r\n', 1599, NULL, NULL, 0, 1, 1, 0),
(16, 19, 'Платье Fendi', 'Состав Вискоза - 95%, Эластан - 5%\r\nРазмер модели на фото 42/44\r\nПараметры модели 80-58-88\r\nРост модели на фото 178\r\nДлина 113 см\r\nДлина рукава 11 см\r\nСезон лето\r\nЦвет розовый\r\nУзор горох, полоска\r\nЗастежка без застежки\r\nДетали одежды пайетки/блестки, разрезы\r\nАртикул OO001EWUTX54\r\n', 1699, NULL, NULL, 0, 1, 1, 0),
(17, 19, 'Платье Fendi', 'Состав Вискоза - 95%, Эластан - 5%\r\nРазмер модели на фото 42/44\r\nПараметры модели 80-58-88\r\nРост модели на фото 178\r\nДлина 113 см\r\nДлина рукава 11 см\r\nСезон лето\r\nЦвет розовый\r\nУзор горох, полоска\r\nЗастежка без застежки\r\nДетали одежды пайетки/блестки, разрезы\r\nАртикул OO001EWUTX54\r\n', 1799, NULL, NULL, 0, 0, 0, 0),
(18, 19, 'Платье Fendi', 'Состав Вискоза - 95%, Эластан - 5%\r\nРазмер модели на фото 42/44\r\nПараметры модели 80-58-88\r\nРост модели на фото 178\r\nДлина 113 см\r\nДлина рукава 11 см\r\nСезон лето\r\nЦвет розовый\r\nУзор горох, полоска\r\nЗастежка без застежки\r\nДетали одежды пайетки/блестки, разрезы\r\nАртикул OO001EWUTX54\r\n', 1899, NULL, NULL, 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Индексы таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Индексы таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Индексы таблицы `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_user_id` (`user_id`);

--
-- Индексы таблицы `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_id`,`product_id`),
  ADD KEY `cart_items_product_id` (`product_id`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Индексы таблицы `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_user_id` (`user_id`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id` (`order_id`),
  ADD KEY `order_items_product_id` (`product_id`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT для таблицы `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT для таблицы `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=110;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  ADD CONSTRAINT `cart_items_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
