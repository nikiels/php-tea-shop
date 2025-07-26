<!DOCTYPE html>
<html lang="ru" class="full-height">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  
  <!-- Заголовок страницы -->
  <title>Интернет-магазин "GREEN TEA"</title>

  <!-- Подключаю все необходимые стили -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/mdb.min.css" rel="stylesheet">
  <link href="css/addons/datatables.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>

<body>

  <!-- Верхняя навигационная панель -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark scrolling-navbar">
    <div class="container">

      <!-- Логотип, ведущий на главную -->
      <a href="index.php" class="navbar-brand waves-effect">
        <strong class="green-text"><i class="fa fa-coffee"></i> GREEN TEA</strong>
      </a>

      <!-- Кнопка "гамбургер" для мобильных устройств -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSuppotedContent" aria-controls="navbarSuppotedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Основное содержимое навбара, которое будет скрываться на мобильных -->
      <div class="collapse navbar-collapse" id="navbarSuppotedContent">
        <!-- Ссылки слева: контакты -->
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a href="#" class="nav-link waves-effect">Адрес</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link waves-effect">Тел.</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link waves-effect">+7(902)459 20 82</a>
          </li>
        </ul>

        <!-- Блок для кнопок входа/регистрации/профиля -->
        <div class="form-inline my-2 my-lg-0">
          <?php if (isset($_SESSION['logged_user']) || isset($_SESSION['logged_admin'])) : // Если пользователь авторизован ?>
            
            <?php
              // Определяю, какое имя пользователя показать (обычного или админа)
              $username = '';
              if (isset($_SESSION['logged_user']->username)) {
                $username = $_SESSION['logged_user']->username;
              } elseif (isset($_SESSION['logged_admin']->username)) {
                $username = $_SESSION['logged_admin']->username;
              }
            ?>
            
            <!-- Показываю ссылку на профиль и кнопку "Выйти" -->
            <a class="green-text" href="index.php?view=logining"><?php echo htmlspecialchars($username); ?></a>
            <a href="index.php?view=logout" class="btn btn-outline-success my-2 my-lg-0 ml-2">Выйти</a>

          <?php else : // Если пользователь не авторизован ?>
          
            <!-- Показываю кнопки "Регистрация" и "Войти" -->
            <a href="index.php?view=logining" class="btn btn-outline-success my-2 my-lg-0">Регистрация</a>
            <a href="index.php?view=loging2" class="btn btn-outline-success my-2 my-lg-0 ml-2">Войти</a>
            
          <?php endif; ?>
        </div>

        <!-- Иконка корзины справа -->
        <ul class="navbar-nav nav-flex-icons">
          <li class="nav-item">
            <a href="index.php?view=carzina" class="nav-link waves-effect">
              <!-- Счетчик товаров в корзине -->
              <span class="badge red z-depth-1 mr-1">
                <?php echo isset($_SESSION['total_items']) ? $_SESSION['total_items'] : '0'; ?>
              </span>
              <i class="fa fa-shopping-cart"></i>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Сюда будет подгружаться основной контент страницы (glav.php, cat.php и т.д.) -->
  <main class="mt-4">
    <?php
      // index.php определяет, какой файл нужно показать, и передает путь в переменной $view.
      // Важно, чтобы переменная $view всегда была определена.
      include(ROOT . '/views/pages/' . $view . '.php'); 
    ?>
  </main>

  <!-- Футер (подвал) сайта -->
  <footer id="footer" class="page-footer font-small mt-4">
    <div class="footer-copyright text-center py-3"> © 2022 ООО "GREEN TEA":
      <a href="#"> GREEN TEA.com</a>
    </div>
  </footer>

  <!-- Подключаю скрипты в конце страницы для ускорения загрузки -->
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="js/popper.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/mdb.min.js"></script>
  <!-- DataTables.js - для админки, но пусть пока будет и тут, не помешает -->
  <script type="text/javascript" src="js/addons/datatables.min.js"></script>
  <script type="text/javascript" src="js/index.js"></script>
  
  <!-- Инициализирую плагины -->
  <script type="text/javascript">
    $(document).ready(function () {
        // Пример инициализации DataTables
        $('#dtBasicExample').DataTable();
        $('.dataTables_length').addClass('bs-select');
    });
  </script>

</body>

</html>