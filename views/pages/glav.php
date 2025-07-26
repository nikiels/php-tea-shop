<div class="container mt-4">
    <div class="row">

        <!-- ===== Сайдбар с категориями ===== -->
        <div class="col-lg-3">
            <h4 class="mb-3 font-weight-bold" style="color: #343a40;">Категории Чая</h4>
            <div class="list-group shadow-sm">
                <!-- В цикле выводим все доступные категории товаров -->
                <?php foreach ($categories as $categ) : ?>
                    <a href="index.php?view=cat&id=<?= htmlspecialchars($categ->cat_id) ?>" class="list-group-item list-group-item-action">
                        <?= htmlspecialchars($categ->name) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- ===== Конец сайдбара ===== -->

        
        <!-- ===== Основной контент страницы ===== -->
        <div class="col-lg-9">
            
            <!-- Рекламный баннер/слайдер -->
            <div id="carousel-main" class="carousel slide carousel-fade mb-5 shadow-lg rounded" data-ride="carousel">
                <div class="carousel-inner rounded" role="listbox">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="img/kar/rek1.png" alt="Реклама: Распродажа к Пасхе">
                    </div>
                </div>
            </div>
            
            <!-- ===== Секция с новинками ===== -->
            <h2 class="mb-4 font-weight-bold text-center" style="color: #343a40;">Новинки нашего магазина</h2>
            <div class="row">
                <?php if (!empty($prod)) : // Проверяем, есть ли товары, отмеченные как новинки ?>
                    
                    <!-- Выводим карточки товаров в цикле -->
                    <?php foreach ($prod as $pr) : ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <!-- Каждая карточка - это ссылка на страницу товара -->
                            <a href="index.php?view=1tovar&id=<?= htmlspecialchars($pr->id) ?>" class="product-card d-block h-100">
                                <div class="card h-100">
                                    <div class="view overlay">
                                        <img src="img/tea/<?= htmlspecialchars($pr->image) ?>" class="card-img-top" alt="<?= htmlspecialchars($pr->title) ?>">
                                        <div class="mask rgba-white-slight"></div>
                                        <!-- Шильдик "Новинка" поверх изображения -->
                                        <span class="badge position-absolute" style="top: 10px; right: 10px; background-color: #28a745;">Новинка</span>
                                    </div>
                                    <!-- Основная информация о товаре: название и цена -->
                                    <div class="card-body d-flex flex-column text-center">
                                        <h5 class="card-title font-weight-bold" style="color: #343a40;">
                                            <?= htmlspecialchars($pr->title) ?>
                                        </h5>
                                        <p class="card-text mt-auto font-weight-bold h4" style="color: #28a745;">
                                            <?= htmlspecialchars($pr->price) ?> ₽
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                    
                <?php else: ?>
                    <!-- Если новинок нет, выводим сообщение-заглушку -->
                    <div class="col-12">
                        <p class="text-center">Новые товары скоро появятся.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- ===== Секция с преимуществами магазина ===== -->
            <hr class="my-5"> <!-- Визуальный разделитель -->
            <h2 class="mb-5 font-weight-bold text-center" style="color: #343a40;">Почему выбирают наш чай</h2>
            <div class="row">
                <!-- Преимущество 1: Качество -->
                <div class="col-md-4 advantage-item mb-4">
                    <div class="icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h5>Высокое качество</h5>
                    <p class="text-muted">Мы отбираем только лучшие чайные листья с проверенных плантаций.</p>
                </div>
                <!-- Преимущество 2: Доставка -->
                <div class="col-md-4 advantage-item mb-4">
                    <div class="icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h5>Быстрая доставка</h5>
                    <p class="text-muted">Доставляем свежий чай по всей стране в кратчайшие сроки.</p>
                </div>
                <!-- Преимущество 3: Гарантия -->
                <div class="col-md-4 advantage-item mb-4">
                    <div class="icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h5>Гарантия вкуса</h5>
                    <p class="text-muted">Каждая партия проходит строгую дегустацию перед продажей.</p>
                </div>
            </div>

        </div>
        <!-- ===== Конец основного контента ===== -->

    </div>
</div>