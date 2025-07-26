<?php
/**
 * Главный контроллер (маршрутизатор) сайта.
 */


require_once 'config.php';   // 1. Настройки (содержит константу ROOT)
require_once 'rb.php';       // 2. Библиотека RedBeanPHP
session_start();             // 3. Запуск сессии

// Подключаем наши файлы с функциями
require_once 'bdfunct.php';
require_once 'carzin_fns.php';

// Устанавливаем соединение с БД
R::setup('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
if (!R::testConnection()) {
    die('Ошибка подключения к базе данных');
}

// Инициализация корзины
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
    $_SESSION['total_items'] = 0;
    $_SESSION['total_price'] = 0.0;
}


// --- 1. Маршрутизация ---
$view = $_GET['view'] ?? 'glav';

// Белый список ВСЕХ разрешенных маршрутов (для безопасности)
$allowed_routes = [
    // Клиентские страницы
    'glav', 'cat', '1tovar', 'carzina', 'order', 'logining', 'loging2', 'logout',
    
    // Клиентские действия
    'add_to_cart', 'update_cart', 'remove_from_cart',

    // Админские страницы и действия
    'admin', 'add_tovadmin', 'un_add_catadmin', 'zakaz', 'comments', 
    'get_deleted_products', 'get_deleted_cat', 'get_deleted_order'
];

if (!in_array($view, $allowed_routes)) {
    http_response_code(404);
    die("Ошибка 404: Страница не найдена");
}

$is_admin_route = in_array($view, ['admin', 'add_tovadmin', 'un_add_catadmin', 'zakaz', 'comments']);


// --- 2. Логика контроллера ---

// Сначала обрабатываем "действия" (которые не рисуют HTML, а делают что-то и перенаправляют)
switch ($view) {
    case 'add_to_cart':
        add_to_cart($_GET['id'] ?? 0);
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
        exit;
    case 'update_cart':
        update_cart();
        header('Location: index.php?view=carzina');
        exit;
    case 'remove_from_cart':
        remove_from_cart($_GET['id'] ?? 0);
        header('Location: index.php?view=carzina');
        exit;
    case 'get_deleted_products':
        get_deleted_products($_GET['id'] ?? 0);
        $_SESSION['message'] = "Товар успешно удален.";
        header('Location: index.php?view=admin');
        exit;
    case 'get_deleted_cat':
        get_deleted_cat($_GET['id'] ?? 0);
        $_SESSION['message'] = "Категория успешно удалена.";
        header('Location: index.php?view=un_add_catadmin');
        exit;
    case 'get_deleted_order':
        get_deleted_order($_GET['id'] ?? 0);
        $_SESSION['message'] = "Заказ отмечен как обработанный.";
        header('Location: index.php?view=zakaz');
        exit;
    case 'logout':
        unset($_SESSION['logged_user']);
        unset($_SESSION['logged_admin']);
        session_destroy();
        header('Location: index.php');
        exit;
}


if ($is_admin_route) {
    // --- Логика для АДМИН-ПАНЕЛИ ---
    // Сначала определим, какой файл контента нам нужно будет вставить в шаблон
    if (isset($_SESSION['logged_admin'])) {
        // Подготавливаем данные для конкретной страницы
        switch ($view) {
            case 'admin':
                $produ = get_product();
                break;
            case 'add_tovadmin':
            case 'un_add_catadmin':
                $cat = get_categories();
                break;
            case 'zakaz':
                $order = get_order();
                break;
        }
        $admin_content_file = ROOT . '/views/admin/' . $view . '.php';
    } else {
        $admin_content_file = ROOT . '/views/admin/partials/_access_denied.php';
    }
    // А теперь подключаем единый ШАБЛОН ДЛЯ АДМИНКИ, который уже сам вставит нужный контент
    include(ROOT . '/views/layouts/admin_layout.php');

} else {
    // --- Логика для КЛИЕНТСКОЙ ЧАСТИ  ---
    switch ($view) {
        case 'glav':
            $categories = get_categories();
            $prod = get_products();
            break;
        case 'cat':
            $categories = get_categories();
            $product = get_cat_product($_GET['id'] ?? '');
            break;
        case '1tovar':
            $categories = get_categories();
            $produc = get_1product($_GET['id'] ?? 0);
            break;
        case 'carzina':
            $_SESSION['total_items'] = calculate_total_items();
            $_SESSION['total_price'] = calculate_total_price();
            break;
    }
    // Подключаем главный шаблон для клиентского сайта
    include(ROOT . '/views/layouts/shop.php');
}