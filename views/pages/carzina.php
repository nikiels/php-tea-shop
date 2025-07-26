<div class="container my-5">

    <!-- Заголовок страницы -->
    <h1 class="font-weight-bold mb-4" style="color: #343a40;">Ваша корзина</h1>

    <?php if (!empty($_SESSION['cart'])) : // Проверяем, есть ли что-нибудь в корзине ?>

        <!-- Если корзина не пуста, отображаем форму с товарами -->
        <form action="index.php?view=update_cart" method="post" id="cart-form">

            <div class="card">
                <div class="table-responsive">
                    <table class="table product-table mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="font-weight-bold" style="width: 50%;">Товар</th>
                                <th scope="col" class="font-weight-bold text-center">Цена за шт.</th>
                                <th scope="col" class="font-weight-bold text-center" style="width: 15%;">Количество</th>
                                <th scope="col" class="font-weight-bold text-right">Сумма</th>
                                <th scope="col"></th> <!-- Пустой заголовок для колонки с кнопкой удаления -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $id => $quantity) : ?>
                                <?php
                                    // Для каждой позиции в корзине получаем полную информацию о товаре.
                                    $product_item = get_1product($id);
                                ?>
                                <tr>
                                    <!-- Колонка с изображением и названием товара -->
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="img/tea/<?= htmlspecialchars($product_item->image) ?>" alt="<?= htmlspecialchars($product_item->title) ?>" class="img-fluid rounded" style="width: 80px;">
                                            <strong class="ml-3" style="color: #343a40;"><?= htmlspecialchars($product_item->title) ?></strong>
                                        </div>
                                    </td>
                                    
                                    <!-- Цена за одну штуку -->
                                    <td class="text-center align-middle">
                                        <?= htmlspecialchars($product_item->price) ?> ₽
                                    </td>
                                    
                                    <!-- Поле для изменения количества -->
                                    <td class="text-center align-middle">
                                        <input type="number" name="<?= htmlspecialchars($id) ?>" value="<?= htmlspecialchars($quantity) ?>" class="form-control text-center" min="1">
                                    </td>

                                    <!-- Сумма по текущей позиции (цена * количество) -->
                                    <td class="text-right align-middle font-weight-bold" style="color: #343a40;">
                                        <?= htmlspecialchars($product_item->price * $quantity) ?> ₽
                                    </td>

                                    <!-- Кнопка для удаления товара из корзины -->
                                    <td class="text-center align-middle">
                                        <a href="index.php?view=remove_from_cart&id=<?= htmlspecialchars($id) ?>" class="text-danger" title="Удалить товар">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Футер таблицы, где выводится итоговая сумма -->
                <div class="card-footer bg-light text-right">
                    <h4 class="font-weight-bold my-2" style="color: #343a40;">
                        Итоговая сумма: 
                        <span style="color: #28a745;"><?= htmlspecialchars($_SESSION['total_price']) ?> ₽</span>
                    </h4>
                </div>
            </div>

            <!-- Блок с управляющими кнопками под таблицей -->
            <div class="d-flex justify-content-between mt-4">
                <!-- Кнопка для возврата в каталог -->
                <a href="index.php" class="btn btn-outline-secondary waves-effect">
                    <i class="fas fa-arrow-left mr-2"></i>Продолжить покупки
                </a>
                
                <!-- Кнопки для обновления корзины и перехода к оформлению заказа -->
                <div>
                    <button type="submit" name="update" class="btn btn-secondary waves-effect mr-2">
                        <i class="fas fa-sync-alt mr-2"></i>Обновить корзину
                    </button>
                    <a href="index.php?view=order" class="btn btn-success btn-lg waves-effect">
                        Оформить заказ<i class="fas fa-angle-right ml-2"></i>
                    </a>
                </div>
            </div>

        </form>

    <?php else: ?>
        <!-- Если корзина пуста, показываем информационное сообщение -->
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="alert alert-info py-5" role="alert">
                    <h4 class="alert-heading">Ваша корзина пуста</h4>
                    <p>Похоже, вы еще не добавили ни одного товара. Перейдите в наш каталог, чтобы найти что-нибудь для себя.</p>
                    <hr>
                    <a href="index.php" class="btn btn-primary">Перейти в каталог</a>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>