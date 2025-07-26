<div class="container mt-4">
    <div class="row">

        <!-- ===== Сайдбар с категориями ===== -->
        <div class="col-lg-3">
            <h4 class="mb-3 font-weight-bold" style="color: #343a40;">Категории Чая</h4>
            
            <div class="list-group">
                <?php
                    // Получаем ID категории текущего товара для подсветки активного пункта.
                    $current_cat_id = $produc->cat; 
                ?>
                <?php foreach ($categories as $categ) : ?>
                    <?php
                        // Проверяем, совпадает ли ID в цикле с ID категории товара, и присваиваем класс 'active'.
                        $is_active = ($current_cat_id == $categ->cat_id) ? 'active' : '';
                    ?>
                    <a href="index.php?view=cat&id=<?= htmlspecialchars($categ->cat_id) ?>" class="list-group-item list-group-item-action <?= $is_active ?>">
                        <?= htmlspecialchars($categ->name) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- ===== Конец сайдбара ===== -->


        <!-- ===== Основной контент страницы ===== -->
        <div class="col-lg-9">

            <!-- Основной блок с товаром -->
            <div class="row">
                <!-- Левая часть: изображение товара -->
                <div class="col-md-6 mb-4">
                    <div class="view overlay rounded z-depth-1-half">
                        <img src="img/tea/<?= htmlspecialchars($produc->image) ?>" class="img-fluid" alt="<?= htmlspecialchars($produc->title) ?>">
                        <div class="mask rgba-white-slight"></div>
                    </div>
                </div>

                <!-- Правая часть: название, цена, кнопка "в корзину" -->
                <div class="col-md-6 mb-4">
                    
                    <h1 class="font-weight-bold" style="color: #343a40;"><?= htmlspecialchars($produc->title) ?></h1>
                    <p class="lead text-muted"><?= htmlspecialchars($produc->description) ?></p>

                    <p class="h2 font-weight-bold my-4" style="color: #28a745;">
                        <?= htmlspecialchars($produc->price) ?> ₽
                    </p>

                    <!-- Кнопка добавления товара в корзину -->
                    <a href="index.php?view=add_to_cart&id=<?= htmlspecialchars($produc->id) ?>" class="btn btn-lg waves-effect waves-light" style="background-color: #28a745 !important;">
                        <i class="fas fa-shopping-cart mr-2"></i> В корзину
                    </a>
                </div>
            </div>

            <!-- Разделитель -->
            <hr class="my-4">
            
            <!-- Табы с дополнительной информацией -->
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Подробное описание</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Отзывы</a>
                </li>
            </ul>

            <!-- Контент для табов -->
            <div class="tab-content pt-4" id="productTabsContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                    <!-- Выводим полное описание, сохраняя переносы строк -->
                    <?= nl2br(htmlspecialchars($produc->fuldescription)) ?>
                </div>
                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                    <p>Отзывы об этом товаре скоро появятся.</p>
                    <a href="#" class="btn btn-outline-secondary btn-sm">Написать отзыв</a>
                </div>
            </div>

        </div>
        <!-- ===== Конец основного контента ===== -->

    </div>
</div>