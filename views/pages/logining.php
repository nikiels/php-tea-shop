<?php
// --- Блок 1: Логика регистрации ---

// Подготавливаю переменные для ошибок и сообщений об успехе.
$errors = [];
$success_message = '';

// Проверяю, была ли нажата кнопка регистрации.
if (isset($_POST['do_signup'])) {
    $data = $_POST;

    // Провожу полную валидацию всех полей формы.
    if (trim($data['name'] ?? '') === '') $errors[] = 'Введите ваше имя.';
    if (trim($data['s_name'] ?? '') === '') $errors[] = 'Введите вашу фамилию.';
    if (trim($data['username'] ?? '') === '') $errors[] = 'Введите желаемый логин.';
    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Введите корректный E-mail.';
    if (empty($data['password'])) $errors[] = 'Введите пароль.';
    
    // Проверяю, не занят ли логин или email.
    if (R::count('user', "username = ?", [$data['username'] ?? ''])) $errors[] = 'Пользователь с таким логином уже существует.';
    if (R::count('user', "email = ?", [$data['email'] ?? ''])) $errors[] = 'Пользователь с таким E-mail уже зарегистрирован.';
    
    // Если по итогам проверок ошибок нет...
    if (empty($errors)) {
        // ...создаю нового пользователя.
        $user = R::dispense('user');
        $user->name = $data['name'];
        $user->s_name = $data['s_name'];
        $user->username = $data['username'];
        $user->email = $data['email'];
        // Хэширую пароль для безопасного хранения.
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->admin = 0; // Новые пользователи не могут быть админами.
        
        // Сохраняю пользователя в базе.
        R::store($user);
        
        // Формирую сообщение об успешной регистрации.
        $success_message = "Вы успешно зарегистрировались! Теперь можете войти.";
    }
}

// --- Блок 2: Логика для страницы профиля ---
// Если пользователь авторизован, получаю историю его заказов.
if (isset($_SESSION['logged_user'])) {
    $user_orders = get_user_orders($_SESSION['logged_user']->id);
}
?>


<!-- --- Блок 3: HTML-разметка --- -->

<div class="container my-5">

<?php if (isset($_SESSION['logged_user'])) : ?>
    <!-- Сценарий 1: Если пользователь вошел в систему, показываю профиль. -->
    
    <div class="row">
        <!-- Левая колонка с основной информацией -->
        <div class="col-md-4 text-center">
            
            <?php
            // Проверяю наличие аватара; если его нет - вывожу заглушку.
            $userAvatar = $_SESSION['logged_user']->avatar ?? null;
            $username = $_SESSION['logged_user']->username;

            if (!empty($userAvatar)) :
            ?>
                <!-- Вариант с реальной аватаркой -->
                <img class="img-fluid rounded-circle z-depth-2 mb-4" src="<?= htmlspecialchars($userAvatar) ?>" alt="Аватар пользователя <?= htmlspecialchars($username) ?>" style="width: 150px; height: 150px; object-fit: cover;">
            <?php else: ?>
                <!-- Вариант с SVG-заглушкой, где в центре - первая буква логина. -->
                <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" viewBox="0 0 150 150" class="rounded-circle z-depth-2 mb-4">
                    <rect width="150" height="150" fill="#e9ecef"/>
                    <text x="50%" y="50%" font-family="-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif" 
                          font-size="65" fill="#adb5bd" text-anchor="middle" dy=".3em">
                        <?= htmlspecialchars(mb_strtoupper(mb_substr($username, 0, 1))) ?>
                    </text>
                </svg>
            <?php endif; ?>
            
            <!-- Вывод логина и email -->
            <h3 class="font-weight-bold" style="color: #343a40;"><?= htmlspecialchars($_SESSION['logged_user']->username) ?></h3>
            <p class="text-muted"><?= htmlspecialchars($_SESSION['logged_user']->email) ?></p>
        </div>

        <!-- Правая колонка с таблицей заказов -->
        <div class="col-md-8">
            <h2 class="font-weight-bold mb-4" style="color: #343a40;">История ваших заказов</h2>
            
            <?php if (!empty($user_orders)): // Если у пользователя есть заказы, показываю таблицу ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Дата</th>
                                <th>Товар</th>
                                <th>Кол-во</th>
                                <th>Сумма</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- В цикле вывожу каждую строку заказа. -->
                            <?php foreach($user_orders as $order): ?>
                                <tr>
                                    <td><?= htmlspecialchars(date("d.m.Y", strtotime($order->date))) ?></td>
                                    <td><?= htmlspecialchars($order->product) ?></td>
                                    <td><?= htmlspecialchars($order->qty) ?></td>
                                    <td class="font-weight-bold"><?= htmlspecialchars($order->price * $order->qty) ?> ₽</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: // Если заказов нет - показываю заглушку. ?>
                <div class="alert alert-info">Вы еще не сделали ни одного заказа.</div>
            <?php endif; ?>
        </div>
    </div>

<?php else: ?>
    <!-- Сценарий 2: Если пользователь не авторизован, показываю форму регистрации. -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center font-weight-bold mb-4" style="color: #343a40;">Регистрация</h3>
                    
                    <!-- Блок для отображения ошибок валидации. -->
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Блок для отображения сообщения об успешной регистрации. -->
                    <?php if (!empty($success_message)): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($success_message) ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Сама форма регистрации. -->
                    <form method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="reg-name">Имя</label>
                                <input type="text" id="reg-name" name="name" class="form-control" value="<?= htmlspecialchars($data['name'] ?? '') ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="reg-s_name">Фамилия</label>
                                <input type="text" id="reg-s_name" name="s_name" class="form-control" value="<?= htmlspecialchars($data['s_name'] ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="reg-username">Логин</label>
                            <input type="text" id="reg-username" name="username" class="form-control" value="<?= htmlspecialchars($data['username'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="reg-email">E-mail</label>
                            <input type="email" id="reg-email" name="email" class="form-control" value="<?= htmlspecialchars($data['email'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="reg-password">Пароль</label>
                            <input type="password" id="reg-password" name="password" class="form-control" required>
                        </div>
                        <button class="btn btn-success btn-block my-4" type="submit" name="do_signup">Зарегистрироваться</button>
                    </form>
                    <div class="text-center">
                        <p>Уже есть аккаунт? <a href="index.php?view=loging2">Войти</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

</div>