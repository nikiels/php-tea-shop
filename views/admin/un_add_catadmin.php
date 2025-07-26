<?php
// --- Обработчик формы добавления категории ---
// Срабатывает только после нажатия кнопки 'add_category'.
if (isset($_POST["add_category"])) {
    
    // Подготавливаю массив для ошибок и получаю данные из формы.
    $errors = [];
    $name = trim($_POST['name'] ?? '');
    $cat_id = trim($_POST['cat_id'] ?? '');

    // Провожу валидацию: проверяю поля на пустоту и уникальность.
    if (empty($name)) $errors[] = "Укажите название категории.";
    if (empty($cat_id)) $errors[] = "Укажите ID (транслит).";
    if (R::count('categories', 'name = ?', [$name])) $errors[] = 'Категория с таким названием уже существует.';
    if (R::count('categories', 'cat_id = ?', [$cat_id])) $errors[] = 'Категория с таким ID уже существует.';
    
    // Если ошибок не найдено...
    if (empty($errors)) {
        // ...создаю новую категорию.
        $category = R::dispense('categories');
        $category->name = $name;
        $category->cat_id = $cat_id;
        
        // Сохраняю её в базу данных.
        R::store($category);
        
        // Формирую сообщение об успехе и перезагружаю страницу.
        $_SESSION['message'] = "Категория '".htmlspecialchars($name)."' успешно добавлена!";
        header('Location: index.php?view=un_add_catadmin');
        exit();
    }
}
?>

<?php if (isset($_SESSION['logged_admin'])) : // Проверяю, авторизован ли админ. ?>

<div class="container my-5">
    <div class="row">
        <!-- Левая колонка - меню админки. -->
        <div class="col-md-3">
            <?php include 'partials/_sidebar.php'; ?>
        </div>
        
        <!-- Правая колонка - основной контент. -->
        <div class="col-md-9">
            <h2 class="font-weight-bold mb-4">Управление категориями</h2>
            
            <!-- Если есть флэш-сообщение (например, после добавления/удаления), вывожу его. -->
            <?php if (!empty($_SESSION['message'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars($_SESSION['message']) ?></div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <div class="row">
                <!-- Блок для отображения и удаления существующих категорий. -->
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">Существующие категории</div>
                        <div class="card-body">
                             <table class="table table-sm table-hover">
                                <thead><tr><th>Название</th><th>ID</th><th></th></tr></thead>
                                <tbody>
                                    <!-- В цикле вывожу все категории, полученные из контроллера. -->
                                    <?php foreach ($cat as $c) : ?>
                                        <tr>
                                            <td><?= htmlspecialchars($c->name) ?></td>
                                            <td><?= htmlspecialchars($c->cat_id) ?></td>
                                            <!-- Ссылка для удаления категории с подтверждением. -->
                                            <td class="text-right">
                                                <a href="index.php?view=get_deleted_cat&id=<?= $c->id ?>" onclick="return confirm('Вы уверены?');" class="text-danger"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                             </table>
                        </div>
                    </div>
                </div>

                <!-- Блок для добавления новой категории. -->
                <div class="col-md-5">
                     <div class="card">
                        <div class="card-header">Добавить новую категорию</div>
                        <div class="card-body">
                            
                            <!-- Блок для отображения ошибок валидации формы. -->
                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger py-2">
                                    <ul class="mb-0 small"><?php foreach ($errors as $error) echo '<li>' . $error . '</li>'; ?></ul>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Форма добавления. -->
                            <form action="index.php?view=un_add_catadmin" method="POST">
                                <div class="form-group">
                                    <label for="name">Название</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="cat_id">ID категории (на англ.)</label>
                                    <input type="text" id="cat_id" name="cat_id" class="form-control" required placeholder="zeleniy-chay">
                                </div>
                                <button type="submit" name="add_category" class="btn btn-success btn-block">Добавить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php else: include 'partials/_access_denied.php';  endif; ?> 