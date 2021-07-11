<?php
/*
+ Вырезать все теги и скрипты из ввода
*/
session_start();
if ((isset($_SESSION['login']))) {
    Header("Location: /index.php");
} else {
    //Вывод HTML формы регистрации
    echo join('', file('html/auth.html'));

    //Подключение к БД
    require_once('../connection.php');
    $link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error($link));


    //Проверка значений полей
    //Тут должна быть большая хорошая проверка и фильтрация данных введенных пользователем
    if (isset($_POST['login']) && isset($_POST['password'])) {
        $login = $_POST['login'];
        $login = strip_tags($login);
        $login = HtmlSpecialChars($login);
        $pass = $_POST['password'];
        $pass = strip_tags($pass);
        $pass = HtmlSpecialChars($pass);
        //Запрос к базе данных по введеному пользователем логину.
        $result  = mysqli_query($link, "SELECT * from users where login = \"$login\"") or die(mysqli_error($link));
        //Получаем результат запроса в виде массива.
        $fetch = mysqli_fetch_array($result);

        if ($fetch) {
            if ($fetch['login'] == $login) {
                if (password_verify($pass, $fetch['password'])) {
                    echo ('Вы успешно авторизованы');
                    session_start();
                    $_SESSION['login'] = $login;
                    $_SESSION['auth'] = true;
                    Header("Location: /index.php");
                } else {
                    echo ('Неверный пароль');
                }
            }
        }
    }
}
