<div class="list-group">
    <?php
        // Определяем, какая страница сейчас активна
        $current_view = $_GET['view'] ?? 'admin';
        
        // Список пунктов меню
        $menu_items = [
            'admin' => ['icon' => 'fas fa-box-open', 'text' => 'Товары'],
            'add_tovadmin' => ['icon' => 'fas fa-plus-circle', 'text' => 'Добавить товар'],
            'un_add_catadmin' => ['icon' => 'fas fa-tags', 'text' => 'Категории'],
            'zakaz' => ['icon' => 'fas fa-receipt', 'text' => 'Заказы'],
            'comments' => ['icon' => 'fas fa-comments', 'text' => 'Комментарии']
        ];
    ?>

    <?php foreach ($menu_items as $view => $item): ?>
        <?php $is_active = ($current_view === $view) ? 'active' : ''; ?>
        <a href="index.php?view=<?= $view ?>" class="list-group-item list-group-item-action <?= $is_active ?>">
            <i class="<?= $item['icon'] ?> mr-2"></i><?= $item['text'] ?>
        </a>
    <?php endforeach; ?>
</div>