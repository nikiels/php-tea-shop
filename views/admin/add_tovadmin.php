<?php
// --- Обработчик формы добавления товара ---
// Логика выполняется, только если была нажата кнопка 'add_product'.
if (isset($_POST["add_product"])) {
    
    // Подготавливаю массив для ошибок валидации.
    $errors = [];
    
    // Проверяю основные поля на пустоту.
    if (empty(trim($_POST["title"]))) $errors[] = "Укажите название товара";
    if (empty(trim($_POST["price"]))) $errors[] = "Укажите цену";
    if (empty($_POST["cat"])) $errors[] = "Укажите категорию";
    
    // Проверяю, не было ли ошибок при загрузке файла изображения.
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE && $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Ошибка загрузки файла изображения.';
    }

    // Если после всех проверок массив с ошибками пуст...
    if (empty($errors)) {
        // ...создаю новый объект 'product'.
        $product = R::dispense('product');
        
        // Заполняю его данными из формы, очищая лишние пробелы.
        $product->title = trim($_POST["title"]);
        $product->description = trim($_POST["description"] ?? '');
        $product->fuldescription = trim($_POST["fuldescription"] ?? '');
        $product->price = (float)$_POST["price"]; // Преобразую цену в число.
        $product->cat = $_POST["cat"];

        // --- Обработка загруженного изображения ---
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploaddir = ROOT . '/img/tea/'; // Папка для загрузки.
            $imgext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)); // Получаю расширение файла.
            $newfilename = uniqid('prod_') . '.' . $imgext; // Генерирую уникальное имя.
            
            // Если файл успешно перемещен в нужную папку...
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploaddir . $newfilename)) {
                // ...сохраняю его новое имя в объект товара.
                $product->image = $newfilename;
            } else {
                // Иначе добавляю ошибку.
                $errors[] = 'Не удалось переместить загруженный файл.';
            }
        } else {
             // Если изображение вообще не было загружено, ставлю заглушку.
             $product->image = 'default.jpg';
        }
        
        // Финальная проверка: если в процессе обработки файла не возникло ошибок...
        if (empty($errors)) {
            // ...сохраняю объект товара в базу данных.
            $id = R::store($product);
            
            // Записываю в сессию сообщение об успехе...
            $_SESSION['message'] = "Товар '".htmlspecialchars($product->title)."' успешно добавлен!";
            
            // ...и перенаправляю админа на главную страницу админки, чтобы избежать повторной отправки формы.
            header('Location: index.php?view=admin');
            exit();
        }
    }
}
?>

<?php if (isset($_SESSION['logged_admin'])) : // Проверяю, авторизован ли админ. ?>

<div class="container my-5">
    <div class="row">
        <!-- Левая колонка - стандартное меню админки. -->
        <div class="col-md-3">
            <?php include 'partials/_sidebar.php'; ?>
        </div>
        
        <!-- Правая колонка - основной контент страницы. -->
        <div class="col-md-9">
            <h2 class="font-weight-bold mb-4">Добавление нового товара</h2>
            
            <!-- Блок для вывода ошибок валидации. -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0"><?php foreach ($errors as $error) echo '<li>' . $error . '</li>'; ?></ul>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <!-- Форма для добавления товара. enctype необходим для загрузки файлов. -->
                    <form enctype="multipart/form-data" action="index.php?view=add_tovadmin" method="POST">
                        <div class="form-group">
                            <label for="title">Название товара</label>
                            <input type="text" id="title" name="title" class="form-control" required value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="description">Краткое описание</label>
                            <textarea id="description" name="description" class="form-control" rows="2"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                        </div>
                         <div class="form-group">
                            <label for="fuldescription">Полное описание</label>
                            <textarea id="fuldescription" name="fuldescription" class="form-control" rows="4"><?= htmlspecialchars($_POST['fuldescription'] ?? '') ?></textarea>
                        </div>
                        <div class="form-row">
                             <div class="form-group col-md-6">
                                <label for="price">Цена (в рублях)</label>
                                <input type="number" step="0.01" id="price" name="price" class="form-control" required value="<?= htmlspecialchars($_POST['price'] ?? '') ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cat">Категория</label>
                                <select id="cat" name="cat" class="form-control" required>
                                    <option value="" disabled selected>Выберите категорию...</option>
                                    <!-- Динамически загружаю список категорий из базы. -->
                                    <?php foreach ($cat as $c) : ?>
                                        <option value="<?= htmlspecialchars($c->cat_id) ?>" <?= (($_POST['cat'] ?? '') === $c->cat_id) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($c->name) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image">Изображение товара</label>
                            <input type="file" id="image" name="image" class="form-control-file">
                        </div>
                        <hr>
                        <button type="submit" name="add_product" class="btn btn-success">Добавить товар</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php else: include 'partials/_access_denied.php';  endif; ?>