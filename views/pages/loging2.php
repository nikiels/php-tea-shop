<?php
// Сначала забираю все данные, отправленные формой.
$data = $_POST;

// Основная логика входа. Срабатывает только после нажатия кнопки 'Вход'.
if (isset($data['do_login'])) 
{
    // Подготавливаю массив для возможных ошибок.
    $errors = array();
    
    // Ищу пользователя в базе по введенному логину.
    $user = R::findOne('user', 'username = ?', array($data['username']));
    
    // Проверяю, нашелся ли такой пользователь.
    if ($user) 
    {
        // Если пользователь нашелся, сверяю хэш пароля из базы с введенным паролем.
        if (password_verify($data['password'], $user->password)) 
        {
            // Если пароль верный, 'запоминаю' пользователя в сессии.
            $_SESSION['logged_user'] = $user;
            
            // И перенаправляю его в личный кабинет.
            header('Location: index.php?view=logining');
   
        }
        
        // Дополнительная проверка: если это админ...
        if ($user->admin == 1) 
        {
            // ...создаю для него отдельную админскую сессию.
            $_SESSION['logged_admin'] = $user;

            // И отправляю в админ-панель.
            header('Location: index.php?view=admin');
        }
        else
        {
            // Если пароль не подошел, добавляю ошибку.
            $errors[] = 'Неверно веден пароль';
        }

    }
    else {
        // Если пользователь с таким логином не найден.
        $errors[] = 'Пользователь с таким ником не существует';
    }
    
    // Если в процессе возникли ошибки...
    if (! empty($errors))
    {
        // ...забираю первую из них для отображения.
        $ma = array_shift($errors);
    }
}
?>

<!-- Стандартная форма авторизации -->
<form class="text-center border border-light p-5" method="post">

    <p class="h4 mb-4">Вход</p>
    
    <!-- Блок для вывода сообщения об ошибке, если оно есть -->
    <?php if(isset($ma)){?> <div class="alert alert-danger" role="alert"> <?php echo $ma; ?> </div><?php }?>

    <div class="form-row mb-4">
        <div class="col">
           <!-- Поле для ввода логина -->
            <input type="text" name="username"  id="defaultRegisterFormFirstName" class="form-control" placeholder="Username">
        </div>
    </div>

    <!-- Поле для ввода пароля -->
    <input type="password" name="password" id="defaultRegisterFormPassword" class="form-control" placeholder="Password" aria-describedby="defaultRegisterFormPasswordHelpBlock">
    <small id="defaultRegisterFormPasswordHelpBlock" class="form-text text-muted mb-4">
    </small>

    <!-- Кнопка для отправки формы -->
    <button class="btn  my-4 btn-block btn-outline-success" type="submit" name="do_login">Вход</button>
</form>