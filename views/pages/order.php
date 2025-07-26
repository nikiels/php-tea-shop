<?php
// --- Обработчик формы заказа. Размещаю его вверху, чтобы вся логика выполнялась до вывода HTML. ---

// Переменные для ошибок и сообщений.
$errors = [];
$success_message = '';

// Проверяю, была ли отправлена форма заказа.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {

    // 1. Собираю и очищаю данные из полей.
    $name = trim($_POST['name'] ?? '');
    $s_name = trim($_POST['s_name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $post_index = trim($_POST['post_index'] ?? '');
    
    // Провожу базовую валидацию на пустоту и корректность email.
    if (empty($name)) { $errors[] = 'Пожалуйста, укажите ваше имя.'; }
    if (empty($s_name)) { $errors[] = 'Пожалуйста, укажите вашу фамилию.'; }
    if (empty($address)) { $errors[] = 'Пожалуйста, укажите адрес доставки.'; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = 'Пожалуйста, укажите корректный Email.'; }
    if (empty($phone)) { $errors[] = 'Пожалуйста, укажите контактный телефон.'; }
    if (empty($post_index)) { $errors[] = 'Пожалуйста, укажите почтовый индекс.'; }

    // 2. Если все поля прошли валидацию и корзина не пуста...
    if (empty($errors) && !empty($_SESSION['cart'])) {

        // ...прохожусь по каждому товару в корзине...
        foreach ($_SESSION['cart'] as $id => $quantity) {
            // ...получаю по нему полную информацию из базы...
            $product_item = get_1product($id);
            if (!$product_item->id) continue; // На всякий случай пропускаю, если товар успели удалить.

            // ...и создаю новую запись (строку) в таблице 'orders'.
            $order_item = R::dispense('orders');

            // Заполняю поля этой строки данными из формы и информацией о товаре.
            $order_item->name = $name;
            $order_item->s_name = $s_name;
            $order_item->address = $address;
            $order_item->email = $email;
            $order_item->phone = $phone;
            $order_item->post_index = $post_index;
            $order_item->product = $product_item->title;
            $order_item->prod_id = $product_item->id;
            $order_item->price = $product_item->price;
            $order_item->qty = $quantity;
            $order_item->date = date('Y-m-d');
            $order_item->time = date('H:i:s');
            
            // Сохраняю готовую строку в базу данных.
            R::store($order_item);
        }

        // 3. После того, как все товары записаны в базу, полностью очищаю корзину.
        unset($_SESSION['cart']);
        unset($_SESSION['total_items']);
        unset($_SESSION['total_price']);
        
        // Формирую сообщение об успехе для пользователя.
        $success_message = 'Спасибо! Ваш заказ успешно оформлен. Мы скоро с вами свяжемся.';
    }
}

// Перед отображением страницы всегда пересчитываю итоговые суммы в корзине.
if(isset($_SESSION['cart'])) {
    $_SESSION['total_items'] = calculate_total_items();
    $_SESSION['total_price'] = calculate_total_price();
}
?>

<!-- --- HTML-разметка страницы --- -->
<div class="container my-5">
    <h1 class="font-weight-bold mb-4" style="color: #343a40;">Оформление заказа</h1>

    <?php if (!empty($success_message)): ?>
        <!-- Если заказ был успешно оформлен, показываю сообщение об успехе. -->
        <div class="alert alert-success text-center py-4">
            <h4><?= htmlspecialchars($success_message) ?></h4>
            <a href="index.php" class="btn btn-outline-success mt-3">Вернуться на главную</a>
        </div>
        
    <?php elseif (empty($_SESSION['cart'])): ?>
        <!-- Если корзина пуста, показываю сообщение об этом. -->
        <div class="alert alert-info text-center py-4">
            <h4>Ваша корзина пуста</h4>
            <p>Вы не можете оформить заказ, пока не добавите что-нибудь в корзину.</p>
            <a href="index.php" class="btn btn-primary mt-3">Перейти в каталог</a>
        </div>
        
    <?php else: ?>
        <!-- Если же пользователь в процессе оформления заказа, показываю форму. -->
        
        <!-- Сначала вывожу блок с ошибками, если они были при отправке формы. -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <strong>Пожалуйста, исправьте следующие ошибки:</strong>
                <ul class="mb-0 mt-2">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <!-- Основная двухколоночная структура страницы. -->
        <div class="row">
            <!-- Левая колонка: форма с данными для доставки. -->
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Данные для доставки</h4>
                        <form action="index.php?view=order" method="post">
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="name">Имя</label>
                                    <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="s_name">Фамилия</label>
                                    <input type="text" id="s_name" name="s_name" class="form-control" value="<?= htmlspecialchars($_POST['s_name'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address">Адрес (Город, улица, дом, квартира)</label>
                                <input type="text" id="address" name="address" class="form-control" value="<?= htmlspecialchars($_POST['address'] ?? '') ?>" required>
                            </div>
                            
                            <div class="form-row">
                                <div class="col-md-7 form-group">
                                    <label for="email">Email для связи</label>
                                    <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-5 form-group">
                                    <label for="phone">Контактный телефон</label>
                                    <input type="tel" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" required placeholder="+7 (999) 123-45-67">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="post_index">Почтовый индекс</label>
                                <input type="text" id="post_index" name="post_index" class="form-control" value="<?= htmlspecialchars($_POST['post_index'] ?? '') ?>" required>
                            </div>

                            <hr>
                            <button type="submit" name="place_order" class="btn btn-success btn-lg btn-block">
                                Подтвердить и заказать
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Правая колонка: сводка по составу и стоимости заказа. -->
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Ваш заказ</h4>
                        <ul class="list-group list-group-flush">
                            <!-- Вывожу все товары из корзины в виде списка. -->
                            <?php foreach ($_SESSION['cart'] as $id => $quantity): ?>
                                <?php $product_item = get_1product($id); ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?= htmlspecialchars($product_item->title) ?></strong> <br>
                                        <small class="text-muted">Кол-во: <?= htmlspecialchars($quantity) ?></small>
                                    </div>
                                    <span><?= htmlspecialchars($product_item->price * $quantity) ?> ₽</span>
                                </li>
                            <?php endforeach; ?>
                            
                            <!-- Отдельно вывожу итоговую сумму. -->
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                <strong class="h5">Итого:</strong>
                                <strong class="h5" style="color: #28a745;"><?= htmlspecialchars($_SESSION['total_price']) ?> ₽</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>