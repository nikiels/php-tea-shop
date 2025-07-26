# Интернет-магазин чая "GREEN TEA"

Проект функционального интернет-магазина, разработанный на чистом PHP в рамках дипломной работы. Включает в себя клиентскую часть (витрину) и административную панель для управления контентом. Этот репозиторий демонстрирует навыки работы с PHP, MySQL, CSS-фреймворками и принципами безопасной веб-разработки.

---

### 🎨 Галерея проекта

<table>
  <tr>
    <td align="center"><strong>Главная страница</strong></td>
    <td align="center"><strong>Страница категории</strong></td>
    <td align="center"><strong>Карточка товара</strong></td>
  </tr>
  <tr>
    <td><a href="https://github.com/nikiels/php-tea-shop/blob/main/showcase-01-main.PNG"><img src="https://github.com/nikiels/php-tea-shop/blob/main/showcase-01-main.PNG" alt="Главная страница"></a></td>
    <td><a href="https://github.com/nikiels/php-tea-shop/blob/main/showcase-02-category.PNG"><img src="https://github.com/nikiels/php-tea-shop/blob/main/showcase-02-category.PNG" alt="Страница категории"></a></td>
    <td><a href="https://github.com/nikiels/php-tea-shop/blob/main/showcase-03-product.PNG"><img src="https://github.com/nikiels/php-tea-shop/blob/main/showcase-03-product.PNG" alt="Страница товара"></a></td>
  </tr>
  <tr>
    <td align="center"><strong>Личный кабинет</strong></td>
    <td align="center"><strong>Корзина</strong></td>
    <td align="center"><strong>Админ-панель</strong></td>
  </tr>
  <tr>
    <td><a href="https://github.com/nikiels/php-tea-shop/blob/main/showcase-04-profile.PNG"><img src="https://github.com/nikiels/php-tea-shop/blob/main/showcase-04-profile.PNG" alt="Личный кабинет"></a></td>
    <td><a href="https://github.com/nikiels/php-tea-shop/blob/main/showcase-05-cart.PNG"><img src="https://github.com/nikiels/php-tea-shop/blob/main/showcase-05-cart.PNG" alt="Корзина"></a></td>
    <td><a href="https://github.com/nikiels/php-tea-shop/blob/main/showcase-06-admin.PNG"><img src="https://github.com/nikiels/php-tea-shop/blob/main/showcase-06-admin.PNG" alt="Админ-панель"></a></td>
  </tr>
</table>

---

### 🚀 Основные возможности

| Функция                      | Клиентская часть | Админ-панель |
| ---------------------------- | :--------------: | :----------: |
| Каталог товаров по категориям |        ✅         |      -       |
| Регистрация и Авторизация      |        ✅         |      ✅       |
| Профиль с историей заказов     |        ✅         |      -       |
| Корзина (добавление, удаление, обновление) |   ✅   |      -       |
| Оформление заказа              |        ✅         |      -       |
| Управление товарами (CRUD)     |        -         |      ✅       |
| Управление категориями         |        -         |      ✅       |
| Просмотр и обработка заказов   |        -         |      ✅       |

---

### 💻 Технологический стек

-   **Backend:** PHP 8.0 (без использования фреймворков)
-   **База данных:** MySQL
-   **ORM:** RedBeanPHP (для упрощенной и безопасной работы с БД)
-   **Frontend:** HTML5, CSS3, JavaScript (jQuery)
-   **CSS-фреймворк:** Bootstrap (с компонентами Material Design for Bootstrap)
-   **Окружение для разработки:** OSPanel (Apache + MySQL)

---

### 🔧 Инструкция по установке и запуску

1.  **Клонируйте репозиторий на свой локальный сервер:**
    ```bash
    git clone https://github.com/ВАШ_НИКНЕЙМ/php-tea-shop.git
    ```
2.  **Импортируйте базу данных:**
    -   Создайте новую базу данных в вашей СУБД (например, через phpMyAdmin).
    -   Импортируйте в неё дамп `shop.sql`, который находится в корне проекта.

3.  **Настройте подключение:**
    -   В корне проекта скопируйте файл `config.sample.php` и переименуйте копию в `config.php`.
    -   Откройте `config.php` и впишите ваши учетные данные для подключения к созданной базе данных.

4.  **Запустите проект:**
    -   Направьте ваш локальный веб-сервер (Apache, Nginx) на корневую папку проекта.
    -   Откройте сайт в браузере. Данные для входа в админ-панель можно найти в дампе `shop.sql` (в таблице `users`).
