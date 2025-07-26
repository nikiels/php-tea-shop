<?php



function get_categories()
{
    // R::findAll() получает все записи из таблицы 'categories'
    return R::findAll('categories');
}

function get_products()
{
    // Второй параметр в findAll позволяет добавлять SQL-условия
    return R::findAll('product', 'ORDER BY id DESC LIMIT 12');
}

function get_product()
{
    // Получение всех товаров для админ-панели
    return R::findAll('product');
}


function get_cat_product($cat_id)
{
    // Получение товаров по ID категории.
    // Знак '?' и массив в третьем параметре — это безопасный способ передачи данных (защита от SQL-инъекций).
    return R::findAll('product', 'cat = ?', [$cat_id]);
}

function get_1product($id)
{
    // R::load() загружает одну запись (один "бин") из таблицы 'product' по её ID.
    return R::load('product', $id);
}

function get_deleted_products($id)
{
    // Для удаления сначала загружаем объект, а потом "выбрасываем" его
    $product = R::load('product', $id);
    if ($product->id) { // Проверяем, что такой товар существует
        R::trash($product);
    }
}

function get_deleted_cat($id)
{
    $category = R::load('categories', $id);
    if ($category->id) {
        R::trash($category);
    }
}

function get_deleted_order($id)
{
    $order = R::load('orders', $id);
    if ($order->id) {
        R::trash($order);
    }
}

function get_order()
{
    // Получаем все заказы
    return R::findAll('orders');
}

function get_user_orders($user_id)
{
    // Ищем все заказы, где поле email совпадает с email пользователя.

    $user = R::load('user', $user_id);
    if (!$user->id) {
        return [];
    }
    return R::find('orders', 'email = ? ORDER BY date DESC, time DESC', [$user->email]);
}