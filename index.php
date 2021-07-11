<?php
require_once('connection.php');
$link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error($link));
session_start();
if (!(isset($_SESSION['login']))) {
    echo ("Доступ запрещён. <br>");
    echo ("Хотите войти? <a href='auth/auth.php'>Войти</a>");
} else {
    echo ("Добро пожаловать " . $_SESSION['login'] . "." . "<br> Перейти к задачам: <a href='objectives/objectives.php'>Задачи</a>" .
         '<br>' . "Вы авторизованы, хотите выйти? <a href='auth/logout.php'>Выйти</a>");
}
