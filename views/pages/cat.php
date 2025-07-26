<div class="container mt-4">
    <div class="row">

        <!-- ===== Сайдбар с категориями ===== -->
        <div class="col-lg-3">
            <h4 class="mb-3 font-weight-bold" style="color: #343a40;">Категории Чая</h4>
            
            <!-- Меню в виде списка -->
            <div class="list-group">
                <?php
                    // Определяем текущую активную категорию из URL-параметра 'id'.
                    $current_cat_id = $_GET['id'] ?? null;
                ?>
                <?php foreach ($categories as $categ) : ?>
                    <?php
                        // Динамически присваиваем класс 'active', если категория совпадает с текущей.
                        $is_active = ($current_cat_id == $categ->cat_id) ? 'active' : '';
                    ?>
                    <a href="index.php?view=cat&id=<?= htmlspecialchars($categ->cat_id) ?>" class="list-group-item list-group-item-action <?= $is_active ?>">
                        <?= htmlspecialchars($categ->name) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- ===== Конец сайдбара ===== -->


        <!-- ===== Основной контент (сетка товаров) ===== -->
        <div class="col-lg-9">

            <?php
              // Находим имя текущей категории, чтобы использовать его в заголовке страницы.
              $page_title = 'Все товары'; // Заголовок по умолчанию, если не удалось определить категорию.
              
              if (isset($_GET['id'])) {
                  // Проходим по всем категориям, чтобы найти ту, у которой cat_id совпадает с 'id' из URL.
                  foreach ($categories as $cat) {
                      if ($cat->cat_id == $_GET['id']) {
                          $page_title = $cat->name; // Если нашли, присваиваем её имя заголовку.
                          break; // Прерываем цикл, так как категория найдена.
                      }
                  }
              }
            ?>
            <!-- Выводим заголовок страницы -->
            <h2 class="mb-4 font-weight-bold" style="color: #343a40;"><?= htmlspecialchars($page_title) ?></h2>
            
            <!-- Сетка для отображения карточек товаров -->
            <div class="row">
                <?php if (!empty($product)) : // Проверяем, есть ли товары в данной категории ?>
                    
                    <!-- Если товары есть, выводим их в цикле -->
                    <?php foreach ($product as $prod) : ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <!-- Каждая карточка товара - это ссылка на страницу этого товара -->
                            <a href="index.php?view=1tovar&id=<?= htmlspecialchars($prod->id) ?>" class="product-card d-block h-100">
                                <div class="card h-100">
                                    <div class="view overlay">
                                        <!-- Изображение товара -->
                                        <img src="img/tea/<?= htmlspecialchars($prod->image) ?>" class="card-img-top" alt="<?= htmlspecialchars($prod->title) ?>">
                                        <div class="mask rgba-white-slight"></div>
                                    </div>
                                    <!-- Основная информация о товаре -->
                                    <div class="card-body d-flex flex-column text-center">
                                        <h5 class="card-title font-weight-bold" style="color: #343a40;">
                                            <?= htmlspecialchars($prod->title) ?>
                                        </h5>
                                        <p class="card-text mt-auto font-weight-bold h4" style="color: #28a745;">
                                            <?= htmlspecialchars($prod->price) ?> ₽
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>

                <?php else: ?>
                    <!-- Если товаров в категории нет, выводим сообщение -->
                    <div class="col-12">
                        <div class="alert alert-info" role="alert">
                            В этой категории пока нет товаров. Загляните позже!
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </div>
        <!-- ===== Конец основного контента ===== -->

    </div>
</div>