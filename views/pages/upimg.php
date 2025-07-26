<?php
/**
 * Обработчик загрузки изображения для товара.
 * Подключается на странице добавления/редактирования товара.
 */

// Получаю ID товара и подключение к БД из глобальной области.
// Эти переменные должны быть определены до подключения этого файла.
global $id, $link;

// Подготавливаю массив для сбора возможных ошибок.
$error_img = array();

// 1. Сначала проверяю, не возникло ли ошибок при самой передаче файла на сервер.
if ($_FILES['image']['error'] > 0) 
{
    // Использую стандартные коды ошибок PHP для определения проблемы.
    switch ($_FILES['image']['error']) 
    {
        case 1: $error_img[] = 'Размер UPLOAD_MAX_FILE_SIZE'; break;
        case 2: $error_img[] = 'Размер MAX_FILE_SIZE'; break;
        case 3: $error_img[] = 'не удается загрузить'; break;
        case 4: $error_img[] = 'небыл загружен'; break;
        case 5: $error_img[] = 'Нет временной папки'; break;
        case 6: $error_img[] = 'Не записался'; break;
        case 7: $error_img[] = 'php-не'; break;
    }
}
else // Если базовых ошибок нет, приступаю к обработке.
{
    // 2. Проверяю тип файла. Разрешаю только стандартные форматы изображений.
    if ($_FILES['image']['type'] == 'image/jpeg' || $_FILES['image']['type'] == 'image/jpg' || $_FILES['image']['type'] == 'image/png') 
    {
       // Вычисляю расширение файла.
       $imgext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES['image']['name'] ));

       // Задаю папку для загрузки.
       $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/img/tea/';

       // Генерирую новое уникальное имя файла, чтобы избежать конфликтов и проблем с кэшем.
       $newfilename = $id.rand(10,100).'.'.$imgext;

       // Формирую полный путь к новому файлу.
       $uploadfile = $uploaddir.$newfilename;

       // 3. Перемещаю загруженный файл из временной директории в постоянную.
       if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) 
       {
          // 4. Если перемещение успешно, обновляю запись в базе данных — прописываю новое имя файла для товара.
          $update = mysqli_query($link, "UPDATE product SET image='$newfilename' WHERE id = $id");
       }
       else // Если переместить файл не удалось, добавляю ошибку.
       {
           $error_img[] = "Ошибка загрузки";
       }

    }
    else { // Если тип файла не подходит - тоже ошибка.
        $error_img[] = 'Доступ разрешен: jpeg, jpg, png';
    }
}
?>
