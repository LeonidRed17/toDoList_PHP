<?php
/*
+ Реализовать невозможность регистрации если введенный логин уже существует.
*/
session_start();
if ((isset($_SESSION['login']))) {
    header("Location: /index.php");
} else {
    //Вывод HTML формы регистрации
    echo join('', file('html/reg.html'));
    //Запрос служебного файла с переменными необходимыми для подключения к БД.
    require_once('../connection.php');

    //Создание и присвоение переменным регистрации значения пользователя.
    //Проверка значений полей
    //Тут должна быть большая хорошая проверка и фильтрация данных введенных пользователем

    if (isset($_POST['login']) && isset($_POST['password'])) {
        $login = $_POST['login'];
        $login = strip_tags($login);
        $login = HtmlSpecialChars($login);

        $pass = $_POST['password'];
        $pass = strip_tags($pass);
        $pass = HtmlSpecialChars($pass);
        $pass = password_hash($pass, PASSWORD_DEFAULT);


        //Подключение к БД
        $link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error($link));


        //Запрос к БД.
        $query0 = "SELECT * FROM users where login = \"$login\"";
        $result0 = mysqli_query($link, $query0) or die("Ошибка" . mysqli_error($link));

        $fetch = mysqli_fetch_array($result0);
        if ($fetch) {
            if ($fetch['login'] == $login) {
                echo ("Такой логин существует! Выберите другой.");
                exit();
            }
        } else {
            $query = "INSERT INTO users values(NULL,'$login','$pass')";
            $result = mysqli_query($link, $query) or die("Ошибка" . mysqli_error($link));
            //Если регистрация прошла успешно то предложить войти 
            if ($result) {
                echo ('
            <p>Вы успешно зарегистрировались!</p> 
            <br>
            <a href="auth.php">Войти</a>');
            }
        }
    }
}
