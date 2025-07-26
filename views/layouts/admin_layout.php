<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Админ-панель - GREEN TEA</title>
    
    <!-- Сначала подключаю все необходимые CSS-файлы -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Стили для плагина DataTables, который делает таблицы красивыми и функциональными -->
    <link href="css/addons/datatables.min.css" rel="stylesheet">
    <link href="css/mdb.min.css" rel="stylesheet">
    <!-- В последнюю очередь подключаю свой файл style.css, чтобы мои стили имели приоритет -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body style="background-color: #f4f5f7;"> <!-- Задаю основной фон для админки -->

    <!-- Верхняя навигационная панель -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <!-- Логотип-ссылка на главную страницу админки -->
            <a class="navbar-brand" href="index.php?view=admin">
                <strong>GREEN TEA - Админ-панель</strong>
            </a>
            
            <!-- Кнопки справа: перейти на сайт и выйти -->
            <div>
                <a href="index.php" class="btn btn-outline-light btn-sm" target="_blank">
                    <i class="fas fa-external-link-alt mr-1"></i> Перейти на сайт
                </a>
                <a href="index.php?view=logout" class="btn btn-light btn-sm">
                    <i class="fas fa-sign-out-alt mr-1"></i> Выйти
                </a>
            </div>
        </div>
    </nav>

    <!-- Основной блок для контента. Он будет меняться в зависимости от страницы. -->
    <main>
        <?php 
            // Подключаю файл с контентом (например, admin.php, zakaz.php и т.д.),
            // путь к которому был определён в index.php
            if (isset($admin_content_file)) include($admin_content_file); 
        ?>
    </main>
    
    <!-- В конце страницы подключаю JavaScript-библиотеки -->
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- Скрипт для плагина DataTables -->
    <script type="text/javascript" src="js/addons/datatables.min.js"></script>
    <script type="text/javascript" src="js/mdb.min.js"></script>
    
    <script type="text/javascript">
        // Небольшой скрипт для инициализации DataTables на моих таблицах.
        $(document).ready(function () {
            // Ищу таблицу по id="dtBasicExample" и применяю к ней плагин.
            $('#dtBasicExample').DataTable({
                // Добавляю русификацию для интерфейса таблицы (надписи "Поиск", "Записи" и т.д.)
                "language": { "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Russian.json" }
            });
        });
    </script>
</body>
</html>