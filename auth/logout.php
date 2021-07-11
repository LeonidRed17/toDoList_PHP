<?php
session_start();
$_SESSION = [];
setcookie ("PHPSESSID", "", time()-3600,"/");
unset($_SESSION['PHPSESSID']);
session_destroy();
echo("Вы успешно вышли. <br>");
echo("Перейти на <a href='../index.php'>главную</a>");
?>