<?php if (isset($_SESSION['logged_admin'])) : // Проверяю, авторизован ли админ. ?>

<div class="container my-5">
    <div class="row">
        <!-- Левая колонка - меню админки. -->
        <div class="col-md-3">
            <?php include 'partials/_sidebar.php'; ?>
        </div>
        
        <!-- Правая колонка - основной контент. -->
        <div class="col-md-9">
            <h2 class="font-weight-bold mb-4">Входящие заказы</h2>
             <div class="card">
                <div class="card-body">
                     <div class="table-responsive">
                        <!-- Отображаю список заказов в виде таблицы. -->
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Дата</th>
                                    <th>Товар</th>
                                    <th>Покупатель</th>
                                    <th>Email/Телефон</th>
                                    <th class="text-center">Кол-во</th>
                                    <th class="text-right">Сумма</th>
                                    <th class="text-center">Статус</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- В цикле вывожу каждую строку заказа. -->
                                <?php foreach ($order as $r) : ?>
                                    <tr>
                                        <!-- Форматирую дату и время для удобного чтения. -->
                                        <td><?= date("d.m.Y H:i", strtotime($r->date . ' ' . $r->time)) ?></td>
                                        <!-- Вывожу название товара. -->
                                        <td><?= htmlspecialchars($r->product) ?></td>
                                        <!-- Отображаю имя и фамилию покупателя. -->
                                        <td><?= htmlspecialchars($r->name . ' ' . $r->s_name) ?></td>
                                        <!-- Показываю контактные данные. -->
                                        <td><?= htmlspecialchars($r->email) ?><br><small><?= htmlspecialchars($r->phone) ?></small></td>
                                        <!-- Вывожу количество единиц товара. -->
                                        <td class="text-center"><?= htmlspecialchars($r->qty) ?></td>
                                        <!-- Считаю и отображаю сумму по этой товарной позиции. -->
                                        <td class="text-right font-weight-bold"><?= htmlspecialchars($r->price * $r->qty) ?> ₽</td>
                                        <!-- Кнопка для смены статуса заказа (например, "Обработан"). -->
                                        <td class="text-center">
                                            <a href="index.php?view=get_deleted_order&id=<?= $r->id ?>" class="btn btn-sm btn-success" onclick="return confirm('Вы уверены, что хотите отметить заказ как обработанный?');">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                     </div>
                 </div>
             </div>
        </div>
    </div>
</div>

<?php else: include 'partials/_access_denied.php'; endif; ?>