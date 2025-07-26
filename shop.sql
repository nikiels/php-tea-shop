-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-8.0
-- Время создания: Июл 26 2025 г., 18:44
-- Версия сервера: 8.0.41
-- Версия PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `cat_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `cat_id`) VALUES
(1, 'ПУЭР', 'puer'),
(2, 'ЗЕЛЕНЫЙ ЧАЙ', 'greentea'),
(3, 'КРАСНЫЙ ЧАЙ', 'redtea'),
(4, 'БЕЛЫЙ ЧАЙ', 'whitetea'),
(5, 'ЖЕЛТЫЙ ЧАЙ', 'yellowtea'),
(6, 'ЖАСМИНОВЫЙ ЧАЙ', 'zastea'),
(7, 'ЧЕРНЫЙ ЧАЙ', 'blasktea');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `product` varchar(100) NOT NULL,
  `prod_id` int NOT NULL,
  `price` decimal(8,0) NOT NULL,
  `qty` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `s_name` varchar(100) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `post_index` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `product`, `prod_id`, `price`, `qty`, `name`, `s_name`, `phone`, `address`, `post_index`, `email`, `date`, `time`) VALUES
(11, 'Сочинский золотой чай', 22, 350, '3', 'никита', 'клаеок', '89204302091', 'Воронеж ул.45 стрелковой д. 34 кв. 24', '123425', 'niki.elshin@bk.ru', '2025-07-26', '17:59:48'),
(12, 'Тай пин хоу куй', 24, 250, '2', 'никита', 'клаеок', '89204302091', 'Воронеж ул.45 стрелковой д. 34 кв. 24', '123425', 'niki.elshin@bk.ru', '2025-07-26', '17:59:48');

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `fuldescription` text NOT NULL,
  `price` decimal(8,0) NOT NULL,
  `image` varchar(100) NOT NULL,
  `cat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `title`, `description`, `fuldescription`, `price`, `image`, `cat`) VALUES
