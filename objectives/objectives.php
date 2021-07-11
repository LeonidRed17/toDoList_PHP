<?php
session_start();
if (isset($_SESSION['login'])) {
    
    require_once('../connection.php');
    $link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error($link));
    echo ('<link rel="stylesheet" href="html/style.css"');
    echo (join("", file("../auth/html/header.html")));

    echo (join("", file("html/objectives.html")));
    
    if(isset($_POST['objective_name']) && isset($_POST['objective_description']) && $_POST['objective_name'] != "" && $_POST['objective_description'] != ""){
        $objective_name = $_POST['objective_name'];
        $objective_name = strip_tags($objective_name);
        $objective_name = HtmlSpecialChars($objective_name);

        $objective_description = $_POST['objective_description'];  
        $objective_description = strip_tags($objective_description);
        $objective_description = HtmlSpecialChars($objective_description);
        
        $q = "INSERT INTO objectives values(NULL,'$objective_name','$objective_description')";
        $result = mysqli_query($link, $q) or die("Ошибка" . mysqli_error($link)); 
    }

    echo ("<div class='content'>");
    echo ("<table class='objectives'>");
    echo ("<tr><td>ID</td><td>Название задачи</td><td>Описание задачи</td></tr>");
    $q = "SELECT * from objectives";
    $result = mysqli_query($link, $q) or die("Ошибка " . mysqli_error($link));

    while ($f = mysqli_fetch_array($result)) {
        echo('<tr><td>' . $f['id'] . '</td>' . '<td>' . $f['objective_name'] . '</td>' . '<td><div class="objective_description">' . $f['objective_description'] . '</div></td>' . '</tr>');
    }

    echo ("</table>");
    echo ("</div>");
} else {
    echo ("Доступ запрещён. <br>");
    echo ("Хотите войти? <a href='../auth/auth.php'>Войти</a>");
}
