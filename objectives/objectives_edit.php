<?php
//Начало сессии
session_start();
//Если логин выдан сессией то продолжить сценарий
if (isset($_SESSION['login'])) {
    //Настройки mysql
    require_once('../connection.php');
    //подключение к серверу
    $link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error($link));
    //Вывод html страницы, подключение css
    echo ('<link rel="stylesheet" href="html/style.css"');
    echo (join("", file("../auth/html/header.html")));
    echo (join("", file("html/objectives_edit.html")));
    if (isset($_POST['objective_name']) && isset($_POST['objective_description']) && $_POST['objective_name'] != "" && $_POST['objective_description'] != "") {
        $objective_name = $_POST['objective_name'];
        $objective_name = strip_tags($objective_name);
        $objective_name = HtmlSpecialChars($objective_name);

        $objective_description = $_POST['objective_description'];  
        $objective_description = strip_tags($objective_description);
        $objective_description = HtmlSpecialChars($objective_description);

        foreach($_POST as $key => $val){
            if($val == 'on'){
                echo($key . ' :'.$val . "<br>");
                //global $objective_name;
                //global $objective_description;
                $q = "UPDATE objectives SET objective_name = '$objective_name', objective_description = '$objective_description' where id = $key";
                $result = mysqli_query($link,$q) or die("Ошибка". mysqli_error($link));
            }
        }
    }
    //Вывод таблицы с данными задач
    echo ("<div class='content'>");
    echo ("<table class='objectives'>");
    echo ("<tr><td>Выбрать</td><td>ID</td><td>Название задачи</td><td>Описание задачи</td></tr>");


    $q = "SELECT * from objectives";
    $result = mysqli_query($link, $q) or die("Ошибка " . mysqli_error($link));

    while ($f = mysqli_fetch_array($result)) {
        echo ('
        <tr>
            <td>' .
            "<input type=checkbox name=$f[id]>" .
            '</td>' .
            '<td> '
            . $f['id'] .
            '</td>' .
            '<td>'
            . $f['objective_name'] .
            '</td>' .
            '<td>
                <div class="objective_description">' .
            $f['objective_description'] .
            '</div>
            </td>' .
            '</tr>
        ');
    }
 
    echo ("</table>");
    echo ("</form>");
    echo ("</div>");
    
}
  
//Иначе запретить выполнение сценария
else {
    echo ("Доступ запрещён. <br>");
    echo ("Хотите войти? <a href='../auth/auth.php'>Войти</a>");
}