(17, 'вапвап', 'фыаываыва', 'йный клуб «ЧаЕ» приглашает Вас на теплые и созерцательные китайские церемонии, в которых соблюдаются древние традиционные правила их проведения: чай подается в специальной посуде, заваривается в гайвани или в авторском чайничке из исинской глины. Здесь Вы сможете познакомиться с более 200 видами чая и трав. Их можно не только продегустировать, но и купить в любом количестве. Для любителей долгих прогулок на свежем воздухе есть возможность взять чай с собой в крафтовом стаканчике. Наши чайные мастера с удовольствием посвятят Вас в секреты китайского и тайваньского чая, раскрывая тонкости вкуса и аромата. ', 123, '1.jpg', 'puer'),
(19, 'Цзинмай гушу бай ча', 'Гора Цзинмай Шань (кит. 景迈山) является родиной чая и одной из шести главных чайных гор Китая.', 'Чай из Цзинмай — результат уникального микроклимата и вековой традиции чайного земледелия. Вкус готового чая нежный, воздушный, с мягкой терпкостью и естественной сладостью, напоминающей молодые ягоды и лесные цветы. Послевкусие — долгое, с лёгкой свежестью и мимолётной сладостью, характерной для чая из Цзинмай. Чай создаёт ощущение легкости и внутреннего баланса. Он мягко очищает ум, освежает тело и помогает расслабиться.', 456, 'prod_6884e36f8bf88.jpg', 'whitetea'),
(20, 'Ешэн Я бао', 'Ешэн Я бао', 'Чай — это не только вкусный и ароматный напиток, но и мощное средство, обладающее множеством полезных свойств. Одним из наиболее важных аспектов его воздействия на организм являются противомикробные и противогрибковые свойства', 342, 'prod_6884e3b2c499a.jpg', 'greentea'),
(21, 'Цзянсу Би ло чунь', 'Цзянсу Би Ло Чунь (кит. 江苏碧螺春, пиньинь: Jiāngsū bìluóchūn) – один из самых известных и почитаемых зеленых чаев Китая. Его название переводится как \"Изумрудные спирали весны\" и прекрасно отражает его внешний вид и время сбора.', 'Этот чай родом из провинции Цзянсу, в основном выращивается вокруг озера Тайху. Благоприятный климат и богатая почва этого региона создают идеальные условия для выращивания чайных кустов, которые дают нежный и ароматный лист.\r\n\r\nИстория Би Ло Чунь уходит корнями в глубокую древность. Существует множество легенд, связанных с его происхождением. Одна из самых известных гласит, что чай был обнаружен случайно монахом, который заметил, что молодые чайные побеги свернулись в спиральки под воздействием утренней росы.', 400, 'prod_6884e3e88701b.jpg', 'puer'),
(22, 'Сочинский золотой чай', 'Российский чай \"Сочинский золотой чай\" (Обработан по технологии шэн пуэров)', '\"Сочинский золотой чай\" — это уникальный российский чай, произведенный из дикорастущих чайных кустов, которые произрастают в горах Черноморского предгорья на территории Сочинского Природного Биосферного Заповедника. Этот чай обработан по технологии шэн пуэров, что придает ему насыщенный вкус, глубокий аромат и уникальную энергетику. Рассыпная форма чая и его внешний вид напоминают красный чай, что делает его весьма необычным и привлекательным для ценителей чайного искусства.', 350, 'prod_6884e415c16ec.jpg', 'puer'),
(23, 'Аньцзи бай ча 2', 'Происхождение: уезд Аньцзи (кит. 安吉县, пиньинь ānjí xiàn), городской округ Хучжоу (кит. 湖州, пиньинь húzhōu), провинция Чжэцзян (кит. 浙江省, пиньинь zhèjiāng shěng).', 'Вероятно именно этот зеленый чай высоко оценивал император династии Сун Хуэйцзун в своём \"Трактате о чае\" (1107 год), описывая его как \"зелёный чай цвета белого нефрита\". Такая метафора объясняется тем, что при зимних температурах (−10 ˚С) в чайном кусте вырабатывается мало хлорофилла, а сбор как раз осуществляется ранней весной в течение 30 дней до потепления, когда листья начнут зеленеть.', 660, 'prod_6884e448bc812.jpg', 'puer'),
(24, 'Тай пин хоу куй', 'ай пин хоу куй – один из наиболее известных сортов китайского чая, который ценится не только в этой стране, но и во всем мире. Его второе название', 'Впервые сорт Тай пин хоу куй был выделен в 1900 году из лезвийных чаев. Династия Цин обладала рядом чаепроизводящих фирм, которые специализировались на лезвийных сортах. Одной из них была Цзяннаньчунь. Именно здесь для производства напитка использовались отборные сорта, произрастающие в уезде Тайпин.', 250, 'prod_6884e4736604e.jpg', 'puer'),
(25, 'Люань гуапянь', 'Cлабоферментированный зеленый чай Лю Ань Гуа Пянь (кит. 六安瓜片, пиньин lù’ān guāpiān) собирают в провинции Аньхой, в префектуре Люань уезда Цзиньчжай.', 'Происхождение данного сорта относят к эпохе династии Мин, существовавшей с 1368 по 1644 год. Книга по ведению сельского хозяйства того времени упоминает Лю Ань Гуа Пянь как самый лучший чайный напиток. Он удостоился высокой оценки со стороны знатных вельмож и ученых, приближенных к императору. Согласно историческим сведениям, императрица Цыси из династии Цин отдавала предпочтение данному сорту и употребляла около 700 грамм продукта в течение месяца.', 349, 'prod_6884e49e6a9e1.jpg', 'puer');

-- --------------------------------------------------------

--
-- Структура таблицы `table_reviews`
--

CREATE TABLE `table_reviews` (
  `reviews_id` int NOT NULL,
  `product_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `good_reviews` text NOT NULL,
  `bad_reviews` text NOT NULL,
  `comment` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `s_name` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `admin` tinyint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `s_name`, `username`, `email`, `password`, `admin`) VALUES
(4, 'Никита', 'Ельшин', 'Nikita', 'nikita.elshi@bk.ru', '$2y$10$IdIkL1JJBGRNCY/QO6.5pOMwbTAy184oN8nlSHHzSTdt5/iZMRZoW', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `table_reviews`
--
ALTER TABLE `table_reviews`
  ADD PRIMARY KEY (`reviews_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
