<?php


/**
 * Добавляет один товар в корзину или увеличивает его количество.
 * @param int $product_id ID товара для добавления.
 */
function add_to_cart($product_id)
{
    // Убедимся, что ID - это целое число
    $product_id = (int)$product_id;

    if (isset($_SESSION['cart'][$product_id])) {
        // Если товар уже есть, увеличиваем количество
        $_SESSION['cart'][$product_id]++;
    } else {
        // Если товара нет, добавляем его с количеством 1
        $_SESSION['cart'][$product_id] = 1;
    }
}

/**
 * Обновляет количество товаров в корзине на основе данных из формы.
 */
function update_cart()
{
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        if (isset($_POST[$product_id])) {
            // ВАЖНО: Приводим полученное значение к целому числу для безопасности
            $new_quantity = (int)$_POST[$product_id];

            if ($new_quantity > 0) {
                // Если новое количество больше нуля, обновляем его
                $_SESSION['cart'][$product_id] = $new_quantity;
            } else {
                // Если количество 0 или меньше, удаляем товар из корзины
                unset($_SESSION['cart'][$product_id]);
            }
        }
    }
}

/**
 * Удаляет товар из корзины.
 * @param int $product_id ID товара для удаления.
 */
function remove_from_cart($product_id)
{
    $product_id = (int)$product_id;
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}


/**
 * Подсчитывает общее количество всех товарных единиц в корзине.
 * @return int Общее количество товаров.
 */
function calculate_total_items()
{
    if (empty($_SESSION['cart'])) {
        return 0;
    }
    // array_sum() - самый эффективный способ сложить все значения в массиве
    return array_sum($_SESSION['cart']);
}

/**
 * Подсчитывает общую стоимость всех товаров в корзине.
 * ИСПОЛЬЗУЕТ REDBEANPHP.
 * @return float Общая стоимость.
 */
function calculate_total_price()
{
    if (empty($_SESSION['cart'])) {
        return 0.0;
    }

    $total_price = 0.0;

    // Получаем ID всех товаров в корзине
    $product_ids = array_keys($_SESSION['cart']);

    // Загружаем все нужные товары ОДНИМ запросом к БД - это очень эффективно!
    $products = R::loadAll('product', $product_ids);

    foreach ($_SESSION['cart'] as $id => $quantity) {
        // Проверяем, что товар существует в загруженных данных
        if (isset($products[$id])) {
            // Умножаем цену товара на его количество в корзине
            $total_price += $products[$id]->price * $quantity;
        }
    }

    return $total_price;
}